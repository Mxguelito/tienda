@extends('layouts.app')

@section('titulo', 'Finalizar compra')

@section('content')

<div class="tesla-form-card">

    <h2 class="title-tesla">🧾 Finalizar compra</h2>

    <form action="{{ route('checkout.procesar') }}" method="POST">
        @csrf

        <div class="group">
            <label class="label">Nombre completo:</label>
            <input type="text" name="nombre" class="input-tesla" required>
        </div>

        <div class="group">
            <label class="label">Email:</label>
            <input type="email" name="email" class="input-tesla" required>
        </div>

        <div class="group">
            <label class="label">Dirección de envío:</label>
            <input type="text" name="direccion" class="input-tesla" required>
        </div>

        <button type="submit" class="btn-tesla-primary" style="width: 100%; margin-top: 20px;">
            Confirmar compra
        </button>
    </form>

</div>

@endsection
