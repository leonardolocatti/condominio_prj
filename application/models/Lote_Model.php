<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lote_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela lote.
     */
    public function __construct()
    {
        $nome_tabela               = 'lote';
        $campo_chave_primaria      = 'lote_id';
        $campo_data_cadastro       = 'lote_data_cadastro';
        $campo_usuario_cadastro    = 'lote_usuario_cadastro';
        $campo_data_modificacao    = 'lote_data_modificacao';
        $campo_usuario_modificacao = 'lote_usuario_modificacao';
        $campo_exclusao            = 'lote_excluido';
        $campo_data_exclusao       = 'lote_data_exclusao';
        $campo_usuario_exclusao    = 'lote_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Retorna os lotes salvos no banco de dados executando os filtros.
     * 
     * @param  array $dados POST enviado para o controller.
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function lote_tabela($dados)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS lote.lote_id', FALSE);
        $this->db->select('lote.lote_numero');
        $this->db->select('lote.lote_area');
        $this->db->select('lote.lote_descricao');
        $this->db->select('condomino.condomino_nome');
        $this->db->from('lote');
        $this->db->join('condomino', 'condomino.condomino_lote = lote.lote_id AND condomino.condomino_excluido = 0', 'left');
        $this->db->where('lote.lote_excluido', 0);

        $this->db->limit($dados['length'], $dados['start']);

        $this->db->order_by($dados['columns'][$dados['order'][0]['column']]['name'], $dados['order'][0]['dir']);

        $resposta['obj'] = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }

    /**
     * Retorna os lotes que serão inseridos no dropdown.
     * 
     * @return array Array com os lotes para inserir no dropdown.
     */
    public function lotes_dropdown()
    {
        $this->db->select('lote.lote_id');
        $this->db->select('lote.lote_numero');
        $this->db->select('lote.lote_descricao');
        $this->db->from('lote');
        $this->db->join('condomino', 'condomino.condomino_lote = lote.lote_id AND condomino.condomino_excluido = 0', 'left');
        $this->db->where('condomino.condomino_id', NULL);
        $this->db->where('lote.lote_excluido', 0);

        $this->db->order_by('lote.lote_numero', 'ASC');

        $lotes = array(
            '' => 'Selecione um lote',
        );

        foreach ($this->db->get()->result() as $lote)
        {
            $lotes[$lote->lote_id] = $lote->lote_numero.' - '.$lote->lote_descricao;
        }

        return $lotes;
    }
}
