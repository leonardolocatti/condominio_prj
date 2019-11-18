// Tabela de carros
var carro_tabela;

/**
 * Carrega a tabela de carros com os carros cadastrados no banco de dados.
 * 
 * @param  {int}  visitante_id ID do visitante que terá os carros visualizados.
 * @return {void}
 */
function carregar_carro_tabela (visitante_id = 0) {
    if ($.fn.DataTable.isDataTable('#carro_tabela')) {
        carro_tabela.ajax.reload();
    } else {
        carro_tabela = $('#carro_tabela').DataTable({
            'processing': true,
            'serverSide': true,
            'searching': false,
            'destroy': true,
            'autoWidth': false,
            'language': {
                'url': base_url + '/application/assets/datatables/portugues.json',
            },
            'ajax': {
                'url': site_url + '/carro/carro_tabela',
                'type': 'post',
                'dataType': 'json',
                'data': function (data) {
                    data.visitante_id = $('#visitante_id').val();
                },
            },
            'columns': [
                { 'title': 'ID', 'className': 'align-middle', 'name': 'carro.carro_id', 'data': 'carro_id', 'width': '30px' },
                { 'title': 'Placa', 'className': 'align-middle', 'name': 'carro.carro_placa', 'data': 'carro_placa' },
                { 'title': 'Marca', 'className': 'align-middle', 'name': 'carro.carro_marca', 'data': 'carro_marca' },
                { 'title': 'Modelo', 'className': 'align-middle', 'name': 'carro.carro_modelo', 'data': 'carro_modelo' },
                { 'title': 'Cor', 'className': 'align-middle', 'name': 'carro.carro_cor', 'data': 'carro_cor' },
                { 'title': 'Opções', 'className': 'align-middle text-center', 'data': 'opcoes', 'sortable': false, 'width': '60px' },
            ],
        });
    }

    // Carrega o dropdown de carros na portaria
    if (window.location.href == site_url + '/portaria') {
        buscar_dados_visitantes();
    }
}

/**
 * Abre o modal de visualização de carros.
 * 
 * @param {int}  visitante_id 
 * @return {void}
 */
function abrir_modal_exibicao_carro (visitante_id) {
    $('#modal_exibicao_carros_titulo').html('Carros de ' + $('#visitante_nome').val());

    carregar_carro_tabela(visitante_id);

    $('#modal_exibicao_carros').modal('show');
}

/**
 * Abre o modal de cadastro/edição de carros.
 * 
 * @param  {int}  carro_id ID do carro que será editado. Se carro_id for 0, abrirá como cadastro.
 * @return {void}
 */
function abrir_modal_carro_edicao (carro_id) {
    if (carro_id > 0) {
        $('#modal_cadastro_carros_titulo').html('Editar Carro');
        carregar_dados_carro(carro_id);
    } else {
        $('#modal_cadastro_carros_titulo').html('Cadastrar Carro');
    }

    $('#modal_cadastro_carros').modal('show');
}

/**
 * Limpa o modal do carro
 * 
 * @return {void}
 */
function limpar_modal_carro () {
    $('#carro_id').val('0');
    $('#carro_placa').val('');
    $('#carro_cor').val('');
    $('#carro_marca').val('');
    $('#carro_modelo').val('');

    limpar_validacao($('#carro_placa'));
    limpar_validacao($('#carro_cor'));
    limpar_validacao($('#carro_marca'));
    limpar_validacao($('#carro_modelo'));
}

/**
 * Busca as informações do carro e preenche os campos do modal
 * 
 * @param  {int} carro_id ID do carro que será buscado
 * @return {void}
 */
function carregar_dados_carro (carro_id) {
    $.ajax({
        url: site_url + '/carro/dados_carro',
        type: 'post',
        dataType: 'json',
        data: {
            carro_id: carro_id,
        },
    })
    .done(function (resposta) {
        $('#carro_id').val(resposta.carro_id);
        $('#carro_placa').val(resposta.carro_placa);
        $('#carro_cor').val(resposta.carro_cor);
        $('#carro_marca').val(resposta.carro_marca);
        $('#carro_modelo').val(resposta.carro_modelo);
    })
    .fail(function (erro) {
        exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
    });
}

/**
 * Envia as informações para o controller salvar os dados do carro no banco de dados.
 * 
 * @return {void}
 */
function salvar_carro () {
    if (validar_campos_carro()) {
        $.ajax({
            url: site_url + '/carro/salvar_carro',
            type: 'post',
            dataType: 'json',
            data: {
                carro_id: $('#carro_id').val(),
                carro_placa: $('#carro_placa').val(),
                carro_cor: $('#carro_cor').val(),
                carro_marca: $('#carro_marca').val(),
                carro_modelo: $('#carro_modelo').val(),
                visitante_id: $('#visitante_id').val(),
            },
        })
        .done(function (resposta) {
            if (resposta.status == '1') {
                exibir_modal('ok', 'sucesso', 'Carro salvo', resposta.mensagem,
                    function () {
                        $('#modal_cadastro_carros').modal('hide');
                        carregar_carro_tabela($('#visitante_id'));
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
 * Valida os campos do carro.
 * 
 * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
 */
function validar_campos_carro () {
    var valido = true;

    if ( ! validar_campo($('#carro_placa'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#carro_cor'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#carro_marca'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#carro_modelo'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Confirma a exclusão e envia os dados para o controller excluir.
 * 
 * @param  {int}  carro_id ID do carro que será excluído.
 * @return {void}
 */
function excluir_carro (carro_id) {
    exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir o carro?',
        function () {
            $.ajax({
                url: site_url + '/carro/excluir_carro',
                type: 'post',
                dataType: 'json',
                data: {
                    carro_id: carro_id,
                },
            })
            .done(function (resposta) {
                if (resposta.status == '1') {
                    exibir_modal('ok', 'sucesso', 'Carro excluído', resposta.mensagem,
                        function () {
                            carregar_carro_tabela();
                        }
                    );
                } else {
                    exibir_modal('ok', 'alerta', 'Carro não excluído', resposta.mensagem);
                }
            })
            .fail(function (erro) {
                exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
            });            
        }
    );
}

$(document).ready(function () {
    $('#modal_cadastro_carros').on('hidden.bs.modal', function () {
        limpar_modal_carro();
    });
});
