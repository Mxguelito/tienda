@extends('layouts.app')

@section('titulo', 'Panel de Administración')

@section('content')
<div class="container my-4">

    <h1 class="mb-4 text-center">👑 Panel de Administración</h1>

    {{-- ========================== --}}
    {{-- 📘 Información del sistema --}}
    {{-- ========================== --}}

    <h4 class="mb-3">📘 Información del sistema</h4>

    <div class="row g-3">

        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Usuarios registrados</h6>
                    <h2 class="fw-bold">{{ $totalUsuarios }}</h2>
                </div>
            </div>
        </div>

    </div>


    {{-- ========================== --}}
    {{-- 🛒 Información de la tienda --}}
    {{-- ========================== --}}

    <h4 class="mb-3 mt-4">🛒 Información de la tienda</h4>

    <div class="row g-3">

        {{-- Productos publicados --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Productos publicados</h6>
                    <h2 class="fw-bold">{{ $totalProductos }}</h2>
                </div>
            </div>
        </div>

        {{-- Órdenes totales --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Órdenes totales</h6>
                    <h2 class="fw-bold">{{ $totalOrdenes }}</h2>
                </div>
            </div>
        </div>

        {{-- Recaudado --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted">Recaudado</h6>
                    <h2 class="fw-bold">
                        ${{ number_format($totalRecaudado, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>

    </div>


    {{-- ========================== --}}
    {{-- 📄 Últimas compras --}}
    {{-- ========================== --}}

    <h4 class="mb-3 mt-4">📄 Últimas compras</h4>

    @if($ultimasOrdenes->isEmpty())

        <p class="text-muted text-center">No hay compras todavía.</p>

    @else

        {{-- ===================== --}}
        {{-- 📱 VISTA MOBILE (CARDS) --}}
        {{-- ===================== --}}
        <div class="d-md-none">

            @foreach($ultimasOrdenes as $o)
                <div class="card shadow-sm p-3 mb-3" style="background:#111; border-radius:14px;">

                    <h5 class="mb-1" style="color:#18ffff; font-weight:600;">
    #{{ $o->id }} — {{ $o->nombre }}
</h5>

<p class="mb-1" style="color:#ddd;">
    <strong style="color:white;">Fecha:</strong> {{ $o->created_at->format('d/m/Y') }}
</p>

<p class="mb-1" style="color:#ddd;">
    <strong style="color:white;">Total:</strong> ${{ number_format($o->total, 0, ',', '.') }}
</p>


                    <a href="{{ route('admin.orden.ver', $o->id) }}"
                       class="btn btn-primary btn-sm w-100 mt-2">
                        Ver detalle
                    </a>

                    <a href="{{ route('admin.ordenes') }}" 
                       class="btn btn-dark btn-sm w-100 mt-2">
                        📦 Gestionar Órdenes
                    </a>
                </div>
            @endforeach

        </div>

        {{-- ===================== --}}
        {{-- 🖥️ VISTA DESKTOP (TABLA) --}}
        {{-- ===================== --}}
        <div class="card shadow-sm d-none d-md-block">
            <div class="card-body">

                <table class="table table-striped text-center align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ultimasOrdenes as $o)
                        <tr>
                            <td>{{ $o->nombre }}</td>
                            <td>{{ $o->created_at->format('d/m/Y') }}</td>
                            <td>${{ number_format($o->total, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.orden.ver', $o->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Ver
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    @endif

</div>
@endsection
