<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reuniao extends MY_Controller {

    /**
     * Exibe a tela de Reuniões.
     */
    public function index()
    {
        $this->load->setar_titulo('Reuniões');
        $this->load->setar_id_body('pagina_reuniao');
        $this->load->adicionar_js('reuniao.js');
        $this->load->exibir('reuniao');
    }
    
    /**
     * Retorna um json com os dados das reuniões para serem inseridas na tabela.
     * 
     * @return {void}
     */
    public function reuniao_tabela()
    {
        $this->load->model('Reuniao_Model');
        $obj_reuniao = new Reuniao_Model();

        $res_reuniao = $obj_reuniao->reuniao_tabela($this->input->post());

        $reunioes = array();
        $i        = 0;

        foreach ($res_reuniao['obj'] as $reuniao)
        {
            $opcoes  = '<button class="btn btn-sm btn-info" title="Baixar Ata" onclick="baixar_ata('.$reuniao->reuniao_id.')">';
            $opcoes .=     '<i class="fas fa-download"></i>';
            $opcoes .= '</button> ';

            if ($this->session->usuario->usuario_tipo === 'administrador')
            {
                $opcoes .= '<button class="btn btn-sm btn-warning" title="Editar Reunião" onclick="abrir_modal_reuniao('.$reuniao->reuniao_id.')">';
                $opcoes .=     '<i class="fas fa-pen"></i>';
                $opcoes .= '</button> ';
            }

            $reunioes[$i]['reuniao_id'] = $reuniao->reuniao_id;
            $reunioes[$i]['reuniao_descricao'] = $reuniao->reuniao_descricao;
            $reunioes[$i]['reuniao_data_hora'] = $reuniao->reuniao_data_hora;
            $reunioes[$i]['reuniao_status']    = $reuniao->reuniao_status;
            $reunioes[$i]['opcoes'] = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_reuniao['total'],
            'recordsTotal'     => $res_reuniao['total'],
            'data'            => $reunioes,
        );

        echo json_encode($resposta);
    }

    /** 
     * Recebe os dados da reunião fornecidas por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_reuniao()
    {
        $this->load->model('Reuniao_Model');
        $obj_reuniao = new Reuniao_Model();

        if ( ! empty($_FILES['reuniao_ata']['tmp_name'])) 
        {
            $reuniao_ata = APPPATH.'assets/uploads/reuniao_ata/'.$_FILES['reuniao_ata']['name'];
            move_uploaded_file($_FILES['reuniao_ata']['tmp_name'], $reuniao_ata);
            $obj_reuniao->reuniao_ata = ! empty($reuniao_ata) ? $reuniao_ata : NULL;
        }

        $obj_reuniao->reuniao_id =        ! empty($_POST['reuniao_id'])        ? $this->input->post('reuniao_id')        : NULL;
        $obj_reuniao->reuniao_descricao = ! empty($_POST['reuniao_descricao']) ? $this->input->post('reuniao_descricao') : NULL;
        $obj_reuniao->reuniao_data_hora = ! empty($_POST['reuniao_data_hora']) ? $this->input->post('reuniao_data_hora') : NULL;
        $obj_reuniao->reuniao_status =    ! empty($_POST['reuniao_status'])    ? $this->input->post('reuniao_status')    : NULL;

        if ($obj_reuniao->reuniao_id > 0)
        {
            if ($obj_reuniao->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Reunião atualizada com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Reunião não pôde ser atualizada.';
            }
        }
        else
        {
            if ($obj_reuniao->inserir() > 0)
            {
                $resposta['status'] = '1';
                $resposta['mensagem'] = 'Reunião cadastrada com sucesso.';
            }
            else
            {
                $resposta['status'] = '0';
                $resposta['mensagem'] = 'A reunião não pôde ser cadastrada.';
            }
        }

        echo json_encode($resposta);
    }

    /**
     * Baixa a atua da reunião se disponível.
     * 
     * @param  int $reuniao_id ID da reunião que terá a ata baixada.
     * @return void
     */
    public function baixar_ata($reuniao_id)
    {
        $this->load->helper('download');
        $this->load->model('Reuniao_Model');
        $obj_reuniao = new Reuniao_Model();

        $obj_reuniao->reuniao_id = $reuniao_id;
        $res_reuniao = $obj_reuniao->recuperar();

        force_download($res_reuniao->reuniao_ata, NULL);
    }

    /**
     * Retorna um json com os dados da reunião pedido por POST.
     * 
     * @return void
     */
    public function dados_reuniao()
    {
        $this->load->model('Reuniao_Model');
        $obj_reuniao = new Reuniao_Model();

        $obj_reuniao->reuniao_id = $this->input->post('reuniao_id');

        echo json_encode($obj_reuniao->recuperar());
    }
}

//     /**
//      * Recebe os dados de um condômino que será excluído.
//      * 
//      * @return void
//      */
//     public function excluir_condomino()
//     {
//         $this->load->model('Condomino_Model');
//         $obj_condomino = new Condomino_Model();

//         $obj_condomino->condomino_id = $this->input->post('condomino_id');

//         if ($obj_condomino->excluir())
//         {
//             $resposta['status']   = '1';
//             $resposta['mensagem'] = 'Condômino excluído com sucesso.';
//         }
//         else
//         {
//             $reposta['status']    = '0';
//             $resposta['mensagem'] = 'Condômino não pôde ser excluído.';
//         }

//         echo json_encode($resposta);
//     }
// }
