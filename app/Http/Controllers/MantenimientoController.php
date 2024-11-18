<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Mantenimiento;

class MantenimientoController extends Controller
{
    public function index(){
        $data=Mantenimiento::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de mantenimientos",
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
            'idVehiculo' => 'required|exists:vehiculos,placaVehiculo',
            'tipoMantenimiento' => 'required|exists:tipoMantenimientos,idTipoMantenimiento',
            'empleadoEncargado' => 'required|exists:empleados,idEmpleado',
            'fechaMantenimiento' => 'required|date',
            'duracionMantenimiento' => 'required|string|max:100'
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $Mantenimiento=new Mantenimiento();
            $Mantenimiento->idVehiculo = $data['idVehiculo'];
            $Mantenimiento->tipoMantenimiento = $data['tipoMantenimiento'];
            $Mantenimiento->empleadoEncargado = $data['empleadoEncargado'];
            $Mantenimiento->fechaMantenimiento = $data['fechaMantenimiento'];
            $Mantenimiento->duracionMantenimiento = $data['duracionMantenimiento'];
            $Mantenimiento->save();
            $response=array(
                'status'=>201,
                'message'=>'mantenimiento creado',
                'mantenimiento'=>$Mantenimiento
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
    $data=Mantenimiento::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los mantenimientos',
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
        $deleted = Mantenimiento::where('idMantenimiento', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'mantenimiento eliminado',
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
            'idMantenimiento' => 'required|exists:mantenimientos,idMantenimiento',
            'idVehiculo' => 'required|exists:vehiculos,placaVehiculo',
            'tipoMantenimiento' => 'required|exists:tipoMantenimientos,idTipoMantenimiento',
            'empleadoEncargado' => 'required|exists:empleados,idEmpleado',
            'fechaMantenimiento' => 'required|date',
            'duracionMantenimiento' => 'required|string|max:100'
            
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $Mantenimiento = Mantenimiento::where('idMantenimiento', $id)->first();
            if($Mantenimiento) {
                $Mantenimiento->idMantenimiento = $data['idMantenimiento'];
                $Mantenimiento->idVehiculo = $data['idVehiculo'];
                $Mantenimiento->tipoMantenimiento = $data['tipoMantenimiento'];
                $Mantenimiento->empleadoEncargado = $data['empleadoEncargado'];
                $Mantenimiento->fechaMantenimiento = $data['fechaMantenimiento'];
                $Mantenimiento->duracionMantenimiento = $data['duracionMantenimiento'];
                $Mantenimiento->save();
                $response = [
                    'status' => 200,
                    'message' => 'mantenimiento actualizado',
                    'empleado' => $Mantenimiento
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'mantenimiento no encontrado'
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