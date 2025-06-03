<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas
Route::get('/saludo', function(){
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
