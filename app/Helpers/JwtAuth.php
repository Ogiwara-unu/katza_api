<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Exceptions\TokenInvalidException;
use App\Models\User;
use App\Models\Librarian;
use DomainException;


class JwtAuth{
    private $key;
    function __construct(){
        $this->key="piippipipi";
    }

    //-------------------------------------GET TOKENS----------------------------------------
    public function getToken($name,$password){
        $user=User::where(['name'=>$name, 'password'=> hash('sha256',$password)])->first();

        if(is_object($user)){

            $token=array(
                'iss'=>$user->id,
                'email'=> $user->email,
                'name'=> $user->name,
                'role' => 'user', 
                'iat'=>time(),
                'exp'=>time()+(2000)
            );
            $data=JWT::encode($token,$this->key, 'HS256' );
        }else{
            $data=array(
                'status'=>401,
                'message'=> 'Datos de autenticacion incorrectos'
            );

        }
        return $data;
    }

 

    //------------------------------------CHECK TOKENS----------------------------------------

    public function checkToken($jwt, $getID=false){
        $authFlag=false;
        if(isset($jwt)){
            try{
                $decode=JWT::decode($jwt,new Key($this->key,'HS256'));
            }catch(DomainException $ex){
                $authFlag=false;
            }catch(ExpiredException $ex){
                $authFlag=false;
            }
            if (!empty ($decode)&&is_object($decode)&&isset($decode->iss)){
                $authFlag=true;
            }
            if($getID && $authFlag){
                return $decode;

            }
        }
        return $authFlag;
    }
    

    //----------------------------------------------------------------------------------------

}