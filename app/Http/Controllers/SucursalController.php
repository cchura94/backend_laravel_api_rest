<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sucursales = Sucursal::get();

        return response()->json($sucursales, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // VALIDAR
        $request->validate([
            "nombre" => "required",
            "direccion" => "required",
            "telefono" => "required"
        ]);
        // guardar
        $sucursal = new Sucursal();
        $sucursal->nombre = $request->nombre;
        $sucursal->direccion = $request->direccion;
        $sucursal->telefono = $request->telefono;
        $sucursal->ciudad = $request->ciudad;
        $sucursal->save();

        return response()->json(["message" => "Sucursal Registrado", "sucursal" => $sucursal], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return response()->json($sucursal, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validar
        $request->validate([
            "nombre" => "required",
            "direccion" => "required",
            "telefono" => "required"
        ]);
        // modificar
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->nombre = $request->nombre;
        $sucursal->direccion = $request->direccion;
        $sucursal->telefono = $request->telefono;
        $sucursal->ciudad = $request->ciudad;
        $sucursal->update();

        return response()->json(["message" => "Sucursal Actualizado", "sucursal" => $sucursal], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
