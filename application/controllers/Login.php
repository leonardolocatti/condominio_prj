<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Exibe a tela de login.
     */
    public function index()
    {
        // Se o usuário tiver uma sessão válida redireciona para a página inicial
        if (isset($this->session->usuario))
        {
            redirect('chome');
        }

        $this->load->adicionar_css('login.css');
        $this->load->adicionar_js('login.js');
        $this->load->setar_titulo('Login');
        $this->load->setar_id_body('pagina_login');
        $this->load->exibir('login', array(), FALSE);
    }
}
