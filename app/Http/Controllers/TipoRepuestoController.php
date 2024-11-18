<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Models\TipoRepuesto;
use Illuminate\Http\Request;

class TipoRepuestoController extends Controller
{
   
    public function index(){
        $data = TipoRepuesto::all();
        $response = [
            "status" => 200,
            "message" => "Todos los registros de tipo de repuesto",
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
                $tipoRepuesto = new TipoRepuesto();
                $tipoRepuesto->nombre = $data['nombre'];
                $tipoRepuesto->save();

                $response = [
                    'status' => 201,
                    'message' => 'Tipo de repuesto creado',
                    'tipoRepuesto' => $tipoRepuesto
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
        $data = TipoRepuesto::find($id);
        if(is_object($data)){
            $response = [
                'status' => 200,
                'message' => 'Datos del tipo de repuesto',
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
            $deleted = TipoRepuesto::where('idtipoRepuesto', $id)->delete();
            if($deleted){
                $response = [
                    'status' => 200,
                    'message' => 'Tipo de repuesto eliminado',
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
                'idtipoRepuesto' => 'required',  
                'nombre' => 'required|string|max:100',
            ];

            $isValid = \validator($data, $rules);
            if(!$isValid->fails()) {
                $tipoRepuesto = TipoRepuesto::where('idtipoRepuesto', $id)->first();
                if($tipoRepuesto) {
                    $tipoRepuesto->idtipoRepuesto = $data['idtipoRepuesto'];
                    $tipoRepuesto->nombre = $data['nombre'];
                    $tipoRepuesto->save();

                    $response = [
                        'status' => 200,
                        'message' => 'Tipo de repuesto actualizado',
                        'tipoRepuesto' => $tipoRepuesto
                    ];
                } else {
                    $response = [
                        'status' => 404,
                        'message' => 'Tipo de repuesto no encontrado'
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
