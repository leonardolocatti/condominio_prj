<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visita extends MY_Controller {

    /**
     * Retorna um json com os dados das visitas para serem inseridas na tabela.
     * 
     * @return void
     */
    public function visita_tabela()
    {
        $this->load->model('Visita_Model');
        $obj_visita = new Visita_Model();

        $res_visita = $obj_visita->visita_tabela($this->input->post());

        $visitas = array();
        $i       = 0;

        foreach ($res_visita['obj'] as $visita)
        {
            $opcoes  = '<button class="btn btn-sm btn-danger" title="Registrar saída" onclick="registrar_saida('.$visita->visita_id.')">';
            $opcoes .=     '<i class="fas fa-sign-out-alt"></i>';
            $opcoes .= '</button> ';

            $visitas[$i]['visita_id']        = $visita->visita_id;
            $visitas[$i]['visitante_nome']   = $visita->visitante_nome;
            $visitas[$i]['carro']            = $visita->carro_modelo.' - '.$visita->carro_placa;
            $visitas[$i]['condomino_nome']   = $visita->condomino_nome;
            $visitas[$i]['visita_entrada']   = $visita->visita_entrada;
            $visitas[$i]['opcoes']           = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_visita['total'],
            'recordsTotal'    => $res_visita['total'],
            'data'            => $visitas,
        );

        echo json_encode($resposta);
    }

    /**
     * Recebe os dados da visita fornecidos por POST e tenta salvar no banco de dados.
     *
     * @return void
     */
    public function registrar_visita()
    {
        $this->load->model('Visita_Model');
        $obj_visita = new Visita_Model();

        $this->load->model('Visitante_Model');
        $obj_visitante = new Visitante_Model();

        $res_visitante = $obj_visitante->buscar_visitante(limpar_cpf($this->input->post('visitante_cpf')));

        $obj_visita->visita_visitante = $res_visitante->visitante_id;
        $obj_visita->visita_condomino = $this->input->post('visitante_condomino');
        $obj_visita->visita_carro     = $this->input->post('visitante_carro');
        $obj_visita->visita_entrada   = date('Y-m-d H:i:s');

        if ($obj_visita->inserir() > 0)
        {
            $resposta['status']   = '1';
            $resposta['mensagem'] = 'Visita cadastrada com sucesso.';
        }
        else
        {
            $resposta['status']   = '0';
            $resposta['mensagem'] = 'O visita não pôde ser cadastrada.';
        }

        echo json_encode($resposta);
    }

    /**
     * Recebe o pedido de registro de saída.
     */
    public function registrar_saida () {
        $this->load->model('Visita_Model');
        $obj_visita = new Visita_Model();

        $obj_visita->visita_id    = $this->input->post('visita_id');
        $obj_visita->visita_ativa = '0';
        $obj_visita->visita_saida = date('Y-m-d H:i:s');

        if ($obj_visita->atualizar())
        {
            $resposta['status']   = '1';
            $resposta['mensagem'] = 'Saída registrada com sucesso.';
        }
        else
        {
            $reposta['status']    = '0';
            $resposta['mensagem'] = 'Saída não pôde ser registrada.';
        }

        echo json_encode($resposta);
    }
}
