<?php

namespace App\Http\Controllers;

use App\Helpers\AdminCheck;
use App\Models\User;
use App\Models\Producto;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ============================
    // DASHBOARD
    // ============================
    public function index()
    {
        AdminCheck::check();

        return view('admin.dashboard', [
            'totalUsuarios'  => User::count(),
            'totalProductos' => Producto::count(),
            'totalOrdenes'   => Order::count(),
            'totalRecaudado' => Order::sum('total'),
            'ultimasOrdenes' => Order::latest()->take(10)->get()
        ]);
    }

    // ============================
    // LISTADO DE ÓRDENES
    // ============================
    public function ordenes()
    {
        AdminCheck::check();

        $ordenes = Order::latest()->get();
        return view('admin.ordenes', compact('ordenes'));
    }

    // ============================
    // VER ORDEN
    // ============================
    public function verOrden($id)
    {
        AdminCheck::check();

        $orden = Order::findOrFail($id);
        return view('admin.ver-orden', compact('orden'));
    }

    // ============================
    // CAMBIAR ESTADO
    // ============================
    public function cambiarEstado(Request $request, $id)
    {
        AdminCheck::check();

        $request->validate([
            'estado' => 'required|string'
        ]);

        $orden = Order::findOrFail($id);
        $orden->estado = $request->estado;
        $orden->save();

        // Mensaje personalizado según nuevo estado
        $mensaje = match ($orden->estado) {
            'pendiente'  => 'Tu pedido está pendiente 🕒',
            'enviado'    => 'Tu pedido fue enviado 🚚',
            'entregado'  => 'Tu pedido fue entregado 📦',
            'cancelado'  => 'Tu pedido fue cancelado ❌',
            default      => 'Actualizamos tu pedido'
        };

        // Crear notificación estilizada
        Notification::create([
            'user_id' => $orden->user_id,
            'order_id' => $orden->id,
            'mensaje'  => $mensaje,
            'estado'   => $orden->estado,
            'leida'    => false,
        ]);

        return back()->with('success', 'Estado actualizado con éxito');
    }

    // ============================
    // ELIMINAR ORDEN + REPONER STOCK
    // ============================
    public function eliminarOrden($id)
    {
        AdminCheck::check();

        $orden = Order::findOrFail($id);

        // Convertir carrito en array siempre
        $carrito = is_string($orden->carrito)
            ? json_decode($orden->carrito, true)
            : $orden->carrito;

        $carrito = is_array($carrito) ? $carrito : [];

        // Reponer stock
        foreach ($carrito as $item) {
            $producto = Producto::find($item['id']);

            if ($producto) {
                $producto->stock += $item['cantidad'];
                $producto->save();
            }
        }

        $orden->delete();

        return back()->with('success', 'Orden eliminada y stock repuesto.');
    }
}
