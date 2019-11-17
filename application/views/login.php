<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main role="main" class="h-100">
    <div class="container h-100 d-flex">
        <div class="col-md-4 m-auto">

            <h2 class="text-center mb-5"><i class="fas fa-home"></i> Web Condomínio</h2>

            <!-- Início do formulário de login -->
            <form id="form_login" action="javascript:entrar();" novalidate>
                
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="login_usuario" name="login_usuario" autofocus>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control form-control-lg mt-4" id="login_senha" name="login_senha">
                </div>

                <button type="submit" class="btn btn-outline-success btn-block mt-4" id="login_botao_entrar">Entrar</button>

            </form> <!-- Fim do formulário de login -->

        </div>
    </div>
</main>
