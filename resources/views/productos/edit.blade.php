@extends('layouts.app')

@section('titulo', 'Editar Producto')

@section('content')

<div class="tesla-form-card">

    <h2 class="title-tesla">Editar Producto</h2>

    @if($errors->any())
        <div class="alert alert-danger tesla-alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto->id) }}" 
          method="POST" 
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- NOMBRE -->
        <div class="group">
            <label class="label">Nombre</label>
            <input type="text" name="nombre" class="input-tesla" value="{{ $producto->nombre }}">
        </div>

        <!-- PRECIO -->
        <div class="group">
            <label class="label">Precio</label>
            <input type="number" name="precio" class="input-tesla" value="{{ $producto->precio }}">
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="group">
            <label class="label">Descripción</label>
            <textarea name="descripcion" class="input-tesla" rows="3">{{ $producto->descripcion }}</textarea>
        </div>

        <!-- STOCK -->
        <div class="group">
            <label class="label">Stock</label>
            <input type="number" name="stock" class="input-tesla" value="{{ $producto->stock }}">
        </div>

        <!-- IMAGEN ACTUAL -->
        <div class="group">
            <label class="label">Imagen actual</label>
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-edit-preview">
            @else
                <p class="text-muted">Sin imagen</p>
            @endif
        </div>

        <!-- SUBIR IMAGEN -->
        <div class="group">
            <label class="label">Cambiar imagen</label>
            <input type="file" name="imagen" class="input-tesla-file">
        </div>

        <!-- BOTONES -->
        <div class="btns-row">
            <button type="submit" class="btn-tesla-save">Actualizar</button>

            <a href="{{ route('productos.show', $producto->id) }}" class="btn-tesla-cancel">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection
