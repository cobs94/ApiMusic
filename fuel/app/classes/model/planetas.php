<?php

class Model_Planetas extends Orm\Model
{
	protected static $_table_name = 'planetas';
    protected static $_properties = array('id', 'description','name', 'model', 'size', 'speed', 'picture');
    protected static $_primary_key = array('id');
}