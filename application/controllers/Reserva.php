<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends MY_Controller {

    /**
     * Retorna um json com os dados das reservas para serem inseridas no calendário.
     */
    public function carregar_reservas()
    {
        $this->load->model('Reserva_Model');
        $obj_reserva = new Reserva_Model();

        $res_reserva = $obj_reserva->carregar_reservas($this->input->post('usuario'));

        $reservas = array();
        $i     = 0;

        foreach ($res_reserva['obj'] as $reserva) 
        {
            $reservas[$i]['title'] = $reserva->area_comum_nome;
            $reservas[$i]['start'] = $reserva->reserva_data_inicio;
            $reservas[$i]['end']   = $reserva->reserva_data_fim;

            $i++;
        }

        echo json_encode($reservas);
    }

    /**
     * Recebe os dados da reserva fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_reserva()
    {
        $this->load->model('Reserva_Model');
        $obj_reserva = new Reserva_Model();

        $obj_reserva->reserva_id          = ! empty($_POST['reserva_id'])          ? $this->input->post('reserva_id')          : NULL;
        $obj_reserva->reserva_area_comum  = ! empty($_POST['area_comum_id'])       ? $this->input->post('area_comum_id')       : NULL;
        $obj_reserva->reserva_data_inicio = ! empty($_POST['reserva_data_inicio']) ? $this->input->post('reserva_data_inicio') : NULL;
        $obj_reserva->reserva_data_fim    = ! empty($_POST['reserva_data_fim'])    ? $this->input->post('reserva_data_fim')    : NULL;

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
}
