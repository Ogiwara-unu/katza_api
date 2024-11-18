<?php

namespace App\Http\Controllers;

use App\Models\TipoDispositivo;
use Illuminate\Http\Request;

class TipoDispositivoController extends Controller
{
      
    public function index(){
        $data = TipoDispositivo::all();
        $response = [
            "status" => 200,
            "message" => "Todos los registros de tipo de dispositivo",
            "data" => $data
        ];
        return response()->json($response, 200);
    }

    // Crear un nuevo tipo de repuesto
    public function store(Request $request){
        $data_input = $request->input('data', null);
        if($data_input){
            $data = json_decode($data_input, true);
            $data = array_map('trim', $data);
            $rules = [
                'nombre' => 'required',
            ];

            $isValid = \validator($data, $rules);
            if(!$isValid->fails()){
                $tipoDispositivo = new TipoDispositivo();
                $tipoDispositivo->nombre = $data['nombre'];
                $tipoDispositivo->save();

                $response = [
                    'status' => 201,
                    'message' => 'Tipo dispositivo creado',
                    'tipoDispositivo' => $tipoDispositivo
                ];
            } else {
                $response = [
                    'status' => 206,
                    'message' => 'Datos inválidos',
                    'errors' => $isValid->errors()
                ];
            }
        } else {
            $response = [
                'status' => 400,
                'message' => 'No se encontró el objeto en data'
            ];
        }
        return response()->json($response, $response['status']);
    }

    // Obtener un tipo de repuesto específico
    public function show($id){
        $data = TipoDispositivo::find($id);
        if(is_object($data)){
            $response = [
                'status' => 200,
                'message' => 'Datos del tipo dispositivo',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Recurso no encontrado'
            ];
        }
        return response()->json($response, $response['status']);
    }

    // Eliminar un tipo de repuesto
    public function destroy($id){
        if (isset($id)){
            $deleted = TipoDispositivo::where('idTipoDispositivo', $id)->delete();
            if($deleted){
                $response = [
                    'status' => 200,
                    'message' => 'Tipo dispositivo eliminado',
                ];

            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Recurso no encontrado, compruebe que exista'
                ];
            }
        } else {
            $response = [
                'status' => 406,
                'message' => 'Falta el identificador del recurso a eliminar'
            ];
        }
        return response()->json($response, $response['status']);
    }

    // Actualizar un tipo de repuesto
    public function update(Request $request, $id) {
        $data_input = $request->input('data', null);
        if($data_input) {
            $data = json_decode($data_input, true);
            $data = array_map('trim', $data);
            $rules = [
                'idTipoDispositivo' => 'required',  
                'nombre' => 'required|string|max:100',
            ];

            $isValid = \validator($data, $rules);
            if(!$isValid->fails()) {
                $tipoRepuesto = TipoDispositivo::where('idTipoDispositivo', $id)->first();
                if($tipoRepuesto) {
                    $tipoRepuesto->idTipoDispositivo = $data['idTipoDispositivo'];
                    $tipoRepuesto->nombre = $data['nombre'];
                    $tipoRepuesto->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Tipo dispositivo actualizado',
                        'tipoDispositivo' => $tipoRepuesto
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'Tipo de dispositivo no encontrado'
                    ];
                }
            } else {
                $response = [
                    'status' => 206,
                    'message' => 'Datos inválidos',
                    'errors' => $isValid->errors()
                ];
            }
        } else {
            $response = [
                'status' => 400,
                'message' => 'No se encontró el objeto en data'
            ];
        }
        return response()->json($response, $response['status']);
    }

}
