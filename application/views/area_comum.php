<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Conteúdo da página -->
<main role="main" class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-11 m-auto">
                <div id="area_comum">
                    <div class="caixa_titulo">
                        <p class="h4 mb-0">Áreas Comuns</p>
                    </div>
                    <div class="caixa_conteudo">
                        <div class="row">
                            <div class="col-12">
                                <table id="area_comum_tabela" class="table table-striped table-bordered table-sm w-100"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-11 mt-5 mx-auto">
                <div id="area_comum_reservas">
                    <div class="caixa_titulo">
                        <p class="h4 mb-0">Reservas</p>
                    </div>
                    <div class="caixa_conteudo">
                        <div class="row">
                            <div class="col-12">
                                <div id="fullcalendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!-- Fim do conteúdo da página -->

<!-- Modal de reserva de Áreas comuns -->
<div class="modal fade modal_cadastro" id="modal_reserva_area_comum" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_reserva_area_comum_titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_reserva_area_comum" action="javascript:salvar_reserva()" novalidate>
                    <input type="hidden" id="reserva_id" name="reserva_id">
                    <input type="hidden" id="area_comum_id_reserva" name="area_comum_id_reserva">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="reserva_data_inicio">De</label>
                                <input type="datetime-local" class="form-control" id="reserva_data_inicio" name="reserva_data_inicio"></input>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="reserva_data_fim">Até</label>
                                <input type="datetime-local" class="form-control" id="reserva_data_fim" name="reserva_data_fim"></input>
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
                <button type="button" class="btn btn-sm btn-outline-success" id="reserva_botao_salvar" onclick="salvar_reserva()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div> <!-- Fim do mocal de cadastro/edição de Reuniões -->
