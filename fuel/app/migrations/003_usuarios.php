<?php
namespace Fuel\Migrations;

class usuarios
{

    function up()
    {
        \DBUtil::create_table('usuarios', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'username' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
            'email' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
            'password' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
            'idDevice' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'picture' => array('type' => 'varchar', 'constraint' => 250, 'null' => true),
            'x' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'y' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'birthday' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'city' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'description' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'id_rol' => array('type' => 'int', 'constraint' => 11),
            'id_privacidad' => array('type' => 'int', 'constraint' => 11),
        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
                array(
                    array(
                        'constraint' => 'claveAjenaUsuariosARol',
                        'key' => 'id_rol',
                        'reference' => array(
                            'table' => 'roles',
                            'column' => 'id',
                        ),
                        'on_update' => 'CASCADE',
                        'on_delete' => 'RESTRICT'
                    ), 
                    array(
                        'constraint' => 'claveAjenaUsuariosAPrivacidad',
                        'key' => 'id_privacidad',
                        'reference' => array(
                            'table' => 'privacidad',
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
       \DBUtil::drop_table('usuarios');
    }
}