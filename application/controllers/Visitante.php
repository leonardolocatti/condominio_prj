<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitante extends MY_Controller {

    /**
     * Busca o visitante e retorna um json com os dados referentes à ele
     */
    public function buscar_visitante()
    {
        // Busca os visitantes cadastrados no sistema
        $this->load->model('Visitante_Model');
        $obj_visitante = new Visitante_Model();
        
        $res_visitante = $obj_visitante->buscar_visitante(limpar_cpf($this->input->post('visitante_cpf')));

        // Busca os funcionários cadastrados no sistema
        $this->load->model('Funcionario_Model');
        $obj_funcionario = new Funcionario_Model();

        $res_funcionario = $obj_funcionario->buscar_funcionario(limpar_cpf($this->input->post('visitante_cpf')));

        // Retorna os dados do visitante, tratando se é funcionário ou visitante
        if ( ! empty($res_visitante))
        {
            // Busca os carros do visitante cadastrados no sistema
            $this->load->model('Carro_Model');
            $obj_carro = new Carro_Model();

            $res_carros = $obj_carro->carros_dropdown($res_visitante->visitante_id);

            $resposta['status']    = '1';
            $resposta['tipo']      = 'visitante';
            $resposta['visitante'] = $res_visitante;
            $resposta['carros']    = $res_carros;
        } 
        elseif ( ! empty($res_funcionario))
        {
            $resposta['status']      = '1';
            $resposta['tipo']        = 'funcionario';
            $resposta['funcionario'] = $res_funcionario;
        }
        else
        {
            $resposta['status'] = '0';
        }
        
        echo json_encode($resposta);
    }

    /** 
     * Recebe os dados do visitante fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_visitante()
    {
        $this->load->model('Visitante_Model');
        $obj_visitante = new Visitante_Model();

        $obj_visitante->visitante_id   = ! empty($_POST['visitante_id'])   ? $this->input->post('visitante_id')              : NULL;
        $obj_visitante->visitante_cpf  = ! empty($_POST['visitante_cpf'])  ? limpar_cpf($this->input->post('visitante_cpf')) : NULL;
        $obj_visitante->visitante_nome = ! empty($_POST['visitante_nome']) ? $this->input->post('visitante_nome')            : NULL;

        if ($obj_visitante->visitante_id > 0)
        {
            if ($obj_visitante->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Visitante atualizado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Visitante não pôde ser atualizado.';
            }
        }
        else
        {
            if ($obj_visitante->inserir() > 0)
            {
                $resposta['status'] = '1';
                $resposta['mensagem'] = 'Visitante cadastrado com sucesso.';
            }
            else
            {
                $resposta['status'] = '0';
                $resposta['mensagem'] = 'O visitante não pôde ser cadastrado.';
            }
        }

        echo json_encode($resposta);
    }

    /**
     * Retorna um json com os dados do visitante pedido por POST.
     * 
     * @return void
     */
    public function visitante_dados()
    {
        $this->load->model('Visitante_Model');
        $obj_visitante = new Visitante_Model();

        $obj_visitante->visitante_id = $this->input->post('visitante_id');

        echo json_encode($obj_visitante->recuperar());
    }

}
