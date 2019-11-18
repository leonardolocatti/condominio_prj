<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lote extends MY_Controller {

    /**
     * Retorna um json com os dados dos lotes para serem inseridos na tabela.
     * 
     * @return void
     */
    public function lote_tabela()
    {
        $this->load->model('Lote_Model');
        $obj_lote = new Lote_Model();

        $res_lote = $obj_lote->lote_tabela($this->input->post());

        $lotes = array();
        $i     = 0;

        foreach ($res_lote['obj'] as $lote)
        {
            $morador = ! empty($lote->condomino_nome) ? $lote->condomino_nome : 'Lote desocupado';

            $opcoes  = '<button class="btn btn-sm btn-warning" title="Editar lote" onclick="abrir_modal_lote('.$lote->lote_id.')">';
            $opcoes .=     '<i class="fas fa-pen"></i>';
            $opcoes .= '</button> ';

            $opcoes .= '<button class="btn btn-sm btn-danger" title="Deletar lote" onclick="excluir_lote('.$lote->lote_id.')">';
            $opcoes .=     '<i class="fas fa-trash"></i>';
            $opcoes .= '</button> ';

            $lotes[$i]['lote_id']        = $lote->lote_id;
            $lotes[$i]['lote_numero']    = $lote->lote_numero;
            $lotes[$i]['lote_area']      = formatar_area($lote->lote_area);
            $lotes[$i]['lote_descricao'] = $lote->lote_descricao;
            $lotes[$i]['morador']        = $morador;
            $lotes[$i]['opcoes']         = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_lote['total'],
            'recordsTotal'    => $res_lote['total'],
            'data'            => $lotes,
        );

        echo json_encode($resposta);
    }

    /**
     * Recebe os dados do lote fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_lote()
    {
        $this->load->model('Lote_Model');
        $obj_lote = new Lote_Model();

        $obj_lote->lote_id        = ! empty($_POST['lote_id'])        ? $this->input->post('lote_id')                : NULL;
        $obj_lote->lote_numero    = ! empty($_POST['lote_numero'])    ? $this->input->post('lote_numero')            : NULL;
        $obj_lote->lote_area      = ! empty($_POST['lote_area'])      ? limpar_area($this->input->post('lote_area')) : NULL;
        $obj_lote->lote_descricao = ! empty($_POST['lote_descricao']) ? $this->input->post('lote_descricao')         : NULL;

        if ($obj_lote->lote_id > 0) 
        {
            if ($obj_lote->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Lote atualizado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Lote não pôde ser atualizado.';
            }
        }
        else
        {
            if ($obj_lote->inserir() > 0)
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Lote cadastrado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'O lote não pôde ser cadastrado.';
            }
        }

        echo json_encode($resposta);
    }

    /**
     * Retorna um json com os dados do lote pedido por POST.
     * 
     * @return void
     */
    public function dados_lote()
    {
        $this->load->model('Lote_Model');
        $obj_lote = new Lote_Model();

        $obj_lote->lote_id = $this->input->post('lote_id');
        
        echo json_encode($obj_lote->recuperar());
    }

    /**
     * Recebe os dados de um lote que será excluído.
     * 
     * @return void
     */
    public function excluir_lote()
    {
        $this->load->model('Lote_Model');
        $obj_lote = new Lote_Model();

        $obj_lote->lote_id = $this->input->post('lote_id');

        if ($obj_lote->excluir())
        {
            $resposta['status']   = '1';
            $resposta['mensagem'] = 'Lote excluído com sucesso.';
        }
        else
        {
            $reposta['status']    = '0';
            $resposta['mensagem'] = 'Lote não pôde ser excluído.';
        }

        echo json_encode($resposta);
    }
}
