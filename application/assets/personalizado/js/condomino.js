// Tabela de condôminos
var condomino_tabela;

/**
 * Carrega a tabela de condôminos com os condôminos cadastrados no banco de dados.
 * 
 * @return {void}
 */
function carregar_condomino_tabela () {
    if ($.fn.DataTable.isDataTable('#condomino_tabela')) {
        condomino_tabela.ajax.reload();
    } else {
        condomino_tabela = $('#condomino_tabela').DataTable({
            'processing': true,
            'serverSide': true,
            'searching': false,
            'destroy': true,
            'autoWidth': false,
            'language': {
                'url': base_url + '/application/assets/datatables/portugues.json',
            },
            'ajax': {
                'url': site_url + '/condomino/condomino_tabela',
                'type': 'post',
                'dataType': 'json',
                'data': function (data) {

                },
            },
            'columns': [
                { 'title': 'ID', 'className': 'align-middle', 'name': 'condomino.condomino_id', 'data': 'condomino_id', 'width': '30px' },
                { 'title': 'Nome', 'className': 'align-middle', 'name': 'condomino.condomino_nome', 'data': 'condomino_nome', 'width': '200px' },
                { 'title': 'CPF', 'className': 'align-middle', 'name': 'condomino.condomino_cpf', 'data': 'condomino_cpf', 'width': '100px' },
                { 'title': 'Lote', 'className': 'align-middle', 'name': 'lote.lote_numero', 'data': 'condomino_lote' },
                { 'title': 'Opções', 'className': 'align-middle text-center', 'data': 'opcoes', 'sortable': false, 'width': '60px'},
            ]
        });
    }
}

/**
 * Abre o modal de cadastro/edição de condôminos.
 * 
 * @param  {int} condomino_id ID do condômino que será editado. Se não for passado nenhum ID, será aberto como cadastro.
 * @return {void}
 */
function abrir_modal_condomino (condomino_id = 0) {
    $('#condomino_id').val(condomino_id);

    if (condomino_id > 0) {
        $('#modal_cadastro_condomino_titulo').html('Editar Condômino');
        carregar_dados_condomino(condomino_id);
    } else {
        $('#modal_cadastro_condomino_titulo').html('Cadastrar Condômino');
    }

    $('#modal_cadastro_condomino').modal('show');
}

/**
 * Limpa o modal do lote.
 * 
 * @return {void}
 */
function limpar_modal_condomino () {
    $('#condomino_id').val('0');
    $('#condomino_cpf').val('');
    $('#condomino_nome').val('');
    $('#condomino_lote').val('');

    limpar_validacao($('#condomino_cpf'));
    limpar_validacao($('#condomino_nome'));
    limpar_validacao($('#condomino_lote'));
}

/**
 * Busca as informações do condômino e preench os campos do modal
 * 
 * @param  {int} condomino_id ID do condômino que será buscado.
 * @return {void}
 */
function carregar_dados_condomino (condomino_id) {
    $.ajax({
        url: site_url + '/condomino/dados_condomino',
        type: 'post',
        dataType: 'json',
        data: {
            condomino_id: condomino_id,
        },
    })
    .done(function (resposta) {
        $('#condomino_cpf').val(resposta.condomino_cpf).trigger('keyup');
        $('#condomino_nome').val(resposta.condomino_nome);
        $('#condomino_lote').val(resposta.condomino_lote);
    })
    .fail(function (erro) {
        exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
    });
}

/**
 * Envia as informações para o controller salvar os dados do condômino no banco de dados.
 * 
 * @return {void}
 */
function salvar_condomino () {
    if (validar_campos_condomino()) {
        $.ajax({
            url: site_url + '/condomino/salvar_condomino',
            type: 'post',
            dataType: 'json',
            data: {
                condomino_id:   $('#condomino_id').val(),
                condomino_cpf:  $('#condomino_cpf').val(),
                condomino_nome: $('#condomino_nome').val(),
                condomino_lote: $('#condomino_lote').val(),
            },
        })
        .done(function (resposta) {
            if (resposta.status == '1') {
                exibir_modal('ok', 'sucesso', 'Condômino salvo', resposta.mensagem,
                    function () {
                        $('#modal_cadastro_condomino').modal('hide');
                        carregar_condomino_tabela();
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
 * Valida os campos do condômino.
 * 
 * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
 */
function validar_campos_condomino () {
    var valido = true;

    if ( ! validar_campo($('#condomino_cpf'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#condomino_nome'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#condomino_lote'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Confirma a exclusão e envia os dados para o controller excluir.
 * 
 * @param  {int} condomino_id ID do condômino que será excluído.
 * @return {void}
 */
function excluir_condomino (condomino_id) {
    exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir o condômino?',
        function () {
            $.ajax({
                url: site_url + '/condomino/excluir_condomino',
                type: 'post',
                dataType: 'json',
                data: {
                    condomino_id: condomino_id,
                }
            })
            .done(function (resposta) {
                if (resposta.status == '1') {
                    exibir_modal('ok', 'sucesso', 'Condômino excluído', resposta.mensagem, 
                        function () {
                            carregar_condomino_tabela();
                        }
                    );
                } else {
                    exibir_modal('ok', 'alerta', 'Condômino não excluído', resposta.mensagem);
                }
            })
            .fail(function (erro) {
                exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
            });
        }
    )
}

$(document).ready(function () {
    carregar_condomino_tabela();

    // Limpa os dados do modal ao fechar.
    $('#modal_cadastro_condomino').on('hidden.bs.modal', function () {
        limpar_modal_condomino();
    });
});
