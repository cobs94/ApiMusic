<?php
namespace Fuel\Migrations;

class canciones
{

    function up()
    {        
        \DBUtil::create_table('canciones', array(
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'title' => array('type' => 'varchar', 'constraint' => 100),
                'artist' => array('type' => 'varchar', 'constraint' => 100),
                'url' => array('type' => 'varchar', 'constraint' => 100),
                'plays' => array('type' => 'varchar', 'constraint' => 100),
            ), array('id'), false, 'InnoDB', 'utf8_unicode_ci'
        );   
    }

    function down()
    {
       \DBUtil::drop_table('canciones');
    }
}