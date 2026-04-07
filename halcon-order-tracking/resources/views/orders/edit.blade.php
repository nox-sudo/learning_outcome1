@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Editar Orden: {{ $order->invoice_number }}</h2>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Regresar</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('orders.update', $order) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Número de Factura *</label>
                            <input type="text" name="invoice_number"
                                   class="form-control @error('invoice_number') is-invalid @enderror"
                                   value="{{ old('invoice_number', $order->invoice_number) }}">
                            @error('invoice_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de Orden *</label>
                            <input type="datetime-local" name="order_date"
                                   class="form-control @error('order_date') is-invalid @enderror"
                                   value="{{ old('order_date', \Carbon\Carbon::parse($order->order_date)->format('Y-m-d\TH:i')) }}">
                            @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre del Cliente *</label>
                            <input type="text" name="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name', $order->customer_name) }}">
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Número de Cliente</label>
                            <input type="text" name="customer_number"
                                   class="form-control"
                                   value="{{ old('customer_number', $order->customer_number) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">RFC</label>
                            <input type="text" name="rfc"
                                   class="form-control"
                                   value="{{ old('rfc', $order->rfc) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Fiscal</label>
                            <input type="email" name="fiscal_email"
                                   class="form-control"
                                   value="{{ old('fiscal_email', $order->fiscal_email) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Dirección Fiscal</label>
                            <textarea name="fiscal_address" class="form-control" rows="2">{{ old('fiscal_address', $order->fiscal_address) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Dirección de Entrega *</label>
                            <textarea name="delivery_address"
                                      class="form-control @error('delivery_address') is-invalid @enderror"
                                      rows="2">{{ old('delivery_address', $order->delivery_address) }}</textarea>
                            @error('delivery_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notas</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $order->notes) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estado *</label>
                            <select id="status-select" name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    onchange="togglePhotoUpload(this.value)">
                                <option value="ordered"    {{ old('status', $order->status) === 'ordered'    ? 'selected' : '' }}>Ordenado</option>
                                <option value="in_process" {{ old('status', $order->status) === 'in_process' ? 'selected' : '' }}>En Proceso</option>
                                <option value="in_route"   {{ old('status', $order->status) === 'in_route'   ? 'selected' : '' }}>En Ruta</option>
                                <option value="delivered"  {{ old('status', $order->status) === 'delivered'  ? 'selected' : '' }}>Entregado</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12" id="photo-upload-section"
                             style="display: {{ in_array(old('status', $order->status), ['in_route', 'delivered']) ? 'block' : 'none' }}">
                            <label class="form-label">Foto (carga / entrega)</label>
                            <input type="file" name="photo" class="form-control" accept="image/*">
                            <small class="text-muted">Requerido para estado En Ruta o Entregado.</small>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Actualizar Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePhotoUpload(status) {
    var section = document.getElementById('photo-upload-section');
    if (status === 'in_route' || status === 'delivered') {
        section.style.display = 'block';
    } else {
        section.style.display = 'none';
    }
}
</script>
@endsection
