<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_login_to_usuarios_table extends CI_Migration
{
    public function up()
    {
        if (! $this->db->field_exists('cust_login', 'usuarios')) {
            $this->dbforge->add_column('usuarios', [
                'cust_login' => [
                    'type' => 'VARCHAR',
                    'constraint' => 80,
                    'null' => true,
                    'after' => 'estado',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->field_exists('cust_login', 'usuarios')) {
            $this->dbforge->drop_column('usuarios', 'cust_login');
        }
    }
}
