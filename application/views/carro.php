<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Modal de exibição dos carros de um determinado visitante -->
<div class="modal fade modal_cadastro" id="modal_exibicao_carros" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_exibicao_carros_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-sm btn-outline-success mb-3" id="carro_botao_cadastrar" 
                        onclick="abrir_modal_carro_edicao()">
                    <i class="fas fa-plus mr-1"></i>
                    Cadastrar
                </button>
                <table id="carro_tabela" class="table table-striped table-bordered table-sm w-100"></table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do modal de exibição dos carros de um determinado visitante -->

<!-- Modal de cadastro/edição dos carros -->
<div class="modal fade modal_cadastro" id="modal_cadastro_carros" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_cadastro_carros_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_carro" action="javascript:salvar_carro()" novalidate>
                    <input type="hidden" id="carro_id" name="carro_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="carro_placa">Placa</label>
                                <input type="text" class="form-control" id="carro_placa" name="carro_placa" data-mask="AAA-0000">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="carro_cor">Cor</label>
                                <input type="text" class="form-control" id="carro_cor" name="carro_cor">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="carro_marca">Marca</label>
                                <input type="text" class="form-control" id="carro_marca" name="carro_marca">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="carro_modelo">Modelo</label>
                            <input type="text" class="form-control" id="carro_modelo" name="carro_modelo">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-danger" 
                        data-dismiss="modal">
                    Fechar
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" id="carro_botao_salvar" onclick="salvar_carro()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>
