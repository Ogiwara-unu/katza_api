<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    //Get
    public function index(){
        $data=DB::select('EXEC paMostrarDepartamentos');
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de departamento",
            "data"=>$data
        );
        return response()->json($response,200);
    }

    //Post
public function store(Request $request) {
    $data_input = $request->input('data', null);
    if ($data_input) {
        $data = json_decode($data_input, true);
        $data = array_map('trim', $data);
        $rules = [
            'nombre' => 'required',
            'descripcion' => 'required'
        ];

        $isValid = \validator($data, $rules);
        if (!$isValid->fails()) {
            // Invocar el procedimiento almacenado que no devuelve resultados
            DB::statement('EXEC paCrearDepartamento ?, ?', [
                $data['nombre'],
                $data['descripcion']
            ]);            

            $response = [
                'status' => 201,
                'message' => 'Departamento registrado'
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


    public function show($id){
        $data = Departamento::where('idDepartamento', $id)->first();
        if(is_object($data)){
            $data=DB::select('EXEC paMostrarDepartamento ?', [
                $data['idDepartamento'],
            ]);
            $response=array(
                'status'=>200,
                'message'=>'Datos de departamentos',
                'errors'=>$data
            );
        }else{
            $response=array(
                'status'=>404,
                'message'=>'Recurso no encontrado'
            );
        }
        return response()->json($response,$response['status']);
    }


    //Eliminar
    public function destroy($id){
        if (isset($id)) {
            // Llamar al procedimiento almacenado correcto para eliminar
            $deleted = DB::statement('EXEC paEliminarDepartamento ?', [
                $id
            ]);
            
            // Verificar si la eliminación fue exitosa
            if($deleted) {
                $response = [
                    'status' => 200,
                    'message' => 'Departamento eliminado'
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
    

   
// Actualizar
public function update(Request $request, $id) {
    $data_input = $request->input('data', null);
    if($data_input) {
        $data = json_decode($data_input, true);
        $data = array_map('trim', $data);
        $rules = [
            'idDepartamento' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required'
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $departamento = Departamento::where('idDepartamento', $id)->first();
            if($departamento) {
                DB::statement('EXEC paModificarDepartamento ?, ?, ?', [
                    $data['idDepartamento'],
                    $data['nombre'],
                    $data['descripcion']
                ]);    
                $response = [
                    'status' => 200,
                    'message' => 'Departamento actualizado',
                    'departamento' => $departamento
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Departamento no encontrado'
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
