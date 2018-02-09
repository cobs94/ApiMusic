<?php
namespace Fuel\Migrations;

class contienen
{

	function up()
	{        
		\DBUtil::create_table('contienen', array(
			'id_orbita' => array('type' => 'int', 'constraint' => 11),
			'id_planeta' => array('type' => 'int', 'constraint' => 11),
			), array('id_orbita','id_planeta'), false, 'InnoDB', 'utf8_unicode_ci',array(
			array(
				'constraint' => 'claveAjenaContienenAOrbitas',
				'key' => 'id_orbita',
				'reference' => array(
					'table' => 'orbitas',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				),
			array(
				'constraint' => 'claveAjenaContienenAPlanetas',
				'key' => 'id_planeta',
				'reference' => array(
					'table' => 'planetas',
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
		\DBUtil::drop_table('contienen');
	}
}