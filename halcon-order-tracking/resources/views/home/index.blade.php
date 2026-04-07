@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">Rastreo de Órdenes</h2>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('home.search') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text"
                               name="invoice_number"
                               class="form-control @error('invoice_number') is-invalid @enderror"
                               placeholder="Número de factura (ej. INV-0001)"
                               value="{{ old('invoice_number') }}">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                        @error('invoice_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>

        @if(isset($order))
            @if($order)
                <div class="card">
                    <div class="card-header">
                        <strong>Orden: {{ $order->invoice_number }}</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Dirección de entrega:</strong> {{ $order->delivery_address }}</p>

                        @if($order->status === 'delivered')
                            <p><strong>Estado:</strong> <span class="badge bg-success">Entregado</span></p>
                            @php
                                $deliveryPhoto = $order->photos->where('photo_type', 'delivery')->last();
                            @endphp
                            @if($deliveryPhoto)
                                <p><strong>Foto de entrega:</strong></p>
                                <img src="{{ Storage::url($deliveryPhoto->photo_url) }}"
                                     class="img-fluid rounded" style="max-height: 300px;" alt="Foto de entrega">
                            @endif
                        @else
                            @php
                                $lastHistory = $order->statusHistory->sortByDesc('changed_at')->first();
                                $statusLabels = [
                                    'ordered'    => 'Ordenado',
                                    'in_process' => 'En Proceso',
                                    'in_route'   => 'En Ruta',
                                    'delivered'  => 'Entregado',
                                ];
                            @endphp
                            <p><strong>Último estado:</strong>
                                <span class="badge bg-info text-dark">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </p>
                            @if($lastHistory)
                                <p><strong>Fecha:</strong> {{ $lastHistory->changed_at }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    No se encontró ninguna orden activa con ese número de factura.
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
