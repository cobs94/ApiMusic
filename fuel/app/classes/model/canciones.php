<?php

class Model_Canciones extends Orm\Model
{
	protected static $_table_name = 'canciones';
    protected static $_properties = array('id', 'title','artist', 'url', 'plays');
    protected static $_primary_key = array('id');
    protected static $_many_many = array(
    'listas' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_cancion', // column 1 from the table in between, should match a posts.id
        'table_through' => 'contienen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_lista', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Listas',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
}