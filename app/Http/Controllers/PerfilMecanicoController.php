<?php

namespace App\Http\Controllers;

use App\Models\PerfilMecanico;
use App\Models\ServicioMecanico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'message' => 'Usuario con perfil mecanico',
            'id' => $perfil->id,
            'alert' => 'success'
        ], 200);
    }

    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = PerfilMecanico::query();

        if (!empty($searchTerm)) {
            $query->where('representante', 'like', "%$searchTerm%")
                ->orWhere('nombre_taller', 'like', "%$searchTerm%");
        }

        $perfiles = $query->paginate(10);

        if ($perfiles->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontraron perfiles mecánicos',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $perfiles
        ], 200);
    }


    public function store(Request $request)
    {
        $rules = [
            'logo' => 'required',
            'nombre_taller' => 'nullable|string',
            'representante' => 'required|string',
            'direcion' => 'nullable|string',
            'numero' => 'required'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $nombreTaller = $request->input('nombre_taller');
        $direccion = $request->input('direcion');

        $perfilMecanico = new PerfilMecanico();


        if (isset($nombreTaller)) {
            $perfilMecanico->nombre_taller = $nombreTaller;
        }
        if (isset($direccion) || !empty($direccion)) {
            $perfilMecanico->direcion = $direccion;
        }

        $base64Image = $request->input('logo');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $extension = 'png';
        $fileName = $request->input('representante') . '_' . uniqid() . '.' . $extension;
        $storedFileName = 'public/perfilMecanico/' . $fileName;
        Storage::put($storedFileName, $image);
        $path = Storage::url($storedFileName);

        $perfilMecanico->logo = $path;
        $perfilMecanico->nombre_taller = $request->nombre_taller;
        $perfilMecanico->numero = $request->numero;
        $perfilMecanico->representante = $request->representante;
        $perfilMecanico->user_id = $request->user_id;

        if ($perfilMecanico->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Pefil mecanico creado con exito',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrio un error al crear el perfil',
            ], 400);
        }

    }


    public function show($id)
    {
        $perfil = PerfilMecanico::where('user_id', $id)->first();

        if (!$perfil) {
            return response()->json([
                'status' => false,
                'message' => 'Perfil mecánico no encontrado',
            ], 404);
        }

        $perfilId = $perfil->id;

        $servicios = ServicioMecanico::where('perfil_mecanico_id', $perfilId)->get();

        $perfil->servicios = $servicios;

        return response()->json([
            'status' => true,
            'data' => $perfil,
        ], 200);
    }

    public function showPerfil($id)
    {
        $perfil = PerfilMecanico::find($id);

        if (!$perfil) {
            return response()->json([
                'status' => false,
                'message' => 'Perfil mecánico no encontrado',
            ], 404);
        }

        $perfilId = $perfil->id;

        $servicios = ServicioMecanico::where('perfil_mecanico_id', $perfilId)->get();

        $perfil->servicios = $servicios;

        return response()->json([
            'status' => true,
            'data' => $perfil,
        ], 200);
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'logo' => 'required',
            'nombre_taller' => 'nullable|string',
            'representante' => 'required|string',
            'direcion' => 'nullable|string',
            'numero' => 'required'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $nombreTaller = $request->input('nombre_taller');
        $direccion = $request->input('direcion');

        $perfilMecanico = new PerfilMecanico();


        if (isset($nombreTaller)) {
            $perfilMecanico->nombre_taller = $nombreTaller;
        }
        if (isset($direccion) || !empty($direccion)) {
            $perfilMecanico->direcion = $direccion;
        }

        $base64Image = $request->input('logo');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $extension = 'png';
        $fileName = $request->input('representante') . '_' . uniqid() . '.' . $extension;
        $storedFileName = 'public/perfilMecanico/' . $fileName;
        Storage::put($storedFileName, $image);
        $path = Storage::url($storedFileName);

        $perfilMecanico->logo = $path;
        $perfilMecanico->nombre_taller = $request->nombre_taller;
        $perfilMecanico->numero = $request->numero;
        $perfilMecanico->representante = $request->representante;
        $perfilMecanico->user_id = $request->user_id;

        if ($perfilMecanico->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Pefil mecanico creado con exito',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrio un error al crear el perfil',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
