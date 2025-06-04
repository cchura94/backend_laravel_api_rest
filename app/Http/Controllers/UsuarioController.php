<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function funListar(){

        // SQL
        $users = DB::select("select * from users");
        // Query Builder
        // $users = DB::table("users")->get();
        // Eloquent ORM
        // $users = User::get();

        return response()->json($users, 200);
    }

    public function funGuardar(Request $request){

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        $nombre = $request->name;
        $correo = $request->email;
        $clave = Hash::make($request->password);
        // SQL
        // DB::insert("insert into users (name, email, password) values(?, ?, ?)", [$nombre, $correo, $clave]);
        // query Builder
        /*
        DB::table("users")->insert([
            "name" => $nombre,
            "email" => $correo,
            "password" => $clave
        ]);
        */
        // Eloquent ORM
        $user = new User();
        $user->name = $nombre;
        $user->email = $correo;
        $user->password = $clave;
        $user->save();
        
        return response()->json(["message" => "Usuario Registrado", "user" => $user], 201);
    }

    public function funMostrar($id){

        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    public function funModificar($id, Request $request){

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email,$id"
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->password)){
            $user->password = $request->password;
        }
        $user->update();

        return response()->json(["mensaje" => "Usuario Actualizado"], 201);
    }

    public function funEliminar($id){
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(["mensaje" => "Usuario Eliminado"], 200);

    } 
}
