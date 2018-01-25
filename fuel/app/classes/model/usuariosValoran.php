<?php

class Model_Usuarios extends Orm\Model
{
	protected static $_table_name = 'usuariosValoran';
    protected static $_properties = array('id_usuario', 'id_esquema');
    protected static $_primary_key = array('id_usuario', 'id_esquema');

}