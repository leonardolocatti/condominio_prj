/**
 * Valida os capos de login.
 * 
 * @return {boolean} Retorna verdadeiro caso sejam válidos e falso caso contrário.
 */
function validar_campos () {
    var valido = true;

    if ( ! validar_campo($('#login_usuario'), false)) {
        valido = false;
    }

    if ( ! validar_campo($('#login_senha'), false)) {
        valido = false;
    }

    return valido;
}

/**
 * Envia os dados de login para validação.
 * Caso o login seja realizado, redireciona para a tela inicial.
 * 
 * @return {void}
 */
function entrar () {
    if (validar_campos()) {
        $.ajax({
            url: site_url + '/login/login_entrar',
            type: 'post',
            dataType: 'json',
            data: {
                login_usuario: $('#login_usuario').val(),
                login_senha:   $('#login_senha').val(),
            },
            beforeSend: function () {
                $('#login_botao_entrar').attr('disabled', 'disabled');
            }
        })
        .always(function () {
            $('#login_botao_entrar').removeAttr('disabled');
        })
        .done(function (resposta) {
            switch (resposta.status) {
                case '0':
                    if (resposta.usuario_existe == '1') {
                        $('#login_usuario').addClass('is-valid');
                        $('#login_senha').addClass('is-invalid');
                    } else {
                        $('#login_usuario').addClass('is-invalid');
                    }
                    break;
                case '1':
                    window.location.href = site_url + '/home';
                    break;
                default:
                    exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: Resposta inválida.');
                    break;
            }
        })
        .fail(function (erro) {
            exibir_modal('ok', 'erro', 'Ocorreu um erro', 'Erro: ' + erro.status + '. ' + erro.statusText);
        });
    }
}
