// Tabela de funcionários
var funcionario_tabela;

/**
 * Carrega a tabela de funcionários com os funcionários cadastrados no banco de dados.
 * 
 * @return {void}
 */
function carregar_funcionario_tabela () {
    if ($.fn.DataTable.isDataTable('#funcionario_tabela')) {
        funcionario_tabela.ajax.reload();
    } else {
        funcionario_tabela = $('#funcionario_tabela').DataTable({
            'processing': true,
            'serverSide': true,
            'searching': false,
            'destroy': true,
            'autoWidth': false,
            'language': {
                'url': base_url + '/application/assets/datatables/portugues.json',
            },
            'ajax': {
                'url': site_url + '/funcionario/funcionario_tabela',
                'type': 'post',
                'dataType': 'json',
                'data': function (data) {

                },
            },
            'columns': [
                { 'title': 'ID', 'className': 'align-middle', 'name': 'funcionario.funcionario_id', 'data': 'funcionario_id', 'width': '30px' },
                { 'title': 'Nome', 'className': 'align-middle', 'name': 'funcionario.funcionario_nome', 'data': 'funcionario_nome' },
                { 'title': 'CPF', 'className': 'align-middle', 'name': 'funcionario.funcionario_cpf', 'data': 'funcionario_cpf' },
                { 'title': 'Cargo', 'className': 'align-middle', 'name': 'funcionario.funcionario_cargo', 'data': 'funcionario_cargo' },
                { 'title': 'Opções', 'className': 'align-middle', 'data': 'opcoes', 'sortable': false, 'width': '60px' },
            ]
        });
    }
}

/**
 * Abre o modal de cadastro/edição de funcionários.
 * 
 * @param  {int} funcionario_id ID do funcionário que será editado. Se não for passado nenhum ID será aberto como cadastro.
 * @return {void}
 */
function abrir_modal_funcionario (funcionario_id = 0) {
    $('#funcionario_id').val(funcionario_id);

    if (funcionario_id > 0) {
        $('#modal_cadastro_funcionario_titulo').html('Editar Funcionário');
        carregar_dados_funcionario(funcionario_id);
    } else {
        $('#modal_cadastro_funcionario_titulo').html('Cadastrar Funcionário');
    }

    $('#modal_cadastro_funcionario').modal('show');
}

/**
 * Limpa o modal do funcionário.
 * 
 * @return {void}
 */
function limpar_modal_funcionario () {
    $('#funcionario_id').val('0');
    $('#funcionario_cpf').val('');
    $('#funcionario_nome').val('');
    $('#funcionario_cargo').val('');

    limpar_validacao($('#funcionario_cpf'));
    limpar_validacao($('#funcionario_nome'));
    limpar_validacao($('#funcionario_cargo'));
}

/**
 * Busca as informações do funcionário e preenche os campos do modal
 * 
 * @param  {int} funcionario_id ID do funcionário que será buscado.
 * @return {void}
 */
function carregar_dados_funcionario (funcionario_id) {
    $.ajax({
        url: site_url + '/funcionario/dados_funcionario',
        type: 'post',
        dataType: 'json',
        data: {
            funcionario_id: funcionario_id,
        },
    })
    .done(function (resposta) {
        $('#funcionario_cpf').val(resposta.funcionario_cpf).trigger('keyup');
        $('#funcionario_nome').val(resposta.funcionario_nome);
        $('#funcionario_cargo').val(resposta.funcionario_cargo);
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
function salvar_funcionario () {
    if (validar_campos_funcionario()) {
        $.ajax({
            url: site_url + '/funcionario/salvar_funcionario',
            type: 'post',
            dataType: 'json',
            data: {
                funcionario_id:    $('#funcionario_id').val(),
                funcionario_cpf:   $('#funcionario_cpf').val(),
                funcionario_nome:  $('#funcionario_nome').val(),
                funcionario_cargo: $('#funcionario_cargo').val(),
            },
        })
        .done(function (resposta) {
            if (resposta.status == '1') {
                exibir_modal('ok', 'sucesso', 'Funcionário salvo', resposta.mensagem,
                    function () {
                        $('#modal_cadastro_funcionario').modal('hide');
                        carregar_funcionario_tabela();
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
 * Valida os campos do funcionário.
 * 
 * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
 */
function validar_campos_funcionario () {
    var valido = true;

    if ( ! validar_campo($('#funcionario_cpf'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#funcionario_nome'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#funcionario_cargo'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Confirma a exclusão e envia os dados para o controller excluir.
 * 
 * @param  {int} funcionario_id ID do funcionário que será excluído.
 * @return {void}
 */
function excluir_funcionario (funcionario_id) {
    exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir o funcionário?',
        function () {
            $.ajax({
                url: site_url + '/funcionario/excluir_funcionario',
                type: 'post',
                dataType: 'json',
                data: {
                    funcionario_id: funcionario_id,
                }
            })
            .done(function (resposta) {
                if (resposta.status == '1') {
                    exibir_modal('ok', 'sucesso', 'Funcionário excluído', resposta.mensagem, 
                        function () {
                            carregar_funcionario_tabela();
                        }
                    );
                } else {
                    exibir_modal('ok', 'alerta', 'Funcionário não excluído', resposta.mensagem);
                }
            })
            .fail(function (erro) {
                exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
            });
        }
    )
}

$(document).ready(function () {
    carregar_funcionario_tabela();

    // Limpa os dados do modal ao fechar
    $('#modal_cadastro_funcionario').on('hidden.bs.modal', function () {
        limpar_modal_funcionario();
    });
});
