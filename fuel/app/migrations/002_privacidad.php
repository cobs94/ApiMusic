<?php
namespace Fuel\Migrations;

class privacidad
{

    function up()
    {        
        \DBUtil::create_table('privacidad', array(
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'profile' => array('type' => 'varchar', 'constraint' => 100),
                'friends' => array('type' => 'varchar', 'constraint' => 100),
                'lists' => array('type' => 'varchar', 'constraint' => 100),
                'notifications' => array('type' => 'varchar', 'constraint' => 100),
                'localize' => array('type' => 'varchar', 'constraint' => 100),
            ), array('id'), false, 'InnoDB', 'utf8_unicode_ci'
        );   
    }

    function down()
    {
       \DBUtil::drop_table('privacidad');
    }
}