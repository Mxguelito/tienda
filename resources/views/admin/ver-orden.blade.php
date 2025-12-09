@extends('layouts.app')

@section('titulo', "Orden #$orden->id")

@section('content')
<div class="container my-4">

    <h1 class="mb-4 text-center">
        📄 Detalle de la orden #{{ $orden->id }}
    </h1>

    <div class="card shadow p-4 mb-4">

        <h4 class="mb-3">🧍‍♂️ Datos del cliente</h4>

        <p><strong>Nombre:</strong> {{ $orden->nombre }}</p>
        <p><strong>Email:</strong> {{ $orden->email }}</p>
        <p><strong>Dirección:</strong> {{ $orden->direccion }}</p>

        <hr>

        <h4 class="mb-3">📦 Datos de la compra</h4>
        <p><strong>Total:</strong> ${{ number_format($orden->total, 0, ',', '.') }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($orden->estado) }}</p>

        <hr>

        <h4 class="mb-3">🛒 Productos</h4>

        @php
            $carrito = is_string($orden->carrito)
                ? json_decode($orden->carrito, true)
                : $orden->carrito;

            if (!is_array($carrito)) $carrito = [];
        @endphp

        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>

            <tbody>
            @foreach($carrito as $item)
                <tr>
                    <td>{{ $item['nombre'] }}</td>
                    <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>
                    <td>{{ $item['cantidad'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.ordenes') }}" class="btn btn-secondary mt-3">
            ◀ Volver
        </a>

    </div>

</div>
@endsection
