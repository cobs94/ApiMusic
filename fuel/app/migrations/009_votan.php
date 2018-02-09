<?php
namespace Fuel\Migrations;

class votan
{

	function up()
	{        
		\DBUtil::create_table('votan', array(
			'id_usuario' => array('type' => 'int', 'constraint' => 11),
			'id_esquema' => array('type' => 'int', 'constraint' => 11),
			), array('id_usuario','id_esquema'), false, 'InnoDB', 'utf8_unicode_ci',array(
			array(
				'constraint' => 'claveAjenaVotanAEsquemas',
				'key' => 'id_esquema',
				'reference' => array(
					'table' => 'esquemas',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				),
			array(
				'constraint' => 'claveAjenavotanAUsuarios',
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
		\DBUtil::drop_table('votan');
	}
}