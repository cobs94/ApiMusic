<?php
namespace Fuel\Migrations;

class estrellas
{

    function up()
    {
        \DBUtil::create_table('estrellas', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'name' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
            'x' => array('type' => 'float', 'constraint' => 25, 'null' => false),
            'y' => array('type' => 'float', 'constraint' => 25, 'null' => false),
            'id_tipo' => array('type' => 'int', 'constraint' => 11),
        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
                array(
                    array(
                        'constraint' => 'claveAjenaEstrellasATipo',
                        'key' => 'id_tipo',
                        'reference' => array(
                            'table' => 'tipos',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    )
                    
                )
		);

        \DB::query("ALTER TABLE `usuarios` ADD UNIQUE (`username`)")->execute();
    }

    function down()
    {
       \DBUtil::drop_table('estrellas');
    }
}