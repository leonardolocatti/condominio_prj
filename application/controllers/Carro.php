<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carro extends MY_Controller {

    /**
     * Retorna um json com os dados dos carros para serem inseridos na tabela.
     * 
     * @return void
     */
    public function carro_tabela()
    {
        $this->load->model('Carro_Model');
        $obj_carro = new Carro_Model();

        $res_carro = $obj_carro->carro_tabela($this->input->post());

        $carros = array();
        $i      = 0;

        foreach ($res_carro['obj'] as $carro)
        {
            $opcoes  = '<button class="btn btn-sm btn-warning" title="Editar carro" onclick="abrir_modal_carro('.$carro->carro_id.')">';
            $opcoes .=     '<i class="fas fa-pen"></i>';
            $opcoes .= '</button> ';

            $opcoes .= '<button class="btn btn-sm btn-danger" title="Deletar carro" onclick="excluir_carro('.$carro->carro_id.')">';
            $opcoes .=     '<i class="fas fa-trash"></i>';
            $opcoes .= '</button>';

            $carros[$i]['carro_id'] = $carro->carro_id;
            $carros[$i]['carro_placa'] = $carro->carro_placa;
            $carros[$i]['carro_marca'] = $carro->carro_marca;
            $carros[$i]['carro_modelo'] = $carro->carro_modelo;
            $carros[$i]['carro_cor'] = $carro->carro_cor;
            $carros[$i]['opcoes'] = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_carro['total'],
            'recordsTotal'    => $res_carro['total'],
            'data'            => $carros,
        );

        echo json_encode($resposta);
    }

    /**
     * Recebe os dados do carro fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_carro()
    {
        $this->load->model('Carro_Model');
        $obj_carro = new Carro_Model();

        $obj_carro->carro_id        = ! empty($_POST['carro_id'])        ? $this->input->post('carro_id')        : NULL;
        $obj_carro->carro_placa     = ! empty($_POST['carro_placa'])     ? $this->input->post('carro_placa')     : NULL;
        $obj_carro->carro_cor       = ! empty($_POST['carro_cor'])       ? $this->input->post('carro_cor')       : NULL;
        $obj_carro->carro_marca     = ! empty($_POST['carro_marca'])     ? $this->input->post('carro_marca')     : NULL;
        $obj_carro->carro_modelo    = ! empty($_POST['carro_modelo'])    ? $this->input->post('carro_modelo')    : NULL;
        $obj_carro->carro_visitante = ! empty($_POST['visitante_id'])    ? $this->input->post('visitante_id')    : NULL;

        if ($obj_carro->carro_id > 0) 
        {
            if ($obj_carro->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Carro atualizado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Carro não pôde ser atualizado.';
            }
        }
        else
        {
            if ($obj_carro->inserir() > 0)
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Carro cadastrado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'O carro não pôde ser cadastrado';
            }
        }

        echo json_encode($resposta);
    }
}



//     /**
//      * Retorna um json com os dados do lote pedido por POST.
//      * 
//      * @return void
//      */
//     public function dados_lote()
//     {
//         $this->load->model('Lote_Model');
//         $obj_lote = new Lote_Model();

//         $obj_lote->lote_id = $this->input->post('lote_id');
        
//         echo json_encode($obj_lote->recuperar());
//     }

//     /**
//      * Recebe os dados de um lote que será excluído.
//      * 
//      * @return void
//      */
//     public function excluir_lote()
//     {
//         $this->load->model('Lote_Model');
//         $obj_lote = new Lote_Model();

//         $obj_lote->lote_id = $this->input->post('lote_id');

//         if ($obj_lote->excluir())
//         {
//             $resposta['status']   = '1';
//             $resposta['mensagem'] = 'Lote excluído com sucesso.';
//         }
//         else
//         {
//             $reposta['status']    = '0';
//             $resposta['mensagem'] = 'Lote não pôde ser excluído.';
//         }

//         echo json_encode($resposta);
//     }
// }
