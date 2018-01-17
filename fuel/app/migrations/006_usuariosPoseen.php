<?php
namespace Fuel\Migrations;

class usuariosPoseen
{

	function up()
	{        
		\DBUtil::create_table('usuariosPoseen', array(
			'id_usuario' => array('type' => 'int', 'constraint' => 11),
			'id_esquema' => array('type' => 'int', 'constraint' => 11),
			), array('id_usuario','id_esquema'), false, 'InnoDB', 'utf8_unicode_ci',array(
			array(
				'constraint' => 'claveAjenaUsuariosPoseenAEsquemas',
				'key' => 'id_esquema',
				'reference' => array(
					'table' => 'esquemas',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				),
			array(
				'constraint' => 'claveAjenaUsuariosPoseenAUsuarios',
				'key' => 'id_usuario',
				'reference' => array(
					'table' => 'usuarios',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				)
			)
			);
	}

	function down()
	{
		\DBUtil::drop_table('usuariosPoseen');
	}
}