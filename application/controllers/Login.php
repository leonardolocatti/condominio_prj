<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Exibe a tela de login.
     * 
     * @return void
     */
    public function index()
    {
        // Se o usuário tiver uma sessão válida redireciona para a página inicial
        if (isset($this->session->usuario))
        {
            redirect('home');
        }

        $this->load->adicionar_css('login.css');
        $this->load->adicionar_js('login.js');
        $this->load->setar_titulo('Login');
        $this->load->setar_id_body('pagina_login');
        $this->load->exibir('login', array(), FALSE);
    }

    /**
     * Recebe os dados do login fornecidos por POST e tenta validar com o banco de dados.
     * Se validar os dados, coloca o usuário na sessão.
     * Método deve ser chamado por Ajax.
     * 
     * @return void
     */
    public function login_entrar()
    {
        $this->load->model('Usuario_Model');
        $obj_usuario = new Usuario_Model();

        if ($obj_usuario->usuario_existe($this->input->post('login_usuario')))
        {
            if ($obj_usuario->conferir_senha($this->input->post('login_usuario'), $this->input->post('login_senha')))
            {
                $resposta['status']         = '1';
                $resposta['usuario_existe'] = '1';

                $this->session->usuario = $obj_usuario->usuario_dados_sessao($this->input->post('login_usuario'));
            }
            else
            {
                $resposta['status']         = '0';
                $resposta['usuario_existe'] = '1';
            }
        }
        else
        {
            $resposta['status']         = '0';
            $resposta['usuario_existe'] = '0';
        }

        echo json_encode($resposta);
    }
}
