<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- View de administração de Condôminos -->
<button type="button" class="btn btn-sm btn-outline-success mb-3" id="condomino_botao_cadastrar"
        onclick="abrir_modal_condomino()">
    Cadastrar
</button>
<table id="condomino_tabela" class="table table-striped table-bordered table-sm w-100"></table>
<!-- Fim da view de administração de Condôminos -->

<!-- Modal de cadastro/edição de Condôminos -->
<div class="modal fade modal_cadastro" id="modal_cadastro_condomino" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_condomino_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="form_condomino" action="javascript:salvar_condomino()" novalidate>
                    <input type="hidden" id="condomino_id" name="condomino_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="condomino_cpf">CPF</label>
                                <input type="text" class="form-control" id="condomino_cpf" name="condomino_cpf">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="condomino_nome">Nome</label>
                                <input type="text" class="form-control" id="condomino_nome" name="condomino_nome">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="condomino_lote">Lote</label>
                                <?php echo form_dropdown('condomino_lote', $lotes_dropdown, '', 'class="form-control" style="width: 100%;" id="condomino_lote"') ?>
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
                <button type="button" class="btn btn-sm btn-outline-success" id="condomino_botao_salvar" onclick="salvar_condomino()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do modal de cadastro/edição de Condôminos -->
