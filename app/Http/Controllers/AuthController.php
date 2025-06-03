<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required|min:6|max:50"
        ]);

        if(!Auth::attempt($credenciales)){
            return response()->json(["message" => "Credenciales Incorrectas"]);
        }

        // generar TOKEN
        $token = $request->user()->createToken("Auth Token")->plainTextToken;

        return response()->json(["access_token" => $token, "user" => $request->user()], 201);

    }

    public function funRegister(Request $request){
        // validar datos
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|max:50",
            "cpassword" => "required|same:password"
        ]);
        // registrar usuario
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
 
        // retornar respuesta
        return response()->json(["mensaje" => "Usuario Registrado"]);
    }

    public function funProfile(Request $request){

        $perfil = $request->user();

        return response()->json($perfil, 200);
    }

    public function funLogout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(["mensaje" => "Salio"], 200);
    }
}
