<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_Model extends MY_Model {

    /**
     * Construtor com os parâmetros referentes à tabela usuario
     */
    public function __construct()
    {
        $nome_tabela               = 'usuario';
        $campo_chave_primaria      = 'usuario_id';
        $campo_data_cadastro       = 'usuario_data_cadastro';
        $campo_usuario_cadastro    = 'usuario_usuario_cadastro';
        $campo_data_modificacao    = 'usuario_data_modificacao';
        $campo_usuario_modificacao = 'usuario_usuario_modificacao';
        $campo_exclusao            = 'usuario_excluido';
        $campo_data_exclusao       = 'usuario_data_exclusao';
        $campo_usuario_exclusao    = 'usuario_usuario_exclusao';

        parent::__construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro,
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao,
            $campo_usuario_exclusao);
    }

    /**
     * Verifica se o usuário informado existe.
     * 
     * @param  string $usuario_login Login do usuário utilizado no login.
     * @return bool   Retorna verdadeiro se o usuário existir e falso caso não exista.
     */
    public function usuario_existe($usuario_login)
    {
        $campos = array(
            'usuario_login' => $usuario_login,
        );

        if ( ! empty($this->buscar($campos)))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Verifica se a senha informada confere com a armazenada no banco de dados.
     * 
     * @param  string $usuario_login Login do usuário utiizado no login.
     * @param  string $usuario_senha Senha a ser conferida.
     * @return bool   Retorna verdadeiro se a senha conferir e falso caso contrário.
     */
    public function conferir_senha($usuario_login, $usuario_senha)
    {
        $campos = array(
            'usuario_login' => $usuario_login,
        );

        $resposta_usuario = $this->buscar($campos);

        return password_verify($usuario_senha, $resposta_usuario[0]->usuario_senha);
    }

    /**
     * Retorna os dados do usuário que serão inseridos na sessão.
     * 
     * @param  string $usuario_login Login do usuário que será carregado para a sessão.
     * @return object Objeto com os dados do usuário.
     */
    public function usuario_dados_sessao($usuario_login)
    {
        $campos = array(
            'usuario_login' => $usuario_login,
        );

        $resposta_usuario = $this->buscar($campos);

        $obj_usuario = new Usuario_Model();
        $obj_usuario->usuario_id = $resposta_usuario[0]->usuario_id;
        $obj_usuario->usuario_login = $resposta_usuario[0]->usuario_login;

        return $obj_usuario;
    }
}
