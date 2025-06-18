<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/sucursal?sucursal=23
        $sucursal = isset($request->sucursal)?$request->sucursal:'';
        if(isset($request->sucursal)){
            $almacenes = Almacen::where("sucursal_id", "=", $sucursal)->get();
        }else{
            $almacenes = Almacen::get();
        }

        return response()->json($almacenes, 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "codigo" => "required",
            "sucursal_id" => "required"
        ]);

        $alm = new Almacen();
        $alm->nombre = $request->nombre;
        $alm->codigo = $request->codigo;
        $alm->sucursal_id = $request->sucursal_id;
        $alm->descripcion = $request->descripcion;
        $alm->save();

        return response()->json(["mensaje" => "Almacen Registrado Correctamente"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alm = Almacen::find($id);

        return response()->json($alm, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required",
            "codigo" => "required",
            "sucursal_id" => "required"
        ]);

        $alm = Almacen::find($id);
        $alm->nombre = $request->nombre;
        $alm->codigo = $request->codigo;
        $alm->sucursal_id = $request->sucursal_id;
        $alm->descripcion = $request->descripcion;
        $alm->update();

        return response()->json(["mensaje" => "Almacen Actualizado Correctamente"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
