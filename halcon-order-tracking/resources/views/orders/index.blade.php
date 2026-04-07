@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Órdenes Activas</h2>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Nueva Orden</a>
</div>

@php
$statusLabels = [
    'ordered'    => ['label' => 'Ordenado',   'color' => 'primary'],
    'in_process' => ['label' => 'En Proceso', 'color' => 'warning'],
    'in_route'   => ['label' => 'En Ruta',    'color' => 'info'],
    'delivered'  => ['label' => 'Entregado',  'color' => 'success'],
];
@endphp

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
                <td>
                    @php $st = $statusLabels[$order->status] ?? ['label' => $order->status, 'color' => 'secondary']; @endphp
                    <span class="badge bg-{{ $st['color'] }}">{{ $st['label'] }}</span>
                </td>
                <td>{{ $order->creator->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="{{ route('orders.destroy', $order) }}" class="d-inline"
                          onsubmit="return confirm('¿Archivar esta orden?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-secondary">Archivar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay órdenes activas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
