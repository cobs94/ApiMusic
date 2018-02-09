<?php

class Model_Usuarios extends Orm\Model
{
	protected static $_table_name = 'usuarios';
    protected static $_properties = array('id', 'username','email', 'password', 'picture', 'id_rol');
    protected static $_primary_key = array('id');
    protected static $_belongs_to = array(
    'roles' => array(
        'key_from' => 'id_rol',
        'model_to' => 'Model_Roles',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    );
    protected static $_many_many = array(
    'esquemas' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_usuario', // column 1 from the table in between, should match a posts.id
        'table_through' => 'tienen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_esquema', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Esquemas',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ),
    'esquemas' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_usuario', // column 1 from the table in between, should match a posts.id
        'table_through' => 'votan', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_esquema', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Esquemas',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
);
}