// Tabela de carros
var carro_tabela;

/**
 * Carrega a tabela de carros com os carros cadastrados no banco de dados.
 * 
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
}

/**
 * Abre o modal de visualização de carros.
 * 
 * @param {int} visitante_id 
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
 * @param  {int} carro_id ID do carro que será editado. Se carro_id for 0, abrirá como cadastro.
 * @return {void}
 */
function abrir_modal_carro_edicao (carro_id) {


    if (carro_id > 0) {
        $('#modal_cadastro_carros_titulo').html('Editar Carro');
        // carregar_dados_carro(carro_id);
    } else {
        $('#modal_cadastro_carros_titulo').html('Cadastrar Carro');
    }

    $('#modal_cadastro_carros').modal('show');
}

// /**
//  * Limpa o modal da área comum
//  * 
//  * @return {void}
//  */
// function limpar_modal_area_comum () {
//     $('#area_comum_id').val('0');
//     $('#area_comum_nome').val('');
//     $('#area_comum_lotacao_maxima').val('');
//     $('#area_comum_hora_abertura').val('');
//     $('#area_comum_hora_fechamento').val('');

//     limpar_validacao($('#area_comum_nome'));
//     limpar_validacao($('#area_comum_lotacao_maxima'));
//     limpar_validacao($('#area_comum_hora_abertura'));
//     limpar_validacao($('#area_comum_hora_fechamento'));
// }

// /**
//  * Busca as informações da área comum e preenche os campos do modal
//  * 
//  * @param  {int} area_comum_id ID da área comum que será buscada
//  * @return {void}
//  */
// function carregar_dados_area_comum (area_comum_id) {
//     $.ajax({
//         url: site_url + '/area_comum/dados_area_comum',
//         type: 'post',
//         dataType: 'json',
//         data: {
//             area_comum_id: area_comum_id,
//         },
//     })
//     .done(function (resposta) {
//         $('#area_comum_nome').val(resposta.area_comum_nome);
//         $('#area_comum_lotacao_maxima').val(resposta.area_comum_lotacao_maxima);
//         $('#area_comum_hora_abertura').val(resposta.area_comum_hora_abertura);
//         $('#area_comum_hora_fechamento').val(resposta.area_comum_hora_fechamento);
//     })
//     .fail(function (erro) {
//         exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
//     });
// }

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

// /**
//  * Confirma a exclusão e envia os dados para o controller excluir.
//  * 
//  * @param  {int} area_comum_id ID da área comum que será excluída.
//  * @return {void}
//  */
// function excluir_area_comum (area_comum_id) {
//     exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir a área comum?',
//         function () {
//             $.ajax({
//                 url: site_url + '/area_comum/excluir_area_comum',
//                 type: 'post',
//                 dataType: 'json',
//                 data: {
//                     area_comum_id: area_comum_id,
//                 },
//             })
//             .done(function (resposta) {
//                 if (resposta.status == '1') {
//                     exibir_modal('ok', 'sucesso', 'Área comum excluída', resposta.mensagem,
//                         function () {
//                             carregar_area_comum_tabela();
//                         }
//                     );
//                 } else {
//                     exibir_modal('ok', 'alerta', 'Área comum não excluída', resposta.mensagem);
//                 }
//             })
//             .fail(function (erro) {
//                 exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
//             });            
//         }
//     );
// }

// $(document).ready(function () {
//     carregar_area_comum_tabela();

//     // Limpa os dados do modal ao fechar
//     $('#modal_cadastro_area_comum').on('hidden.bs.modal', function () {
//         limpar_modal_area_comum();
//     });
// });
