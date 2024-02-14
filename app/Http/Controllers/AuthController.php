<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ConductorData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:90',
            'edad' => 'required|integer',
            'rol' => 'string',
            'correo' => 'required|string|max:100',
            'password' => 'required|string'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $licencia = $request->input('licencia');
        $numero_licencia = $request->input('numero_licencia');
        $rol = $request->input('rol');

        $rolConductor = isset($licencia) ? "conductor" : "futuro_conductor"; 

        $rolUser = "";

        if($rol == "mecanico_independiente" || $rol == "taller_mecanico"){
            $rolUser = $rol;
        }else{
            $rolUser = $rolConductor;
        }

        $user = new User();

        $user->nombre = $request->nombre;
        $user->edad = $request->edad;
        $user->rol = $rolUser;
        $user->correo = $request->correo;
        $user->password = Hash::make($request->password);
        $user->save();

        if (isset($licencia)) { 
            $conductorData = new ConductorData();
            $conductorData->licencia = $licencia;
            $conductorData->numero_licencia = $numero_licencia;
            $conductorData->user_id = $user->id;
            $conductorData->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuario Creado',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $rules = [
            'correo' => 'required|string|max:100',
            'password' => 'required|string'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
        if(!Auth::attempt($request->only('correo', 'password'))){
            return response()->json([
                'status' => false,
                'errors' => ['Unauthorized']
            ], 401);
        }

        $user = User::where('correo', $request->correo)->first();
        return response()->json([
            'status' => true,
            'message' => 'Usuario logeado correctamente',
            'data' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Sesion cerrada correctamente',
        ], 200);
    }
}
