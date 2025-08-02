<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $activo = isset($request->activo)?$request->activo:null;
        $almacenID = isset($request->almacen)?$request->almacen:null;


        $productos = Producto::query();

        if(isset($activo)){
            $productos = $productos->where('activo',"=",$request->activo);
        }

        if (isset($request->search)) {
            $search = $request->search;
            $productos = $productos
                                ->where("nombre", "iLIKE", "%$search%")
                                ->orwhere('marca', "iLIKE", "%$search%");
        } 

        if(isset($almacenID)){

            $productos = $productos->whereHas('almacens', function ($query) use ($almacenID){
                            $query->where('almacens.id', "=", $almacenID);
                        });
                
        }

        $productos = $productos->with(['categoria', 'almacens'])
                    ->orderBy('id', 'desc')
                    ->paginate($limit);

        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...

            // validar
            $request->validate([
                "nombre" => "required",
                "unidad_medida" => "required",
                "categoria_id" => "required",
                "fecha_registro" => "required",
                "precio_venta_actual" => "required",
                "stock_minimo" => "required"
            ]);

            // guardar
            $prod = new Producto();
            $prod->nombre = $request->nombre;
            $prod->unidad_medida = $request->unidad_medida;
            $prod->categoria_id = $request->categoria_id;
            $prod->fecha_registro = $request->fecha_registro;
            $prod->descripcion = $request->descripcion;
            $prod->codigo_barra = $request->codigo_barra;
            $prod->marca = $request->marca;
            $prod->precio_venta_actual = $request->precio_venta_actual;
            $prod->stock_minimo = $request->stock_minimo;
            $prod->activo = $request->activo?$request->activo:true;

            // subida de imagen
            if ($file = $request->file("imagen")) {
                $direccion_url = time() . "-" . $file->getClientOriginalName();
                $file->move("imagenes", $direccion_url);
                $prod->imagen_url = "imagenes/" . $direccion_url;
            }

            $prod->save();

            return response()->json($prod);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["message" => "Error al realizar la consulta", "error" => $th->getMessage()]);
        }

        // responder
    }

    public function guardarProductoImagen(Request $request)
    {

        try {

            // validar
            $request->validate([
                "nombre" => "required",
                "unidad_medida" => "required",
                "categoria_id" => "required",
                "fecha_registro" => "required",
                "precio_venta_actual" => "required",
                "stock_minimo" => "required",
                "activo" => "required"
            ]);

            // guardar
            $prod = new Producto();
            $prod->nombre = $request->nombre;
            $prod->unidad_medida = $request->unidad_medida;
            $prod->categoria_id = $request->categoria_id;
            $prod->fecha_registro = $request->fecha_registro;
            $prod->descripcion = $request->descripcion;
            $prod->codigo_barra = $request->codigo_barra;
            $prod->marca = $request->marca;
            $prod->precio_venta_actual = $request->precio_venta_actual;
            $prod->stock_minimo = $request->stock_minimo;
            $prod->activo = $request->activo;

            if ($file = $request->file("imagen")) {
                $direccion_url = time() . "-" . $file->getClientOriginalName();
                $file->move("imagenes", $direccion_url);
                $prod->imagen_url = "imagenes/" . $direccion_url;
            }

            $prod->save();

            return response()->json(["message" => "Producto Registrado"], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Error al realizar la consulta"]);
        }
    }

    public function actualizarProductoImagen(Request $request, $id)
    {

        try {


            // guardar
            $prod = Producto::find($id);

            if ($file = $request->file("imagen")) {
                $direccion_url = time() . "-" . $file->getClientOriginalName();
                $file->move("imagenes", $direccion_url);
                $prod->imagen_url = "imagenes/" . $direccion_url;
            }

            $prod->update();

            return response()->json(["message" => "Imagen Actualizado"], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Error al realizar la consulta"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validar
        $request->validate([
            "nombre" => "required",
            "unidad_medida" => "required",
            "categoria_id" => "required",
            "fecha_registro" => "required",
            "precio_venta_actual" => "required",
            "stock_minimo" => "required",
            "activo" => "required"
        ]);

        $prod = Producto::findOrFail($id);

        $prod->nombre = $request->nombre;
        $prod->unidad_medida = $request->unidad_medida;
        $prod->categoria_id = $request->categoria_id;
        $prod->fecha_registro = $request->fecha_registro;
        $prod->descripcion = $request->descripcion;
        $prod->codigo_barra = $request->codigo_barra;
        $prod->marca = $request->marca;
        $prod->precio_venta_actual = $request->precio_venta_actual;
        $prod->stock_minimo = $request->stock_minimo;
        $prod->activo = $request->activo;

        if ($file = $request->file("imagen")) {
            $direccion_url = time() . "-" . $file->getClientOriginalName();
            $file->move("imagenes", $direccion_url);
            $prod->imagen_url = "imagenes/" . $direccion_url;
        }

        $prod->update();

        return response()->json(["message" => "Producto Actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prod = Producto::findOrFail($id);
        $prod->activo = false;
        $prod->update();
        return response()->json(["message" => "Producto ha cambiado el estado"], 201);
    }
}
