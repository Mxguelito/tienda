@extends('layouts.app')

@section('titulo', 'Notificaciones')

@section('content')

<div class="container my-5">

    <h2 class="tesla-title">🔔 Mis notificaciones</h2>

    @if($notificaciones->isEmpty())
        <p style="color:#e0d0ff; font-size:18px; margin-top:20px;">
    No tenés notificaciones por ahora.
</p>

    @else
        <ul class="list-group tesla-list mt-4">

            @foreach($notificaciones as $n)
             <li class="list-group-item"
    style="background:#1a1a1a; border:1px solid #9b4dff; border-radius:8px; padding:18px; margin-bottom:12px; color:#f7e9ff;">

    <div style="font-size:18px; font-weight:bold; color:#e8d2ff;">
        ✔ Tu pedido fue actualizado
    </div>

    <small style="color:#caa8ff !important; font-size:13px;">
        {{ $n->created_at->format('d/m/Y H:i') }}
    </small>

</li>

            @endforeach

        </ul>
    @endif

</div>

@endsection
