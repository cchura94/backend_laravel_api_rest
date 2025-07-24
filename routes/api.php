<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\EntidadComercialController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas
Route::get('/saludos', function(){
    return [
        "message" => "Saludos desde Api (routes/api.php)"
    ];
});



Route::get('/nombre/{nom}', function($nombre){
    return [
        "nombre" => $nombre
    ];
});

Route::get('/nombre/{n}/edad/{ed}', function($nombre, $edad){
    return [
        "nombres" => $nombre,
        "edad" => $edad
    ];
});

// Autenticación Api Rest

Route::prefix("auth")->group(function() {

    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);
    
    Route::middleware("auth:sanctum")->group(function (){
    
        Route::get("/profile", [AuthController::class, "funProfile"]);
        Route::post("/logout", [AuthController::class, "funLogout"]);
    });

});


Route::middleware("auth:sanctum")->group(function(){

    // reporte pdf
    Route::get("/reporte/nota_pdf", [NotaController::class, "funReportePDF"]);


    // Asignar Role a usuario
    Route::post("/users/{id}/roles", [UsuarioController::class, "funActualizarRoles"]);
    // Asignar Permisos a role
    Route::post("/role/{id}/permisos", [RoleController::class, "funActualizarPermisos"]);

    // CRUD USUARIO
    Route::get("/users", [UsuarioController::class, "funListar"]);
    Route::post("/users", [UsuarioController::class, "funGuardar"]);
    Route::get("/users/{id}", [UsuarioController::class, "funMostrar"]);
    Route::put("/users/{id}", [UsuarioController::class, "funModificar"]);
    Route::delete("/users/{id}", [UsuarioController::class, "funEliminar"]);
    
    // actualizar imagen
    Route::post("producto/{id}/actualizar-imagen", [ProductoController::class, "actualizarProductoImagen"]);

    // Registro de producto con Subida de Imagen
    Route::post("producto/imagen", [ProductoController::class, "guardarProductoImagen"]);

    // CRUDs
    Route::apiResource("role", RoleController::class);
    Route::apiResource('almacen', AlmacenController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('contacto', ContactoController::class);
    Route::apiResource('entidad-comercial', EntidadComercialController::class);
    Route::apiResource('nota', NotaController::class);
    Route::apiResource('permiso', PermisoController::class);
    Route::apiResource('persona', PermisoController::class);
    Route::apiResource('producto', ProductoController::class);
    Route::apiResource('sucursales', SucursalController::class);
});

Route::get("/no-autorizado", function (){
    return response()->json(["message" => "No Autorizado para ver el recurso"], 401);
})->name('login');