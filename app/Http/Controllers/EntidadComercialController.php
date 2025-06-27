<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\EntidadComercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntidadComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->search;

        if (isset($query)) {
            $entidadComercial = EntidadComercial::orderBy('id', 'desc')->where('razon_social', "LIKE", $query)
                ->with(["contactos"])
                ->paginate(20);
        } else {
            $entidadComercial = EntidadComercial::orderBy('id', 'desc')->with(["contactos"])
                ->paginate(20);
        }
        return response()->json($entidadComercial, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "tipo" => "required"
        ]);

        DB::beginTransaction();

        try {

            // guardar
            $ec = new EntidadComercial();
            $ec->tipo = $request->tipo;
            $ec->razon_social = $request->razon_social;
            $ec->ci_nit_ruc_rut = $request->ci_nit_ruc_rut;
            $ec->telefono = $request->telefono;
            $ec->direccion = $request->direccion;
            $ec->correo = $request->correo;
            $ec->save();

            if (isset($request->nombre_completo)) {
                $contacto = new Contacto();
                $contacto->nombre_completo = $request->nombre_completo;
                $contacto->rol_contacto = $request->rol_contacto;
                $contacto->telefono_secundario = $request->telefono_secundario;
                $contacto->correo_secundario = $request->correo_secundario;
                $contacto->observaciones = $request->observaciones;
                $contacto->entidad_comercial_id = $ec->id;
                $contacto->save();
            }

            DB::commit();

            return response()->json(["menssage" => "Entidad Comercial Registrado"], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(["menssage" => "Ocurrión un error al registrar entidad comercial", "error" => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(EntidadComercial::with(['contactos'])->find($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validar
        $request->validate([
            "tipo" => "required"
        ]);

        DB::beginTransaction();

        try {

            // guardar
            $ec = EntidadComercial::find($id);
            $ec->tipo = $request->tipo;
            $ec->razon_social = $request->razon_social;
            $ec->ci_nit_ruc_rut = $request->ci_nit_ruc_rut;
            $ec->telefono = $request->telefono;
            $ec->direccion = $request->direccion;
            $ec->correo = $request->correo;
            $ec->update();

            DB::commit();

            return response()->json(["message" => "Entidad Comercial Registrado"], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(["message" => "Ocurrión un error al registrar entidad comercial", "error" => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ec = EntidadComercial::find($id);
        $ec->activo = false;
        $ec->update();

        return response()->json(["message" => "Entidad Comercial inactivo"]);
    }
}
