// Tabela de áreas comuns
var area_comum_tabela;

/**
 * Carrega a tabela de área comum com as áreas comuns cadastradas no banco de dados.
 * 
 * @return {void}
 */
function carregar_area_comum_tabela () {
    if ($.fn.DataTable.isDataTable('#area_comum_tabela')) {
        area_comum_tabela.ajax.reload();
    } else {
        area_comum_tabela = $('#area_comum_tabela').DataTable({
            'processing': true,
            'serverSide': true,
            'searching': false,
            'destroy': true,
            'language': {
                'url': base_url + '/application/assets/datatables/portugues.json',
            },
            'ajax': {
                'url': site_url + '/area_comum/area_comum_tabela',
                'type': 'post',
                'dataType': 'json',
                'data': function (data) {
                    
                },
            },
            'columns': [
                { 'title': 'ID', 'className': 'align-middle', 'name': 'area_comum.area_comum_id', 'data': 'area_comum_id' },
                { 'title': 'Nome', 'className': 'align-middle', 'name': 'area_comum.area_comum_nome', 'data': 'area_comum_nome' },
                { 'title': 'Lotação', 'className': 'align-middle', 'name': 'area_comum.area_comum_lotacao_maxima', 'data': 'area_comum_lotacao_maxima' },
                { 'title': 'Hora de Abertura', 'className': 'align-middle', 'name': 'area_comum.area_comum_hora_abertura', 'data': 'area_comum_hora_abertura' },
                { 'title': 'Hora de Fechamento', 'className': 'align-middle', 'name': 'area_comum.area_comum_hora_fechamento', 'data': 'area_comum_hora_fechamento' },
                { 'title': 'Opções', 'className': 'align-middle', 'data': 'opcoes', 'sortable': false, 'width': '80px' },
            ],
        });
    }
}

/**
 * Abre o modal de cadastro/edição de áreas comuns.
 * 
 * @param  {int} area_comum_id ID da área comum que será editada. Se não for passado nenhum ID, será aberto como cadastro.
 * @return {void}
 */
function abrir_modal_area_comum (area_comum_id = 0) {
    $('#area_comum_id').val(area_comum_id);

    if (area_comum_id > 0) {
        $('#modal_cadastro_area_comum_titulo').html('Editar Área Comum');
        carregar_dados_area_comum(area_comum_id);
    } else {
        $('#modal_cadastro_area_comum_titulo').html('Cadastrar Área Comum');
    }

    $('#modal_cadastro_area_comum').modal('show');
}

/**
 * Limpa o modal da área comum
 * 
 * @return {void}
 */
function limpar_modal_area_comum () {
    $('#area_comum_id').val('0');
    $('#area_comum_nome').val('');
    $('#area_comum_lotacao_maxima').val('');
    $('#area_comum_hora_abertura').val('');
    $('#area_comum_hora_fechamento').val('');

    limpar_validacao($('#area_comum_nome'));
    limpar_validacao($('#area_comum_lotacao_maxima'));
    limpar_validacao($('#area_comum_hora_abertura'));
    limpar_validacao($('#area_comum_hora_fechamento'));
}

/**
 * Busca as informações da área comum e preenche os campos do modal
 * 
 * @param  {int} area_comum_id ID da área comum que será buscada
 * @return {void}
 */
function carregar_dados_area_comum (area_comum_id) {
    $.ajax({
        url: site_url + '/area_comum/dados_area_comum',
        type: 'post',
        dataType: 'json',
        data: {
            area_comum_id: area_comum_id,
        },
    })
    .done(function (resposta) {
        $('#area_comum_nome').val(resposta.area_comum_nome);
        $('#area_comum_lotacao_maxima').val(resposta.area_comum_lotacao_maxima);
        $('#area_comum_hora_abertura').val(resposta.area_comum_hora_abertura);
        $('#area_comum_hora_fechamento').val(resposta.area_comum_hora_fechamento);
    })
    .fail(function (erro) {
        exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
    });
}

/**
 * Envia as informações para o controller salvar os dados da área comum no banco de dados.
 * 
 * @return {void}
 */
function salvar_area_comum () {
    if (validar_campos_area_comum()) {
        $.ajax({
            url: site_url + '/area_comum/salvar_area_comum',
            type: 'post',
            dataType: 'json',
            data: {
                area_comum_id: $('#area_comum_id').val(),
                area_comum_nome: $('#area_comum_nome').val(),
                area_comum_lotacao_maxima: $('#area_comum_lotacao_maxima').val(),
                area_comum_hora_abertura: $('#area_comum_hora_abertura').val(),
                area_comum_hora_fechamento: $('#area_comum_hora_fechamento').val(),
            },
        })
        .done(function (resposta) {
            if (resposta.status == '1') {
                exibir_modal('ok', 'sucesso', 'Área comum salva', resposta.mensagem,
                    function () {
                        $('#modal_cadastro_area_comum').modal('hide');
                        carregar_area_comum_tabela();
                    }
                );
            } else {
                exibir_modal('ok', 'alerta', 'Erro ao salvar', resposta.mensagem);
            }
        })
        .fail(function (erro) {
            exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
        });
    }
}

/**
 * Valida os campos da área comum.
 * 
 * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
 */
function validar_campos_area_comum () {
    var valido = true;

    if ( ! validar_campo($('#area_comum_nome'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#area_comum_lotacao_maxima'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#area_comum_hora_abertura'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#area_comum_hora_fechamento'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Confirma a exclusão e envia os dados para o controller excluir.
 * 
 * @param  {int} area_comum_id ID da área comum que será excluída.
 * @return {void}
 */
function excluir_area_comum (area_comum_id) {
    exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir a área comum?',
        function () {
            $.ajax({
                url: site_url + '/area_comum/excluir_area_comum',
                type: 'post',
                dataType: 'json',
                data: {
                    area_comum_id: area_comum_id,
                },
            })
            .done(function (resposta) {
                if (resposta.status == '1') {
                    exibir_modal('ok', 'sucesso', 'Área comum excluída', resposta.mensagem,
                        function () {
                            carregar_area_comum_tabela();
                        }
                    );
                } else {
                    exibir_modal('ok', 'alerta', 'Área comum não excluída', resposta.mensagem);
                }
            })
            .fail(function (erro) {
                exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
            });            
        }
    );
}

$(document).ready(function () {
    carregar_area_comum_tabela();

    // Limpa os dados do modal ao fechar
    $('#modal_cadastro_area_comum').on('hidden.bs.modal', function () {
        limpar_modal_area_comum();
    });
});
