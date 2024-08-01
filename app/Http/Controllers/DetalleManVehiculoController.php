<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DetalleManVehiculo;

class DetalleManVehiculoController extends Controller
{
    public function index(){
        $data=DetalleManVehiculo::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de detalle mantenimiento",
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
            'idDetalleMantenimiento' => 'required',
            'mantenimiento' => 'required|exists:mantenimientos,idMantenimiento',
            'observaciones' => 'required',
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $detalleManVehiculo=new DetalleManVehiculo();
            $detalleManVehiculo->idDetalleMantenimiento = $data['idDetalleMantenimiento'];
            $detalleManVehiculo->mantenimiento = $data['mantenimiento'];
            $detalleManVehiculo->observaciones = $data['observaciones'];
            $detalleManVehiculo->save();
            $response=array(
                'status'=>201,
                'message'=>'detalle de mantenimiento vehiculo creado',
                'dispositivo'=>$detalleManVehiculo
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
    $data=DetalleManVehiculo::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los detalle mantenimiento vehiculo',
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
        $deleted = DetalleManVehiculo::where('idDetalleMantenimiento', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'detalle mantenimiento vehiculo eliminado',
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
            'idDetalleMantenimiento' => 'required',
            'mantenimiento' => 'required|exists:mantenimientos,idMantenimiento',
            'observaciones' => 'required',
        ];
        

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $detalleManVehiculo = DetalleManVehiculo::where('idDetalleMantenimiento', $id)->first();
            if($detalleManVehiculo) {
                $detalleManVehiculo->idDetalleMantenimiento = $data['idDetalleMantenimiento'];
                $detalleManVehiculo->mantenimiento = $data['mantenimiento'];
                $detalleManVehiculo->observaciones = $data['observaciones'];
                $detalleManVehiculo->save();
                $response = [
                    'status' => 200,
                    'message' => 'detalle mantenimiento vehiculo actualizado',
                    'detalleManVehiculo' => $detalleManVehiculo
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'detalle mantenimiento vehiculo no encontrado'
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
