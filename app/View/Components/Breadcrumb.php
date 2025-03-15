<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (request()->routeIs('admin.dashboard')) {
            return view('admin.layouts.breadcrumb', ['breadcrumbs' => []]);
        }

        $breadcrumbs = [
            ['name' => 'Trang chủ', 'url' => route('admin.dashboard')]
        ];

        $routes = [
            'admin.users' => 'Người dùng',
            'admin.categories' => 'Danh mục sản phẩm',
            'admin.products' => 'Sản phẩm',
            'admin.warehouses' => 'Kho hàng',
            'admin.discounts' => 'Khuyến mãi',
            'admin.orders' => 'Hóa đơn'
        ];

        foreach ($routes as $prefix => $label) {
            if (request()->routeIs("$prefix.index")) {
                $breadcrumbs[] = ['name' => $label, 'url' => null];
            } elseif (request()->routeIs("$prefix.create")) {
                $breadcrumbs[] = ['name' => $label, 'url' => route("$prefix.index")];
                $breadcrumbs[] = ['name' => "Thêm $label", 'url' => null];
            } elseif (request()->routeIs("$prefix.show")) {
                $breadcrumbs[] = ['name' => $label, 'url' => route("$prefix.index")];
                $breadcrumbs[] = ['name' => "Xem chi tiết", 'url' => null];
            } elseif (request()->routeIs("$prefix.edit")) {
                $breadcrumbs[] = ['name' => $label, 'url' => route("$prefix.index")];
                $breadcrumbs[] = ['name' => "Cập nhật $label", 'url' => null];
            }
        }

        return view('admin.layouts.breadcrumb', compact('breadcrumbs'));
    }
}
