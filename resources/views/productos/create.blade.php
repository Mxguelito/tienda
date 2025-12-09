@extends('layouts.app')

@section('titulo', 'Crear Producto')

@section('content')

<div class="tesla-form-card">

    <h2 class="title-tesla">Crear nuevo producto</h2>

    @if($errors->any())
        <div class="alert alert-danger tesla-alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="group">
            <label class="label">Nombre</label>
            <input type="text" name="nombre" class="input-tesla" placeholder="Ej: Silla gamer PRO">
        </div>

        <div class="group">
            <label class="label">Precio</label>
            <input type="number" name="precio" class="input-tesla" placeholder="Ej: 150000">
        </div>

        <div class="group">
            <label class="label">Descripción</label>
            <textarea name="descripcion" class="input-tesla" rows="3" placeholder="Escribí una descripción"></textarea>
        </div>

        <div class="group">
            <label class="label">Stock</label>
            <input type="number" name="stock" class="input-tesla" placeholder="Ej: 10">
        </div>

        <div class="group">
            <label class="label">Imagen</label>
            <input type="file" name="imagen" class="input-tesla-file">
        </div>

        <button type="submit" class="btn-tesla-save">Guardar producto</button>

    </form>

</div>

@endsection
