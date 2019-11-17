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
     * Retorna qw reservas salvas no banco de dados executando os filtros.
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

        $resposta['obj'] = $this->db->get()->result();
        $resposta['total'] = $this->db->query('SELECT FOUND_ROWS() AS total')->row()->total;

        return $resposta;
    }


//     /**
//      * Retorna os reservas que serão inseridos no dropdown.
//      * 
//      * @return array Array com os reservas para inserir no dropdown.
//      */
//     public function reservas_dropdown()
//     {
//         $this->db->select('reserva.reserva_id');
//         $this->db->select('reserva.reserva_numero');
//         $this->db->select('reserva.reserva_descricao');
//         $this->db->from('reserva');
//         $this->db->join('condomino', 'condomino.condomino_reserva = reserva.reserva_id AND condomino.condomino_excluido = 0', 'left');
//         $this->db->where('condomino.condomino_id', NULL);
//         $this->db->where('reserva.reserva_excluido', 0);

//         $this->db->order_by('reserva.reserva_numero', 'ASC');

//         $reservas = array(
//             '' => 'Selecione um reserva',
//         );

//         foreach ($this->db->get()->result() as $reserva)
//         {
//             $reservas[$reserva->reserva_id] = $reserva->reserva_numero.' - '.$reserva->reserva_descricao;
//         }

//         return $reservas;
//     }
}
