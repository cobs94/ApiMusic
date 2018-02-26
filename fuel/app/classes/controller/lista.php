<?php
use Firebase\JWT\JWT;
class Controller_lista extends Controller_Base
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

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));        
        if($BDuser != null){
            if (array_key_exists('title', $input) && !empty($title)) {

                $BDlist = Model_Listas::find('first', array(
                    'where' => array(
                        array('title', $title),
                        array('id_usuario', $idUser)
                    ),
                ));

                if($BDlist == null){
                    $new = new Model_Listas();
                    $new->title = $title;
                    $new->edit = true;
                    $new->id_usuario = $id;
                    $new->save();

                    $this->Mensaje('200', 'lista creada', $input);
                    
                } else {
                    $this->Mensaje('400', 'Esa lista ya existe', $title);
                }
            }else{
                $this->Mensaje('400', 'Introduce un titulo', $input);
            }
        }else{
            $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch (Exception $e) {
        echo $e;
        $this->Mensaje('500', 'Error interno del servidor', $input);
    } 
}

function post_addSong(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key, array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $idSong = $input['idSong'];
        $idList = $input['idList'];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            if(array_key_exists('idSong', $input) && !empty($idSong) && array_key_exists('idList', $input) && !empty($idList)){

                $BDsong = Model_Canciones::find('first', array(
                    'where' => array(
                        array('id', $idSong)
                    ),
                ));
                $BDlist = Model_Listas::find('first', array(
                    'where' => array(
                        array('id', $idList),
                        array('id_usuario', $id),
                        array('edit', true)
                    ),
                ));

                if($BDsong != null && $BDlist != null){
                    $contienen = Model_Contienen::find('first', array(
                        'where' => array(
                            array('id_lista', $idList),
                            array('id_cancion', $idSong)
                        )
                    ));

                    if($contienen == null){

                        $props = array('id_list' => $id_list, 'id_song' => $id_song);
                        $new = new Model_Contain($props);
                        $new->save();

                        $new = new Model_Contienen();
                        $new->id_lista = $idList;
                        $new->id_cancion = $idSong;
                        $new->save();

                        $this->Mensaje('200', 'Cancion añadida a la lista', $input);
                    }else{
                         $this->Mensaje('400', 'La cancion ya esta en la lista', $input);
                    }
                }elseif ($BDsong == null){
                    $this->Mensaje('400', 'La cancion no existe', $input);
                }elseif ($BDlist == null) {
                    $this->Mensaje('400', 'La lista no existe', $input);
                }
            }else{
                $this->Mensaje('400', 'Faltan parametros', $input);
            }
        }else{
             $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch(Exception $e){
        $this->Mensaje('500', 'Error interno del servidor', $input);
    }
}

function post_removeSong(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key, array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $idSong = $input['idSong'];
        $idList = $input['idList'];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            if(array_key_exists('idSong', $input) && !empty($idSong) && array_key_exists('idList', $input) && !empty($idList)){

                $BDsong = Model_Canciones::find('first', array(
                    'where' => array(
                        array('id', $idSong)
                    ),
                ));
                $BDlist = Model_Listas::find('first', array(
                    'where' => array(
                        array('id', $idList),
                        array('id_usuario', $id),
                        array('edit', true)
                    ),
                ));

                if($BDsong != null && $BDlist != null){
                    $contienen = Model_Contienen::find('first', array(
                        'where' => array(
                            array('id_lista', $idList),
                            array('id_cancion', $idSong)
                        )
                    ));

                    if($contienen != null){

                        $contienen->delete();

                        $this->Mensaje('200', 'Cancion eliminada de la lista', $input);
                    }else{
                         $this->Mensaje('400', 'La cancion no esta en la lista', $input);
                    }
                }elseif ($BDsong == null){
                    $this->Mensaje('400', 'La cancion no existe', $input);
                }elseif ($BDlist == null) {
                    $this->Mensaje('400', 'La lista no existe', $input);
                }
            }else{
                $this->Mensaje('400', 'Faltan parametros', $input);
            }
        }else{
             $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch(Exception $e){
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
        $idList = $input['idList'];

       
        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        $BDlist = Model_Listas::find('first', array(
            'where' => array(
                array('id', $idList),
                array('id_usuario', $id),
                array('edit', true)
            ),
        ));

        $BDlist2 = Model_Listas::find('first', array(
            'where' => array(
                array('title', $title)                     
            ),
        ));

        if($BDuser != null){
            if (array_key_exists('title', $input) && !empty($title)){
                if($BDlist2 == null ){

                    $BDlist->title = $title;
                    $BDlist->save();
                    
                    $this->Mensaje('200', 'Lista modificada', $BDlist);
                }else{
                    $this->Mensaje('400', 'Ya hay una lista con ese titulo', $title);
                }
            
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
        $idList = $input['idList'];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            $BDlist = Model_Listas::find('first', array(
                'where' => array(
                    array('id', $idList),
                    array('id_usuario', $id),
                    array('edit', true)
                ),
            ));
            if ($BDlist != null) {
                $BDsong->delete();

                $this->Mensaje('200', 'Lista borrada', $BDlist);
            }else{
                $this->Mensaje('400', 'Esta lista no existe', $input);
            }
        } else {
            $this->Mensaje('400', 'Permisos denegados', $id);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', $input);
    } 
}

public function get_ownList(){
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
            $lists = Model_Listas::find('all', array(
                'where' => array(
                    array('id_usuario', $id)
                ),
            ));

            $this->Mensaje('200', 'listas de usuarios', $lists);
        }else {
            $this->Mensaje('400', 'Permisos denegados', $input);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', ' ');
    } 
}
}