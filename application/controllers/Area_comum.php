<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_comum extends MY_Controller {

    /**
     * Retorna um json com os dados das áreas comuns para serem inseridas na tabela.
     * 
     * @return void
     */
    public function area_comum_tabela()
    {
        $this->load->model('Area_Comum_Model');
        $obj_area_comum = new Area_Comum_Model();

        $res_area_comum = $obj_area_comum->area_comum_tabela($this->input->post());

        $areas_comuns = array();
        $i            = 0;

        foreach ($res_area_comum['obj'] as $area_comum)
        {
            $opcoes  = '<button class="btn btn-sm btn-warning" title="Editar área comum" onclick="abrir_modal_area_comum('.$area_comum->area_comum_id.')">';
            $opcoes .=     '<i class="fas fa-pen"></i>';
            $opcoes .= '</button> ';

            $opcoes .= '<button class="btn btn-sm btn-danger" title="Deletar área comum" onclick="excluir_area_comum('.$area_comum->area_comum_id.')">';
            $opcoes .=     '<i class="fas fa-trash"></i>';
            $opcoes .= '</button> ';

            $areas_comuns[$i]['area_comum_id']              = $area_comum->area_comum_id;
            $areas_comuns[$i]['area_comum_nome']            = $area_comum->area_comum_nome;
            $areas_comuns[$i]['area_comum_lotacao_maxima']  = $area_comum->area_comum_lotacao_maxima;
            $areas_comuns[$i]['area_comum_hora_abertura']   = $area_comum->area_comum_hora_abertura;
            $areas_comuns[$i]['area_comum_hora_fechamento'] = $area_comum->area_comum_hora_fechamento;
            $areas_comuns[$i]['opcoes']                     = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_area_comum['total'],
            'recordsTotal'    => $res_area_comum['total'],
            'data'            => $areas_comuns,
        );

        echo json_encode($resposta);
    }

    /**
     * Recebe os dados da área comum fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_area_comum()
    {
        $this->load->model('Area_Comum_Model');
        $obj_area_comum = new Area_Comum_Model();

        $obj_area_comum->area_comum_id              = ! empty($_POST['area_comum_id'])              ? $this->input->post('area_comum_id')              : NULL;
        $obj_area_comum->area_comum_nome            = ! empty($_POST['area_comum_nome'])            ? $this->input->post('area_comum_nome')            : NULL;
        $obj_area_comum->area_comum_lotacao_maxima  = ! empty($_POST['area_comum_lotacao_maxima'])  ? $this->input->post('area_comum_lotacao_maxima')  : NULL;
        $obj_area_comum->area_comum_hora_abertura   = ! empty($_POST['area_comum_hora_abertura'])   ? $this->input->post('area_comum_hora_abertura')   : NULL;
        $obj_area_comum->area_comum_hora_fechamento = ! empty($_POST['area_comum_hora_fechamento']) ? $this->input->post('area_comum_hora_fechamento') : NULL;

        if ($obj_area_comum->area_comum_id > 0)
        {
            if ($obj_area_comum->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Área comum atualizada com sucesso.';
            }
            else
            {
                $resposta['status'] = '0';
                $resposta['mensagem'] = 'Área comum não pôde ser atualizado.';
            }
        }
        else
        {
            if ($obj_area_comum->inserir() > 0)
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Área comum cadastrada com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Área comum não pôde ser cadastrada';
            }
        }

        echo json_encode($resposta);
    }

    /**
     * Retorna um json com os dados da área comum pedidi por POST.
     * 
     * @return void
     */
    public function dados_area_comum()
    {
        $this->load->model('Area_Comum_Model');
        $obj_area_comum = new Area_Comum_Model();

        $obj_area_comum->area_comum_id = $this->input->post('area_comum_id');

        echo json_encode($obj_area_comum->recuperar());
    }

    /**
     * Recebe os dados de uma área comum que será excluída.
     * 
     * @return void
     */
    public function excluir_area_comum()
    {
        $this->load->model('Area_Comum_Model');
        $obj_area_comum = new Area_Comum_Model();

        $obj_area_comum->area_comum_id = $this->input->post('area_comum_id');

        if ($obj_area_comum->excluir()) 
        {
            $resposta['status']   = '1';
            $resposta['mensagem'] = 'Área comum excluída com sucesso.';
        }
        else
        {
            $resposta['status']   = '0';
            $resposta['mensagem'] = 'Área comum não pôde ser excluída.';
        }

        echo json_encode($resposta);
    }
}
