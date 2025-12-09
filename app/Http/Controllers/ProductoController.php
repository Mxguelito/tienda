<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Helpers\AdminCheck;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos', compact('productos'));
    }

    public function create()
    {
        AdminCheck::check(); //SOLO ADMIN
        return view('productos.create');
    }

    public function store(Request $request)
    {
        AdminCheck::check(); 

        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240'
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $ruta;
        }

        Producto::create($data);

        return redirect()->route('productos')->with('success', 'Producto creado correctamente');
    }

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id)
    {
        AdminCheck::check(); 
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        AdminCheck::check(); 

        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $producto = Producto::findOrFail($id);
        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $ruta;
        }

        $producto->update($data);

        return redirect()->route('productos.show', $producto->id)
                        ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        AdminCheck::check(); 

        $producto = Producto::findOrFail($id);

        if ($producto->imagen) {
            \Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('productos')
                        ->with('success', 'Producto eliminado correctamente');
    }
}
