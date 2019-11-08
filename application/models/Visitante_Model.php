<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitante_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela visitante.
     */
    public function __construct()
    {
        $nome_tabela               = 'visitante';
        $campo_chave_primaria      = 'visitante_id';
        $campo_data_cadastro       = 'visitante_data_cadastro';
        $campo_usuario_cadastro    = 'visitante_usuario_cadastro';
        $campo_data_modificacao    = 'visitante_data_modificacao';
        $campo_usuario_modificacao = 'visitante_usuario_modificacao';
        $campo_exclusao            = 'visitante_excluido';
        $campo_data_exclusao       = 'visitante_data_exclusao';
        $campo_usuario_exclusao    = 'visitante_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Busca os visitante e retorna os dados do visitante.
     * 
     * @param  string $visitante_cpf CPF do visitante
     * @return object Retorna um objeto do visitante correspondente.
     */
    public function buscar_visitante($visitante_cpf)
    {
        $this->db->select('visitante.visitante_id');
        $this->db->select('visitante.visitante_cpf');
        $this->db->select('visitante.visitante_nome');
        $this->db->from('visitante');
        $this->db->where('visitante.visitante_excluido', '0');
        $this->db->where('visitante.visitante_cpf', $visitante_cpf);

        return $this->db->get()->row();
    }

    /**
     * Retorna os visitantes salvos no banco de dados executando os filtros.
     * 
     * @param  array $dados POST enviado para o controller.
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function visitante_tabela($dados)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS visitante.visitante_id', FALSE);
        $this->db->select('visitante.visitante_cpf');
        $this->db->select('visitante.visitante_nome');
        $this->db->select('CONCAT(lote.lote_numero, " - ", lote.lote_descricao) AS visitante_lote');
        $this->db->from('visitante');
        $this->db->join('lote', 'lote.lote_id = visitante.visitante_lote');
        $this->db->where('visitante.visitante_excluido', '0');

        $this->db->limit($dados['length'], $dados['start']);

        $this->db->order_by($dados['columns'][$dados['order'][0]['column']]['name'], $dados['order'][0]['dir']);

        $resposta['obj'] = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }
}
