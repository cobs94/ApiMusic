<?php
use Firebase\JWT\JWT;
class Controller_usuario extends Controller_Base
{
    private $key = 'my_secret_key';
    protected $format = 'json';

    public function post_create()
    {
        try{
            $input = $_POST;
            $username = $input['username'];
            $email = $input['email'];
            $password = $input['password'];
            $passwordRepeat = $input['passwordRepeat'];
            $idDevice = $input['idDevice'];
            $x = $input['x'];
            $y = $input['y'];            

            if (array_key_exists('username', $input) && !empty($username) && array_key_exists('email', $input) && !empty($email) && array_key_exists('password', $input) && !empty($password) && array_key_exists('passwordRepeat', $input) && !empty($passwordRepeat) && array_key_exists('idDevice', $input) && !empty($idDevice) && array_key_exists('x', $input) && !empty($x) && array_key_exists('y', $input) && !empty($y)) {

                $BDuser = Model_Usuarios::find('first', array(
                    'where' => array(
                        array('username', $username),
                        'or' => array(
                        array('email', $email)),                      
                        ),
                ));

                if($BDuser == null){
                    if ($password == $passwordRepeat){
                        $new = new Model_Usuarios();
                        $new->username = $username;
                        $new->email = $email;
                        $new->password = $password;
                        $new->idDevice = $idDevice;
                        $new->x = $x;
                        $new->y = $y;
                        $new->rol = 2;
                        $new->save();

                        $time = time();
                        $token = array(
                            'iat' => $time,
                            'data' => [
                                'id' => $new->id,
                                'username' => $username,
                                'password'=> $password,
                            ]
                        );

                        $jwt = JWT::encode($token, $this->key);

                        $this->Mensaje('200', 'usuario creado', $jwt);
                    }else{
                        $this->Mensaje('400', 'contraseñas no coinciden', $password);
                    }
                } elseif ($BDuser->username == $username) {
                    $this->Mensaje('400', 'Este nombre de usuario ya esta en uso', $username);
                }elseif ($BDuser->email == $email) {
                    $this->Mensaje('400', 'Este email ya esta en uso', $username);
                }
            }elseif(empty($username)){
                $this->Mensaje('400', 'Falta nombre de usuario', $input);
            }elseif (empty($email)) {
                $this->Mensaje('400', 'Falta email', $input);
            }elseif (empty($password)) {
                $this->Mensaje('400', 'Falta contraseña', $input);
            }elseif (empty($passwordRepeat)) {
                $this->Mensaje('400', 'Tienes que repetir la contraseña', $input);
            }elseif (empty($idDevice)) {
                $this->Mensaje('400', 'Falta id del dispositivo', $input);
            }elseif (empty($x)) {
                $this->Mensaje('400', 'Falta coordenada x', $input);
            }elseif (empty($y)) {
                $this->Mensaje('400', 'Falta coordenado y', $input);
            }
        }catch (Exception $e) {
            echo $e;
            $this->Mensaje('500', 'Error interno del servidor', $input);
        } 
    }
    public function post_login()
    {
        try{
            $input = $_POST;
        	$username = $input['username'];
            $password = $input['password'];
            $idDevice = $input['idDevice'];
            $x = $input['x'];
            $y = $input['y'];

            if(array_key_exists('username', $input) && !empty($username) && array_key_exists('password', $input) && !empty($password) && array_key_exists('idDevice', $input) && !empty($idDevice) && array_key_exists('x', $input) && !empty($x) && array_key_exists('y', $input) && !empty($y)){

                $BDuser = Model_Usuarios::find('first', array(
                 'where' => array(
                     array('username', $username),
                     array('password', $password)
                     ),
                 ));

                if(count($BDuser) == 1){

                    $BDuser->idDevice = $idDevice;
                    $BDuser->x = $x;
                    $BDuser->y = $y;
                    $BDuser->save();

                    $time = time();
                    $token = array(
                        'iat' => $time,
                        'data' => [
                            'id' => $BDuser->id,
                            'username' => $username,
                            'password' => $password,
                            'rol' => $BDuser->rol
                        ]
                    );

                    $jwt = JWT::encode($token, $this->key);

                    $this->Mensaje('200', 'usuario logueado', $jwt);
             } else {
                $this->Mensaje('400', 'usuario o contraseña incorrectos', $username);
            }
        }else {
            $this->Mensaje('400', 'Todos los campos son obligatorios', $username);
        }
    }catch (Exception $e) {
        echo $e;
        $this->Mensaje('500', 'Error interno del servidor', $username);
    } 
}

public function get_validateEmail(){
    try{
        $email = $_GET['email'];
        if (!empty($email)) {
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
        }else{
            $this->Mensaje('400', 'Introduce un email', $email);
        }
        
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno de servidor', $email);
    }
}

public function post_recoverPassword(){
    try{

        $input = $_POST;
        $email = $input['email'];
        $password = $input['password'];
        $passwordRepeat = $input['passwordRepeat'];

        if (array_key_exists('email', $input) && !empty($email) && array_key_exists('password', $input) && !empty($password) && array_key_exists('passwordRepeat', $input) && !empty($passwordRepeat)) {

            $BDuser = Model_Usuarios::find('first', array(
                'where' => array(
                    array('email', $email)
                ),
            ));
            if ($password == $passwordRepeat) {
                if($BDuser != null){
                    $BDuser->password = $password;
                    $BDuser->save();
                    $this->Mensaje('200', 'Contraseña modificada', $email);
                } else {
                    $this->Mensaje('400', 'Usuario incorrecto', $email);
                }
            }else{
                $this->Mensaje('400', 'Las contraseñas no coinciden', $email);
            }
        }else{
            $this->Mensaje('400', 'Todos los campos son obligatorios', $email);
        }
    } catch(Exception $e) {
        $this->Mensaje('500', 'Error interno de servidor', $input);
    } 
}

public function get_allUsers(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;
            
        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if ($BDuser != null){
            $users = Model_Usuarios::find('all');

            $this->Mensaje('200', 'lista de usuarios', $users);
        }else {
            $this->Mensaje('400', 'Permisos denegados', $id);
        }
    }catch(Exception $e){
        $this->Mensaje('500', 'Error interno del servidor', ' ');
    }
}  

