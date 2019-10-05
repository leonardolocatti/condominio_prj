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
        $this->load->setar_titulo('Administração');
        $this->load->setar_id_body('pagina_administracao');
        $this->load->exibir('administracao');
    }
}
