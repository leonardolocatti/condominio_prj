<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Barra de navegação -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info py-0">

    <!-- Logo do sistema -->
    <a class="navbar-brand mr-5" href="<?php echo site_url('home') ?>">
        <i class="fas fa-home"></i>
        Web Condomínio
    </a>

    <!-- Botão para expandir a barra de navegação -->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#conteudo_navegacao"
            aria-controls="conteudo_navegacao" aria-expanded="false" aria-label="Exibir barra de navegação">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Conteúdo da barra de navegação -->
    <div id="conteudo_navegacao" class="collapse navbar-collapse">

        <!-- Links de acesso -->
        <ul class="navbar-nav mr-auto">

            <li class="nav-item" id="item_home">
                <a class="nav-link" href="<?php echo site_url('home') ?>">
                    <i class="fas fa-home mr-1"></i>
                    Home
                </a>
            </li>

            <li class="nav-item" id="item_area_comum">
                <a class="nav-link" href="<?php echo site_url('area_comum') ?>">
                    <i class="fas fa-dumbbell mr-1"></i>
                    Área Comum
                </a>
            </li>

            <li class="nav-item" id="item_reuniao">
                <a class="nav-link" href="<?php echo site_url('reuniao') ?>">
                    <i class="fas fa-clipboard-list mr-1"></i>
                    Reunião
                </a>
            </li>

            <?php if ($this->session->usuario->usuario_tipo === 'administrador') { ?>
                <li class="nav-item" id="item_administracao">
                    <a class="nav-link" href="<?php echo site_url('administracao') ?>">
                        <i class="fas fa-user-shield mr-1"></i>
                        Administração
                    </a>
                </li>
            <?php } ?>

        </ul> <!-- Fim dos links de acesso -->

        <!-- Dropdown com as opções do usuário -->
        <div class="dropdown">

            <!-- Botão do dropdown -->
            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Usuário
            </button>

            <!-- Opções do usuário -->
            <div class="dropdown-menu dropdown-menu-lg-right">
                <button class="dropdown-item" onclick="sair()">
                    <i class="fas fa-sign-out-alt mr-1"></i>
                    Sair
                </button>
            </div> <!-- Fim das opções do usuário -->

        </div> <!-- Fim do dropdown com as opções do usuário -->

    </div> <!-- Fim do conteúdo da barra de navegação -->

</nav> <!-- Fim da barra de navegação -->
