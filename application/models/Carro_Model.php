<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carro_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela carro.
     */
    public function __construct()
    {
        $nome_tabela               = 'carro';
        $campo_chave_primaria      = 'carro_id';
        $campo_data_cadastro       = 'carro_data_cadastro';
        $campo_usuario_cadastro    = 'carro_usuario_cadastro';
        $campo_data_modificacao    = 'carro_data_modificacao';
        $campo_usuario_modificacao = 'carro_usuario_modificacao';
        $campo_exclusao            = 'carro_excluido';
        $campo_data_exclusao       = 'carro_data_exclusao';
        $campo_usuario_exclusao    = 'carro_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Retorna os carros salvos no banco de dados executando os filtros.
     * 
     * @param  array $dados POST enviado para o controller.
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function carro_tabela($dados)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS carro.carro_id', FALSE);
        $this->db->select('carro.carro_placa');
        $this->db->select('carro.carro_marca');
        $this->db->select('carro.carro_modelo');
        $this->db->select('carro.carro_cor');
        $this->db->from('carro');
        $this->db->where('carro.carro_excluido', 0);

        if ( ! empty($dados['visitante_id']))
        {
            $this->db->where('carro.carro_visitante', $dados['visitante_id']);
        }

        $this->db->limit($dados['length'], $dados['start']);

        $this->db->order_by($dados['columns'][$dados['order'][0]['column']]['name'], $dados['order'][0]['dir']);

        $resposta['obj'] = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }
}
