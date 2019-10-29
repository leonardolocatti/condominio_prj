<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('limpar_cpf'))
{
    /**
     * Limpa os caracteres do CPF.
     * 
     * @param  string $cpf CPF com os pontos e traços.
     * @return string Retorna o CPF limpo sem os pontos e traços.
     */
    function limpar_cpf($cpf)
    {
        return str_replace(array('.', '-'), '', $cpf);
    }
}

if ( ! function_exists('cpf'))
{
    /**
     * Formata o CPF adicionando os pontos e traços.
     * 
     * @param  string $cpf CPF sem os pontos e traços
     * @return string Retorna o CPF com os pontos e traços
     */
    function cpf($cpf)
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '${1}.${2}.${3}-${4}', $cpf);
    }
}
