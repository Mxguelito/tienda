@extends('layouts.app')

@section('titulo', 'Mi carrito')

@section('content')
<h2 class="mb-4">🛒 Mi carrito</h2>

@if(count($carrito) == 0)
    <p class="text-muted">Tu carrito está vacío.</p>
@else

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @php $totalGeneral = 0; @endphp

        @foreach($carrito as $item)
        @php
            $totalProducto = $item['precio'] * $item['cantidad'];
            $totalGeneral += $totalProducto;
        @endphp

        <tr>
            <td>{{ $item['nombre'] }}</td>

            <td style="width:120px;">
                @if($item['imagen'])
                    <img src="{{ asset('storage/'.$item['imagen']) }}" 
                         style="width:100px; height:80px; object-fit:cover;">
                @else
                    <img src="https://via.placeholder.com/100x80?text=Sin+Imagen">
                @endif
            </td>

            <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>
            <td>{{ $item['cantidad'] }}</td>
            <td>${{ number_format($totalProducto, 0, ',', '.') }}</td>

            <td>
                <form action="{{ route('carrito.eliminar', $item['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">🗑 Eliminar</button>
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>

<h3>Total general: ${{ number_format($totalGeneral, 0, ',', '.') }}</h3>

@endif

@endsection

