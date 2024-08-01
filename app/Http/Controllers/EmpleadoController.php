<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Empleado;

class EmpleadoController extends Controller
{

    public function index(){
        $data=Empleado::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de empleados",
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
            'idEmpleado'=>'required',
            'nombre'=>'required',
            'apellidos'=>'required',
            'correo'=>'required',
            'telefono'=>'required',
            'departamento'=>'required|exists:departamentos,idDepartamento',
            'fechaContratacion'=>'required'
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $empleado=new Empleado();
            $empleado->idEmpleado=$data['idEmpleado'];
            $empleado->nombre=$data['nombre']; 
            $empleado->apellidos=$data['apellidos'];
            $empleado->correo=$data['correo'];
            $empleado->telefono=$data['telefono'];
            $empleado->departamento=$data['departamento'];
            $empleado->fechaContratacion=$data['fechaContratacion'];
            $empleado->save();
            $response=array(
                'status'=>201,
                'message'=>'empleado creado',
                'empleado'=>$empleado
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
    $data=Empleado::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los empleado',
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
        $deleted = Empleado::where('idEmpleado', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'Empleado eliminado',
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
            'idEmpleado'=>'required',
            'nombre'=>'required',
            'apellidos'=>'required',
            'correo'=>'required',
            'telefono'=>'required',
            'departamento' => 'required|exists:departamentos,idDepartamento',
            'fechaContratacion'=>'required'
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $empleado = Empleado::where('idEmpleado', $id)->first();
            if($empleado) {
                $empleado->idEmpleado = $data['idEmpleado'];
                $empleado->nombre = $data['nombre']; 
                $empleado->apellidos = $data['apellidos'];
                $empleado->correo = $data['correo'];
                $empleado->telefono = $data['telefono'];
                $empleado->departamento = $data['departamento'];
                $empleado->fechaContratacion = $data['fechaContratacion'];
                $empleado->save();
                $response = [
                    'status' => 200,
                    'message' => 'Empleado actualizado',
                    'empleado' => $empleado
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Empleado no encontrado'
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