public function post_modify(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $image = $_FILES['image'];
        $password = $input['password'];
        $passwordRepeat = $input['passwordRepeat'];
        $birthday = $input["birthday"];
        $city = $input["city"];
        $description = $input["description"];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            if (array_key_exists('image', $_FILES) && !empty($image) || array_key_exists('password', $input) && !empty($password) || array_key_exists('passwordRepeat', $input) && !empty($passwordRepeat) || array_key_exists('birthday', $input) && !empty($birthday) || array_key_exists('city', $input) && !empty($city) || array_key_exists('description', $input) && !empty($description)){

                if (!empty($image)) {
                    $this->Upload($new, $image);
                }
                if (!empty($password) && !empty($passwordRepeat) && $password == $passwordRepeat) {
                    $BDuser->password = $password;
                    $BDuser->save();
                }else{
                   $this->Mensaje('400', 'Las contraseñas no coinciden', $input); 
                }
                if (!empty($birthday)) {
                    $BDuser->birthday = $birthday;
                    $BDuser->save();
                }
                if (!empty($city)) {
                    $BDuser->city = $city;
                    $BDuser->save();
                }
                if (!empty($description)) {
                    $BDuser->description = $description;
                    $BDuser->save();
                }
                
                $this->Mensaje('200', 'Usuario modificado', $BDuser);
            
            }else{
                $this->Mensaje('400', 'Introduce algun parametro', $input);
            }
        }else {
            $this->Mensaje('400', 'Permisos Denegados', $id);
        }
    }catch(Exception $e) {
        echo $e;
        $this->Mensaje('500', 'Error interno del servidor', $input);
    }
}

public function post_delete(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            
            $BDuser->delete();

            $this->Mensaje('200', 'Usuario borrado', $BDuser);
        } else {
            $this->Mensaje('400', 'Permisos denegados', $id);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', $input);
    } 
}

function post_initialSetting(){
        try{

            $DBuser = Model_Usuarios::find('first', array(
                    'where' => array(
                            array('id_rol', 1)
                    )
            ));

            if($userDB == null){

                $new = new Model_Usuarios();
                $new->username = 'admin';
                $new->email = 'admin@admin.es';
                $new->password = '1234';
                $new->rol = 1;
                $new->save();

                $time = time();
                $token = array(
                    'iat' => $time,
                    'data' => [
                        'id' => $new->id,
                        'username' => $new->username,
                        'password'=> $new->password,
                    ]
                );

                $jwt = JWT::encode($token, $this->key);

                $this->Mensaje('200', 'Usuario administrador creado', $jwt);
            }else{
               $this->Mensaje('400', 'Ya hay un usuario administrador', $DBuser); 
            }

            
        }catch(Exception $e){
            $this->Mensaje('500', 'Error de verificacion', "aprender a programar");
        }
    }
}