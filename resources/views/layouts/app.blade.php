<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - Tienda Digital</title>
    
    
    
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/tesla.css') }}">

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>




 


</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-tesla fixed-top">
    <div class="container py-2">

        {{-- BRAND / LOGO --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <strong>MVM STORE</strong>
        </a>

        {{-- BOTÓN RESPONSIVE --}}
        <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTesla">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- ITEMS --}}
        <div class="collapse navbar-collapse" id="navbarTesla">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- LINK PRODUCTOS --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos') }}">Productos</a>
                </li>

                {{-- CARRITO (solo usuario logueado) --}}
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('compras.historial') }}">
                        📦 Mis compras
                    </a>
                </li>
                @endauth

              {{-- ADMIN --}}
@auth
@if(auth()->user()->role === 'admin')
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        👑 Admin
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.ordenes') }}">
        📦 Órdenes
    </a>
</li>
@endif
@endauth

{{-- NOTIFICACIONES --}}
@auth
    @php
        $notificaciones = \App\Models\Notification::where('user_id', auth()->id())
            ->where('leida', false)
            ->count();
    @endphp

    <li class="nav-item position-relative">
        <a href="{{ url('/notificaciones') }}" class="nav-link" style="color:white; font-size:18px;">
            🔔
        </a>

        @if($notificaciones > 0)
            <span style="
                position:absolute;
                top:0;
                right:0;
                background:#ff4081;
                color:white;
                padding:2px 6px;
                border-radius:50%;
                font-size:11px;
                font-weight:bold;
            ">
                {{ $notificaciones }}
            </span>
        @endif
    </li>
@endauth



                {{-- LOGIN / LOGOUT --}}
                <li class="nav-item ms-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-login">Ingresar</a>
                    @else
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="btn btn-login">Salir</button>
                        </form>
                    @endguest
                </li>

            </ul>
        </div>
    </div>
</nav>

{{-- ESPACIADOR (para que no tape el contenido) --}}
<div style="height: 80px;"></div>


    <main>
        @if(session('success'))
    <div class="alert alert-success text-center py-3" 
         style="background:#a5ffce; color:#003f1f; font-weight:bold;">
        {{ session('success') }}
    </div>
@endif

        @yield('content')
        

    </main>

 <footer class="footer-tesla">
    <div class="footer-container">

        <div class="footer-col">
            <h3 class="footer-title">Tienda Digital</h3>
            <p class="footer-text">
                Comprá con confianza. Los mejores productos al mejor precio.
            </p>
        </div>

        <div class="footer-col">
            <h4 class="footer-sub">Secciones</h4>
            <ul>
                <li><a href="{{ url('/') }}">Inicio</a></li>
                <li><a href="{{ route('productos') }}">Productos</a></li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="{{ route('compras.historial') }}">Mis compras</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4 class="footer-sub">Contacto</h4>
            <ul>
                <li>📩 contacto@tiendadigital.com</li>
                <li>📞 11-5555-5555</li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        © 2025 — Tienda Digital. Todos los derechos reservados.
    </div>
</footer>







</body>
</html>
