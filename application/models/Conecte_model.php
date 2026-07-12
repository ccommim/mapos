<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Conecte_model extends CI_Model
{
    private function tecnicoStatusDisponivel(): bool
    {
        static $statusDisponivel = null;

        if ($statusDisponivel === null) {
            $statusDisponivel = $this->db->field_exists('status', 'cus_tecnico');
        }

        return $statusDisponivel;
    }

    public function add($table, $data, $returnId = false)
    {
        if ($table === 'os' && empty($data['idOs'])) {
            $data['idOs'] = $this->proximoNumeroOs($data['dataInicial'] ?? null);
        }

        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            if ($returnId == true) {
                return $this->db->insert_id($table);
            }

            return true;
        }

        return false;
    }

    private function proximoNumeroOs($dataInicial = null): int
    {
        $timestamp = $dataInicial ? strtotime($dataInicial) : time();
        $ano = (int) date('Y', $timestamp);
        $inicio = $ano * 10000;
        $fim = $inicio + 9999;

        $query = $this->db->query('SELECT MAX(idOs) AS maxId FROM os WHERE idOs BETWEEN ? AND ?', [$inicio, $fim])->row();
        $maxId = (int) ($query->maxId ?? 0);

        return $maxId >= $inicio ? $maxId + 1 : $inicio + 1;
    }

    public function getLastOs($cliente)
    {
        $this->db->from('os');
        $this->db->join('usuarios', 'os.usuarios_id = usuarios.idUsuarios', 'left');
        $this->db->where('clientes_id', $cliente);
        $this->db->limit(10);
        $this->db->order_by('idOs', 'desc');

        $result = $this->db->get()->result();
        foreach ($result as $item) {
            $item->nomes_tecnicos = $this->nomesTecnicosPorIds($item->cust_tecnicos ?? '');
        }

        return $result;
    }

    public function getLastCompras($cliente)
    {
        $this->db->select('vendas.*,usuarios.nome');
        $this->db->from('vendas');
        $this->db->join('usuarios', 'usuarios.idUsuarios = vendas.usuarios_id');
        $this->db->order_by('idVendas', 'desc');
        $this->db->where('clientes_id', $cliente);
        $this->db->limit(10);
        $this->db->order_by('idVendas', 'desc');

        return $this->db->get()->result();
    }

    public function getCompras($table, $fields, $where, $perpage, $start, $one, $array, $cliente)
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('usuarios', 'vendas.usuarios_id = usuarios.idUsuarios', 'left');
        $this->db->order_by('idVendas', 'desc');
        $this->db->where('clientes_id', $cliente);
        $this->db->limit($perpage, $start);
        $this->db->order_by('idVendas', 'desc');
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getCobrancas($table, $fields, $where, $perpage, $start, $one, $array, $cliente)
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('clientes', 'cobrancas.clientes_id = clientes.idClientes', 'left');
        $this->db->where('clientes_id', $cliente);
        $this->db->order_by('expire_at', 'desc');
        $this->db->limit($perpage, $start);
        $this->db->order_by('idCobranca', 'desc');
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getOs($table, $fields, $where, $perpage, $start, $one, $array, $cliente)
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('usuarios', 'os.usuarios_id = usuarios.idUsuarios', 'left');
        $this->db->where('clientes_id', $cliente);
        $this->db->limit($perpage, $start);
        $this->db->order_by('idOs', 'desc');
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->select('os.*, clientes.*, clientes.celular as celular_cliente, garantias.refGarantia, garantias.textoGarantia, usuarios.telefone as telefone_usuario, usuarios.email as email_usuario, usuarios.nome');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('usuarios', 'usuarios.idUsuarios = os.usuarios_id');
        $this->db->join('garantias', 'garantias.idGarantias = os.garantias_id', 'left');
        $this->db->where('os.idOs', $id);
        $this->db->limit(1);

        $result = $this->db->get()->row();
        if ($result) {
            $result->nomes_tecnicos = $this->nomesTecnicosPorIds($result->cust_tecnicos ?? '');
        }

        return $result;
    }

    public function nomesTecnicosPorIds($ids = ''): string
    {
        $ids = trim((string) $ids);
        if ($ids === '') {
            return '';
        }

        $listaIds = array_values(array_filter(array_map('intval', explode(',', $ids))));
        if (empty($listaIds)) {
            return '';
        }

        $this->db->select('nome');
        $this->db->where_in('idTecnico', $listaIds);
        $this->db->order_by('nome', 'asc');
        $tecnicos = $this->db->get('cus_tecnico')->result();

        $nomes = array_map(static function ($tecnico) {
            return $tecnico->nome;
        }, $tecnicos);

        return implode(', ', $nomes);
    }

    public function getTecnicoPadrao()
    {
        $this->db->from('cus_tecnico');
        if ($this->tecnicoStatusDisponivel()) {
            $this->db->where('status', 1);
        }
        $this->db->order_by('nome', 'asc');
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function count($table, $cliente)
    {
        $this->db->where('clientes_id', $cliente);

        return $this->db->count_all_results($table);
    }

    public function getDados()
    {
        $this->db->where('idclientes', $this->session->userdata('cliente_id'));
        $this->db->limit(1);

        return $this->db->get('clientes')->row();
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function getQrCode($id, $pixKey, $emitente)
    {
        if (empty($id) || empty($pixKey) || empty($emitente)) {
            return;
        }

        $result = $this->valorTotalOS($id);
        $amount = $result['valor_desconto'] != 0 ? round(floatval($result['valor_desconto']), 2) : round(floatval($result['totalServico'] + $result['totalProdutos']), 2);

        if ($amount <= 0) {
            return;
        }

        $pix = (new StaticPayload())
            ->setAmount($amount)
            ->setTid($id)
            ->setDescription(sprintf('%s OS %s', substr($emitente->nome, 0, 18), $id), true)
            ->setPixKey(getPixKeyType($pixKey), $pixKey)
            ->setMerchantName($emitente->nome)
            ->setMerchantCity($emitente->cidade);

        return $pix->getQRCode();
    }
}

/* End of file conecte_model.php */
/* Location: ./application/models/conecte_model.php */
