<?php

namespace App\Http\Controllers;

use App\Models\PerfilMecanico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerfilMecanicoController extends Controller
{

    public function verificarPerfil($id)
    {
        $perfil = PerfilMecanico::where('user_id', $id)->first();

        if (!$perfil) {
            return response()->json([
                'status' => false,
                'alert' => 'error',
                'message' => 'Perfil mecánico no creado'
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado',
            'alert' => 'success'
        ], 200);
    }



    public function store(Request $request)
    {
        $rules = [
            'logo' => 'required|image|mimes:jpeg,png,jpg',
            'nombre_taller' => 'nullable|string',
            'representante' => 'required|string',
            'direccion' => 'nullable|string'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $nombreTaller = $request->input('nombre_taller');
        $direccion = $request->input('direccion');

        $perfilMecanico = new PerfilMecanico();


        if(isset($nombreTaller)){
            $perfilMecanico->nombre_taller = $nombreTaller;
        }
        if(isset($direccion) || !empty($direccion)){
            $perfilMecanico->direccion = $direccion;
        }

        $file = $request->logo;
        $extension = $file->getClientOriginalExtension();
        $path = $file->storeAs('public/perfilMecanico', $request->representante . $this->random() . '.' . $extension);

        $perfilMecanico->logo = $path;
        $perfilMecanico->nombre_taller = $request->nombre_taller;
        $perfilMecanico->numero = $request->numero;
        $perfilMecanico->user_id = $request->user_id;
        $perfilMecanico->save();

        return response()->json([
            'status' => true,
            'message' => 'Pefil mecanico creado con exito',
        ], 200);

    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
