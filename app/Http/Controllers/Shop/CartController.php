<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    /**
     * Show home
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $relatedProducts = collect([]);
        if (!empty($cart)) {
            $productIdsInCart = array_keys($cart);
            $categoriesInCart = Product::whereIn('id', $productIdsInCart)
                ->pluck('category_id')
                ->unique()
                ->toArray();

            $relatedProducts = Product::whereIn('category_id', $categoriesInCart)
                ->whereNotIn('id', $productIdsInCart)
                ->with('images')
                ->take(3)
                ->get();
        }

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Giỏ hàng', 'url' => route('shop.cart')],
        ];

        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        return view('shop.cart', compact('cart', 'total', 'relatedProducts', 'categories', 'breadcrumbs'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->images->first()->image_url ?? null,
                'slug' => $product->slug,
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_count', count($cart));

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
        ]);
    }

    /**
     * Update cart
     */
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        session()->put('cart_count', count($cart));

        return response()->json([
            'success' => true,
            'total' => number_format($total, 0, ',', '.') . ' đ',
            'cart_count' => count($cart),
        ]);
    }

    /**
     * Remove product form cart
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        session()->put('cart_count', count($cart));

        return response()->json([
            'success' => true,
            'total' => number_format($total, 0, ',', '.') . ' đ',
            'cart_count' => count($cart),
        ]);
    }

    /**
     * Payment
     */
    public function payment()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('shop.login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Giỏ hàng của bạn trống.');
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        return view('shop.payment', compact('cart', 'total', 'categories'));
    }

    /**
     * Checkout
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('shop.login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Giỏ hàng của bạn trống.');
        }

        $request->validate([
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'street' => 'required',
            'payment_method' => 'required|in:cash_on_delivery,bank_transfer',
        ]);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Tạo chuỗi shipping_address từ các trường riêng biệt
        $shippingAddress = implode(', ', array_filter([
            $request->input('street'),
            $request->input('ward'),
            $request->input('district'),
            $request->input('province'),
        ]));

        // Lưu đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'street' => $request->input('street'),
            'shipping_address' => $shippingAddress,
            'status' => 'processing',
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cart as $productId => $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Tạo bản ghi thanh toán
        Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'amount' => $total,
            'status' => 'pending',
            'note' => $request->payment_method === 'bank_transfer' ? 'Chờ xác nhận chuyển khoản' : null,
        ]);

        session()->forget('cart');
        session()->put('cart_count', 0);

        return redirect()->route('shop.home')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    }
}
