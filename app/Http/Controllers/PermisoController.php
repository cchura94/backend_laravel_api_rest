<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persmisos = Permiso::get();

        return response()->json($persmisos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|unique:permisos"
        ]);

        $permiso = new Permiso();
        $permiso->nombre = $request->nombre;
        $permiso->descripcion= $request->descripcion;
        $permiso->subject= $request->subject;
        $permiso->action= $request->action;
        $permiso->save();

        return response()->json(["message" => "El permiso ha sido registrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permiso = Permiso::find($id);
        return response()->json($permiso, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            "nombre" => "required|unique:permisos,nombre,$id"
        ]);

        $permiso = Permiso::find($id);
        $permiso->nombre = $request->nombre;
        $permiso->descripcion= $request->descripcion;
        $permiso->subject= $request->subject;
        $permiso->action= $request->action;
        $permiso->update();

        return response()->json(["message" => "El permiso ha sido actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
