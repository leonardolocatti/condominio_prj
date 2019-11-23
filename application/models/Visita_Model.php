<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visita_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela visita.
     */
    public function __construct()
    {
        $nome_tabela               = 'visita';
        $campo_chave_primaria      = 'visita_id';
        $campo_data_cadastro       = 'visita_data_cadastro';
        $campo_usuario_cadastro    = 'visita_usuario_cadastro';
        $campo_data_modificacao    = 'visita_data_modificacao';
        $campo_usuario_modificacao = 'visita_usuario_modificacao';
        $campo_exclusao            = 'visita_excluido';
        $campo_data_exclusao       = 'visita_data_exclusao';
        $campo_usuario_exclusao    = 'visita_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Retorna as visitas salvas no banco de dados executando os filtros.
     * 
     * @param  array $dados POST enviado para o controller.
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function visita_tabela($dados)
    {
        $this->db->select('SQL_CALC_FOUND_ROWS visita.visita_id', FALSE);
        $this->db->select('visitante.visitante_nome');
        $this->db->select('DATE_FORMAT(visita.visita_entrada, "%d/%m/%Y %H:%i") AS visita_entrada');
        $this->db->select('carro.carro_modelo');
        $this->db->select('carro.carro_placa');
        $this->db->select('condomino.condomino_nome');
        $this->db->from('visita');
        $this->db->join('visitante', 'visita.visita_visitante = visitante.visitante_id');
        $this->db->join('carro', 'visita.visita_carro = carro.carro_id');
        $this->db->join('condomino', 'visita.visita_condomino = condomino.condomino_id');
        $this->db->join('usuario', 'usuario.usuario_login = condomino.condomino_cpf');
        $this->db->where('visita.visita_excluido', 0);
        $this->db->where('visita.visita_ativa', 1);

        if ( ! empty($dados['usuario'])) {
            $this->db->where('usuario.usuario_id', $dados['usuario']);
        }

        $this->db->limit($dados['length'], $dados['start']);

        $this->db->order_by($dados['columns'][$dados['order'][0]['column']]['name'], $dados['order'][0]['dir']);

        $resposta['obj']   = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }
}
