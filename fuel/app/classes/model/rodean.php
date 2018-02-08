<?php

class Model_Rodean extends Orm\Model
{
	protected static $_table_name = 'rodean';
    protected static $_properties = array('id_estrella', 'id_orbita');
    protected static $_primary_key = array('id_estrella', 'id_orbita');
}