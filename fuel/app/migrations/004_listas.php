<?php
namespace Fuel\Migrations;

class listas
{

    function up()
    {
        \DBUtil::create_table('listas', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'title' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
            'edit' => array('type' => 'bool', 'null' => false),
            'id_usuario' => array('type' => 'int', 'constraint' => 11),
        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
                array(
                    array(
                        'constraint' => 'claveAjenaListasAUsuarios',
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
       \DBUtil::drop_table('listas');
    }
}