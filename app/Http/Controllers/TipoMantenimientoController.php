<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TipoMantenimiento;

class TipoMantenimientoController extends Controller
{
    public function index(){
        $data=TipoMantenimiento::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de tipos de mantenimientos",
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
            'idTipoMantenimiento'=>'required',
            'nombre'=>'required'
            
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $tipoMantenimiento=new TipoMantenimiento();
            $tipoMantenimiento->idTipoMantenimiento=$data['idTipoMantenimiento'];
            $tipoMantenimiento->nombre=$data['nombre']; 
            $tipoMantenimiento->save();
            $response=array(
                'status'=>201,
                'message'=>'tipo de mantenimiento creado',
                'tipoMantenimiento'=>$tipoMantenimiento
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
    $data=TipoMantenimiento::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los tipos de mantenimientos',
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
        $deleted = TipoMantenimiento::where('idTipoMantenimiento', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'tipo de mantenimiento eliminado',
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
            'idTipoMantenimiento'=>'required',
            'nombre'=>'required'
            
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $tipoMantenimiento = TipoMantenimiento::where('idTipoMantenimiento', $id)->first();
            if($tipoMantenimiento) {
                $tipoMantenimiento->idTipoMantenimiento=$data['idTipoMantenimiento'];
                $tipoMantenimiento->nombre=$data['nombre']; 
                $tipoMantenimiento->save();
                $response = [
                    'status' => 200,
                    'message' => 'Tipo de mantenimiento actualizado',
                    'empleado' => $tipoMantenimiento
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'tipo de mantenimiento no encontrado'
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