<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Nota;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validacion
        $validated = $request->validate([
            "codigo_nota" => "required|string|unique:notas,codigo_nota",
            "fecha_emision" => "required|date",
            "tipo_nota" => "required|in:venta,compra,devolucion",
            "entidad_comercial_id" => "required|exists:entidad_comercials,id",
            "user_id" => "required|exists:users,id",
            "subtotal" => "nullable|numeric",
            "impuestos" => "nullable|numeric",
            "descuento_total" => "nullable|numeric",
            "total_calculado" => "nullable|numeric",
            "estado_nota" => "required|string",
            "observaciones" => "nullable|string",
            "movimientos" => "required|array|min:1",
            "movimientos.*.producto_id" => "required|exists:productos,id",
            "movimientos.*.almacen_id" => "required|exists:almacens,id",
            "movimientos.*.cantidad" => "required|integer|min:1",
            "movimientos.*.tipo_movimiento" => "required|in:ingreso,salida,devolucion",
            "movimientos.*.precio_unitario_compra" => "required|numeric",
            "movimientos.*.precio_unitario_venta" => "required|numeric",
            "movimientos.*.total_linea" => "required|numeric",
            "movimientos.*.observaciones" => "nullable|string"
        ]);

        DB::beginTransaction();

        try {

            $nota = new Nota();
            $nota->codigo_nota = $request->codigo_nota;
            $nota->fecha_emision = $request->fecha_emision;
            $nota->tipo_nota = $request->tipo_nota;
            $nota->entidad_comercial_id = $request->entidad_comercial_id;
            $nota->user_id = $request->user_id;
            $nota->subtotal = $request->subtotal;
            $nota->impuestos = $request->impuestos;
            $nota->descuento_total = $request->descuento_total;
            $nota->total_calculado = $request->total_calculado;
            $nota->estado_nota = $request->estado_nota;
            $nota->observaciones = $request->observaciones;
            $nota->save();

            foreach ($request->movimientos as $mov) {
                // $almacen = Almacen::findOrFail($mov['almacen_id']);
                // $producto = Producto::findOrFail($mov['producto_id']);
                $nota->almacenes()->attach($mov['almacen_id'], [
                    'producto_id' => $mov['producto_id'],
                    'cantidad' => $mov['producto_id'],
                    'tipo_movimiento' => $mov['tipo_movimiento'],
                     'precio_unitario_compra' => $mov['precio_unitario_compra'],
                     'precio_unitario_venta' => $mov['precio_unitario_venta'],
                     'total_linea' => $mov['total_linea'],
                     'observaciones' => $mov['observaciones']??null
                ]);

                // actualizar stock
                $pivot = DB::table("almacen_producto")
                                ->where("almacen_id", $mov['almacen_id'])
                                ->where("producto_id", $mov['producto_id'])
                                ->first();
                
                if(!$pivot){
                    if($mov["tipo_movimiento"] === 'salida'){
                        throw new \Exception("No hay stock para salida en este almacen y producto");                        
                    }

                    DB::table("almacen_producto")->insert([
                        "almacen_id" => $mov["almacen_id"],
                        "producto_id" => $mov["producto_id"],
                        "cantidad" => $mov["cantidad"],
                        "fecha_actualizacion" => now(),
                    ]);
                }else{
                    
                }
                // $stock = $almacen->productos()

                // existenacias por tipo de movimiento

                // registrar Movimiento
                // $movimiento = new Movimiento
            }



            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
