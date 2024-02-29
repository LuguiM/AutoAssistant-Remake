<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PerfilMecanico;
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
            'edad' => 'integer',
            'rol' => 'string',
            'correo' => 'required|string|max:100|email|unique:users,correo',
            'password' => 'required|string',
            'numero_licencia' => 'nullable|regex:/^\d{4}-\d{6}-\d{3}-\d{1}$/'
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
        $edad = $request->input('edad');

        $rolConductor = isset($numero_licencia) && !empty($numero_licencia) ? "conductor" : "futuro_conductor";

        $rolUser = "";

        if($rol == "Mecanico Independiente" || $rol == "Taller Mecanico"){
            $rolUser = $rol;
        }else{
            $rolUser = $rolConductor;
        }

        $user = new User();

        if(isset($edad)){
            $user->edad = $edad;
        }
        $user->nombre = $request->nombre;
        $user->rol = $rolUser;
        $user->correo = $request->correo;
        $user->password = Hash::make($request->password);
        $user->save();

        if (isset($numero_licencia) && !empty($numero_licencia)) {
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
                'errors' => ['Datos Incorrectos']
            ], 401);
        }

        $user = User::where('correo', $request->correo)->first();

        $perfil = PerfilMecanico::where('user_id', $user->id)->first();
        

        if($perfil){
            $user->perfilMecanico = $perfil->id;
        }
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
