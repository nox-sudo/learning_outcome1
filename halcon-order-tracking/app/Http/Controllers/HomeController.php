<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string',
        ]);

        $order = Order::active()
            ->where('invoice_number', $request->invoice_number)
            ->with(['photos', 'statusHistory'])
            ->first();

        return view('home.index', compact('order'));
    }
}
