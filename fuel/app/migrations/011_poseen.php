<?php
namespace Fuel\Migrations;

class poseen
{

	function up()
	{        
		\DBUtil::create_table('poseen', array(
			'id_esquema' => array('type' => 'int', 'constraint' => 11),
			'id_estrella' => array('type' => 'int', 'constraint' => 11),
			), array('id_esquema','id_estrella'), false, 'InnoDB', 'utf8_unicode_ci',array(
			array(
				'constraint' => 'claveAjenaPoseenAEsquema',
				'key' => 'id_esquema',
				'reference' => array(
					'table' => 'esquemas',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				),
			array(
				'constraint' => 'claveAjenaPoseenAEstrellas',
				'key' => 'id_estrella',
				'reference' => array(
					'table' => 'estrellas',
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
		\DBUtil::drop_table('poseen');
	}
}