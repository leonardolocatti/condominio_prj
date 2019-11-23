<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    /**
     * Exibe a tela home.
     * 
     * @return void
     */
    public function index()
    {
        // Redireciona para a página de portaria se o usuário for porteiro
        if ($this->session->usuario->usuario_tipo == 'porteiro')
        {
            redirect('portaria');
        }

        $this->load->setar_titulo('Home');
        $this->load->setar_id_body('pagina_home');
        $this->load->adicionar_js('area_comum.js');
        $this->load->adicionar_js('visita.js');
        $this->load->exibir('home');
    }
}
