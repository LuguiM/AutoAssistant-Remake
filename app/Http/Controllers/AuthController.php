<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:90',
            'edad' => 'required',
            'rol' => 'required|string',
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
        $user = new User([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'rol' => $request->rol,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

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
