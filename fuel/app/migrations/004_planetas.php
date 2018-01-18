<?php
namespace Fuel\Migrations;

class planetas
{

    function up()
    {        
        \DBUtil::create_table('planetas', array(
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'description' => array('type' => 'varchar', 'constraint' => 100),
                'model' => array('type' => 'varchar', 'constraint' => 100),
                'size' => array('type' => 'varchar', 'constraint' => 100),
                'speed' => array('type' => 'varchar', 'constraint' => 100),
            ), array('id'), false, 'InnoDB', 'utf8_unicode_ci'
        );   
    }

    function down()
    {
       \DBUtil::drop_table('planetas');
    }
}