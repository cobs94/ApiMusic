<?php

class Model_Usuarios extends Orm\Model
{
	protected static $_table_name = 'usuarios';
    protected static $_properties = array('id', 'username','email', 'password', 'idDevice', 'picture', 'x', 'y', 'birthday', 'city', 'description','id_rol', 'id_privacidad');
    protected static $_primary_key = array('id');
    protected static $_belongs_to = array(
    'roles' => array(
        'key_from' => 'id_rol',
        'model_to' => 'Model_Roles',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ),
    'privacidad' => array(
        'key_from' => 'id_privacidad',
        'model_to' => 'Model_Privacidad',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
    protected static $_many_many = array(
    'usuarios' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_seguidor', // column 1 from the table in between, should match a posts.id
        'table_through' => 'siguen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_seguido', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Usuarios',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ),
    'usuarios' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_seguido', // column 1 from the table in between, should match a posts.id
        'table_through' => 'siguen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_seguidor', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Usauarios',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
    protected static $_has_many = array(
    'listas' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Listas',
        'key_to' => 'id_usuario',
        'cascade_save' => true,
        'cascade_delete' => false,
    ),
    'noticias' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Noticias',
        'key_to' => 'id_usuario',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
}