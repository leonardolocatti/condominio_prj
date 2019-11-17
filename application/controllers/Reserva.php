<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends MY_Controller {

    /**
     * Retorna um json com os dados das reservas para serem inseridas no calendário 
     */
    public function carregar_reservas()
    {
        $this->load->model('Reserva_Model');
        $obj_reserva = new Reserva_Model();

        $res_reserva = $obj_reserva->carregar_reservas();

        $reservas = array();
        $i     = 0;

        foreach ($res_reserva['obj'] as $reserva) 
        {
            $reservas[$i]['title'] = $reserva->reserva_area_comum;
            $reservas[$i]['start'] = $reserva->reserva_data_inicio;
            $reservas[$i]['end']   = $reserva->reserva_data_fim;

            $i++;
        }

        echo json_encode($reservas);
    }
//     /**
//      * Retorna um json com os dados dos reservas para serem inseridos na tabela.
//      * 
//      * @return void
//      */
//     public function reserva_tabela()
//     {
//         $this->load->model('Reserva_Model');
//         $obj_reserva = new Reserva_Model();

//         $res_reserva = $obj_reserva->reserva_tabela($this->input->post());

//         foreach ($res_reserva['obj'] as $reserva)
//         {
//             $morador = ! empty($reserva->condomino_nome) ? $reserva->condomino_nome : 'Reserva desocupado';

//             $opcoes  = '<button class="btn btn-sm btn-warning" title="Editar reserva" onclick="abrir_modal_reserva('.$reserva->reserva_id.')">';
//             $opcoes .=     '<i class="fas fa-pen"></i>';
//             $opcoes .= '</button> ';

//             $opcoes .= '<button class="btn btn-sm btn-danger" title="Deletar reserva" onclick="excluir_reserva('.$reserva->reserva_id.')">';
//             $opcoes .=     '<i class="fas fa-trash"></i>';
//             $opcoes .= '</button>';

//             $reservas[$i]['reserva_id']        = $reserva->reserva_id;
//             $reservas[$i]['reserva_numero']    = $reserva->reserva_numero;
//             $reservas[$i]['reserva_area']      = formatar_area($reserva->reserva_area);
//             $reservas[$i]['reserva_descricao'] = $reserva->reserva_descricao;
//             $reservas[$i]['morador']        = $morador;
//             $reservas[$i]['opcoes']         = $opcoes;

//             $i++;
//         }

//         $resposta = array(
//             'recordsFiltered' => $res_reserva['total'],
//             'recordsTotal'    => $res_reserva['total'],
//             'data'            => $reservas,
//         );

//         echo json_encode($resposta);
//     }

    /**
     * Recebe os dados da reserva fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_reserva()
    {
        $this->load->model('Reserva_Model');
        $obj_reserva = new Reserva_Model();

        $obj_reserva->reserva_id        = ! empty($_POST['reserva_id'])        ? $this->input->post('reserva_id')                : NULL;
        $obj_reserva->reserva_area_comum = ! empty($_POST['area_comum_id']) ? $this->input->post('area_comum_id')         : NULL;
        $obj_reserva->reserva_data_inicio    = ! empty($_POST['reserva_data_inicio'])    ? $this->input->post('reserva_data_inicio')            : NULL;
        $obj_reserva->reserva_data_fim      = ! empty($_POST['reserva_data_fim'])      ? $this->input->post('reserva_data_fim') : NULL;

        if ($obj_reserva->reserva_id > 0) 
        {
            if ($obj_reserva->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Reserva atualizada com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Reserva não pôde ser atualizado.';
            }
        }
        else
        {
            if ($obj_reserva->inserir() > 0)
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Reserva cadastrada com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'A reserva não pôde ser cadastrada';
            }
        }

        echo json_encode($resposta);
    }

//     /**
//      * Retorna um json com os dados do reserva pedido por POST.
//      * 
//      * @return void
//      */
//     public function dados_reserva()
//     {
//         $this->load->model('Reserva_Model');
//         $obj_reserva = new Reserva_Model();

//         $obj_reserva->reserva_id = $this->input->post('reserva_id');
        
//         echo json_encode($obj_reserva->recuperar());
//     }

//     /**
//      * Recebe os dados de um reserva que será excluído.
//      * 
//      * @return void
//      */
//     public function excluir_reserva()
//     {
//         $this->load->model('Reserva_Model');
//         $obj_reserva = new Reserva_Model();

//         $obj_reserva->reserva_id = $this->input->post('reserva_id');

//         if ($obj_reserva->excluir())
//         {
//             $resposta['status']   = '1';
//             $resposta['mensagem'] = 'Reserva excluído com sucesso.';
//         }
//         else
//         {
//             $reposta['status']    = '0';
//             $resposta['mensagem'] = 'Reserva não pôde ser excluído.';
//         }

//         echo json_encode($resposta);
//     }
}
