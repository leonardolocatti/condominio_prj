// Tabela de visitas
var visita_tabela;

/**
 * Carrega a tabela de visita com as visitas cadastrados no banco de dados.
 * 
 * @return {void}
 */
function carregar_visita_tabela () {
    if ($.fn.DataTable.isDataTable('#visita_tabela')) {
        visita_tabela.ajax.reload();
    } else {
        visita_tabela = $('#visita_tabela').DataTable({
            'processing': true,
            'serverSide': true,
            'searching': false,
            'destroy': true,
            'autoWidth': false,
            'language': {
                'url': base_url + '/application/assets/datatables/portugues.json',
            },
            'ajax': {
                'url': site_url + '/visita/visita_tabela',
                'type': 'post',
                'dataType': 'json',
                'data': function (data) {

                },
            },
            'columns': [
                { 'title': 'ID', 'className': 'align-middle', 'name': 'visita.visita_id', 'data': 'visita_id', 'width': '30px' },
                { 'title': 'Visitante', 'className': 'align-middle', 'name': 'visitante.visitante_nome', 'data': 'visitante_nome', 'width': '' },
                { 'title': 'Carro', 'className': 'align-middle', 'name': 'carro.carro_modelo', 'data': 'carro', 'width': '' },
                { 'title': 'Condômino', 'className': 'align-middle', 'name': 'condomino.condomino_nome', 'data': 'condomino_nome', 'width': '' },
                { 'title': 'Entrada', 'className': 'align-middle', 'name': 'visita.visita_entrada', 'data': 'visita_entrada', 'width': '' },
                { 'title': 'Opções', 'className': 'align-middle text-center', 'data': 'opcoes', 'sortable': false, 'width': '60px' },
            ],
        });
    }
}

// /**
//  * Abre o modal de cadastro/edição de visitas.
//  * 
//  * @param  {int} lote_id ID do lote que será editado. Se não for passado nenhum ID, será aberto como cadastro.
//  * @return {void}
//  */ 
// function abrir_modal_lote (lote_id = 0) {
//     $('#lote_id').val(lote_id);

//     if (lote_id > 0) {
//         $('#modal_cadastro_lote_titulo').html('Editar Lote');
//         carregar_dados_lote(lote_id);
//     } else {
//         $('#modal_cadastro_lote_titulo').html('Cadastrar Lote');
//     }

//     $('#modal_cadastro_lote').modal('show');
// }

// /**
//  * Limpa o modal do lote.
//  * 
//  * @return {void}
//  */
// function limpar_modal_lote () {
//     $('#lote_id').val('0');
//     $('#lote_numero').val('');
//     $('#lote_area').val('');
//     $('#lote_descricao').val('');

//     limpar_validacao($('#lote_numero'));
//     limpar_validacao($('#lote_area'));
//     limpar_validacao($('#lote_descricao'));
// }

// /**
//  * Busca as informações do lote e preenche os campos do modal
//  * 
//  * @param  {int} lote_id ID do lote que será buscado
//  * @return {void}
//  */
// function carregar_dados_lote (lote_id) {
//     $.ajax({
//         url: site_url + '/lote/dados_lote',
//         type: 'post',
//         dataType: 'json',
//         data: {
//             lote_id: lote_id,
//         },        
//     })
//     .done(function (resposta) {
//         $('#lote_numero').val(resposta.lote_numero);
//         $('#lote_area').val(resposta.lote_area).trigger('keyup');
//         $('#lote_descricao').val(resposta.lote_descricao);
//     })
//     .fail(function (erro) {
//         exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
//     });
// }

// /**
//  * Envia as informações para o controller salvar os dados do lote no banco de dados.
//  * 
//  * @return {void}
//  */
// function salvar_lote () {
//     if (validar_campos_lote()) {
//         $.ajax({
//             url: site_url + '/lote/salvar_lote',
//             type: 'post',
//             dataType: 'json',
//             data: {
//                 lote_id:        $('#lote_id').val(),
//                 lote_numero:    $('#lote_numero').val(),
//                 lote_area:      $('#lote_area').val(),
//                 lote_descricao: $('#lote_descricao').val(),
//             },
//         })
//         .done(function (resposta) {
//             if (resposta.status == '1') {
//                 exibir_modal('ok', 'sucesso', 'Lote salvo', resposta.mensagem,
//                     function () {
//                         $('#modal_cadastro_lote').modal('hide');
//                         carregar_lote_tabela();
//                     }
//                 );
//             } else {
//                 exibir_modal('ok', 'alerta', 'Erro ao salvar', resposta.mensagem);
//             }
//         })
//         .fail(function (erro) {
//             exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
//         });
//     }
// }

// /**
//  * Valida os campos do lote.
//  * 
//  * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
//  */
// function validar_campos_lote () {
//     var valido = true;

//     if ( ! validar_campo($('#lote_numero'), false)) {
//         valido = false;
//     }

//     if ( ! validar_campo($('#lote_area'), false)) {
//         valido = false;
//     }

//     if ( ! validar_campo($('#lote_descricao'), false)) {
//         valido = false;
//     }

//     return valido;
// }

// /**
//  * Confirma a exclusão e envia os dados para o controller excluir.
//  * 
//  * @param  {int} lote_id ID do lote que será excluído.
//  * @return {void}
//  */
// function excluir_lote (lote_id) {
//     exibir_modal('sim_nao', 'alerta', 'Deseja excluir?', 'Tem certeza que deseja excluir o lote?',
//         function () {
//             $.ajax({
//                 url: site_url + '/lote/excluir_lote',
//                 type: 'post',
//                 dataType: 'json',
//                 data: {
//                     lote_id: lote_id,
//                 },
//             })
//             .done(function (resposta) {
//                 if (resposta.status == '1') {
//                     exibir_modal('ok', 'sucesso', 'Lote excluído', resposta.mensagem, 
//                         function () {
//                             carregar_lote_tabela();
//                         }
//                     );
//                 } else {
//                     exibir_modal('ok', 'alerta', 'Lote não excluído', resposta.mensagem);
//                 }
//             })
//             .fail(function (erro) {
//                 exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText + '.');
//             });
//         }
//     );
// }

$(document).ready(function () {
    carregar_visita_tabela();

    // // Limpa os dados do modal ao fechar
    // $('#modal_cadastro_lote').on('hidden.bs.modal', function () {
    //     limpar_modal_lote();
    // });
});
