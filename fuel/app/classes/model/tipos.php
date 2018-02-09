<?php

class Model_Tipos extends Orm\Model
{
	protected static $_table_name = 'tipos';
    protected static $_properties = array('id', 'name','size');
    protected static $_primary_key = array('id');
    protected static $_has_many = array(
	    'estrellas' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Estrellas',
	        'key_to' => 'id_tipos',
	        'cascade_save' => true,
	        'cascade_delete' => true,
	    )
	);
}