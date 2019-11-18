<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela reserva.
     */
    public function __construct()
    {
        $nome_tabela               = 'reserva';
        $campo_chave_primaria      = 'reserva_id';
        $campo_data_cadastro       = 'reserva_data_cadastro';
        $campo_usuario_cadastro    = 'reserva_usuario_cadastro';
        $campo_data_modificacao    = 'reserva_data_modificacao';
        $campo_usuario_modificacao = 'reserva_usuario_modificacao';
        $campo_exclusao            = 'reserva_excluido';
        $campo_data_exclusao       = 'reserva_data_exclusao';
        $campo_usuario_exclusao    = 'reserva_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Retorna as reservas salvas no banco de dados executando os filtros.
     * 
     * @return array Retorna um array contendo o total de registros e os registros.
     */
    public function carregar_reservas()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS reserva.reserva_id', FALSE);
        $this->db->select('reserva.reserva_area_comum');
        $this->db->select('reserva.reserva_data_inicio');
        $this->db->select('reserva.reserva_data_fim');
        $this->db->from('reserva');
        $this->db->where('reserva.reserva_excluido', 0);

        $resposta['obj']   = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }
} 
