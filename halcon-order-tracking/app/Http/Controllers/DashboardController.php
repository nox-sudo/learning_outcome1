<?php

namespace App\Http\Controllers;

use App\Models\Order;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total     = Order::active()->count();
        $ordered   = Order::active()->where('status', Order::STATUS_ORDERED)->count();
        $inProcess = Order::active()->where('status', Order::STATUS_IN_PROCESS)->count();
        $inRoute   = Order::active()->where('status', Order::STATUS_IN_ROUTE)->count();
        $delivered = Order::active()->where('status', Order::STATUS_DELIVERED)->count();

        return view('dashboard.index', compact('total', 'ordered', 'inProcess', 'inRoute', 'delivered'));
    }
}
