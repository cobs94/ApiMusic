<?php

class Model_Privacidad extends Orm\Model
{
	protected static $_table_name = 'privacidad';
    protected static $_properties = array('id', 'profile', 'friends', 'lists', 'notifications', 'localize');
    protected static $_primary_key = array('id');
    /*protected static $_has_one = array(
    'usuarios' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Usuarios',
        'key_to' => 'id_privacidad',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));*/
}
