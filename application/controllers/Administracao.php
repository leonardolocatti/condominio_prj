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

        // Array com as variáveis passadas para a view de Administração
        $variaveis_administracao = array(
            'view_lote' => $view_lote,
            'view_condomino' => $view_condomino,
        );

        $this->load->setar_titulo('Administração');
        $this->load->setar_id_body('pagina_administracao');
        $this->load->exibir('administracao', $variaveis_administracao);
    }
}
