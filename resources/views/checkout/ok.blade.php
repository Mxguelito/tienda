@extends('layouts.app')

@section('titulo', 'Compra realizada')

@section('content')
<div class="d-flex justify-content-center mt-5">

    <div class="checkout-ok-card">


        <h2 style="
            color: #d5b6ff;
            font-weight: 700;
            margin-bottom: 10px;
        ">
            🎉 ¡Gracias por tu compra!
        </h2>

        <p style="color: #ddd; font-size: 17px;">
            Tu pedido fue registrado correctamente.  
            Estamos preparando todo para enviártelo ✨
        </p>

        <div style="margin-top: 25px;">
            <a href="{{ route('productos') }}"
               style="
                    padding: 12px 30px;
                    background: linear-gradient(90deg, #a56cff, #ff75b9);
                    color: white;
                    font-weight: 600;
                    border-radius: 10px;
                    text-decoration: none;
                    box-shadow: 0 0 14px rgba(186, 104, 200, 0.45);
                    transition: 0.25s;
               "
               onmouseover="this.style.boxShadow='0 0 22px rgba(255,118,200,0.65)'"
               onmouseout="this.style.boxShadow='0 0 14px rgba(186,104,200,0.45)'"
            >
                Seguir comprando
            </a>
        </div>

    </div>

</div>
@endsection
