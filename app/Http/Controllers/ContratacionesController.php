<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contratacion;


class ContratacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $id)
    {
        $contrataciones = Contratacion::with('servicio', 'conductor', 'mecanico', 'estado')
        ->where(function ($query) use ($id) {
            $query->where('conductor_id', $id)
                ->orWhere('mecanico_id', $id);
        })
        ->get();


        if ($contrataciones->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontraron perfiles mecánicos',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $contrataciones
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'tipo_servicio' => 'required',
            'fecha_contratacion' => 'required',
            'direccion' => 'nullable|string',
            'comentario' => 'nullable|string',
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $direccion = $request->input('direccion');
        $comentario = $request->input('comentario');


        $contratacion = new Contratacion();

        if (isset($direccion) || !empty($direccion)) {
            $contratacion->direccion = $direccion;
        }
        if (isset($comentario) || !empty($comentario)) {
            $contratacion->comentario = $comentario;
        }

        $contratacion->tipo_servicio = $request->tipo_servicio;
        $contratacion->fecha_contratacion = $request->fecha_contratacion;
        $contratacion->servicio_id = $request->servicio_id;
        $contratacion->conductor_id = $request->conductor_id;
        $contratacion->mecanico_id = $request->mecanico_id;
        $contratacion->estado_id = 2;

        if ($contratacion->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Servicio contratado con exito',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrio un error al contratar el servicio',
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        switch ($id) {
            case 0:
                echo "i es igual a 0";
                break;
            case 1:
                echo "i es igual a 1";
                break;
            case 2:
                echo "i es igual a 2";
                break;
            default:
                echo "i no es igual a 0, 1 ni 2";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
