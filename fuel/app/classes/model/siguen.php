<?php

class Model_Siguen extends Orm\Model
{
	protected static $_table_name = 'siguen';
    protected static $_properties = array('id_seguido', 'id_seguidor');
    protected static $_primary_key = array('id_seguido', 'id_seguidor');
}