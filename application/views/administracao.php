<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Conteúdo da página -->
<main role="main" class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-11 m-auto">
                <div id="administracao">
                    <div class="caixa_titulo">
                        <p class="h4 mb-0">Administração</p>
                    </div>
                    <div class="caixa_conteudo">
                        <div class="row">

                            <!-- Barra de navegação com as opções de administração -->
                            <div class="col-2">
                                <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" data-toggle="pill" href="#lotes" role="tab" 
                                            aria-controls="lotes" aria-selected="true">
                                        <i class="fas fa-square mr-1"></i>
                                        Lotes
                                    </a>
                                    <a class="nav-link" data-toggle="pill" href="#condominos" role="tab" 
                                            aria-controls="condominos" aria-selected="false">
                                        <i class="fas fa-user mr-1"></i>
                                        Condôminos
                                    </a>
                                    <a class="nav-link" data-toggle="pill" href="#areas_comuns" role="tab"
                                            aria-controls="areas_comuns" aria-selected="false">
                                        <i class="fas fa-dumbbell mr-1"></i>
                                        Áreas Comuns
                                    </a>
                                    <a class="nav-link" data-toggle="pill" href="#funcionarios" role="tab"
                                            aria-controls="funcionarios" aria-selected="false">
                                        <i class="fas fa-user-tie mr-1"></i>
                                        Funcionários
                                    </a>
                                </div>
                            </div> <!-- Fim da barra de navegação com as opções de administração -->

                            <!-- Conteúdos exibidos ao clicar nas abas da barra de navegação -->
                            <div class="col-10">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="lotes" role="tabpanel">
                                        <?php echo $view_lote ?>
                                    </div>
                                    <div class="tab-pane" id="condominos" role="tabpanel">
                                        <?php echo $view_condomino ?>
                                    </div>
                                    <div class="tab-pane" id="areas_comuns" role="tabpanel">
                                        <?php echo $view_areas_comuns ?>
                                    </div>
                                    <div class="tab-pane" id="funcionarios" role="tabpanel">
                                        <?php echo $view_funcionario ?>
                                    </div>
                                </div>
                            </div> <!-- Fim dos conteúdos exibidos ao clicar nas abas da barra de navegação -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!-- Fim do conteúdo da página -->
