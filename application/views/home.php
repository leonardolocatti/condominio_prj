<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main role="main">
    <input type="hidden" id="usuario_busca" value="<?php echo $_SESSION['usuario']->usuario_id ?>">
    <div class="container-fluid mt-5">
    <div class="col-md-12 m-auto">
            <div class="row">
                <div class="col-12">
                    <div id="visitas_atuais">
                        <div class="caixa_titulo">
                            <p class="h4 mb-0">Minhas Visitas</p>
                        </div>
                        <div class="caixa_conteudo">
                            <div class="row">
                                <div class="col-12">
                                <table id="visita_tabela" class="table table-striped table-bordered table-sm w-100"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mx-auto mt-5">
            <div class="row">
                <div class="col-12">
                    <div id="visitas_atuais">
                        <div class="caixa_titulo">
                            <p class="h4 mb-0">Minhas Reservas</p>
                        </div>
                        <div class="caixa_conteudo">
                            <div class="row">
                                <div class="col-12">
                                    <div id="fullcalendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
