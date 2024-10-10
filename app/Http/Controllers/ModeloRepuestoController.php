<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Models\ModeloRepuesto;
use Illuminate\Http\Request;

class ModeloRepuestoController extends Controller
{
    
    public function index(){
        $data=ModeloRepuesto::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de modelo repuesto",
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
            'modelo'=>'required',
            'marca'=>'required',
        ];

        $isValid=\validator($data,$rules);
        if(!$isValid->fails()){
            $modeloRepuesto=new ModeloRepuesto();
            $modeloRepuesto->modelo=$data['modelo']; 
            $modeloRepuesto->marca=$data['marca'];
            $modeloRepuesto->save();
            $response=array(
                'status'=>201,
                'message'=>'Modelo registrado',
                'modeloRepuesto'=>$modeloRepuesto
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
    $data=ModeloRepuesto::find($id);
    if(is_object($data)){
        $response=array(
            'status'=>200,
            'message'=>'Datos del modelo',
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
        $deleted = ModeloRepuesto::where('idModeloRepuesto', $id)->delete();
        if($deleted){
            $response=array(
                'status'=>200,
                'message'=>'Modelo eliminado',
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
            'idModeloRepuesto'=>'required', //VERIFICAR ESTA PUTA MIERDA
            'modelo'=>'required',
            'marca'=>'required'
        ];

        $isValid = \validator($data, $rules);
        if(!$isValid->fails()) {
            $modeloRepuesto = ModeloRepuesto::where('idModeloRepuesto', $id)->first();
            if($modeloRepuesto) {
                $modeloRepuesto->idModeloRepuesto = $data['idModeloRepuesto'];
                $modeloRepuesto->modelo = $data['modelo']; 
                $modeloRepuesto->marca = $data['marca'];
                $modeloRepuesto->save();
                $response = [
                    'status' => 200,
                    'message' => 'Modelo repuesto actualizado',
                    'modeloRepuesto' => $modeloRepuesto
                ];
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Modelo repuesto no encontrado'
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
