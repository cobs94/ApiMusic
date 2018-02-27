<?php
use Firebase\JWT\JWT;
class Controller_noticia extends Controller_Base
{
    private $key = 'my_secret_key';
    protected $format = 'json';

public function post_create()
{
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key, array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $title = $input['title'];
        $description = $input['description'];   

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));        
        if($BDuser != null){
            if (array_key_exists('title', $input) && !empty($title) && array_key_exists('description', $input) && !empty($description)) {

                $new = new Model_Noticias();
                $new->title = $title;
                $new->description = $description;
                $new->id_usuario = $id;
                $new->save();

                $this->Mensaje('200', 'noticia creada', $input);
            }elseif(empty($title)){
                $this->Mensaje('400', 'Introduce un titulo', $input);
            }elseif (empty($description)) {
            	$this->Mensaje('400', 'Introduce una descripcion', $input);
            }
        }else{
            $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch (Exception $e) {
        echo $e;
        $this->Mensaje('500', 'Error interno del servidor', $input);
    } 
}

public function post_modify(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $title = $input['title'];
        $description = $input['description'];
        $idNotice = $input['idNotice'];

       
        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        $BDnotice = Model_Noticias::find('first', array(
            'where' => array(
                array('id', $idNotice),
                array('id_usuario', $id),
            ),
        ));

        if($BDuser != null){
            if (array_key_exists('title', $input) && !empty($title) || array_key_exists('description', $input) && !empty($description)){

                if (!empty($title)) {
                    $BDnotice->title = $title;
                    $BDnotice->save();
                }

                if (!empty($description)) {
                        $BDnotice->description = $description;
                        $BDnotice->save();
                    }
                
                $this->Mensaje('200', 'Noticia modificada', $BDnotice);
            
            }else{
                $this->Mensaje('400', 'Introduce algun parametro', $input);
            }
        }else {
            $this->Mensaje('400', 'Permisos Denegados', $id);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', $input);
    }
}

public function post_delete(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $idNotice = $input['idNotice'];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            $BDnotice = Model_Noticias::find('first', array(
                'where' => array(
                    array('id', $idNotice),
                    array('id_usuario', $id),
                ),
            ));
            if ($BDnotice != null) {
                $BDnotice->delete();

                $this->Mensaje('200', 'noticia borrada', $BDnotice);
            }else{
                $this->Mensaje('400', 'Esta noticia no existe', $input);
            }
        } else {
            $this->Mensaje('400', 'Permisos denegados', $id);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', $input);
    } 
}

public function get_ownNotices(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;


        $BDuser = Model_Usuarios::find('all', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            $notices = Model_Noticias::find('all', array(
                'where' => array(
                    array('id_usuario', $id)
                ),
            ));

            $this->Mensaje('200', 'listas de noticias', $notices);
        }else {
            $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', ' ');
    } 
}

public function get_allNotices(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key , array('HS256'));
        $id = $tokenDecode->data->id;


        $BDuser = Model_Usuarios::find('all', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            $notices = Model_Noticias::find('all');

            $this->Mensaje('200', 'listas de noticias', $notices);
        }else {
            $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', ' ');
    } 
}
}