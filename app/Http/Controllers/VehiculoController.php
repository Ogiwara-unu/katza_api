<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index(){
        $data=Vehiculo::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de Vehiculos unu",
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
            'placa'=>'required|unique:vehiculos',
            'modelo'=>'required',
            'marca'=>'required',
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $vehiculo=new Vehiculo();
            $vehiculo->placa=$data['placa']; 
            $vehiculo->modelo=$data['modelo']; 
            $vehiculo->marca=$data['marca'];
            $vehiculo->save();
            $response=array(
                'status'=>201,
                'message'=>'Vehiculo creado unu',
                'vehiculo'=>$vehiculo
            );
        }else{
            $response=array(
                'status'=>206,
                'message'=>'Datos inválidos unu',
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
    $data=Vehiculo::where('placaVehiculo', $id)->first();
    if(is_object($data)){
        //$data=$data->load('mantenimientos');
       // $data=$data->load('detallePrestamoVehiculos');
        $response=array(
            'status'=>200,
            'message'=>'Datos del Vehiculo unu',
            'errors'=>$data
        );
    }else{
        $response=array(
            'status'=>404,
            'message'=>'Recurso no encontrado unu'
        );
    }
    return response()->json($response,$response['status']);
}


//Eliminar
public function destroy($id){
    if (isset($id)){
        $deleted = Vehiculo::where('placaVehiculo', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'Vehiculo eliminado unu',
            );

        }else{
            $response=array(
                'status'=> 400,
                'message'=>'Recurso no encontrado, compruebe que exista unu'
            );
        }
    }else{
        $response=array(
            'status'=> 406,
            'message'=>'Falta el identificador del recurso a eliminar unu'
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
            'modelo' => 'required',
            'marca' => 'required'
        ];

        $isValid = \validator($data, $rules);
        if (!$isValid->fails()) {
            $vehiculo=Vehiculo::where('placaVehiculo', $id)->first();
            if ($vehiculo) {
                // Asegúrate de que 'placaVehiculo' existe en $data
                if (isset($data['placaVehiculo'])) {
                    $vehiculo->placaVehiculo = $data['placaVehiculo'];
                }
                $vehiculo->modelo = $data['modelo'];
                $vehiculo->marca = $data['marca'];
                $vehiculo->save();
                $response = [
                    'status' => 200,
                    'message' => 'Vehiculo actualizado',
                    'vehiculo' => $vehiculo
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Vehiculo no encontrado'
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