<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;



class UsuarioController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $usuario = Usuario::where("email", "=", $request->email)->first();
        
        if (isset($usuario->id)) {
            if (Hash::check($request->password, $usuario->password)) {
                $token = $usuario->createToken("auth_token")->plainTextToken;
                response()->json([
                    "access_token" => $token
                ]);
            } else {
                response()->json([
                    "status"=>33,
                    "msj"=>"contraseña incorrecta"
                ]);
            }
        } else {
            response()->json([
                "status"=>0,
                "msj"=>"usuario no existe"
            ]);
        }
    }

    
    public function logout()
    {
        auth()->usuario()->tokens()->delete();
    }

    
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'lastname'=>'required',
            'email'=>'required|email|unique:usuarios',
            'password'=>'required',
            'cellphone'=>'required'
        ]);
        $usuario = new Usuario();
        $usuario->name = $request->name;
        $usuario->lastname = $request->lastname;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->cellphone = $request->cellphone;
        $usuario->save();
    }

    
    public function show(Usuario $usuario)
    {
        response()->json([
            "data"=>auth()->usuario()
        ]);
    }

    
}
