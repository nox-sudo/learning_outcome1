@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Nueva Orden</h2>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Regresar</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Número de Factura *</label>
                            <input type="text" name="invoice_number"
                                   class="form-control @error('invoice_number') is-invalid @enderror"
                                   value="{{ old('invoice_number') }}">
                            @error('invoice_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de Orden *</label>
                            <input type="datetime-local" name="order_date"
                                   class="form-control @error('order_date') is-invalid @enderror"
                                   value="{{ old('order_date') }}">
                            @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre del Cliente *</label>
                            <input type="text" name="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name') }}">
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Número de Cliente</label>
                            <input type="text" name="customer_number"
                                   class="form-control"
                                   value="{{ old('customer_number') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">RFC</label>
                            <input type="text" name="rfc"
                                   class="form-control"
                                   value="{{ old('rfc') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Fiscal</label>
                            <input type="email" name="fiscal_email"
                                   class="form-control"
                                   value="{{ old('fiscal_email') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Dirección Fiscal</label>
                            <textarea name="fiscal_address" class="form-control" rows="2">{{ old('fiscal_address') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Dirección de Entrega *</label>
                            <textarea name="delivery_address"
                                      class="form-control @error('delivery_address') is-invalid @enderror"
                                      rows="2">{{ old('delivery_address') }}</textarea>
                            @error('delivery_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notas</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Crear Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
