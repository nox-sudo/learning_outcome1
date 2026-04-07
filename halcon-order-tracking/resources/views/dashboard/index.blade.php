@extends('layouts.app')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h5 class="card-title">Total Órdenes</h5>
                <h2>{{ $total }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h5 class="card-title">Ordenadas</h5>
                <h2>{{ $ordered }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h5 class="card-title">En Ruta</h5>
                <h2>{{ $inRoute }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h5 class="card-title">Entregadas</h5>
                <h2>{{ $delivered }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-3">
    <a href="{{ route('users.index') }}" class="btn btn-outline-dark">Usuarios</a>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">Órdenes</a>
    <a href="{{ route('orders.archived') }}" class="btn btn-outline-secondary">Archivadas</a>
</div>
@endsection
