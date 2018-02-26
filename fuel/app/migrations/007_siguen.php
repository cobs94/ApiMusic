<?php
namespace Fuel\Migrations;

class siguen
{

	function up()
	{        
		\DBUtil::create_table('siguen', array(
			'id_seguido' => array('type' => 'int', 'constraint' => 11),
			'id_seguidor' => array('type' => 'int', 'constraint' => 11),
			), array('id_seguido','id_seguidor'), false, 'InnoDB', 'utf8_unicode_ci',array(
			array(
				'constraint' => 'claveAjenaSiguenAUsuarios',
				'key' => 'id_seguido',
				'reference' => array(
					'table' => 'usuarios',
					'column' => 'id',
					),
				'on_update' => 'CASCADE',
				'on_delete' => 'RESTRICT'
				),
			array(
				'constraint' => 'claveAjenaSiguenAUsuarios2',
				'key' => 'id_seguidor',
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
		\DBUtil::drop_table('siguen');
	}
}