<?php
namespace Fuel\Migrations;

class esquemas
{

    function up()
    {        
        \DBUtil::create_table('esquemas', array(
                'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
                'name' => array('type' => 'varchar', 'constraint' => 100),
                'editable' => array('type' => 'bool'),
                'ranking' => array('type' => 'varchar', 'constraint' => 100),
            ), array('id'), false, 'InnoDB', 'utf8_unicode_ci'
        );   
    }

    function down()
    {
       \DBUtil::drop_table('esquemas');
    }
}