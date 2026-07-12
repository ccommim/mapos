<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tecnicos extends MY_Controller
{
    private function toUpper($valor)
    {
        $valor = trim((string) $valor);

        return function_exists('mb_strtoupper') ? mb_strtoupper($valor, 'UTF-8') : strtoupper($valor);
    }

    public function __construct()
    {
        parent::__construct();

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'cUsuario')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar esta área.');
            redirect(base_url());
        }

        $this->load->helper('form');
        $this->load->model('tecnicos_model');
        $this->data['menuTecnicos'] = 'Técnicos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = base_url() . 'index.php/tecnicos/gerenciar/';
        $this->data['configuration']['total_rows'] = $this->tecnicos_model->count('cus_tecnico');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->tecnicos_model->get($this->data['configuration']['per_page'], $this->uri->segment(3));
        $this->data['view'] = 'tecnicos/tecnicos';

        return $this->layout();
    }

    public function adicionar()
    {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = validation_errors() ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : '';
        } else {
            $agora = date('Y-m-d H:i:s');
            $usuario = $this->session->userdata('nome_admin') ?: $this->session->userdata('nome') ?: 'Sistema';
            $statusTecnico = $this->input->post('status') === '0' ? 0 : 1;

            $data = [
                'nome' => $this->toUpper($this->input->post('nome')),
                'criado_por' => $usuario,
                'criado_em' => $agora,
                'alterado_por' => null,
                'alterado_em' => null,
            ];

            if ($this->tecnicos_model->campoStatusDisponivel()) {
                $data['status'] = $statusTecnico;
            }

            if ($this->tecnicos_model->add('cus_tecnico', $data) == true) {
                $this->session->set_flashdata('success', 'Técnico cadastrado com sucesso!');
                log_info('Adicionou um técnico.');
                redirect(site_url('tecnicos/adicionar'));
            }

            $this->data['custom_error'] = '<div class="alert alert-danger">Ocorreu um erro ao tentar cadastrar o técnico.</div>';
        }

        $this->data['view'] = 'tecnicos/adicionarTecnico';
        return $this->layout();
    }

    public function editar()
    {
        $id = (int) $this->uri->segment(3);
        $this->data['result'] = $this->tecnicos_model->getById($id);

        if (! $id || ! $this->data['result']) {
            $this->session->set_flashdata('error', 'Técnico não encontrado.');
            redirect(site_url('tecnicos'));
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = validation_errors() ? '<div class="alert alert-danger">' . validation_errors() . '</div>' : '';
        } else {
            $agora = date('Y-m-d H:i:s');
            $usuario = $this->session->userdata('nome_admin') ?: $this->session->userdata('nome') ?: 'Sistema';
            $statusTecnico = $this->input->post('status') === '0' ? 0 : 1;

            $data = [
                'nome' => $this->toUpper($this->input->post('nome')),
                'alterado_por' => $usuario,
                'alterado_em' => $agora,
            ];

            if ($this->tecnicos_model->campoStatusDisponivel()) {
                $data['status'] = $statusTecnico;
            }

            if ($this->tecnicos_model->edit('cus_tecnico', $data, 'idTecnico', $id) == true) {
                $this->session->set_flashdata('success', 'Técnico editado com sucesso!');
                log_info('Alterou um técnico. ID: ' . $id);
                redirect(site_url('tecnicos/editar/') . $id);
            }

            $this->data['custom_error'] = '<div class="alert alert-danger">Ocorreu um erro ao tentar editar o técnico.</div>';
        }

        $this->data['view'] = 'tecnicos/editarTecnico';
        return $this->layout();
    }

    public function excluir()
    {
        $id = (int) $this->uri->segment(3);

        if ($id > 0 && $this->tecnicos_model->delete('cus_tecnico', 'idTecnico', $id)) {
            log_info('Removeu um técnico. ID: ' . $id);
            $this->session->set_flashdata('success', 'Técnico removido com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Não foi possível remover o técnico.');
        }

        redirect(site_url('tecnicos'));
    }
}
