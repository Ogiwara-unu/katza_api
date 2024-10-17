<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\Request;

class DispositivoController extends Controller
{
    public function index(){
        $data=Dispositivo::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de Dispositivos",
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
            'tipoDispositivo'=>'required',
            'modeloDispositivo'=>'required',
            'cantidad'=>'required',
            'marca'=>'required'
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $dispositivo=new Dispositivo();
            $dispositivo->tipoDispositivo=$data['tipoDispositivo']; 
            $dispositivo->modeloDispositivo=$data['modeloDispositivo']; 
            $dispositivo->cantidad=$data['cantidad'];
            $dispositivo->marca=$data['marca'];
            $dispositivo->save();
            $response=array(
                'status'=>201,
                'message'=>'Dispositivo creado',
                'dispositivo'=>$dispositivo
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
         'message'=>'No se enconto el objeto en data unu'
         
        );
    }
    return response()->json($response,$response['status']);
}


public function show($id){
    $data=Dispositivo::where('idDispositivos', $id)->first();
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos del dispositivo',
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
        $deleted = Dispositivo::where('idDispositivos', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'Dispositivo eliminado',
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
    if ($data_input) {
        $data = json_decode($data_input, true);
        $data = array_map('trim', $data);
        $rules = [
            'idDispositivos'=>'required',
            'tipoDispositivo'=>'required',
            'modeloDispositivo'=>'required',
            'cantidad'=>'required',
            'marca'=>'required'
        ];

        $isValid = \validator($data, $rules);
        if (!$isValid->fails()) {
            $dispositivo=Dispositivo::where('idDispositivos', $id)->first();
            if ($dispositivo) {
                if (isset($data['idDispositivos'])) {
                    $dispositivo->idDispositivos = $data['idDispositivos'];
                }
                $dispositivo->tipoDispositivo = $data['tipoDispositivo'];
                $dispositivo->modeloDispositivo = $data['modeloDispositivo'];
                $dispositivo->cantidad = $data['cantidad'];
                $dispositivo->marca = $data['marca'];
                $dispositivo->save();
                $response = [
                    'status' => 200,
                    'message' => 'Dispositivo actualizado',
                    'dispositivo' => $dispositivo
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Dispositivo no encontrado'
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
