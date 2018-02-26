<?php
use Firebase\JWT\JWT;
class Controller_cancion extends Controller_Base
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
            $artist = $input['artist'];
            $url = $input['url'];    

            $BDuser = Model_Usuarios::find('first', array(
                'where' => array(
                    array('id', $id)
                ),
            ));        
            if($BDuser != null){
                if (array_key_exists('title', $input) && !empty($title) && array_key_exists('artist', $input) && !empty($artist) && array_key_exists('url', $input) && !empty($url)) {

                    $BDsong = Model_Canciones::find('first', array(
                        'where' => array(
                            array('title', $title),
                            array('artist', $artist),
                        'or' => array(
                            array('url', $url)),
                        ),
                    ));

                    if($BDsong == null){
                        $new = new Model_Canciones();
                        $new->title = $title;
                        $new->artist = $artist;
                        $new->url = $url;
                        $new->plays = 0;
                        $new->save();

                        $this->Mensaje('200', 'cancion agregada', $input);
                        
                    } elseif ($BDsong->title == $title) {
                        $this->Mensaje('400', 'Esa cancion ya existe', $title);
                    }elseif ($BDsong->url == $url) {
                        $this->Mensaje('400', 'Ya hay una cancion con esta URL', $url);
                    }
                }elseif(empty($title)){
                    $this->Mensaje('400', 'Introduce el campo titulo', $input);
                }elseif (empty($artist)) {
                    $this->Mensaje('400', 'Introduce el campo artista', $input);
                }elseif (empty($url)) {
                    $this->Mensaje('400', 'Introduce el campo url', $input);
                }
            }else{
                $this->Mensaje('400', 'Permisos denegados', $input);
            }
        }catch (Exception $e) {
            echo $e;
            $this->Mensaje('500', 'Error interno del servidor', $input);
        } 
    }

public function post_playSong(){
    try{
        $jwt = apache_request_headers()['Authorization'];
        $tokenDecode = JWT::decode($jwt, $this->key, array('HS256'));
        $id = $tokenDecode->data->id;

        $input = $_POST;
        $idSong = $input['idSong'];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if ($BDuser != null) {
            if (array_key_exists('idSong', $input) && !empty($idSong)) {
                $BDsong = Model_Canciones::find('first', array(
                    'where' => array(
                        array('id', $idSong)
                    ),
                ));

                if ($BDsong != null) {
                    $BDsong->plays += 1;
                    $this->Mensaje('400', 'Esta cancion no existe', $BDsong);
                }else{
                    $this->Mensaje('400', 'Esta cancion no existe', $input);
                }
            }else{
               $this->Mensaje('400', 'Selecciona una cancion', $input); 
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
        $artist = $input['artist'];
        $url = $input['url'];
        $idSong = $input["id"];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));
        
        $BDsong = Model_Canciones::find('first', array(
        'where' => array(
            array('id', $idSong)
            ),
        ));
        $BDsong2 = Model_Canciones::find('first', array(
            'where' => array(
                array('title', $title),
                array('artist', $artist),
                'or' => array(
                array('url', $url)),                      
                ),
        ));
        if($BDuser != null){
            if (array_key_exists('title', $input) && !empty($title) || array_key_exists('artist', $input) && !empty($artist) || array_key_exists('url', $input) && !empty($url)){
                if($BDsong2 == null){
                    if (!empty($title)) {
                        $BDsong->title = $title;
                        $BDsong->save();
                    }
                    if (!empty($artist)) {
                        $BDsong->artist = $artist;
                        $BDsong->save();
                    }
                    if (!empty($url)) {
                        $BDsong->url = $url;
                        $BDsong->save();
                    }
                    
                    $this->Mensaje('200', 'Cancion modificada', $BDsong);
                }elseif ($BDsong2->title == $title) {
                    $this->Mensaje('400', 'Esta cancion ya existe', $title);
                }elseif ($BDsong2->url == $url) {
                    $this->Mensaje('400', 'Ya hay una cancion con esta url', $url);
                }
            
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

        $input = $_POST;
        $idSong = $input['idSong'];

        $BDuser = Model_Usuarios::find('first', array(
            'where' => array(
                array('id', $id)
            ),
        ));

        if($BDuser != null){
            $BDsong = Model_Canciones::find('first', array(
                'where' => array(
                    array('id', $idSong),
                ),
            ));
            if ($BDsong != null) {
                $BDsong->delete();

                $this->Mensaje('200', 'Cancion borrada', $BDsong);
            }else{
                $this->Mensaje('400', 'Esta cancion no existe', $input);
            }
        } else {
            $this->Mensaje('400', 'Permisos denegados', $id);
        }
    }catch(Exception $e) {
        $this->Mensaje('500', 'Error interno del servidor', $input);
    } 
}

public function get_allSongs(){
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
            $songs = Model_Canciones::find('all');

            $this->Mensaje('200', 'lista de canciones', $songs);
        }else {
            $this->Mensaje('400', 'Permisos denegados', $id);
        }
    }catch(Exception $e){
        $this->Mensaje('500', 'Error interno del servidor', ' ');
    }
}
}