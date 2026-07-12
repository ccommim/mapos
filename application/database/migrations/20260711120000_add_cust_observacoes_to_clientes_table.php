<?php

class Migration_add_cust_observacoes_to_clientes_table extends CI_Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `clientes` ADD COLUMN `cust_observacoes` TEXT NULL COMMENT 'Observações';");
    }

    public function down()
    {
        $this->dbforge->drop_column('clientes', 'cust_observacoes');
    }
}