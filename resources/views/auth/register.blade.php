@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 450px;">
    <h2 class="text-center mb-4">Crear Cuenta</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="/register" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button class="btn btn-success w-100">Registrarme</button>

        <p class="mt-3 text-center">
            ¿Ya tenés cuenta? <a href="/login">Iniciar sesión</a>.
        </p>
    </form>
</div>
@endsection
