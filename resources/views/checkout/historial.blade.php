@extends('layouts.app')

@section('titulo', 'Historial de compras')

@section('content')

<div class="container my-5 historial-min-height">


    <h2 class="tesla-title">🧾 Historial de compras</h2>

   <div class="tesla-table-container historial-compras-wrapper">


        <table class="tesla-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Detalles</th>
        </tr>
    </thead>

    <tbody>
        @php
            // Cantidad total de compras de ESTE usuario
            $total = $orders->count();
        @endphp

        @foreach($orders as $compra)
            <tr>
                {{-- Numeración inversa: la primera compra es 1, la última es $total --}}
                <td>{{ $loop->iteration }}</td>

                <td>{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $compra->nombre }}</td>
                <td>{{ $compra->email }}</td>
                <td>${{ number_format($compra->total, 0, ',', '.') }}</td>

                <td>
                    @php
                        $estado = $compra->estado ?? 'pendiente';
                    @endphp

                    @if($estado === 'pendiente')
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @elseif($estado === 'enviado')
                        <span class="badge bg-info text-dark">Enviado</span>
                    @elseif($estado === 'entregado')
                        <span class="badge bg-success">Entregado</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($estado) }}</span>
                    @endif
                </td>

                <td>
                    <a href="{{ url('/compras/' . $compra->id) }}" class="btn-tesla-details">
                        Ver detalle
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


    </div>

</div>

@endsection
