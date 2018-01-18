<?php

class Model_Usuarios extends Orm\Model
{
	protected static $_table_name = 'planetas';
    protected static $_properties = array('id', 'description','name', 'model', 'size', 'speed');


}