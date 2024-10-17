<?php

namespace App\Http\Controllers;

use App\Models\DetallePresDispositivo;
use Illuminate\Http\Request;

class DetallePresDispositivoController extends Controller
{
    public function index(){
        $data=DetallePresDispositivo::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de detalle prestamo dispositivo",
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
            'observaciones' => 'required',
            'prestamo' => 'required|exists:prestamos,idPrestamo',
            'dispositivosPrestado' => 'required|exists:dispositivos,idDispositivos',
            'fechaDevolucion' => 'required'
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $detallePresDispositivo=new DetallePresDispositivo();
            $detallePresDispositivo->observaciones = $data['observaciones'];
            $detallePresDispositivo->prestamo = $data['prestamo'];
            $detallePresDispositivo->dispositivosPrestado = $data['dispositivosPrestado'];
            $detallePresDispositivo->fechaDevolucion = $data['fechaDevolucion'];
            $detallePresDispositivo->save();
            $response=array(
                'status'=>201,
                'message'=>'detalle de prestamo dispositivo creado',
                'detallePresDispositivo'=>$detallePresDispositivo
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
    $data=DetallePresDispositivo::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los detalle prestamo dispositivo',
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
        $deleted = DetallePresDispositivo::where('idDetallePrestamoDispositivo', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'detalle prestamo dispositivo eliminado',
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
            'idDetallePrestamoDispositivo' => 'required',
            'observaciones' => 'required',
            'prestamo' => 'required|exists:prestamos,idPrestamo',
            'dispositivosPrestado' => 'required|exists:dispositivos,idDispositivos',
            'fechaDevolucion' => 'required'
        ];
        

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $detallePresDispositivo = DetallePresDispositivo::where('idDetallePrestamoDispositivo', $id)->first();
            if($detallePresDispositivo) {
                $detallePresDispositivo->observaciones = $data['observaciones'];
                $detallePresDispositivo->prestamo = $data['prestamo'];
                $detallePresDispositivo->dispositivosPrestado = $data['dispositivosPrestado'];
                $detallePresDispositivo->fechaDevolucion = $data['fechaDevolucion'];
                $detallePresDispositivo->save();
                $response = [
                    'status' => 200,
                    'message' => 'detalle prestamo dispositivo actualizado',
                    'detallePresDispositivo' => $detallePresDispositivo
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'detalle prestamo dispositivo no encontrado'
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
