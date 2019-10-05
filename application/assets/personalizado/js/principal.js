/**
 * Valida o campo passado verificando se está vazio.
 * 
 * @param  {JQuery}  campo            Elemento de entrada a ser validado.
 * @param  {boolean} marcar_validacao Indica se o campo deve ser marcado como válido.
 * @return {boolean} Retorna verdadeiro se o campo estiver preenchido e falso caso contrário.
 */
function validar_campo (campo, marcar_validacao = true) {
    limpar_validacao(campo);

    var valido = true;

    if ($(campo).val() !== '') {
        if (marcar_validacao) {
            $(campo).addClass('is-valid');
        }
    } else {
        $(campo).addClass('is-invalid');
        valido = false;
    }

    return valido;
}

/**
 * Limpa a validação do campo.
 *
 * @param  {JQuery} campo Elemento de entrada a ser validado.
 * @return {void}
 */
function limpar_validacao (campo) {
    $(campo).removeClass('is-valid');
    $(campo).removeClass('is-invalid');
}

/**
 * Exibe um modal na tela.
 * 
 * @param  {string}   botoes              Botões que serão exibidos no modal.
 * @param  {string}   tipo                Tipo do modal que será exibido.
 * @param  {string}   titulo              Título que será exibido no modal.
 * @param  {string}   mensagem            Mensagem que será exibida no modal.
 * @param  {function} funcao_ok_sim       Função executada ao clicar em no botão OK ou Sim.
 * @param  {function} funcao_cancelar_nao Função executada ao clicar no botão Cancelar ou Não.
 * @return {void}
 */
function exibir_modal (botoes, tipo, titulo, mensagem, funcao_ok_sim = null, funcao_cancelar_nao = null) {
    
    /* Insere a mensagem no alert correspondente ao tipo do modal. Define a cor do 
     * botão OK (quando somente este botão estará presente no modal) e do título do modal */
    var mensagem_modal;
    var classe_botao_ok;
    var classe_modal;

    switch (tipo) {
        case 'erro':
            mensagem_modal  = '<div class="alert alert-danger" role="alert">' + mensagem + '</div>';
            classe_botao_ok = 'btn-outline-danger';
            classe_modal    = 'modal_erro';
            break;
        case 'sucesso':
            mensagem_modal  = '<div class="alert alert-success" role="alert">' + mensagem + '</div>';
            classe_botao_ok = 'btn-outline-success';
            classe_modal    = 'modal_sucesso';
            break;
        case 'alerta':
            mensagem_modal  = '<div class="alert alert-warning" role="alert">' + mensagem + '</div>';
            classe_botao_ok = 'btn-outline-warning';
            classe_modal    = 'modal_alerta';
            break;
        case 'informacao':
            mensagem_modal  = '<div class="alert alert-info" role="alert">' + mensagem + '</div>';
            classe_botao_ok = 'btn-outline-info';
            classe_modal    = 'modal_informacao';
            break;
    }

    // Monta os botões correspondentes ao tipo do modal
    var botoes_modal;

    switch (botoes) {
        case 'ok_cancelar':
            botoes_modal  = '<button type="button" class="btn btn-sm btn-outline-danger btn_cancelar_nao" data-dismiss="modal" id="botao_cancelar">Cancelar</button>';
            botoes_modal += '<button type="button" class="btn btn-sm btn-outline-primary btn_ok_sim" data-dismiss="modal" id="botao_ok">OK</button>';
            break;
        case 'ok':
            botoes_modal  = '<button type="button" class="btn btn-sm ' + classe_botao_ok + ' btn_ok_sim" data-dismiss="modal" id="botao_ok">OK</button>';
            break;
        case 'sim_nao':
            botoes_modal  = '<button type="button" class="btn btn-sm btn-outline-danger btn_cancelar_nao" data-dismiss="modal" id="botao_nao">Não</button>';
            botoes_modal += '<button type="button" class="btn btn-sm btn-outline btn_ok_sim" data-dismiss="modal" id="botao_sim">Sim</button>';
            break;
    }
            
    // Monta o HTML do modal que será exibido
    var modal = '';

    modal += '<div class="modal fade ' + classe_modal + '" id="modal_principal" tabindex="-1" role="dialog" aria-hidden="true">';
    modal +=     '<div class="modal-dialog modal-dialog-centered modal-sm" role="document">';
    modal +=         '<div class="modal-content">';
    modal +=             '<div class="modal-header">';
    modal +=                 '<h6 class="modal-title">' + titulo + '</h6>';
    modal +=                 '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
    modal +=                     '<span aria-hidden="true">&times;</span>';
    modal +=                 '</button>';
    modal +=             '</div>';
    modal +=             '<div class="modal-body">';
    modal +=                 mensagem_modal;
    modal +=             '</div>';
    modal +=             '<div class="modal-footer">';
    modal +=                 botoes_modal;
    modal +=             '</div>';
    modal +=         '</div>';
    modal +=     '</div>';
    modal += '</div>';

    // Adiciona o modal na tag HTML e exibe
    $('html').append(modal);
    $('#modal_principal').modal('show');

    // Adiciona as funções nos eventos de click dos botões
    $('.btn_ok_sim').on('click', function() {
        if (typeof funcao_ok_sim === 'function') {
            funcao_ok_sim();
        }
    });
    $('.btn_cancelar_nao').on('click', function() {
        if (typeof funcao_cancelar_nao === 'function') {
            funcao_cancelar_nao();
        }
    });
    
    // Remove o modal do html depois de fechado
    $('#modal_principal').on('hidden.bs.modal', function () {
        $(this).remove();
    });
}