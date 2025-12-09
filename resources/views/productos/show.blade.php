@extends('layouts.app')

@section('titulo', $producto->nombre)

@section('content')

<div class="container py-5">

    <div class="product-detail-card">

        {{-- Imagen --}}
        <div class="product-image">
            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
        </div>

        {{-- Info --}}
        <div class="product-info">
            
            <h1 class="title">{{ $producto->nombre }}</h1>

            <h3 class="price">
                ${{ number_format($producto->precio, 0, ',', '.') }}
            </h3>

            <p class="desc">
                {{ $producto->descripcion ?: 'Sin descripción.' }}
            </p>

            <span class="stock-badge">
                Stock: {{ $producto->stock }}
            </span>

           {{-- Botón agregar al carrito --}}
@if ($producto->stock > 0)
    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
        @csrf
        <button class="btn-tesla-primary w-100 mt-4">
            🛒 Agregar al carrito
        </button>
    </form>
@else
    <button class="btn btn-secondary w-100 mt-4" disabled>
        ❌ Sin stock disponible
    </button>
@endif


            {{-- Acciones Admin --}}
            @if(auth()->check() && auth()->user()->role === 'admin')

            <div class="admin-actions">

                <a href="{{ route('productos.edit', $producto->id) }}" class="btn-edit-tesla">
                    ✏️ Editar
                </a>

                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que querés eliminar este producto?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete-tesla">🗑️ Eliminar</button>
                </form>

            </div>

            @endif

            <a href="{{ route('productos') }}" class="btn-back-tesla">
                ◀ Volver
            </a>

        </div>

    </div>

</div>

@endsection
