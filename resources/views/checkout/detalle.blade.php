@extends('layouts.app')

@section('titulo', 'Detalle de compra')

@section('content')

<div class="tesla-order-box">


    <h2 class="tesla-title">🧾 Detalle de compra #{{ $order->id }}</h2>

    <p><span class="tesla-label">Cliente:</span> {{ $order->nombre }}</p>
    <p><span class="tesla-label">Email:</span> {{ $order->email }}</p>
    <p><span class="tesla-label">Dirección:</span> {{ $order->direccion ?: 'No especificó' }}</p>

    <p><span class="tesla-label">Estado:</span> 
        {{ ucfirst($order->estado ?? 'pendiente') }}
    </p>

    <p><span class="tesla-label">Total:</span> 
        ${{ number_format($order->total, 0, ',', '.') }}
    </p>

    <h4 class="mt-4 tesla-label">Productos</h4>

   <div class="tabla-scroll">
    <table class="tesla-table mt-3">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->carrito as $item)
            <tr>
                <td>{{ $item['nombre'] }}</td>
                <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>
                <td>{{ $item['cantidad'] }}</td>
                <td>${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


    <a href="{{ route('compras.historial') }}" class="btn-tesla-back mt-4">Volver</a>
</div>

@endsection
