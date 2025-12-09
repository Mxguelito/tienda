@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')

<div class="hero-full">
    <div class="hero-center">

        <h2 class="hero-title">
            Bienvenido a <span>Tienda Digital</span> 🛒
        </h2>

        <p class="hero-sub">
            Los mejores productos al mejor precio. Calidad garantizada.
        </p>

        <a href="{{ route('productos') }}" class="btn-tesla-primary hero-cta">
            Ver Productos
        </a>

        <div class="hero-img-wrap">
            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80" alt="Tienda">
        </div>

    </div>
</div>


{{-- Mostrar 4 productos recomendados (si querés) --}}
@if(isset($productos) && count($productos))
    <h3 class="mb-4">Productos Destacados</h3>

    <div class="row">
        @foreach($productos as $producto)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    <img src="{{ $producto->imagen }}" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">${{ number_format($producto->precio, 0, ',', '.') }}</p>

                        <a href="{{ route('productos.detalle', $producto->id) }}" class="btn btn-outline-primary w-100">
                            Ver más
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
