<?php

class Model_Contienen extends Orm\Model
{
	protected static $_table_name = 'contienen';
    protected static $_properties = array('id_lista', 'id_cancion');
    protected static $_primary_key = array('id_lista', 'id_cancion');
}