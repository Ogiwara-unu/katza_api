<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Prestamo;

class PrestamoController extends Controller
{
    public function index(){
        $data=Prestamo::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de prestamos",
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
                'idPrestamo'=>'required',
                'empleadoEmisor'=>'required|exists:empleados,idEmpleado',
                'empleadoReceptor'=>'required|exists:empleados,idEmpleado',
                'estadoPrestamo'=>'required',
                'fechaPrestamo'=>'required',
                'fechaLimite'=>'required'
            ];
    
            $isValid=\validator($data,$rules);
            if(!$isValid->fails()){
                $prestamo=new Prestamo();
                $prestamo->idPrestamo=$data['idPrestamo'];
                $prestamo->empleadoEmisor=$data['empleadoEmisor']; 
                $prestamo->empleadoReceptor=$data['empleadoReceptor'];
                $prestamo->estadoPrestamo=$data['estadoPrestamo'];
                $prestamo->fechaPrestamo=$data['fechaPrestamo'];
                $prestamo->fechaLimite=$data['fechaLimite'];
                $prestamo->save();
                $response=array(
                    'status'=>201,
                    'message'=>'Prestamo creado creado',
                    'departamento'=>$prestamo
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
        $data = Prestamo::where('idPrestamo', $id)->first();
        if(is_object($data)){
            $data=$data->load('detallePrestamos');
            $response=array(
                'status'=>200,
                'message'=>'Datos de prestamos',
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
            $deleted = Prestamo::where('idPrestamo', $id)->delete();
            if($deleted){
                $response=array(
                    'status'=>200,
                    'message'=>'Prestamo eliminado',
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
            'idPrestamo'=>'required',
            'empleadoEmisor'=>'required|exists:empleados,idEmpleado',
            'empleadoReceptor'=>'required|exists:empleados,idEmpleado',
            'estadoPrestamo'=>'required',
            'fechaPrestamo'=>'required',
            'fechaLimite'=>'required'
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $prestamo = Prestamo::where('idPrestamo', $id)->first();
            if($prestamo) {
                $prestamo->idPrestamo=$data['idPrestamo'];
                $prestamo->empleadoEmisor=$data['empleadoEmisor']; 
                $prestamo->empleadoReceptor=$data['empleadoReceptor'];
                $prestamo->estadoPrestamo=$data['estadoPrestamo'];
                $prestamo->fechaPrestamo=$data['fechaPrestamo'];
                $prestamo->fechaLimite=$data['fechaLimite'];
                $prestamo->save();
                $response = [
                    'status' => 200,
                    'message' => 'Prestamo actualizado',
                    'departamento' => $prestamo
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Prestamo no encontrado'
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
