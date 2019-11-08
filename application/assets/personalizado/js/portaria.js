/**
 * Busca o visitante para saber se já está cadastrado.
 * Se já estiver preenche os dados do visitante no formulário, caso não esteja abre
 * um dialog para perguntando se deseja cadastrar o visitante.
 * 
 * @return {void}
 */
function buscar_dados_visitantes () {
    if (validar_cpf($('#visitante_cpf'))) {
        $.ajax({
            url: site_url + '/visitante/buscar_visitante',
            type: 'post',
            dataType: 'json',
            data: {
                visitante_cpf: $('#visitante_cpf').val(),
            }
        })
        .done(function (resposta) {
            if (resposta.status == '0') {
                exibir_modal('sim_nao', 'informacao', 'Visitante não cadastrado.', 'Visitante não cadastrado. Deseja cadastrá-lo?',
                    function () {
                        abrir_modal_cadastro_visitante();
                    }  
                );
            } else if (resposta.status == '1') {
                $('#visitante_condomino').removeAttr('disabled');
                $('#visitante_botao_editar').removeAttr('disabled');
                switch (resposta.tipo) {
                    case 'funcionario':
                        $('#visitante_nome').val(resposta.funcionario.funcionario_nome);
                        break;
                    case 'visitante':
                        $('#visitante_id').val(resposta.visitante.visitante_id);
                        $('#visitante_nome').val(resposta.visitante.visitante_nome);
                        break;
                }
            }
        })
        .fail(function (erro) {
            exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
        });
    }
}

/**
 * Abre o modal para cadastro/edição de visitantes.
 * 
 * @param  {int} visitante_id ID do visitante que será editado. Se não for passado nenhum ID, será aberto como cadastro.
 * @return {void}
 */
function abrir_modal_cadastro_visitante (visitante_id) {
    $('#modal_cadastro_visitante #visitante_id').val(visitante_id);

    if (visitante_id > 0) {
        $('#modal_cadastro_visitante_titulo').html('Editar Visitante');
        buscar_dados_visitantes_edicao(visitante_id);
    } else {
        $('#modal_cadastro_visitante #visitante_cpf').val($('#visitante_cpf').val());
        $('#modal_cadastro_visitante_titulo').html('Cadastrar Visitante');
    }

    $('#modal_cadastro_visitante').modal('show');
}

/**
 * Envia as informações para o controller salvar os dados do visitante no banco de dados.
 * 
 * @return {void}
 */
function salvar_visitante () {
    if (validar_campos_cadastro_visitante()) {
        $.ajax({
            url: site_url + '/visitante/salvar_visitante',
            type: 'post',
            dataType: 'json',
            data: {
                visitante_id: $('#visitante_id').val(),
                visitante_cpf: $('#modal_cadastro_visitante #visitante_cpf').val(),
                visitante_nome: $('#modal_cadastro_visitante #visitante_nome').val(),
            }
        })
        .done(function (resposta) {
            if (resposta.status == '1') {
                exibir_modal('ok', 'sucesso', 'Visitante Salvo', resposta.mensagem,
                    function () {
                        $('#modal_cadastro_visitante').modal('hide');
                        buscar_dados_visitantes();
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
 * Valida os campos do visitante.
 * 
 * @return {boolean} Retorna verdadeiro caso os dados sejam validados e falso caso contrário.
 */
function validar_campos_cadastro_visitante () {
    var valido = true;

    if ( ! validar_campo($('#modal_cadastro_visitante #visitante_nome'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Limpa o modal de cadastro de visitante.
 * 
 * @return {void}
 */
function limpar_modal_cadastro_visitante () {
    $('#modal_cadastro_visitante #visitante_cpf').val('');
    $('#modal_cadastro_visitante #visitante_nome').val('');

    limpar_validacao($('#modal_cadastro_visitante #visitante_nome'));
}

/**
 * Busca as informações do visitante e preenche os campos do modal
 * 
 * @param  {int} visitante_id ID do visitante que será buscado.
 * @return {void}
 */
function buscar_dados_visitantes_edicao (visitante_id) {
    $.ajax({
        url: site_url + '/visitante/visitante_dados',
        type: 'post',
        dataType: 'json',
        data: {
            visitante_id: visitante_id,
        }
    })
    .done(function (resposta) {
        $('#modal_cadastro_visitante #visitante_cpf').val(resposta.visitante_cpf);
        $('#modal_cadastro_visitante #visitante_nome').val(resposta.visitante_nome);
    })
    .fail(function (erro) {
        exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
    });
}

$(document).ready(function () {
    $('#visitante_cpf').on('change', function () {
        buscar_dados_visitantes();
    });

    $('#visitante_botao_editar').on('click', function () {
        abrir_modal_cadastro_visitante($('#visitante_id').val());
    });

    // Limpa os dados do modal ao fechar
    $('#modal_cadastro_visitante').on('hidden.bs.modal', function () {
        limpar_modal_cadastro_visitante();
    });
});
