<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
      //----GET-----
      public function index(){
        $data=User::all();
        $response=array(
            "status"=>200,
            "message"=>"Todos los registros de usuarios",
            "data"=>$data
        );
        return response()->json($response,200);
    
    }
    
        //----POST----
        public function store(Request $request){
            $data_input=$request->input('data',null);
            if($data_input){
                $data=json_decode($data_input,true);
                $data=array_map('trim',$data);
                $rules=[
                    'name'=>'required|alpha',
                    'email' => 'required|email|unique:users,email',
                    'password'=>'required|min:5',
                ];
    
                $isValid=\validator($data,$rules);
                if(!$isValid->fails()){
                    $user=new user();
                    $user->name=$data['name'];
                    $user->email=$data['email'];
                    $user->password=hash('sha256',$data['password']);
                    $user->save();
                    $response=array(
                        'status'=>201,
                        'message'=>'Usuario creado',
                        'user'=>$user
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
            $data=User::find($id);
            if(is_object($data)){
                $data=$data->load('users');
                $response=array(
                    'status'=>200,
                    'message'=>'Datos de los usuarios',
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
    
    
        public function destroy(Request $request, $id) {
            // Verifica si el token JWT es válido
            $jwtAuth = new JwtAuth();
            $decodedToken = $jwtAuth->checkToken($request->header('bearertoken'), true);
            
            if (!$decodedToken) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Acceso no autorizado'
                ], 401);
            } elseif ($decodedToken->iss == $id || $decodedToken->role == 'librarian1') {
                $deleted = User::where('id', $id)->delete();
                if ($deleted) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Usuario eliminado',
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Recurso no encontrado, comprueba que exista'
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 403,
                    'message' => 'No tienes permiso para eliminar este usuario'
                ], 403);
            }
        }
        
        
        

        //----UPDATE----
        public function update(Request $request, $id) {
      
            $jwtAuth = new JwtAuth();
            $decodedToken = $jwtAuth->checkToken($request->header('bearertoken'), true);
        
            if (!$decodedToken) {
               
                return response()->json([
                    'status' => 401,
                    'message' => 'Acceso no autorizado'
                ], 401);
            }
        
            if ($decodedToken->iss == $id || $decodedToken->role == 'librarian1') {
                $data_input = $request->input('data', null);
        
                if ($data_input) {
                    $data = json_decode($data_input, true);
        
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Datos JSON inválidos'
                        ], 400);
                    }
        
                    $data = array_map('trim', $data);
        
                    $rules = [
                        'name' => 'required|alpha',
                        'lastName' => 'required',
                        'phone' => 'required',
                        'email' => 'required|email',
                       
                    ];
        
                    $validator = \Validator::make($data, $rules);
        
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => 206,
                            'message' => 'Datos inválidos',
                            'errors' => $validator->errors()
                        ], 206);
                    }
        
                    $user = User::find($id);
        
                    if ($user) {
                        $user->name = $data['name'];
                        $user->lastName = $data['lastName'];
                        $user->phone = $data['phone'];
                        $user->email = $data['email'];
                        if (!empty($data['password'])) {
                            $user->password = hash('sha256', $data['password']);
                        }
                        $user->image = $data['image'];
                        $user->save();
        
                        return response()->json([
                            'status' => 200,
                            'message' => 'Usuario actualizado',
                            'user' => $user
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Usuario no encontrado'
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'No se encontró el objeto en data'
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 403,
                    'message' => 'No tienes permiso para actualizar este usuario'
                ], 403);
            }
        }

public function login(Request $request){
    $data_input=$request->input('data',null);
    $data=json_decode($data_input,true);
    $data=array_map('trim', $data);
    $rules=['name'=>'required', 'password'=>'required'];
    $isValid=\validator($data,$rules);
    if(!$isValid->fails()){
        $jwt=new JwtAuth();
        $response= $jwt->getToken($data['name'], $data['password']);
        return response()->json($response);
    }else{
        $response=array(
            'status'=>406,
            'message'=>'Error en la valdiacion de los datos',
            'errors'=>$isValid->errors(),

        );
        return response()->json($response,406);
    }
}

public function getIdentity(Request $request){
    $jwt=new JwTAuth();
    $token=$request->header('bearertoken');
    if(isset($token)){
        $response=$jwt->checkToken($token,true);
    }else{
        $response=array(
          'status'=>404,
          'message'=> 'token (bearertoken) no encontrado',
        );
    }
    return response()->json($response);
}

public function restoreDatabase(Request $request)
{
   
    $backupPath = $request->input('BackupPath', null);
    $backupPath = trim($request->input('BackupPath', null));

    if (!$backupPath) {
        return response()->json([
            'status' => 400,
            'message' => 'Debe proporcionar la ruta del archivo de respaldo'
        ], 400);
    }

    $backupPath = str_replace(['{', '}', '"'], '', $backupPath);

    try {
        // Cambiar a la base de datos master y desconectar usuarios
        \DB::connection('sqlsrv')->statement("USE master");
        \DB::statement("ALTER DATABASE katza SET SINGLE_USER WITH ROLLBACK IMMEDIATE");

        // Ejecutar el procedimiento de restauración
        \DB::statement("EXEC katza.dbo.paRestablecerKatzaDB @BackupPath = ?", [$backupPath]);

        // Volver a habilitar el acceso multiusuario
        \DB::statement("ALTER DATABASE katza SET MULTI_USER");

        return response()->json([
            'status' => 200,
            'message' => 'La base de datos fue restaurada con éxito'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'Error al restaurar la base de datos',
            'error' => $e->getMessage()
        ], 500);
    }
}





public function uploadImage(Request $request){
    $isValid=\Validator::make($request->all(),
        ['file0'=>'required|image|mimes:jpg,png,jpeg,svg,gif']);
    if(!$isValid->fails()){
        $image=$request->file('file0');
        $filename=\Str::uuid().".".$image->getClientOriginalExtension();
        \Storage::disk('users')->put($filename,\File::get($image));
        $response=array(
            'status'=>201,
            'message'=>'Imagen Guardada',
            'filename'=>$filename,
        );
    }else{
        $response=array(
            'status'=>406,
            'message'=>'Error: no se encontro el archivo',
            'errors'=>$isValid->errors(),
        );

    }
    return response()->json($response, $response['status']);

}

public function getImage($filename) {
    if (isset($filename)) {
        $exist = \Storage::disk('users')->exists($filename);

        if ($exist) {
            $file = \Storage::disk('users')->get($filename);
            return new Response($file, 200);
        } else {
            $response = array(
                'status' => 404,
                'message' => 'Imagen no existe',
            );
        }
    } else {
        $response = array(
            'status' => 406,
            'message' => 'No se definió el nombre de la imagen',
        );
    }

    return response()->json($response, $response['status']);
}


public function deleteImage($filename) {
    if (isset($filename)) {
        $exist = \Storage::disk('users')->exists($filename);

        if ($exist) {
            \Storage::disk('users')->delete($filename);
            $response = array(
                'status' => 200,
                'message' => 'Imagen eliminada',
            );
        } else {
            $response = array(
                'status' => 404,
                'message' => 'La imagen no existe',
            );
        }
    } else {
        $response = array(
            'status' => 406,
            'message' => 'No se definió el nombre de la imagen',
        );
    }

    return response()->json($response, $response['status']);
}

    
}
