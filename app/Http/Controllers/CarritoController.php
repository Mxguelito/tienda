<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    
    // AGREGAR AL CARRITO
    public function agregar(Request $request, $id)
    {
        // Buscar producto
        $producto = Producto::findOrFail($id);

        // Obtener carrito actual 
        $carrito = session()->get('carrito', []);
        // VALIDAR STOCK DISPONIBLE
if ($producto->stock <= 0) {
    return redirect()->route('carrito.ver')
        ->with('error', 'Este producto no tiene stock.');
}

// Si ya existe en el carrito, evitamos superar el stock
if (isset($carrito[$id]) && $carrito[$id]['cantidad'] >= $producto->stock) {
    return redirect()->route('carrito.ver')
        ->with('error', 'No podés agregar más unidades. Stock disponible: ' . $producto->stock);
}


        // Si ya existe en el carrito, sumamos 1
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            // Si no existe, lo agregamos
            $carrito[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagen,
                'cantidad' => 1
            ];
        }

        // Guardar carrito actualizado
        session()->put('carrito', $carrito);

        // Redirigir al carrito
        return redirect()->route('carrito.ver')->with('success', 'Producto agregado al carrito.');
    }

   
    // VER CARRITO
    public function ver()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    
    // ELIMINAR PRODUCTO DEL CARRITO
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }


    // ===========================================
    public function sumar($id)
{
    $carrito = session('carrito', []);
    $producto = \App\Models\Producto::find($id);

// VALIDAR QUE NO SE SUPERE EL STOCK
if ($producto && $carrito[$id]['cantidad'] >= $producto->stock) {
    return redirect()->route('carrito.ver')
        ->with('error', 'No podés agregar más unidades. Stock disponible: ' . $producto->stock);
}


    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad'] += 1;
    }

    session(['carrito' => $carrito]);

    return redirect()->route('carrito.ver');
}

public function restar($id)
{
    $carrito = session('carrito', []);

    if (isset($carrito[$id])) {

        // Resta 1
        $carrito[$id]['cantidad'] -= 1;

        // Si llega a 0, eliminar producto
        if ($carrito[$id]['cantidad'] <= 0) {
            unset($carrito[$id]);
        }
    }

    session(['carrito' => $carrito]);

    return redirect()->route('carrito.ver');
}

}
