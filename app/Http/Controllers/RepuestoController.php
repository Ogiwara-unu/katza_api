<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Models\Repuesto;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    
     // Obtener todos los repuestos
     public function index(){
        $data = Repuesto::all();
        $response = array(
            "status" => 200,
            "message" => "Todos los registros de repuestos",
            "data" => $data
        );
        return response()->json($response, 200);
    }

    // Crear un nuevo repuesto
    public function store(Request $request){
        $data_input = $request->input('data', null);
        if ($data_input) {
            $data = json_decode($data_input, true);
            $data = array_map('trim', $data);
            $rules = [
                'cantidadInv'=>'required',
                'tipoRepuesto' => 'required|exists:tipoRepuestos,idtipoRepuesto',
                'modeloRepuesto' => 'required|exists:modeloRepuestos,idModeloRepuesto'
            ];

            $isValid = \validator($data, $rules);
            if (!$isValid->fails()) {
                $repuesto = new Repuesto();
                $repuesto->cantidadInv = $data['cantidadInv'];
                $repuesto->tipoRepuesto = $data['tipoRepuesto'];
                $repuesto->modeloRepuesto = $data['modeloRepuesto'];
                $repuesto->save();
                $response = array(
                    'status' => 201,
                    'message' => 'Repuesto creado',
                    'repuesto' => $repuesto
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

    //No sirve pero estoy sin internet pipipi
    public function show($id){
        $data = Repuesto::where('idRepuesto', $id)->first();
        if (is_object($data)) {
            $response = array(
                'status' => 200,
                'message' => 'Datos del repuesto ',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Repuesto  no encontrado'
            );
        }
        return response()->json($response, $response['status']);
    }

    // Eliminar un repuesto
    public function destroy($id){
        if (isset($id)) {
            $deleted = Repuesto::where('idRepuesto', $id)->delete();
            if ($deleted) {
                $response = array(
                    'status' => 200,
                    'message' => 'Repuesto eliminado'
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

    // Actualizar un repuesto existente
    public function update(Request $request, $id) {
        $data_input = $request->input('data', null);
        if ($data_input) {
            $data = json_decode($data_input, true);
            $data = array_map('trim', $data);
            $rules = [
                'idRepuesto'=> 'required',  //VERIFICAR ESTA PUTA MIERDA
                'cantidadInv'=> 'required',
                'tipoRepuesto' => 'required|exists:tipoRepuestos,idtipoRepuesto',
                'modeloRepuesto' => 'required|exists:modeloRepuestos,idModeloRepuesto'
            ];

            $isValid = \validator($data, $rules);
            if (!$isValid->fails()) {
                $repuesto = Repuesto::where('idRepuesto', $id)->first();
                if ($repuesto) {
                    $repuesto->idRepuesto = $data['idRepuesto'];
                    $repuesto->tipoRepuesto = $data['tipoRepuesto'];
                    $repuesto->modeloRepuesto = $data['modeloRepuesto'];
                    $repuesto->cantidadInv = $data['cantidadInv'];
                    $repuesto->save();
                    $response = array(
                        'status' => 200,
                        'message' => 'Repuesto actualizado',
                        'repuesto' => $repuesto
                    );
                } else {
                    $response = array(
                        'status' => 404,
                        'message' => 'Repuesto no encontrado'
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
