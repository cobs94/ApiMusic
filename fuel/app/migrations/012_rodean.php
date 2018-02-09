<?php
namespace Fuel\Migrations;

class rodean
{

	function up()
	{        
		\DBUtil::create_table('rodean', array(
			'id_estrella' => array('type' => 'int', 'constraint' => 11),
			'id_orbita' => array('type' => 'int', 'constraint' => 11),
			), array('id_orbita','id_estrella'), false, 'InnoDB', 'utf8_unicode_ci',array(
			array(
				'constraint' => 'claveAjenaRodeanAEstrella',
				'key' => 'id_estrella',
				'reference' => array(
					'table' => 'estrellas',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				),
			array(
				'constraint' => 'claveAjenaRodeanAorbita',
				'key' => 'id_orbita',
				'reference' => array(
					'table' => 'orbitas',
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
		\DBUtil::drop_table('rodean');
	}
}