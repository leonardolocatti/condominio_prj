<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reuniao_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela reunião.
     */
    public function __construct()
    {
        $nome_tabela               = 'reuniao';
        $campo_chave_primaria      = 'reuniao_id';
        $campo_data_cadastro       = 'reuniao_data_cadastro';
        $campo_usuario_cadastro    = 'reuniao_usuario_cadastro';
        $campo_data_modificacao    = 'reuniao_data_modificacao';
        $campo_usuario_modificacao = 'reuniao_usuario_modificacao';
        $campo_exclusao            = 'reuniao_excluido';
        $campo_data_exclusao       = 'reuniao_data_exclusao';
        $campo_usuario_exclusao    = 'reuniao_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Retorna as reuniões salvas no banco de dados executando os filtros.
     * 
     * @param  array $dados POST enviado para o controller.
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function reuniao_tabela($dados)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS reuniao.reuniao_id', FALSE);
        $this->db->select('reuniao.reuniao_descricao');
        $this->db->select('reuniao.reuniao_data_hora');
        $this->db->select('reuniao.reuniao_status');
        $this->db->from('reuniao');
        $this->db->where('reuniao.reuniao_excluido', 0);

        $this->db->limit($dados['length'], $dados['start']);

        $this->db->order_by($dados['columns'][$dados['order'][0]['column']]['name'], $dados['order'][0]['dir']);

        $resposta['obj']   = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }
}
