@extends('layouts.app')

@section('titulo', 'Productos')

@section('content')

<div class="container my-5">

    <h2 class="mb-4">Nuestros Productos</h2>

 <div class="mb-4 mt-4 boton-agregar-wrapper">
    <a href="{{ route('productos.crear') }}" class="btn-tesla-primary">
        ➕ Agregar producto
    </a>
</div>


    @if ($productos->count() == 0)

        <p class="text-muted">No hay productos cargados todavía.</p>

    @else

   <div class="row productos-row g-4">


        @foreach($productos as $producto)
            <div class="col-md-3">

               <div class="card product-card h-100">

    {{-- Imagen --}}
    @if($producto->imagen)
        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}">
    @else
        <img src="https://via.placeholder.com/300x200?text=Sin+Imagen" class="card-img-top">
    @endif

    <div class="card-body">

        <h5 class="card-title">{{ $producto->nombre }}</h5>

        <p class="price-tesla">
            ${{ number_format($producto->precio, 0, ',', '.') }}
        </p>

        <p class="text-muted small" style="height: 40px; overflow: hidden;">
            {{ $producto->descripcion ?? 'Sin descripción.' }}
        </p>
{{-- BADGE DE STOCK --}}
@if ($producto->stock > 0)
    <span class="badge badge-stock mb-2">
        Stock: {{ $producto->stock }}
    </span>
@else
    <span class="badge bg-danger mb-2" style="font-size: 14px;">
        ❌ Sin stock
    </span>
@endif


{{-- BOTÓN DETALLE --}}
@if ($producto->stock > 0)
    <a href="{{ route('productos.show', $producto->id) }}" class="btn-tesla-outline w-100 mt-2">
        Ver detalle
    </a>
@else
    <button class="btn btn-secondary w-100 mt-2" disabled>
        No disponible
    </button>
@endif


    </div>

</div>


            </div>
        @endforeach

    </div>

    @endif

</div>

@endsection
