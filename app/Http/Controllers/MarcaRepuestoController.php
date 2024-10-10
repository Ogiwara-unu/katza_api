<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Models\MarcaRepuesto;
use Illuminate\Http\Request;

class MarcaRepuestoController extends Controller
{
    public function index(){
        $data=MarcaRepuesto::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de marcas",
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
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $marcaRepuesto=new MarcaRepuesto();
            $marcaRepuesto->nombre=$data['nombre']; 
            $marcaRepuesto->save();
            $response=array(
                'status'=>201,
                'message'=>'Marca registrada',
                'empleado'=>$marcaRepuesto
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
    $data=MarcaRepuesto::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos de los marca',
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
        $deleted = MarcaRepuesto::where('idMarcaRepuesto', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'Marca eliminada',
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
            'idMarcaRepuesto'=>'required', //VERIFICAR ESTA MIERDA
            'nombre'=>'required'
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $marcaRepuesto = MarcaRepuesto::where('idMarcaRepuesto', $id)->first();
            if($marcaRepuesto) {
                $marcaRepuesto->idMarcaRepuesto = $data['idMarcaRepuesto'];
                $marcaRepuesto->nombre = $data['nombre']; 
                $marcaRepuesto->save();
                $response = [
                    'status' => 200,
                    'message' => 'Marca Repuesto actualizado',
                    'marcaRepuesto' => $marcaRepuesto
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Marca repuesto no encontrado'
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
