<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main role="main">
    <div class="container-fluid mt-5">
        <div class="col-md-12 m-auto">
            <h2 class="text-center mb-5"><i class="fas fa-home"></i> Web Condomínio</h2>
            <div class="row">
                <div class="col-6">
                    <div id="registrar_visitas">
                        <div class="caixa_titulo">
                            <p class="h4 mb-0">Registrar Visitas</p>
                        </div>
                        <div class="caixa_conteudo">
                            <input type="hidden" id="visitante_id" name="visitante_id">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="visitante_cpf">
                                            CPF
                                            <i class="fas fa-info-circle text-info ml-1" title="Preencha com o CPF do visitante e pressione a tecla TAB"></i>
                                        </label>
                                        <input type="text" class="form-control" id="visitante_cpf" name="visitante_cpf" data-mask="000.000.000-00">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="visitante_nome">Nome</label>
                                        <input type="text" class="form-control" id="visitante_nome" name="visitante_nome" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="visitante_carro">
                                            Carro
                                            <i class="fas fa-info-circle text-info ml-1" title="Selecione o carro do visitante ou caso esteja a pé, selecione a opção correspondente"></i>
                                        </label>
                                        <select class="form-control" id="visitante_carro" name="visitante_carro" disabled></select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="visitante_condomino">
                                            Condômino
                                            <i class="fas fa-info-circle text-info ml-1" title="Selecione o nome do condômino que será visitado"></i>
                                        </label>
                                        <?php echo form_dropdown('visitante_condomino', $condominos_dropdown, '', 'class="form-control" style="width: 100%;" id="visitante_condomino" disabled') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 m-auto">
                                    <button type="button" class="btn btn-outline-warning btn-block mt-3" id="visitante_botao_editar" disabled>
                                        <i class="fas fa-pen mr-2"></i>
                                        Editar Visitante
                                    </button>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 m-auto">
                                    <button type="button" class="btn btn-outline-info btn-block mt-3" id="carro_botao_editar" disabled>
                                        <i class="fas fa-car mr-2"></i>
                                        Editar Carros
                                    </button>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 m-auto">
                                    <button type="submit" class="btn btn-outline-success btn-block mt-3" id="visitante_botao_registrar" disabled>
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Registrar Entrada
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div id="visitas_atuais">
                        <div class="caixa_titulo">
                            <p class="h4 mb-0">Visitas Atuais</p>
                        </div>
                        <div class="caixa_conteudo">
                            <div class="row">
                                <div class="col-12">
                                <table id="visita_tabela" class="table table-striped table-bordered table-sm w-100"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal de cadastro/edição de visitantes -->
<div class="modal fade modal_cadastro" id="modal_cadastro_visitante" tabindex="-1" role="dialog" aria-hidde="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_visitante_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_visitante" action="javascript:salvar_visitante()" novalidate>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="visitante_cpf">CPF</label>
                                <input type="text" class="form-control" id="visitante_cpf" name="visitante_cpf" data-mask="000.000.000-00" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="visitante_cpf">Nome</label>
                                <input type="text" class="form-control" id="visitante_nome" name="visitante_nome">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger"
                        data-dismiss="modal">
                    Fechar
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" id="visitante_botao_salvar" onclick="salvar_visitante()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do modal de cadastro/edição de áreas comuns -->

<?php echo $view_carros ?>

<!-- Modal de cadastro/edição de carros -->
<!-- <div class="modal fade modal_cadastro" id="modal_cadastro_carro" tabindex="-1" role="dialog" aria-hidde="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_carro_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger"
                        data-dismiss="modal">
                    Fechar
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" id="visitante_botao_salvar" onclick="salvar_visitante()">
                    Salvar
                </button>
            </div>
        </div>
    </div> -->
<!-- </div> Fim do modal de cadastro/edição de áreas comuns -->
