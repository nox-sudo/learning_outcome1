<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPhoto;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::active()->with('creator')->orderByDesc('created_at')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number'   => 'required|string|max:50|unique:orders',
            'customer_name'    => 'required|string|max:200',
            'delivery_address' => 'required|string',
            'order_date'       => 'required|date',
        ]);

        $order = Order::create([
            'invoice_number'   => $request->invoice_number,
            'customer_name'    => $request->customer_name,
            'customer_number'  => $request->customer_number,
            'rfc'              => $request->rfc,
            'fiscal_address'   => $request->fiscal_address,
            'fiscal_email'     => $request->fiscal_email,
            'delivery_address' => $request->delivery_address,
            'notes'            => $request->notes,
            'order_date'       => $request->order_date,
            'status'           => Order::STATUS_ORDERED,
            'deleted'          => 0,
            'created_by'       => Auth::id(),
        ]);

        StatusHistory::log($order->id, null, Order::STATUS_ORDERED, Auth::id());

        return redirect()->route('orders.index')->with('success', 'Orden creada correctamente.');
    }

    public function show(Order $order)
    {
        $order->load(['creator', 'photos.uploader', 'statusHistory.changedBy']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'invoice_number'   => 'required|string|max:50|unique:orders,invoice_number,' . $order->id,
            'customer_name'    => 'required|string|max:200',
            'delivery_address' => 'required|string',
            'order_date'       => 'required|date',
            'status'           => 'required|in:ordered,in_process,in_route,delivered',
        ]);

        if ($request->status !== $order->status) {
            $order->changeStatus($request->status, Auth::id());
        }

        $order->update([
            'invoice_number'   => $request->invoice_number,
            'customer_name'    => $request->customer_name,
            'customer_number'  => $request->customer_number,
            'rfc'              => $request->rfc,
            'fiscal_address'   => $request->fiscal_address,
            'fiscal_email'     => $request->fiscal_email,
            'delivery_address' => $request->delivery_address,
            'notes'            => $request->notes,
            'order_date'       => $request->order_date,
        ]);

        if (in_array($request->status, [Order::STATUS_IN_ROUTE, Order::STATUS_DELIVERED])
            && $request->hasFile('photo')
        ) {
            $photoType = $request->status === Order::STATUS_IN_ROUTE
                ? OrderPhoto::TYPE_LOADING
                : OrderPhoto::TYPE_DELIVERY;

            $path = $request->file('photo')->store('order-photos', 'public');

            OrderPhoto::create([
                'order_id'    => $order->id,
                'photo_type'  => $photoType,
                'photo_url'   => $path,
                'uploaded_by' => Auth::id(),
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy(Order $order)
    {
        $order->softDelete();
        return redirect()->route('orders.index')->with('success', 'Orden archivada correctamente.');
    }

    public function archived()
    {
        $orders = Order::archived()->with('creator')->orderByDesc('created_at')->get();
        return view('orders.archived', compact('orders'));
    }

    public function restore(Order $order)
    {
        $order->restore();
        return redirect()->route('orders.archived')->with('success', 'Orden restaurada correctamente.');
    }
}
