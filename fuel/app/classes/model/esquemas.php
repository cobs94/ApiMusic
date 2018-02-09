<?php

class Model_Esquemas extends Orm\Model
{
	protected static $_table_name = 'esquemas';
    protected static $_properties = array('id', 'name','ranking', 'editable', 'picture');
    protected static $_primary_key = array('id');
    protected static $_many_many = array(
        'usuarios' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_esquemas', // column 1 from the table in between, should match a posts.id
            'table_through' => 'tienen', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_usuario', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Usuarios',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'usuarios' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_esquema', // column 1 from the table in between, should match a posts.id
            'table_through' => 'votan', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_usuario', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Usuarios',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'estrellas' => array(
            'key_from' => 'id',
            'key_through_from' => 'id_esquema', // column 1 from the table in between, should match a posts.id
            'table_through' => 'poseen', // both models plural without prefix in alphabetical order
            'key_through_to' => 'id_estrella', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Estrellas',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    
    );
}