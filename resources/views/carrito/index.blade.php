@extends('layouts.app')

@section('titulo', 'Mi Carrito')

@section('content')

<h2 class="mb-4 text-center">🛒 Mi Carrito</h2>

@if(empty($carrito))
    <p class="text-center text-muted">No hay productos en el carrito.</p>
@else

{{-- ============================ --}}
{{-- 🖥️ VISTA DESKTOP (TABLA) --}}
{{-- ============================ --}}
<div class="carrito-box-tesla d-none d-md-block">

    <table class="table table-dark table-bordered text-center align-middle" style="border-radius: 12px; overflow: hidden;">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @php $total = 0; @endphp

            @foreach($carrito as $item)
                @php
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                @endphp

                <tr>
                    <td width="120">
                        <img src="{{ asset('storage/'.$item['imagen']) }}" class="img-fluid rounded">
                    </td>

                    <td>{{ $item['nombre'] }}</td>
                    <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>

                    {{-- Cantidad --}}
                    <td>
                        <form action="{{ route('carrito.restar', $item['id']) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-cantidad">-</button>
                        </form>

                        <span class="mx-2 text-white">{{ $item['cantidad'] }}</span>

                        <form action="{{ route('carrito.sumar', $item['id']) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-cantidad">+</button>
                        </form>
                    </td>

                    <td>${{ number_format($subtotal, 0, ',', '.') }}</td>

                    {{-- Eliminar --}}
                    <td>
                        <form action="{{ route('carrito.eliminar', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-eliminar-tesla">Eliminar</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</div>



{{-- ============================ --}}
{{-- 📱 VISTA MOBILE (CARDS) --}}
{{-- ============================ --}}
<div class="d-md-none">

    @php $total = 0; @endphp

    @foreach($carrito as $item)
        @php
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        @endphp

       <div class="card-carrito-mobile">


            {{-- Imagen + nombre --}}
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('storage/'.$item['imagen']) }}" 
                     class="rounded" 
                     style="width:70px; height:70px; object-fit:cover;">

                <div>
                    <h5 class="text-white mb-1">{{ $item['nombre'] }}</h5>
                    <p class="carrito-precio-mobile mb-1">
    ${{ number_format($item['precio'], 0, ',', '.') }}
</p>

                </div>
            </div>

            {{-- Cantidad --}}
            <div class="d-flex justify-content-between align-items-center mt-3">

                <div class="d-flex align-items-center">

                    <form action="{{ route('carrito.restar', $item['id']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn-cantidad-mobile">-</button>
                    </form>

                    <span class="mx-2 text-white fw-bold">{{ $item['cantidad'] }}</span>

                    <form action="{{ route('carrito.sumar', $item['id']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn-cantidad-mobile">+</button>
                    </form>

                </div>

                <span class="text-white fw-bold">
                    ${{ number_format($subtotal, 0, ',', '.') }}
                </span>

            </div>

            {{-- Botón eliminar --}}
            <form action="{{ route('carrito.eliminar', $item['id']) }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button class="btn-eliminar-tesla w-100">Eliminar</button>
            </form>

        </div>
    @endforeach

</div>



{{-- ============================ --}}
{{-- TOTAL Y BOTONES --}}
{{-- ============================ --}}
<h3 class="text-center mt-4 text-white">
    Total: ${{ number_format($total, 0, ',', '.') }}
</h3>

<div class="cart-actions">
    <a href="{{ route('productos') }}" class="btn-cart btn-cart-secondary">
        ⬅ Seguir comprando
    </a>

    <a href="{{ route('checkout.form') }}" class="btn-cart btn-cart-primary">
        ✔ Finalizar compra
    </a>
</div>

@endif

@endsection
