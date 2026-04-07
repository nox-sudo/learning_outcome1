@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Órdenes Archivadas</h2>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Órdenes Activas</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Factura</th>
                <th>Cliente</th>
                <th>Fecha Orden</th>
                <th>Estado</th>
                <th>Creado por</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->invoice_number }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->creator->name ?? '-' }}</td>
                <td>
                    <form method="POST" action="{{ route('orders.restore', $order) }}"
                          onsubmit="return confirm('¿Restaurar esta orden?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay órdenes archivadas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
