<?php

class Model_Usuarios extends Orm\Model
{
	protected static $_table_name = 'posiciones';
    protected static $_properties = array('id', 'x','y', 'id_esquema', 'id_planeta');
    protected static $_primary_key = array('id');

}