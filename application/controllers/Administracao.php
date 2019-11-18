<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administracao extends MY_Controller {

    /**
     * Exibe a tela home.
     * 
     * @return void
     */
    public function index()
    {
        $this->load->model('Lote_Model');
        $obj_lote = new Lote_Model();

        // View de administração de Lotes
        $view_lote = $this->load->view('lote', array(), TRUE);
        $this->load->adicionar_js('lote.js');

        // Carrega os lotes que serão colocados no dropdown dos Condôminos
        $lotes_dropdown = $obj_lote->lotes_dropdown();

        // Array com as variáveis passadas para a view de administração de Condôminos
        $variaveis_condomino = array(
            'lotes_dropdown' => $lotes_dropdown,
        );

        // View de administração de Condôminos
        $view_condomino = $this->load->view('condomino', $variaveis_condomino, TRUE);
        $this->load->adicionar_js('condomino.js');

        // View de administração de áreas comuns
        $view_areas_comuns = $this->load->view('area_comum_adm', array(), TRUE);
        $this->load->adicionar_js('area_comum.js');

        // Carrega os cargos dos funcionários que serão colocados no dropdown dos Funcionários
        $this->lang->load('funcionario');
        $cargos_dropdown = $this->lang->line('funcionario_cargos');
        $cargos_dropdown = array('' => 'Selecione um cargo') + $cargos_dropdown;

        // Array com as variáveis passadas para a view de administração de Funcionários
        $variaveis_funcionario = array(
            'cargos_dropdown' => $cargos_dropdown,
        );

        // View de administração de funcionários
        $view_funcionario = $this->load->view('funcionario', $variaveis_funcionario, TRUE);
        $this->load->adicionar_js('funcionario.js');

        // Array com as variáveis passadas para a view de Administração
        $variaveis_administracao = array(
            'view_lote'         => $view_lote,
            'view_condomino'    => $view_condomino,
            'view_areas_comuns' => $view_areas_comuns,
            'view_funcionario'  => $view_funcionario,
        );

        $this->load->setar_titulo('Administração');
        $this->load->setar_id_body('pagina_administracao');
        $this->load->exibir('administracao', $variaveis_administracao);
    }
}
