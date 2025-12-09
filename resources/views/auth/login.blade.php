@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 450px;">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="/login" method="POST">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button class="btn btn-primary w-100">Entrar</button>

        <p class="mt-3 text-center">
            ¿No tenés cuenta? <a href="/register">Registrate</a>.
        </p>
    </form>
</div>
@endsection
