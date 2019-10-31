<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- View de administração de Lotes -->
<button type="button" class="btn btn-sm btn-outline-success mb-3" id="lote_botao_cadastrar" 
        onclick="abrir_modal_lote()">
    <i class="fas fa-plus mr-1"></i>
    Cadastrar
</button>
<table id="lote_tabela" class="table table-striped table-bordered table-sm w-100"></table>
<!-- Fim da view de administração de Lotes -->

<!-- Modal de cadastro/edição de Lotes -->
<div class="modal fade modal_cadastro" id="modal_cadastro_lote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_lote_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_lote" action="javascript:salvar_lote()" novalidate>
                    <input type="hidden" id="lote_id" name="lote_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lote_numero">Número</label>
                                <input type="number" class="form-control" id="lote_numero" name="lote_numero">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lote_area">Área</label>
                                <input type="text" class="form-control" id="lote_area" name="lote_numero" data-mask='#.##0,00 m²' data-mask-reverse="true" data-mask>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="lote_descricao">Descrição</label>
                                <textarea class="form-control"id="lote_descricao" name="lote_descricao"></textarea>
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
                <button type="button" class="btn btn-sm btn-outline-success" id="lote_botao_salvar" onclick="salvar_lote()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do modal de cadastro/edição de Lotes -->
