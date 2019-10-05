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
        $this->load->setar_titulo('Home');
        $this->load->setar_id_body('pagina_home');
        $this->load->exibir('home');
    }
}
