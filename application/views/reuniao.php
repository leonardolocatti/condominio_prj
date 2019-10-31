<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Conteúdo da página -->
<main role="main" class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-11 m-auto">
                <div id="reuniao">
                    <div class="caixa_titulo">
                        <p class="h4 mb-0">Reuniões</p>
                    </div>
                    <div class="caixa_conteudo">
                        <div class="row">
                            <div class="col-12">
                                <?php if ($this->session->usuario->usuario_tipo == 'administrador') { ?> 
                                    <button type="button" class="btn btn-sm btn-outline-success mb-3" id="reuniao_botao_cadastrar"
                                            onclick="abrir_modal_reuniao()">
                                        <i class="fas fa-plus mr-1"></i>
                                        Cadastrar
                                    </button>
                                <?php } ?>
                                <table id="reuniao_tabela" class="table table-striped table-bordered table-sm w-100"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!-- Fim do conteúdo da página -->

<!-- Modal de cadastro/edição de Reuniões -->
<div class="modal fade modal_cadastro" id="modal_cadastro_reuniao" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_reuniao_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_reuniao" action="javascript:salvar_reuniao()" enctype="multipart/form-data" novalidate>
                    <input type="hidden" id="reuniao_id" name="reuniao_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="reuniao_descricao">Descrição</label>
                                <textarea name="reuniao_descricao" id="reuniao_descricao" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="data_hora_reuniao">Data e Hora</label>
                                <input type="datetime-local" class="form-control" id="reuniao_data_hora" name="reuniao_data_hora"></input>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for=reuniao_status">Status</label>
                                <select class="form-control" id="reuniao_status" name="reuniao_status">
                                    <option value="">Selecione</option>
                                    <option value="agendada">Agendada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="reuniao_ata">Ata</label><br>
                                <button type="button" class="btn btn-sm btn-info mr-2" id="reuniao_botao_up_ata">
                                    <i class="fas fa-upload mr-2"></i>
                                    Enviar ata
                                </button>
                                <span class="text-muted" id="arquivo">Nenhum arquivo selecionado</span>
                                <input type="file" name="reuniao_ata" id="reuniao_ata" class="d-none">
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
                <button type="button" class="btn btn-sm btn-outline-success" id="reuniao_botao_salvar" onclick="salvar_reuniao()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do mocal de cadastro/edição de Reuniões -->
