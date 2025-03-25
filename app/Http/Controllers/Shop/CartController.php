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
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Show home
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function ($item) {
            return ($item['discounted_price'] ?? $item['price']) * $item['quantity'];
        }, $cart));

        $originalTotal = array_sum(array_map(function ($item) {
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

        return view('shop.cart', compact('cart', 'total', 'originalTotal', 'relatedProducts', 'categories', 'breadcrumbs'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->with(['warehouses', 'discounts'])->firstOrFail();

        $totalStock = $product->total_stock;
        if ($totalStock < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã hết hàng!',
            ]);
        }

        $cart = session()->get('cart', []);

        // Lấy khuyến mãi hiện tại (nếu có)
        $activeDiscount = $product->discounts()
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('percentage', 'desc')
            ->first();

        $originalPrice = $product->price;
        $discountedPrice = $activeDiscount ? $originalPrice * (1 - $activeDiscount->percentage / 100) : $originalPrice;

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + 1;
            if ($newQuantity > $totalStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng trong giỏ hàng vượt quá tồn kho!',
                ]);
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $originalPrice, // Giá gốc
                'discounted_price' => $discountedPrice, // Giá sau khuyến mãi
                'quantity' => 1,
                'image' => $product->images->first()->image_url ?? null,
                'slug' => $product->slug,
                'discount_percentage' => $activeDiscount ? $activeDiscount->percentage : 0, // Phần trăm giảm giá
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
            $product = Product::findOrFail($productId);
            if ($quantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho!',
                ]);
            }
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        $total = array_sum(array_map(function ($item) {
            return ($item['discounted_price'] ?? $item['price']) * $item['quantity'];
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
            return ($item['discounted_price'] ?? $item['price']) * $item['quantity'];
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
            return ($item['discounted_price'] ?? $item['price']) * $item['quantity'];
        }, $cart));

        // Kiểm tra tồn kho
        foreach ($cart as $productId => $item) {
            $product = Product::with('warehouses')->findOrFail($productId);
            if ($item['quantity'] > $product->total_stock) {
                return redirect()->route('shop.cart')->with('error', "Sản phẩm {$item['name']} không đủ tồn kho.");
            }
        }

        $shippingAddress = implode(', ', array_filter([
            $request->input('street'),
            $request->input('ward'),
            $request->input('district'),
            $request->input('province'),
        ]));

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'ward' => $request->input('ward'),
                'street' => $request->input('street'),
                'shipping_address' => $shippingAddress,
                'status' => $request->payment_method === 'bank_transfer' ? 'pending' : 'confirmed',
            ]);
            foreach ($cart as $productId => $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['discounted_price'] ?? $item['price'], // Giá sau khuyến mãi
                    'original_price' => $item['price'], // Giá gốc
                ]);

                // Giảm số lượng trong kho
                $product = Product::with('warehouses')->findOrFail($productId);
                $remainingQuantity = $item['quantity'];
                foreach ($product->warehouses as $warehouse) {
                    if ($remainingQuantity <= 0) break;
                    $currentQuantity = $warehouse->pivot->quantity;
                    if ($currentQuantity > 0) {
                        $reduce = min($remainingQuantity, $currentQuantity);
                        $warehouse->pivot->quantity -= $reduce;
                        $warehouse->pivot->save();
                        $remainingQuantity -= $reduce;
                    }
                }
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending',
            ]);

            session()->forget('cart');
            session()->put('cart_count', 0);

            DB::commit();
            return redirect()->route('shop.order.success', $order->id)
                ->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('shop.cart')->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }

    public function orderSuccess($orderId)
    {
        $order = Order::with('orderDetails.product')->findOrFail($orderId);
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        return view('shop.order_success', compact('order', 'categories'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        if ($order->status === 'pending' || $order->status === 'confirmed') {
            $order->status = 'cancelled';
            $order->save();

            // Hoàn lại số lượng vào kho (thêm đều vào kho đầu tiên, hoặc tùy logic bạn muốn)
            foreach ($order->orderDetails as $detail) {
                $product = Product::with('warehouses')->findOrFail($detail->product_id);
                $firstWarehouse = $product->warehouses->first();
                if ($firstWarehouse) {
                    $firstWarehouse->pivot->quantity += $detail->quantity;
                    $firstWarehouse->pivot->save();
                } else {
                    // Nếu chưa có kho, thêm vào kho mặc định (giả sử warehouse_id = 1)
                    DB::table('warehouse_products')->insert([
                        'warehouse_id' => 1,
                        'product_id' => $detail->product_id,
                        'quantity' => $detail->quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy.'
            ]);
        }
        return response()->json([
            'success' => false,
            'error' => 'Không thể hủy đơn hàng ở trạng thái hiện tại.'
        ]);
    }
}
