<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    //Get
    public function index(){
        $data=Departamento::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de departamento",
            "data"=>$data
        );
        return response()->json($response,200);
    }

    //Post
    public function store(Request $request){
        $data_input=$request->input('data',null);
        if($data_input){
            $data=json_decode($data_input,true);
            $data=array_map('trim',$data);
            $rules=[
                'nombre'=>'required',
                'descripcion'=>'required'
            ];
    
            $isValid=\validator($data,$rules);
            if(!$isValid->fails()){
                $departamento=new departamento();
                $departamento->nombre=$data['nombre']; 
                $departamento->descripcion=$data['descripcion'];
                $departamento->save();
                $response=array(
                    'status'=>201,
                    'message'=>'Departamento creado',
                    'departamento'=>$departamento
                );
            }else{
                $response=array(
                    'status'=>206,
                    'message'=>'Datos inválidos',
                    'errors'=>$isValid->errors()
                );
            }
        }else{
            $response=array(
             'status'=>400,
             'message'=>'No se enconto el objeto en data'
             
            );
        }
        return response()->json($response,$response['status']);
    }


    public function show($id){
        $data = Departamento::where('idDepartamento', $id)->first();
        if(is_object($data)){
            $data=$data->load('empleados');
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
        if (isset($id)){
            $deleted = Departamento::where('idDepartamento', $id)->delete();
            if($deleted){
                $response=array(
                    'status'=>200,
                    'message'=>'Departamento eliminado',
                );
    
            }else{
                $response=array(
                    'status'=> 400,
                    'message'=>'Recurso no encontrado, compruebe que exista'
                );
            }
        }else{
            $response=array(
                'status'=> 406,
                'message'=>'Falta el identificador del recurso a eliminar'
            );
        }
        return response()->json($response,$response['status']);
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
                $departamento->idDepartamento = $data['idDepartamento'];
                $departamento->nombre = $data['nombre']; 
                $departamento->descripcion = $data['descripcion'];
                $departamento->save();
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
