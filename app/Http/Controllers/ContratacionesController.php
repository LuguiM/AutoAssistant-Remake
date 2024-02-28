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
        $estado = $request->input("estado");

        if (!empty($estado)) {
            $contrataciones = Contratacion::with('servicio', 'conductor', 'mecanico', 'estado')
                ->where(function ($query) use ($id) {
                    $query->where('conductor_id', $id)
                        ->orWhere('mecanico_id', $id);
                })->where('estado_id', $estado)
                ->orderBy('estado_id', 'asc')->paginate(10);
        } else {
            $contrataciones = Contratacion::with('servicio', 'conductor', 'mecanico', 'estado')
                ->where(function ($query) use ($id) {
                    $query->where('conductor_id', $id)
                        ->orWhere('mecanico_id', $id);
                })->orderBy('estado_id', 'asc')->paginate(10);
        }


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
        $contratacion = Contratacion::find($id);
        if (!$contratacion) {
            return response()->json([
                'status' => false,
                'message' => 'Contratación no encontrada',
            ], 404);
        }
        $message = '';
        $estado_id = $request->input('estado_id');

        switch ($estado_id) {
            case 1:
                $contratacion->estado_id = 1;
                $message = 'Contratación activada con exito';
                break;
            case 3:
                $contratacion->estado_id = 3;
                $message = 'Contratacion completada con exito';
                break;
            case 4:
                $contratacion->estado_id = 4;
                $message = 'Contratación cancelada con exito';
                break;
            case 5:
                $contratacion->estado_id = 5;
                $message = 'Contratación rechazada con exito';
                break;
            default:
                $message = 'No se pudo cambiar el estado de la contratación';

        }

        if ($contratacion->update()) {
            return response()->json([
                'status' => true,
                'message' => $message,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrio un error al actualizar el estado',
            ], 400);
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
