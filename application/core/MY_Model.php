<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*


Essa classe inteira precisa passar por refatoração




*/


class MY_Model extends CI_Model {

    // Atributos para auxiliar nas operações com o banco de dados
    private $nome_tabela;
    private $campo_chave_primaria;
    private $campo_data_cadastro;
    private $campo_usuario_cadastro;
    private $campo_data_modificacao;
    private $campo_usuario_modificacao;
    private $campo_exclusao;
    private $campo_data_exclusao;
    private $campo_usuario_exclusao;

    /**
     * Construtor recebe os parâmetros referentes à tabela equivalente no banco de dados.
     * 
     * @param string $nome_tabela               Nome da tabela no banco de dados.
     * @param string $campo_chave_primaria      Nome do campo que é a chave primária da tabela no banco de dados.
     * @param string $campo_data_cadastro       Nome do campo que armazena a data que o cadastro foi realizado.
     * @param string $campo_usuario_cadastro    Nome do campo que armazena o usuário que realizou o cadastro.
     * @param string $campo_data_modificacao    Nome do campo que armazena a data em que a modificação foi realizada.
     * @param string $campo_usuario_modificacao Nome do campo que armazena o usuário que realizou a modificação.
     * @param string $campo_exclusao            Nome do campo que indica a exclusão lógica do registro no banco de dados.
     * @param string $campo_data_exclusao       Nome do campo que armazena a data em que a exclusão foi realizada.
     * @param string $campo_usuario_exclusao    Nome do campo que armazena o usuário que realizou a exclusão.
     */
    public function __construct($nome_tabela, $campo_chave_primaria, $campo_data_cadastro, $campo_usuario_cadastro, 
            $campo_data_modificacao, $campo_usuario_modificacao, $campo_exclusao, $campo_data_exclusao, $campo_usuario_exclusao)
    {
        $this->nome_tabela               = $nome_tabela;
        $this->campo_chave_primaria      = $campo_chave_primaria;
        $this->campo_data_cadastro       = $campo_data_cadastro;
        $this->campo_usuario_cadastro    = $campo_usuario_cadastro;
        $this->campo_data_modificacao    = $campo_data_modificacao;
        $this->campo_usuario_modificacao = $campo_usuario_modificacao;
        $this->campo_exclusao            = $campo_exclusao;
        $this->campo_data_exclusao       = $campo_data_exclusao;
        $this->campo_usuario_exclusao    = $campo_usuario_exclusao;

        parent::__construct();
    }

    /**
     * Insere o registro no banco de dados.
     * 
     * @return int Se foi inserido o registro retorna o ID, caso contrário, retorna -1.
     */
    public function inserir()
    {
        // Insere as informações referentes ao cadastro
        $this->$campo_data_cadastro    = date('Y-m-d H:i:s');
        $this->$campo_usuario_cadastro = $this->session->usuario->usuario_id;

        // Tenta inserir o registro no banco e verifica
        if ($this->db->insert($nome_tabela, $this))
        {
            return $this->db->insert_id();
        }
        else {
            return -1;
        }
    }

    /**
     * Atualiza o registro no banco de dados.
     * 
     * @return bool Se foi atualizado retorna TRUE, caso contrário retorna FALSE.
     */
    public function atualizar()
    {
        // Insere as informações referentes a atualização
        $this->$campo_data_modificacao    = date('Y-m-d H:i:s');
        $this->$campo_usuario_modificacao = $this->session->usuario->usuario_id;

        // Tenta atualizar o registro no banco
        $this->db->where($campo_chave_primaria, $this->$campo_chave_primaria);
        return $this->db->update($nome_tabela, $this);
    }

    /**
     * Realiza a exclusão lógica do registro no banco de dados.
     * 
     * @return bool Se foi excluído retorna TRUE, caso contrário retorna FALSE.
     */
    public function deletar()
    {
        // Insere as informações referentes a exclusão
        $this->$campo_data_exclusao    = date('Y-m-d H:i:s');
        $this->$campo_usuario_exclusao = $this->session->usuario->usuario_id;
        
        // Tenta realizar a exclusão lógica no banco
        $this->$campo_exclusao = '1';
        $this->db->where($campo_chave_primaria, $this->$campo_chave_primaria);
        return $this->db->update($nome_tabela, $this);
    }

    /**
     * Recupera o registro do banco de dados.
     * 
     * @return object Retorna o objeto com as informações do registro no banco.
     */
    public function recuperar()
    {
        $this->db->where($campo_chave_primaria, $this->$campo_chave_primaria);
        return $this->db->get($nome_tabela);
    }

    /**
     * Realiza uma busca no banco de dados.
     * 
     * @param  array $campos          Array associativo com os campos e os valores que serão buscados.
     * @param  bool  $buscar_excluido Parâmetro para indicar a busca também pelos registros excluídos.
     * @return array Retorna um array de objetos contendo as informações que combinaram.
     */
    public function buscar($campos, $buscar_excluido = FALSE)
    {
        $this->db->where($campos);

        if ( ! $buscar_excluido) {
            $this->db->where($this->campo_exclusao, 0);
        }

        return $this->db->get($this->nome_tabela)->result();
    }
}
