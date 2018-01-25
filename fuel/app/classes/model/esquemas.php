<?php

class Model_Usuarios extends Orm\Model
{
	protected static $_table_name = 'esquemas';
    protected static $_properties = array('id', 'name','ranking', 'editable');
    protected static $_primary_key = array('id');

}