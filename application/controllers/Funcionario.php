<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario extends MY_Controller {

    /**
     * Retorna um json com os dados dos funcionários para serem inseridos na tabela.
     * 
     * @return void
     */
    public function funcionario_tabela()
    {
        $this->load->model('Funcionario_Model');
        $obj_funcionario = new Funcionario_Model();

        $this->lang->load('funcionario');
        $funcionario_cargos = $this->lang->line('funcionario_cargos');

        $res_funcionario = $obj_funcionario->funcionario_tabela($this->input->post());

        $funcionarios = array();
        $i            = 0;

        foreach ($res_funcionario['obj'] as $funcionario)
        {
            $opcoes  = '<button class="btn btn-sm btn-warning" title="Editar funcionário" onclick="abrir_modal_funcionario('.$funcionario->funcionario_id.')">';
            $opcoes .=     '<i class="fas fa-pen"></i>';
            $opcoes .= '</button> ';

            $opcoes .= '<button class="btn btn-sm btn-danger" title="Deletar funcionário" onclick="excluir_funcionario('.$funcionario->funcionario_id.')">';
            $opcoes .=     '<i class="fas fa-trash"></i>';
            $opcoes .= '</button> ';

            $funcionarios[$i]['funcionario_id']    = $funcionario->funcionario_id;
            $funcionarios[$i]['funcionario_nome']  = $funcionario->funcionario_nome;
            $funcionarios[$i]['funcionario_cpf']   = cpf($funcionario->funcionario_cpf);
            $funcionarios[$i]['funcionario_cargo'] = $funcionario_cargos[$funcionario->funcionario_cargo];
            $funcionarios[$i]['opcoes']            = $opcoes;

            $i++;
        }

        $resposta = array(
            'recordsFiltered' => $res_funcionario['total'],
            'recordsTotal'    => $res_funcionario['total'],
            'data'            => $funcionarios,
        );

        echo json_encode($resposta);
    }

    /**
     * Recebe os dados do funcionário fornecidos por POST e tenta salvar no banco de dados.
     * 
     * @return void
     */
    public function salvar_funcionario()
    {
        $this->load->model('Funcionario_Model');
        $obj_funcionario = new Funcionario_Model();

        $obj_funcionario->funcionario_id    = ! empty($_POST['funcionario_id'])    ? $this->input->post('funcionario_id')               : NULL;
        $obj_funcionario->funcionario_cpf   = ! empty($_POST['funcionario_cpf'])   ? limpar_cpf($this->input->post('funcionario_cpf'))  : NULL;
        $obj_funcionario->funcionario_nome  = ! empty($_POST['funcionario_nome'])  ? $this->input->post('funcionario_nome')             : NULL;
        $obj_funcionario->funcionario_cargo = ! empty($_POST['funcionario_cargo']) ? $this->input->post('funcionario_cargo')            : NULL;

        if ($obj_funcionario->funcionario_id > 0) 
        {
            if ($obj_funcionario->atualizar())
            {
                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Funcionário atualizado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Funcionário não pôde ser atualizado.';
            }
        }
        else
        {
            if (($id_funcionario = $obj_funcionario->inserir()) > 0)
            {
                if ($this->input->post('funcionario_cargo') == '1') // 1 -> Código do porteiro
                {
                    // Criar usuário para o porteiro
                    $this->load->model('Usuario_Model');
                    $obj_usuario = new Usuario_Model();

                    $obj_usuario->usuario_login = limpar_cpf($this->input->post('funcionario_cpf'));
                    $obj_usuario->usuario_senha = password_hash(limpar_cpf($this->input->post('funcionario_cpf')), PASSWORD_DEFAULT);
                    $obj_usuario->inserir();
                }

                $resposta['status']   = '1';
                $resposta['mensagem'] = 'Funcionário cadastrado com sucesso.';
            }
            else
            {
                $resposta['status']   = '0';
                $resposta['mensagem'] = 'Funcionário não pôde ser cadastrado';
            }
        }

        echo json_encode($resposta);
    }

    /**
    * Retorna um json com os dados do funcionário pedido por POST.
    * 
    * @return void
    */
    public function dados_funcionario()
    {
        $this->load->model('Funcionario_Model');
        $obj_funcionario = new Funcionario_Model();

        $obj_funcionario->funcionario_id = $this->input->post('funcionario_id');

        echo json_encode($obj_funcionario->recuperar());
    }

    /**
     * Recebe os dados de um funcionário que será excluído.
     * 
     * @return void
     */
    public function excluir_funcionario()
    {
        $this->load->model('Funcionario_Model');
        $obj_funcionario = new Funcionario_Model();

        $obj_funcionario->funcionario_id = $this->input->post('funcionario_id');

        if ($obj_funcionario->excluir())
        {
            $resposta['status']   = '1';
            $resposta['mensagem'] = 'Funcionário excluído com sucesso.';
        }
        else
        {
            $reposta['status']    = '0';
            $resposta['mensagem'] = 'Funcionário não pôde ser excluído.';
        }

        echo json_encode($resposta);
    }
}
