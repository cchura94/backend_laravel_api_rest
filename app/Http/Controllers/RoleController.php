<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('listar-role');
        
        $roles = Role::with(["permisos"])->get();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Gate::authorize('create-role');

        $request->validate([
            "nombre" => "required"
        ]);

        $role = new Role();
        $role->nombre = $request->nombre;
        $role->descripcion = $request->descripcion;
        $role->save();

        return response()->json(["message" => "Role Regitrado Correctamente..."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('show-role');
        $role = Role::findOrFail($id);

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('update-role');

        $request->validate([
            "nombre" => "required"
        ]);

        
        $role = Role::findOrFail($id);

        $role->nombre = $request->nombre;
        $role->descripcion = $request->descripcion;
        $role->update();

        return response()->json(["message" => "Role actualizado Correctamente..."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function funActualizarPermisos($id, Request $request){
        Gate::authorize('update-role');
        $role = Role::find($id);
        $role->permisos()->sync($request["permisos_id"]);

        return response()->json(["mensaje" => "Permisos actualizados"]);

    }
}
