<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RepuestoUsado;

class RepuestoUsadoController extends Controller
{
    
      // Obtener todos los repuestos usados 
      public function index(){
        $data = RepuestoUsado::all();
        $response = array(
            "status" => 200,
            "message" => "Todos los registros de repuestos usados",
            "data" => $data
        );
        return response()->json($response, 200);
    }

    // Crear un nuevo repuesto usado
    public function store(Request $request){
        $data_input = $request->input('data', null);
        if ($data_input) {
            $data = json_decode($data_input, true);
            $data = array_map('trim', $data);
            $rules = [
                'repuesto' => 'required|exists:repuestos,idRepuesto',
                'cantidadUsada' => 'required',
                'mantenimiento' => 'required'
            ];

            $isValid = \validator($data, $rules);
            if (!$isValid->fails()) {
                $repuestoUsado = new RepuestoUsado();
                $repuestoUsado->repuesto = $data['repuesto'];
                $repuestoUsado->cantidadUsada = $data['cantidadUsada'];
                $repuestoUsado->mantenimiento = $data['mantenimiento'];
                $repuestoUsado->save();
                $response = array(
                    'status' => 201,
                    'message' => 'Repuesto usado creado',
                    'repuestoUsado' => $repuestoUsado
                );
            } else {
                $response = array(
                    'status' => 206,
                    'message' => 'Datos inválidos',
                    'errors' => $isValid->errors()
                );
            }
        } else {
            $response = array(
                'status' => 400,
                'message' => 'No se encontró el objeto en data'
            );
        }
        return response()->json($response, $response['status']);
    }

    // Mostrar un repuesto usado específico
    public function show($id){
        $data = RepuestoUsado::where('idRepuestosUsados', $id)->first();
        if (is_object($data)) {
            $response = array(
                'status' => 200,
                'message' => 'Datos del repuesto usado',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Repuesto usado no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }

    // Eliminar un repuesto usado
    public function destroy($id){
        if (isset($id)) {
            $deleted = RepuestoUsado::where('idRepuestosUsados', $id)->delete();
            if ($deleted) {
                $response = array(
                    'status' => 200,
                    'message' => 'Repuesto usado eliminado'
                );
            } else {
                $response = array(
                    'status' => 400,
                    'message' => 'Recurso no encontrado, compruebe que exista'
                );
            }
        } else {
            $response = array(
                'status' => 406,
                'message' => 'Falta el identificador del recurso a eliminar'
            );
        }
        return response()->json($response, $response['status']);
    }

    // Actualizar un repuesto usado existente
    public function update(Request $request, $id) {
        $data_input = $request->input('data', null);
        if ($data_input) {
            $data = json_decode($data_input, true);
            $data = array_map('trim', $data);
            $rules = [
                'repuesto' => 'required|exists:repuestos,idRepuesto',
                'cantidadUsada' => 'required',
                'mantenimiento' => 'required'
            ];

            $isValid = \validator($data, $rules);
            if (!$isValid->fails()) {
                $repuestoUsado = RepuestoUsado::where('idRepuestosUsados', $id)->first();
                if ($repuestoUsado) {
                    $repuestoUsado->repuesto = $data['repuesto'];
                    $repuestoUsado->cantidadUsada = $data['cantidadUsada'];
                    $repuestoUsado->mantenimiento = $data['mantenimiento'];
                    $repuestoUsado->save();
                    $response = array(
                        'status' => 200,
                        'message' => 'Repuesto usado actualizado',
                        'repuestoUsado' => $repuestoUsado
                    );
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => 'Repuesto usado no encontrado'
                    );
                }
            } else {
                $response = array(
                    'status' => 206,
                    'message' => 'Datos inválidos',
                    'errors' => $isValid->errors()
                );
            }
        } else {
            $response = array(
                'status' => 400,
                'message' => 'No se encontró el objeto en data'
            );
        }
        return response()->json($response, $response['status']);
    }

}
