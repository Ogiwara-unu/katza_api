<?php

namespace App\Http\Controllers;

use App\Models\DetalleManVehiculo;
use App\Models\DetallePresVehiculo;
use Illuminate\Http\Request;

class DetallePresVehiculoController extends Controller
{
    public function index(){
        $data=DetallePresVehiculo::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de detalle prestamo vehiculo",
            "data"=>$data
        );
        return response()->json($response,200);
    }

    
//Post
public function store(Request $request){
    $data_input = $request->input('data', null);
    
    if ($data_input) {
        $data = json_decode($data_input, true);
        $data = array_map('trim', $data);
        
        $rules = [
            'prestamo' => 'required|exists:prestamos,idPrestamo',
            'observaciones' => 'required',
            'kmInicial' => 'required|numeric',
            'kmFinal' => 'required|numeric',
            'vehiculoPrestado' => 'required|exists:vehiculos,placaVehiculo',
            'fechaDevolucion' => 'required|date'
        ];
        
        $validator = \Validator::make($data, $rules);
        
        if (!$validator->fails()) {
            $detallePresVehiculo = new DetallePresVehiculo();
            $detallePresVehiculo->prestamo = $data['prestamo'];
            $detallePresVehiculo->observaciones = $data['observaciones'];
            $detallePresVehiculo->kmInicial = $data['kmInicial'];
            $detallePresVehiculo->kmFinal = $data['kmFinal'];
            $detallePresVehiculo->vehiculoPrestado = $data['vehiculoPrestado'];
            $detallePresVehiculo->fechaDevolucion = $data['fechaDevolucion'];
            $detallePresVehiculo->save();
            
            $response = [
                'status' => 201,
                'message' => 'Detalle de préstamo de vehículo creado',
                'detallePresVehiculo' => $detallePresVehiculo
            ];
        } else {
            $response = [
                'status' => 206,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
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
    $data=DetallePresVehiculo::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los detalle prestamo vehiculo',
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
        $deleted = DetallePresVehiculo::where('idDetallePrestamo', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'detalle prestamo vehiculo eliminado',
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
            'idDetallePrestamo' => 'required',
            'prestamo' => 'required|exists:prestamos,idPrestamo',
            'observaciones' => 'required',
            'kmInicial' => 'required',
            'kmFinal' => 'required',
            'vehiculoPrestado' => 'required|exists:vehiculos,placaVehiculo',
            'fechaDevolucion' => 'required'
        ];
        

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $detallePresVehiculo = DetallePresVehiculo::where('idDetallePrestamo', $id)->first();
            if($detallePresVehiculo) {
                $detallePresVehiculo->prestamo = $data['prestamo'];
                $detallePresVehiculo->observaciones = $data['observaciones'];
                $detallePresVehiculo->kmInicial = $data['kmInicial'];
                $detallePresVehiculo->kmFinal = $data['kmFinal'];
                $detallePresVehiculo->vehiculoPrestado = $data['vehiculoPrestado'];
                $detallePresVehiculo->fechaDevolucion = $data['fechaDevolucion'];
                $detallePresVehiculo->save();
                $response = [
                    'status' => 200,
                    'message' => 'detalle prestamo vehiculo actualizado',
                    'detallePresVehiculo' => $detallePresVehiculo
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'detalle prestamo vehiculo no encontrado'
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
