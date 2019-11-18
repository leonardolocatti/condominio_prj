<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela funcionário.
     */
    public function __construct()
    {
        $nome_tabela               = 'funcionario';
        $campo_chave_primaria      = 'funcionario_id';
        $campo_data_cadastro       = 'funcionario_data_cadastro';
        $campo_usuario_cadastro    = 'funcionario_usuario_cadastro';
        $campo_data_modificacao    = 'funcionario_data_modificacao';
        $campo_usuario_modificacao = 'funcionario_usuario_modificacao';
        $campo_exclusao            = 'funcionario_excluido';
        $campo_data_exclusao       = 'funcionario_data_exclusao';
        $campo_usuario_exclusao    = 'funcionario_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Retorna os funcionários salvos no banco de dados executando os filtros.
     * 
     * @param  array $dados POST enviado para o controller.
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function funcionario_tabela($dados)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS funcionario.funcionario_id', FALSE);
        $this->db->select('funcionario.funcionario_cpf');
        $this->db->select('funcionario.funcionario_nome');
        $this->db->select('funcionario.funcionario_cargo');
        $this->db->from('funcionario');
        $this->db->where('funcionario.funcionario_excluido', 0);

        $this->db->limit($dados['length'], $dados['start']);

        $this->db->order_by($dados['columns'][$dados['order'][0]['column']]['name'], $dados['order'][0]['dir']);

        $resposta['obj']   = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }

    /**
     * Busca os funcionários e retorna os dados do funcionário.
     * 
     * @param  string $funcionario_cpf CPF do funcionário
     * @return object Retorna um objeto do funcionário correspondente.
     */
    public function buscar_funcionario($funcionario_cpf)
    {
        $this->db->select('funcionario.funcionario_cpf');
        $this->db->select('funcionario.funcionario_nome');
        $this->db->from('funcionario');
        $this->db->where('funcionario.funcionario_excluido', '0');
        $this->db->where('funcionario.funcionario_cpf', $funcionario_cpf);

        return $this->db->get()->row();
    }
}
