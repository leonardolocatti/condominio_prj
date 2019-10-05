<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    /**
     * MY_Loader
     * 
     * @var MY_Loader
     */
    public $load;

    /**
     * Construtor chama o método para verificar se o usuário tem uma sessão válida.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_verificar_sessao();
    }

    /**
     * Verifica se o usuário tem uma sessão válida (está logado).
     * Se não tiver, redireciona para a página de login.
     * 
     * @return void
     */
    private function _verificar_sessao()
    {
        if ( ! isset($this->session->usuario))
        {
            redirect(site_url('login'));
        }
    }
}
