<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

    // Atributos utilizados para auxiliar na geração do HTML das páginas
    private $css_array;
    private $js_array;
    private $titulo;
    private $id_body;
    private $classe_body;

    /**
     * Construtor seta os valores padrões para os atributos.
     */
    public function __construct()
    {
        $this->css_array   = array();
        $this->js_array    = array();
        $this->titulo      = 'Sistema Condomínio';
        $this->id_body     = '';
        $this->classe_body = '';

        parent::__construct();
    }

    /**
     * Adiciona um arquivo de css no array que será carregado na página.
     * Esse método deve ser chamado antes do método exibir.
     * 
     * @param  string $css Arquivo css que será adicionado.
     * @return void
     */
    public function adicionar_css($css)
    {
        // Adiciona o caminho dos assets no css
        $arquivo_css = BASEPATH.'/../application/assets/personalizado/css/'.$css;

        // Verifica se o arquivo pode ser lido e adiciona o caminho url do arquivo no array
        if (is_readable($arquivo_css))
        {
            $this->css_array[] = base_url('/application/assets/personalizado/css/'.$css);
        }
    }

    /**
     * Adiciona um arquivo de js no array que será carregado na página.
     * Esse método deve ser chamado antes do método exibir.
     * 
     * @param  string $js Arquivo js que será adicionado.
     * @return void
     */
    public function adicionar_js($js)
    {
        // Adiciona o caminho dos assets no js
        $arquivo_js = BASEPATH.'/../application/assets/personalizado/js/'.$js;

        // Verifica se o arquivo pode ser lido e adiciona o caminho url do arquivo no array
        if (is_readable($arquivo_js))
        {
            $this->js_array[] = base_url('/application/assets/personalizado/js/'.$js);
        }
    }

    /**
     * Seta o título da página.
     * Esse método deve ser chamado antes do método exibir.
     * 
     * @param  string $titulo Título da página
     * @return void
     */
    public function setar_titulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * Seta o ID do body.
     * Esse método deve ser chamado antes do método exibir.
     * 
     * @param  string $id_body ID do body
     * @return void
     */
    public function setar_id_body($id_body)
    {
        $this->id_body = $id_body;
    }

    /**
     * Seta a(s) classe(s) do body.
     * Esse método deve ser chamado antes do método exibir.
     * 
     * @param  string $classe_body Classe(s) do body
     * @return void
     */
    public function setar_classe_body($classe_body)
    {
        $this->classe_body = $classe_body;
    }

    /**
     * Carrega os templates e a página passada.
     * 
     * @param  string $pagina    Página que será carregada.
     * @param  array  $variaveis Array associativo opcional com as variáveis que serão passadas para a página.
     * @param  bool   $menu      Parâmetro opcional para indicar o carregamento do menu. Carregado por padrão.
     * @return void
     */
    public function exibir($pagina, $variaveis = array(), $menu = TRUE)
    {
        // Array com as variáveis passadas para o template do cabeçalho
        $variaveis_cabecalho = array(
            'css_array'   => $this->css_array,
            'titulo'      => $this->titulo,
            'id_body'     => $this->id_body,
            'classe_body' => $this->classe_body,
        );

        // Array com as variáveis passadas para o template do rodapé
        $variaveis_rodape = array(
            'js_array' => $this->js_array,
        );

        // Carrega o template do cabeçalho
        parent::view('templates/cabecalho', $variaveis_cabecalho);

        // Carrega o template do menu
        if ($menu)
        {
            parent::view('templates/menu');
        }

        // Carrega o conteúdo da página
        parent::view($pagina, $variaveis);

        // Carrega o template do rodapé
        parent::view('templates/rodape', $variaveis_rodape);
    }
}
