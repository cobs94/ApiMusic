<?php

class Model_Listas extends Orm\Model
{
	protected static $_table_name = 'listas';
    protected static $_properties = array('id', 'title','edit', 'id_usuario');
    protected static $_primary_key = array('id');
    protected static $_belongs_to = array(
    'usuarios' => array(
        'key_from' => 'id_usuario',
        'model_to' => 'Model_Usuarios',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
    protected static $_many_many = array(
    'canciones' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_lista', // column 1 from the table in between, should match a posts.id
        'table_through' => 'contienen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_cancion', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Canciones',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
}