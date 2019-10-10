<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Condomino extends MY_Controller {
    
    /**
     * Retorna um json com os dados dos condôminos para serem inseridos na tabela.
     * 
     * @return void
     */
    public function condomino_tabela()
    {
        $this->load->model('Condomino_Model');
        $obj_condomino = new Condomino_Model();

        $res_condomino = $obj_condomino->condomino_tabela($this->input->post());

        $condominos = array();
        $i          = 0;

        foreach ($res_condomino['obj'] as $condomino)
        {
            $opcoes  = '<button class="btn btn-sm btn-warning" title="Editar condômino" onclick="abrir_modal_condomino('.$condomino->condomino_id.')">';
            $opcoes .=     '<i class="fas fa-pen"></i>';
            $opcoes .= '</button> ';

            $opcoes .= '<button class="btn btn-sm btn-danger" title="Deletar condômino" onclick="excluir_condomino('.$condomino->condomino_id.')">';
            $opcoes .=     '<i class="fas fa-trash"></i>';
            $opcoes .= '</button>';

            $condominos[$i]['condomino_id']   = $condomino->condomino_id;
            $condominos[$i]['condomino_nome'] = $condomino->condomino_nome;
            $condominos[$i]['condomino_cpf']  = $condomino->condomino_cpf;
            $condominos[$i]['condomino_lote'] = $condomino->condomino_lote;
            $condominos[$i]['opcoes']         = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_condomino['total'],
            'recordsTotal'    => $res_condomino['total'],
            'data'            => $condominos,
        );

        echo json_encode($resposta);
    }

    /**
     * Recebe os dados do condômino fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_condomino()
    {
        $this->load->model('Condomino_Model');
        $obj_condomino = new Condomino_Model();

        $obj_condomino->condomino_id   = ! empty($_POST['condomino_id'])   ? $this->input->post('condomino_id')   : NULL;
        $obj_condomino->condomino_cpf  = ! empty($_POST['condomino_cpf'])  ? $this->input->post('condomino_cpf')  : NULL;
        $obj_condomino->condomino_nome = ! empty($_POST['condomino_nome']) ? $this->input->post('condomino_nome') : NULL;
        $obj_condomino->condomino_lote = ! empty($_POST['condomino_lote']) ? $this->input->post('condomino_lote') : NULL;

        if ($obj_condomino->condomino_id > 0) 
        {
            if ($obj_condomino->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Condômino atualizado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Condômino não pôde ser atualizado.';
            }
        }
        else
        {
            if ($obj_condomino->inserir() > 0)
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Condômino cadastrado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'O condômino não pôde ser cadastrado';
            }
        }
        
        echo json_encode($resposta);
    }

    /**
    * Retorna um json com os dados do condômino pedido por POST.
    * 
    * @return void
    */
    public function dados_condomino()
    {
        $this->load->model('Condomino_Model');
        $obj_condomino = new Condomino_Model();

        $obj_condomino->condomino_id = $this->input->post('condomino_id');

        echo json_encode($obj_condomino->recuperar());

    }

    /**
     * Recebe os dados de um condômino que será excluído.
     * 
     * @return void
     */
    public function excluir_condomino()
    {
        $this->load->model('Condomino_Model');
        $obj_condomino = new Condomino_Model();

        $obj_condomino->condomino_id = $this->input->post('condomino_id');

        if ($obj_condomino->excluir())
        {
            $resposta['status']   = '1';
            $resposta['mensagem'] = 'Condômino excluído com sucesso.';
        }
        else
        {
            $reposta['status']    = '0';
            $resposta['mensagem'] = 'Condômino não pôde ser excluído.';
        }

        echo json_encode($resposta);
    }
}
