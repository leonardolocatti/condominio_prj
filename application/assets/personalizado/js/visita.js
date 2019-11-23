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
                    data.usuario = $('#usuario_busca').val();
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
            'dom': 'B',
            'buttons': [
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],
        });
    }
}

$(document).ready(function () {
    carregar_visita_tabela();
});
