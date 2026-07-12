<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_login_to_usuarios_table extends CI_Migration
{
    public function up()
    {
        if ($this->db->field_exists('login', 'usuarios') && ! $this->db->field_exists('cust_login', 'usuarios')) {
            $this->db->query("ALTER TABLE `usuarios` CHANGE `login` `cust_login` VARCHAR(80) NULL");
        }

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

        // Preenche login para usuários já existentes a partir do e-mail.
        $this->db->query("UPDATE `usuarios` SET `cust_login` = LOWER(`email`) WHERE (`cust_login` IS NULL OR `cust_login` = '') AND `email` IS NOT NULL AND `email` <> ''");
    }

    public function down()
    {
        if ($this->db->field_exists('cust_login', 'usuarios')) {
            $this->dbforge->drop_column('usuarios', 'cust_login');
        }
    }
}
