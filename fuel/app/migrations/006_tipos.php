<?php
namespace Fuel\Migrations;

class tipos
{

    function up()
    {        
        \DBUtil::create_table('tipos', array(
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'name' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
                'size' => array('type' => 'float', 'constraint' => 25),
            ), array('id'), false, 'InnoDB', 'utf8_unicode_ci'
        );   
    }

    function down()
    {
       \DBUtil::drop_table('tipos');
    }
}
