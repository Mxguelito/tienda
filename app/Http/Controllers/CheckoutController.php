<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Producto;   // <-- IMPORTANTE

class CheckoutController extends Controller
{
    public function form()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.ver')
                ->with('error', 'No tenés productos en el carrito.');
        }

        return view('checkout.form', compact('carrito'));
    }

    public function procesar(Request $request)
{
    // Validación de formulario
    $request->validate([
        'nombre' => 'required',
        'email' => 'required|email',
    ]);

    // Obtener carrito
    $carrito = session('carrito', []);

    if (empty($carrito)) {
        return redirect()->route('carrito.ver')
            ->with('error', 'No tenés productos en el carrito.');
    }

    // Validación de stock
    foreach ($carrito as $item) {
        $producto = \App\Models\Producto::find($item['id']);

        if (!$producto || $producto->stock < $item['cantidad']) {
            return redirect()->route('carrito.ver')
                ->with('error', 'No hay stock suficiente para el producto: ' . $item['nombre']);
        }
    }

    // Calcular total
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Restar stock
    foreach ($carrito as $item) {
        $producto = \App\Models\Producto::find($item['id']);
        $producto->update([
            'stock' => max(0, $producto->stock - $item['cantidad'])
        ]);
    }

    

// ===============================
// GUARDAR ORDEN
// ===============================
$orden = Order::create([
    'nombre'        => $request->nombre,
    'email'         => $request->email,
    'direccion'     => $request->direccion,
    'carrito'       => $carrito,
    'total'         => $total,
    'estado'        => 'pendiente',
    'user_id'       => auth()->id(),
   
]);



    // Vaciar carrito
    session()->forget('carrito');

    return view('checkout.ok');
}


    public function historial()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('checkout.historial', compact('orders'));
    }

    public function detalle($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('checkout.detalle', compact('order'));
    }
}
