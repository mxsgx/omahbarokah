<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Left side of Navbar list item
     *
     * @var array
     */
    public $leftItems = [
        [
            'route' => 'home',
            'name' => 'Beranda',
        ],
        [
            'route' => 'admin.product.index',
            'name' => 'Produk',
            'auth' => true,
            'role' => ['admin'],
        ],
        [
            'route' => 'admin.user.index',
            'name' => 'Pengguna',
            'auth' => true,
            'role' => ['admin'],
        ],
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.navbar');
    }

    /**
     * @param array $item
     * @return bool
     */
    public function roleGranted($item)
    {
        if (isset($item['role'])) {
            return in_array(Auth::user()->role, $item['role']);
        }

        return false;
    }

    /**
     * @param string $routeName
     * @return bool
     */
    public function isActive($routeName)
    {
        return Route::currentRouteName() === $routeName;
    }
}
