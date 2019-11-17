<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portaria extends MY_Controller {

    /**
     * Exibe a tela de Portaria.
     */
    public function index()
    {
        // Carrega os condôminos
        $this->load->model('Condomino_Model');
        $obj_condomino = new Condomino_Model();

        $condominos = $obj_condomino->condominos_dropdown();

        // View dos carros
        $view_carros = $this->load->view('carro', array(), TRUE);
        $this->load->adicionar_js('carro.js');

        // Array com as variáveis passadas para a view
        $variaveis = array(
            'condominos_dropdown' => $condominos,
            'view_carros'         => $view_carros,
        );

        $this->load->setar_titulo('Portaria');
        $this->load->setar_id_body('pagina_portaria');
        $this->load->adicionar_js('portaria.js');
        $this->load->adicionar_js('visita.js');
        $this->load->exibir('portaria', $variaveis, FALSE);
    }
}
