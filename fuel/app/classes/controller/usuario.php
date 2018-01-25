<?php
use Firebase\JWT\JWT;
class Controller_usuario extends Controller_Rest
{
    private $key = 'my_secret_key';
    protected $format = 'json';

    public function post_create()
    {
        $input = $_POST;
        if (array_key_exists('username', $input)&& !empty($input['username']) && array_key_exists('email', $input) && !empty($input['email']) && array_key_exists('passwordRepeat', $input) && !empty($input['passwordRepeat']) && !empty($input['password']) && array_key_exists('password', $input) && array_key_exists('rol', $input)){
            $BDuser = Model_Usuarios::find('first', array(
                'where' => array(
                    array('username', $input['username'])
                    ),
                ));
            if ($input['password'] == $input['passwordRepeat']){
                if(count($BDuser) < 1){
                    $new = new Model_Usuarios();
                    $new->username = $input['username'];
                    $new->email = $input['email'];
                    $new->password = $input['password'];
                    $new->id_rol = $input['rol'];
                    $new->save();

                    $BDuser2 = Model_Usuarios::find('first', array(
                        'where' => array(
                            array('username', $input['username']),
                            array('password', $input['password'])
                            ),
                        ));

                    $time = time();
                    $token = array(
                        'iat' => $time,
                            'data' => [ // información del usuario
                                'id' => $BDuser2->id,
                                'username' => $input['username'],
                                'password'=> $input['password']
                            ]
                        );

                    $jwt = JWT::encode($token, $this->key);

                    $this->Mensaje('200', 'usuario creado', $jwt);
                } else {
                    $this->Mensaje('400', 'usuario ya esta en uso', $input['username']);
                }
            }else {
                $this->Mensaje('400', 'contraseñas no coinciden', $input['password']);
            }
        } else{
            $this->Mensaje('400', 'Parametros incorrectos', $input);
        }    
    }

    public function get_login()
    {
    	$username = $_GET['username'];
    	$password = $_GET['password'];
        if(!empty($username) && !empty($password)){
            $BDuser = Model_Usuarios::find('first', array(
             'where' => array(
                 array('username', $username),
                 array('password', $password)
                 ),
             ));

            if(count($BDuser) == 1){
             $time = time();
             $token = array(
                'iat' => $time,
	    		'data' => [ // información del usuario
                'id' => $BDuser->id,
                'username' => $username,
                'password'=> $password
                ]
                );

             $jwt = JWT::encode($token, $this->key);

             $this->Mensaje('200', 'usuario logueado', $jwt);
         } else {
            $this->Mensaje('400', 'usuario o contraseña incorrectos', $username);
        }
    }else {
        $this->Mensaje('400', 'parametros vacios', $username);
    }
}

public function get_authorization(){
    $jwt = apache_request_headers()['Authorization'];

    $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));

    $username = $tokenDecode->data->username;
    $password = $tokenDecode->data->password;

    $BDuser = Model_Usuarios::find('all', array(
        'where' => array(
            array('username', $username),
            array('password', $password)
        ),
    ));

    if(count($BDuser) == 1){
        $users = Model_Usuarios::find('all');
        $this->Mensaje('200', 'lista de usuarios', $users);
    }else {
        $this->Mensaje('400', 'usuario incorrecto', $username);
    }
}

public function post_modifyPassword(){

    try{

        $input = $_POST;

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('username', $input['username']),
            ));

        if($BDuser != null){
            $BDuser->password = $input['password'];
            $BDuser->save();
            $this->Mensaje('200', 'usuario modificado', $input['password']);
        } else {
            $this->Mensaje('400', 'usuario invcorrecto', $input['username']);
        }
    } catch(Exception $e) {
        $this->Mensaje('500', 'Error de verificacion', "aprender a programar");
    } 
}

public function post_deleteUser(){
    $jwt = apache_request_headers()['Authorization'];
    try{
        if(!empty($jwt)){
            $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));

            $id = $tokenDecode->data->id;

            $BDuser = Model_Usuarios::find('first', array(
                'where' => array(
                    array('id', $id)
                    ),
                ));
            if($BDuser != null){

                $BDuser->delete();

                $this->Mensaje('200', 'usuario borrado', $BDuser);
            } else {
                $this->Mensaje('400', 'usuario incorrecto', $input['username']);
            }
        } else {
            $this->Mensaje('400', 'token vacio', $jwt);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error de verificacion', "aprender a programar");
    } 
}

public function get_validateEmail(){
    try{
        $email = $_GET['email'];
        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('email', $email)
                ),
            ));
        if($BDuser != null){
            $this->Mensaje('200', 'email correcto', $BDuser);
        } else {
            $this->Mensaje('400', 'email incorrecto', $email);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error de servidor', "aprender a programar");
    }
}

function Mensaje($code, $message, $data){
    $json = $this->response(array(
        'code' => $code,
        'message' => $message,
        'data' => $data
        ));
    return $json;
}
}