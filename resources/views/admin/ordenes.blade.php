@extends('layouts.app')

@section('titulo', 'Gestión de Órdenes')

@section('content')
<div class="container my-4">

    <h1 class="mb-4 text-center">📦 Gestión de Órdenes</h1>

    @if($ordenes->isEmpty())
        <p class="text-muted text-center">No hay órdenes registradas.</p>
    @else

    <!-- ==========================
         VISTA DESKTOP (TABLA)
    =========================== -->
    <div class="d-none d-md-block">
        <table class="table table-dark table-striped text-center align-middle"
                style="border-radius: 12px; overflow: hidden;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($ordenes as $o)
                <tr>
                    <td>{{ $o->id }}</td>
                    <td>{{ $o->nombre }}</td>
                    <td>{{ $o->email }}</td>
                    <td>{{ $o->direccion }}</td>
                    <td>${{ number_format($o->total, 0, ',', '.') }}</td>

                    <td>
                        <span class="badge 
                            @if($o->estado == 'pendiente') bg-warning 
                            @elseif($o->estado == 'enviado') bg-info 
                            @elseif($o->estado == 'entregado') bg-success 
                            @elseif($o->estado == 'cancelado') bg-danger 
                            @endif">
                            {{ ucfirst($o->estado) }}
                        </span>
                    </td>

                    <td>
                        <!-- Ver -->
                        <a href="{{ route('admin.orden.ver', $o->id) }}" class="btn btn-sm btn-primary mb-1">Ver</a>

                        <!-- Estado -->
                        <form action="{{ route('admin.orden.estado', $o->id) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option {{ $o->estado=='pendiente' ? 'selected':'' }}>pendiente</option>
                                <option {{ $o->estado=='enviado' ? 'selected':'' }}>enviado</option>
                                <option {{ $o->estado=='entregado' ? 'selected':'' }}>entregado</option>
                                <option {{ $o->estado=='cancelado' ? 'selected':'' }}>cancelado</option>
                            </select>
                        </form>

                        <!-- Eliminar -->
                        <form action="{{ route('admin.orden.eliminar', $o->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger mt-1">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- ==========================
         VISTA MOBILE (CARDS)
    =========================== -->
    <div class="d-md-none">
        @foreach($ordenes as $o)
        <div class="card shadow-sm mb-3 p-3" style="border-radius: 14px; background: #1a1a1a; color:white;">

            <h5 class="fw-bold mb-2">#{{ $o->id }} — {{ $o->nombre }}</h5>

            <p class="m-0"><strong>Email:</strong> {{ $o->email }}</p>
            <p class="m-0"><strong>Dirección:</strong> {{ $o->direccion }}</p>
            <p class="m-0"><strong>Total:</strong> ${{ number_format($o->total, 0, ',', '.') }}</p>

            <p class="mt-2">
                <strong>Estado:</strong>
                <span class="badge 
                    @if($o->estado == 'pendiente') bg-warning 
                    @elseif($o->estado == 'enviado') bg-info 
                    @elseif($o->estado == 'entregado') bg-success 
                    @elseif($o->estado == 'cancelado') bg-danger 
                    @endif">
                    {{ ucfirst($o->estado) }}
                </span>
            </p>

            <div class="mt-3 d-flex flex-column gap-2">

                <a href="{{ route('admin.orden.ver', $o->id) }}" class="btn btn-primary btn-sm w-100">
                    Ver detalle
                </a>

                <form action="{{ route('admin.orden.estado', $o->id) }}" method="POST">
                    @csrf
                    <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option {{ $o->estado=='pendiente' ? 'selected':'' }}>pendiente</option>
                        <option {{ $o->estado=='enviado' ? 'selected':'' }}>enviado</option>
                        <option {{ $o->estado=='entregado' ? 'selected':'' }}>entregado</option>
                        <option {{ $o->estado=='cancelado' ? 'selected':'' }}>cancelado</option>
                    </select>
                </form>

                <form action="{{ route('admin.orden.eliminar', $o->id) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar orden?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm w-100">
                        Eliminar
                    </button>
                </form>

            </div>
        </div>
        @endforeach
    </div>

    @endif

</div>
@endsection
