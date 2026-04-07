@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Orden: {{ $order->invoice_number }}</h2>
    <div>
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
</div>

@php
$statusLabels = [
    'ordered'    => ['label' => 'Ordenado',   'color' => 'primary'],
    'in_process' => ['label' => 'En Proceso', 'color' => 'warning'],
    'in_route'   => ['label' => 'En Ruta',    'color' => 'info'],
    'delivered'  => ['label' => 'Entregado',  'color' => 'success'],
];
$st = $statusLabels[$order->status] ?? ['label' => $order->status, 'color' => 'secondary'];
@endphp

<div class="row g-4">
    {{-- Customer Data Card --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><strong>Datos del Cliente</strong></div>
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
                <p><strong>Número de Cliente:</strong> {{ $order->customer_number ?? '-' }}</p>
                <p><strong>RFC:</strong> {{ $order->rfc ?? '-' }}</p>
                <p><strong>Email Fiscal:</strong> {{ $order->fiscal_email ?? '-' }}</p>
                <p><strong>Dirección Fiscal:</strong> {{ $order->fiscal_address ?? '-' }}</p>
                <p><strong>Dirección de Entrega:</strong> {{ $order->delivery_address }}</p>
                @if($order->notes)
                    <p><strong>Notas:</strong> {{ $order->notes }}</p>
                @endif
                <p><strong>Creado por:</strong> {{ $order->creator->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Status Card --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><strong>Estado de la Orden</strong></div>
            <div class="card-body">
                <p><strong>Factura:</strong> {{ $order->invoice_number }}</p>
                <p><strong>Fecha de Orden:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
                <p><strong>Estado Actual:</strong>
                    <span class="badge bg-{{ $st['color'] }}">{{ $st['label'] }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Photos --}}
@if($order->photos->isNotEmpty())
<div class="mt-4">
    <h4>Fotos</h4>
    <div class="row g-3">
        @foreach($order->photos as $photo)
        <div class="col-md-4">
            <div class="card">
                <img src="{{ Storage::url($photo->photo_url) }}" class="card-img-top" alt="Foto {{ $photo->photo_type }}" style="max-height:200px;object-fit:cover;">
                <div class="card-body py-2">
                    <small class="text-muted">
                        {{ $photo->photo_type === 'loading' ? 'Carga' : 'Entrega' }}
                        — {{ $photo->uploader->name ?? '-' }}
                        — {{ $photo->uploaded_at }}
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Status History --}}
<div class="mt-4">
    <h4>Historial de Estatus</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Estado Anterior</th>
                    <th>Estado Nuevo</th>
                    <th>Cambiado por</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->statusHistory as $history)
                <tr>
                    <td>{{ $history->old_status ?? 'N/A' }}</td>
                    <td>{{ $history->new_status }}</td>
                    <td>{{ $history->changedBy->name ?? '-' }}</td>
                    <td>{{ $history->changed_at }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Sin historial.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
