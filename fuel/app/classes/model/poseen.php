<?php

class Model_Poseen extends Orm\Model
{
	protected static $_table_name = 'poseen';
    protected static $_properties = array('id_esquema', 'id_estrella');
    protected static $_primary_key = array('id_esquema', 'id_estrella');
}