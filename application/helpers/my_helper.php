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

if ( ! function_exists('numero_br'))
{
    /**
     * Converte os números do padrão americano para o padrão brasileiro.
     * 
     * @param  string $numero Número formatado no padrão americano.
     * @return string Retorna um número formatado no padrão brasileiro.
     */
    function numero_br($numero)
    {
        return number_format($numero, 2, ',', '.');
    }
}

if ( ! function_exists('numero_us'))
{
    /**
     * Converte os números do padrão brasileiro para o padrão americano.
     * 
     * @param  string $numero Número formatado no padrão brasileiro.
     * @return string Retorna um número formatado no padrão americano.
     */
    function numero_us($numero)
    {
        $numero = str_replace('.', '', $numero);

        return str_replace(',', '.', $numero);
    }
}

if ( ! function_exists('limpar_area'))
{
    /**
     * Limpa os caracteres da área.
     * 
     * @param  string $area Área com os pontos e m².
     * @return string Retorna a área limpa somente com os números e as casas decimais.
     */
    function limpar_area($area)
    {
        $area = str_replace(' m²', '', $area);

        return numero_us($area);
    }
}

if ( ! function_exists('formatar_area'))
{
    /**
     * Formata a área adicionando os caracteres de divisão de milhar, casas decimais e m².
     * 
     * @param  string $area Área limpa somente com os números e as casas decimais.
     * @return string Retorna a área formatada
     */
    function formatar_area($area)
    {
        $area = numero_br($area);
        
        return $area.' m²';
    }
}

if ( ! function_exists('validar_cpf'))
{
    /**
     * Valida um número de CPF.
     * 
     * @param  string $cpf Número de CPF com pontos e traços
     * @return bool   Retorna verdadeiro se o número for válido e falso caso contrário
     */
    function validar_cpf($cpf)
    {
        $cpf = limpar_cpf($cpf);

        $array_cpf = str_split($cpf, 1);

        // CPF deve ter 11 dígitos
        if (count($array_cpf) == 11)
        {
            // Calculando o primeiro dígito verificador
            $soma          = 0;
            $multiplicador = 10;
            foreach ($array_cpf as $digito)
            {
                if ($multiplicador < 2)
                {
                    break;
                }

                $soma += $multiplicador-- * $digito;
            }

            $digito_verificador_1 = ($soma * 10) % 11;

            // Calculando o segundo dígito verificador
            $soma          = 0;
            $multiplicador = 11;
            foreach ($array_cpf as $digito)
            {
                if ($multiplicador < 2)
                {
                    break;
                }

                $soma += $multiplicador-- * $digito;
            }

            $digito_verificador_2 = ($soma * 10) % 11;

            if ($digito_verificador_1 == $array_cpf[9] && $digito_verificador_2 == $array_cpf[10])
            {
                $resposta['valido'] = TRUE;
            }
            else
            {
                $resposta['valido'] = FALSE;
            }
        }
        else
        {
            $resposta['valido'] = FALSE;
        }

        echo json_encode($resposta);
    }
}
