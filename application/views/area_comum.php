<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- View de administração de áreas comuns -->
<button type="button" class="btn btn-sm btn-outline-success mb-3" id="area_comum_botao_cadastrar"
        onclick="abrir_modal_area_comum()">
    Cadastrar
</button>
<table id="area_comum_tabela" class="table table-striped table-bordered table-sm w-100"></table>
<!-- Fim da view de administração de áreas comuns -->

<!-- Modal de cadastro/edição de áreas comuns -->
<div class="modal fade modal_cadastro" id="modal_cadastro_area_comum" tabindex="-1" role="dialog" aria-hidde="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_area_comum_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_area_comum" action="javascript:salvar_area_comum()" novalidate>
                    <input type="hidden" id="area_comum_id" name="area_comum_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="area_comum_nome">Nome</label>
                                <input type="text" class="form-control" id="area_comum_nome" name="area_comum_nome">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="area_comum_lotacao">Lotação Máxima</label>
                                <input type="number" class="form-control" id="area_comum_lotacao_maxima" name="area_comum_lotacao_maxima">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="area_comum_hora_abertura">Hora de Abertura</label>
                                <input type="time" class="form-control" id="area_comum_hora_abertura" name="area_comum_hora_abertura">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="area_comum_hora_fechamento">Hora de Fechamento</label>
                                <input type="time" class="form-control" id="area_comum_hora_fechamento" name="are_comum_hora_fechamento">
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
                <button type="button" class="btn btn-sm btn-outline-success" id="area_comum_botao_salvar" onclick="salvar_area_comum()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do modal de cadastro/edição de áreas comuns -->
