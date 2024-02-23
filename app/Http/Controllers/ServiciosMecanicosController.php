<?php

namespace App\Http\Controllers;

use App\Models\PerfilMecanico;
use Illuminate\Http\Request;
use App\Models\ServicioMecanico;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ServiciosMecanicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = ServicioMecanico::with('perfilMecanico')->paginate(10);

        if ($servicios->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontraron servicios mecánicos',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $servicios
        ], 200);
    }

    public function serviciosInscritos($id)
    {
        $servicios = ServicioMecanico::where('perfil_mecanico_id', $id)->paginate(10);

        if ($servicios->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontraron servicios mecánicos inscritos',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $servicios
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            "logo" => "required",
            "rubro" => "required",
            "servicio" => "required",
            "tipo_servicio" => "required",
            "descripcion" => "required",
            "dia_inicio" => "required",
            "dia_fin" => "required",
            "hora_apertura" => "required",
            "hora_cierre" => "required",
            "precio" => "required",
            "precio_adomicilio" => "required",
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $servicioMecanico = new ServicioMecanico();

        $base64Image = $request->input('logo');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $extension = 'png';
        $fileName = $request->input('representante') . '_' . uniqid() . '.' . $extension;
        $storedFileName = 'public/servicioMecanico/' . $fileName;
        Storage::put($storedFileName, $image);
        $path = Storage::url($storedFileName);

        $servicioMecanico->logo = $path;
        $servicioMecanico->rubro = $request->rubro;
        $servicioMecanico->servicio = $request->servicio;
        $servicioMecanico->tipo_servicio = $request->tipo_servicio;
        $servicioMecanico->descripcion = $request->descripcion;
        $servicioMecanico->dia_inicio = $request->dia_inicio;
        $servicioMecanico->dia_fin = $request->dia_fin;
        $servicioMecanico->hora_apertura = $request->hora_apertura;
        $servicioMecanico->hora_cierre = $request->hora_cierre;
        $servicioMecanico->precio = $request->precio;
        $servicioMecanico->precio_adomicilio = $request->precio_adomicilio;
        $servicioMecanico->perfil_mecanico_id = $request->perfil_mecanico_id;



        if ($servicioMecanico->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Servicio mecanico creado con exito',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrio un error al crear el servicio',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servicios = ServicioMecanico::with('perfilMecanico')->find($id);

        if (!$servicios) {
            return response()->json([
                'status' => false,
                'message' => 'El servicio mecanico solicitado no se ha encontrado o no esta disponible',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $servicios
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
