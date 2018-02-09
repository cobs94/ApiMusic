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
            'picture' => array('type' => 'varchar', 'constraint' => 250, 'null' => true),
            'id_rol' => array('type' => 'int', 'constraint' => 11),
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
                    )
                    
                )
		);

        \DB::query("ALTER TABLE `usuarios` ADD UNIQUE (`username`)")->execute();
    }

    function down()
    {
       \DBUtil::drop_table('usuarios');
    }
}