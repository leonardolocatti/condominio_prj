// Tabela de reuniões
var reuniao_tabela;

/**
 * Carrega a tabela de reunião com as reuniões cadastradas no banco de dados.
 * 
 * @return {void}
 */
function carregar_reuniao_tabela () {
    if ($.fn.DataTable.isDataTable('#reuniao_tabela')) {
        reuniao_tabela.ajax.reload();
    } else {
        reuniao_tabela = $('#reuniao_tabela').DataTable({
            'processing': true,
            'serverSide': true,
            'searching': false,
            'destroy': true,
            'language': {
                'url': base_url + '/application/assets/datatables/portugues.json',
            },
            'ajax': {
                'url': site_url + '/reuniao/reuniao_tabela',
                'type': 'post',
                'dataType': 'json',
                'data': function (data) {

                },
            },
            'columns': [
                { 'title': 'ID', 'className': 'align-middle', 'name': 'reuniao.reuniao_id', 'data': 'reuniao_id' },
                { 'title': 'Descrição', 'className': 'align-middle', 'name': 'reuniao.reuniao_descricao', 'data': 'reuniao_descricao' },
                { 'title': 'Data e Hora', 'className': 'align-middle', 'name': 'reuniao.reuniao_data_hora', 'data': 'reuniao_data_hora' },
                { 'title': 'Status', 'className': 'align-middle', 'name': 'reuniao.reuniao_status', 'data': 'reuniao_status' },
                { 'title': 'Opções', 'className': 'align-middle', 'data': 'opcoes', 'sortable': false, 'width': '80px' },
            ],
        });
    }
}

/**
 * Abre o modal de cadastro/edição de reunião.
 * 
 * @param  {int}  reuniao_id ID da reunião que será editada. Se não for passado nenhum ID, será aberto como cadastro.
 * @return {void}
 */
function abrir_modal_reuniao (reuniao_id) {
    $('#reuniao_id').val(reuniao_id);

    if (reuniao_id > 0) {
        $('#modal_cadastro_reuniao_titulo').html('Editar Reunião');
        carregar_dados_reuniao(reuniao_id);
    } else {
        $('#modal_cadastro_reuniao_titulo').html('Cadastrar Reunião');
    }

    $('#modal_cadastro_reuniao').modal('show');
}

/**
 * Limpa o modal da reunião.
 * 
 * @return {void}
 */
function limpar_modal_reuniao () {
    $('#reuniao_id').val('0');
    $('#reuniao_descricao').val('');
    $('#reuniao_data_hora').val('');
    $('#reuniao_status').val('');

    limpar_validacao($('#reuniao_descricao'));
    limpar_validacao($('#reuniao_data_hora'));
    limpar_validacao($('#reuniao_status'));
}

/**
 * Busca as informações da reunião e preenche os campos do modal.
 * 
 * @param  {int}  reuniao_id ID da reunião que será buscada.
 * @return {void}
 */
function carregar_dados_reuniao (reuniao_id) {
    $.ajax({
        url: site_url + '/reuniao/dados_reuniao',
        type: 'post',
        dataType: 'json',
        data: {
            reuniao_id: reuniao_id,
        },
    })
    .done(function (resposta) {
        $('#reuniao_descricao').val(resposta.reuniao_descricao);
        $('#reuniao_data_hora').val(resposta.reuniao_data_hora);
        $('#reuniao_status').val(resposta.reuniao_status);
    })
    .fail(function (erro) {
        exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
    });
}

/**
 * Envia as informações para o controller salvar os dados da reunião no banco de dados.
 * 
 * @return {void}
 */
function salvar_reuniao () {
    if (validar_campos_reuniao()) {

        var formulario = new FormData($('#form_reuniao')[0]);

        $.ajax({
            url: site_url + '/reuniao/salvar_reuniao',
            type: 'post',
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            data: formulario,
        })
        .done(function (resposta) {
            if (resposta.status == '1') {
                exibir_modal('ok', 'sucesso', 'Reunião Salva', resposta.mensagem,
                    function () {
                        $('#modal_cadastro_reuniao').modal('hide');
                        carregar_reuniao_tabela();
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
 * Valida os campos da reunião.
 * 
 * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
 */
function validar_campos_reuniao () {
    var valido = true;

    if ( ! validar_campo($('#reuniao_descricao'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#reuniao_data_hora'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#reuniao_status'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Confirma a exclusão e envia os dados para o controller excluir.
 * 
 * @param  {int}  reuniao_id ID da reunião que será excluída.
 * @return {void}
 */
function excluir_reuniao (reuniao_id) {
    exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir a reunião?',
        function () {
            $.ajax({
                url: site_url + '/reuniao/excluir_reuniao',
                type: 'post',
                dataType: 'json',
                data: {
                    reuniao_id: reuniao_id,
                },
            })
            .done(function (resposta) {
                if (resposta.status == '1') {
                    exibir_modal('ok', 'sucesso', 'Reunião excluída', resposta.mensagem,
                        function () {
                            carregar_reuniao_tabela();
                        }
                    );
                } else {
                    exibir_modal('ok', 'alerta', 'Reunião não excluída', resposta.mensagem);
                }
            })
            .fail(function (erro) {
                exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
            });
        }
    )
}

/**
 * Baixar ata da reunião.
 * 
 * @param  {int}  reuniao_id ID da reunião que terá a ata baixada.
 * @return {void}
 */
function baixar_ata (reuniao_id) {
    window.location.href = site_url + '/reuniao/baixar_ata/' + reuniao_id;
}

$(document).ready(function () {
    carregar_reuniao_tabela();

    // Limpa os dados do modal ao fechar
    $('#modal_cadastro_reuniao').on('hidden.bs.modal', function () {
        limpar_modal_reuniao();
    });

    $('#reuniao_botao_up_ata').on('click', function () {
        $('#reuniao_ata').click();
    });

    $('#reuniao_ata').on('change', function () {
        $('#arquivo').html($(this.files[0]).attr('name'));
    });
});
