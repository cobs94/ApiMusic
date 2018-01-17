<?php
namespace Fuel\Migrations;

class posiciones
{

    function up()
    {        
        \DBUtil::create_table('posiciones', array(
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'x' => array('type' => 'varchar', 'constraint' => 100),
                'y' => array('type' => 'varchar', 'constraint' => 100),
                'id_esquema' => array('type' => 'int', 'constraint' => 11),
                'id_planeta' => array('type' => 'int', 'constraint' => 11),
            ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',array(
        array(
            'constraint' => 'claveAjenaPosicionesdeAEsquemas',
            'key' => 'id_esquema',
            'reference' => array(
                'table' => 'esquemas',
                'column' => 'id',
            ),
            'on_update' => 'CASCADE',
            'on_delete' => 'RESTRICT'
                ),
        array(
            'constraint' => 'claveAjenaPosicionesdeAPlanetas',
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
       \DBUtil::drop_table('posiciones');
    }
}