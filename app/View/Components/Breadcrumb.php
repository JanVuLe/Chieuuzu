<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $breadcrumbs = [];
        if(!request()->routeIs('admin.dashboard')){
            $breadcrumbs[] = ['name' => 'Trang chủ', 'url' => route('admin.dashboard')];
            //User
            if(request()->routeIs('admin.users.index')){
                $breadcrumbs[] = ['name' => 'Người dùng', 'url' => null];
            }elseif(request()->routeIs('admin.users.create')){
                $breadcrumbs[] = ['name' => 'Người dùng', 'url' => route('admin.users.index')];
                $breadcrumbs[] = ['name' => 'Thêm người dùng', 'url' => null];
            }elseif(request()->routeIs('admin.users.show')){
                $breadcrumbs[] = ['name' => 'Người dùng', 'url' => route('admin.users.index')];
                $breadcrumbs[] = ['name' => 'Thông tin người dùng', 'url' => null];
            }
            elseif(request()->routeIs('admin.users.edit')){
                $breadcrumbs[] = ['name' => 'Người dùng', 'url' => route('admin.users.index')];
                $breadcrumbs[] = ['name' => 'Chỉnh sửa người dùng', 'url' => null];
            }
            //Categories
            if(request()->routeIs('admin.categories.index')){
                $breadcrumbs[] = ['name' => 'Danh mục sản phẩm', 'url' => null];
            }elseif(request()->routeIs('admin.categories.create')){
                $breadcrumbs[] = ['name' => 'Danh mục sản phẩm', 'url' => route('admin.categories.index')];
                $breadcrumbs[] = ['name' => 'Thêm danh mục', 'url' => null];
            }
            elseif(request()->routeIs('admin.categories.edit')){
                $breadcrumbs[] = ['name' => 'Danh mục sản phẩm', 'url' => route('admin.categories.index')];
                $breadcrumbs[] = ['name' => 'Chỉnh sửa danh mục', 'url' => null];
            }
            //Products
            if(request()->routeIs('admin.products.index')){
                $breadcrumbs[] = ['name' => 'Sản phẩm', 'url' => null];
            }elseif(request()->routeIs('admin.products.create')){
                $breadcrumbs[] = ['name' => 'Sản phẩm', 'url' => route('admin.products.index')];
                $breadcrumbs[] = ['name' => 'Thêm sản phẩm', 'url' => null];
            }
            //Discounts
            if(request()->routeIs('admin.discounts.index')){
                $breadcrumbs[] = ['name' => 'Khuyến mãi', 'url' => null];
            }elseif(request()->routeIs('admin.discounts.create')){
                $breadcrumbs[] = ['name' => 'Khuyến mãi', 'url' => route('admin.discounts.index')];
                $breadcrumbs[] = ['name' => 'Thêm khuyến mãi', 'url' => null];
            }
            elseif(request()->routeIs('admin.discounts.edit')){
                $breadcrumbs[] = ['name' => 'Khuyến mãi', 'url' => route('admin.discounts.index')];
                $breadcrumbs[] = ['name' => 'Chỉnh sửa khuyến mãi', 'url' => null];
            }
        }

        return view('admin.layouts.breadcrumb', compact('breadcrumbs'));
    }
}
