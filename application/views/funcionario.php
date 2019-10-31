<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- View de administração de Funcionários -->
<button type="button" class="btn btn-sm btn-outline-success mb-3" id="funcionarios_botao_cadastrar"
        onclick="abrir_modal_funcionario()">
    <i class="fas fa-plus mr-1"></i>
    Cadastrar
</button>
<table id="funcionario_tabela" class="table table-striped table-bordered table-sm w-100"></table>
<!-- Fim da view de administração de funcionários -->

<!-- Modal de cadastro/edição de Funcionários -->
<div class="modal fade modal_cadastro" id="modal_cadastro_funcionario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_funcionario_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_funcionario" action="javascript:salvar_funcionario()" novalidate>
                    <input type="hidden" id="funcionario_id" name="funcionario_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="funcionario_cpf">CPF</label>
                                <input type="text" class="form-control" id="funcionario_cpf" name="funcionario_cpf" data-mask="000.000.000-00">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="funcionario_nome">Nome</label>
                                <input type="text" class="form-control" id="funcionario_nome" name="funcionario_nome">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="funcionario_cargo">Cargo</label>
                                <?php echo form_dropdown('funcionario_cargo', $cargos_dropdown, '', 'class="form-control" style="width: 100%;" id="funcionario_cargo"') ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">
                    Fechar
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" id="funcionario_botao_salvar" onclick="salvar_funcionario()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do modal de cadastro/edição de Funcionários -->
