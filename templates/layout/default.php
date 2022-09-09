<?php

$cakeDescription = 'Riomix - Sistema';

?>
<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.4.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>
    <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="manifest" href="<?php echo $this->Url->build('/'); ?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <meta name="theme-color" content="#ffffff">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $this->Url->build('/'); ?>calendar/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Main styles for this application-->
    <link href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/coreui/dist/css/coreui.min.css" rel="stylesheet">
    <link href="<?php echo $this->Url->build('/'); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script src="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/utils/dist/coreui-utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>

<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed <?php if ($usuarioAtual['menu_show'] == 1) { echo ' c-sidebar-lg-show '; } if ($usuarioAtual['menu_minimized'] == 1) { echo ' c-sidebar-minimized '; } ?> no-print" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <img src="<?php echo $this->Url->build('/'); ?>img/logo.png" class="c-sidebar-brand-full" height="46" alt="">
            <img src="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png" class="c-sidebar-brand-minimized" height="46" alt="">
        </div>
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="<?= $this->Url->build(['controller' => 'dashboard']); ?>">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-speedometer">
                        </use>
                    </svg>
                    Dashboard
                </a>
            </li>


            <li class="c-sidebar-nav-dropdown">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">
                    <i class="fas fa-recycle c-sidebar-nav-icon"></i>
                    Recolhimento
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'sales', 'action' => 'add']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-plus-circle c-sidebar-nav-icon"></i>
                            Adicionar
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'sales', 'action' => 'index']); ?>" class="c-sidebar-nav-link">
                            <i class="far fa-calendar-alt c-sidebar-nav-icon"></i>
                            Calendário
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'sales', 'action' => 'pesquisa']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-list c-sidebar-nav-icon"></i>
                            Lista
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-dropdown">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">
                <i class="fas fa-users c-sidebar-nav-icon"></i>
                    Clientes
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'clients', 'action' => 'add']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-plus-circle c-sidebar-nav-icon"></i>
                            Adicionar
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'clients', 'action' => 'index']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-list c-sidebar-nav-icon"></i>
                            Lista
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-dropdown">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">
                <i class="fas fa-phone c-sidebar-nav-icon"></i>
                    Contatos
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'contacts', 'action' => 'index']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-list c-sidebar-nav-icon"></i>
                            Lista
                        </a>
                    </li>
                </ul>
            </li>

            <li class="c-sidebar-nav-dropdown">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">
                <i class="fas fa-clipboard-check c-sidebar-nav-icon"></i>
                    Certificados
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'certificates', 'action' => 'index']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-list c-sidebar-nav-icon"></i>
                            Lista
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-dropdown">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">
                <i class="fas fa-newspaper c-sidebar-nav-icon"></i>
                    Notícias
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'news', 'action' => 'index']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-list c-sidebar-nav-icon"></i>
                            Lista
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-dropdown">
                <a href="#" class="c-sidebar-nav-dropdown-toggle">
                    <i class="far fa-chart-bar c-sidebar-nav-icon"></i>
                    Relatórios
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <?php
                    if ($usuarioAtual['role_id'] == 1 || $usuarioAtual['role_id'] == 3) {
                        ?>
                        <li class="c-sidebar-nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'reports', 'action' => 'count']); ?>" class="c-sidebar-nav-link">
                                <i class="fas fa-shopping-cart c-sidebar-nav-icon"></i>
                                Resultados
                            </a>
                        </li>
                        <?php
                    }
                    if ($usuarioAtual['role_id'] == 1 || $usuarioAtual['role_id'] == 3) {
                        ?>
                        <li class="c-sidebar-nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'reports', 'action' => 'graphics']); ?>" class="c-sidebar-nav-link">
                                <i class="fas fa-chart-bar c-sidebar-nav-icon"></i>
                                Gráficos
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="c-sidebar-nav-item">
                        <a href="<?= $this->Url->build(['controller' => 'reports', 'action' => 'list']); ?>" class="c-sidebar-nav-link">
                            <i class="fas fa-list c-sidebar-nav-icon"></i>
                            Lista
                        </a>
                    </li>
                </ul>
            </li>
            <?php
            if ($usuarioAtual['role_id'] == 1 || $usuarioAtual['role_id'] == 3) {
                ?>
                <li class="c-sidebar-nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'customers']); ?>" class="c-sidebar-nav-link">
                        <i class="fas fa-user c-sidebar-nav-icon"></i>
                        Usuários
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'users']); ?>" class="c-sidebar-nav-link">
                        <i class="fas fa-user-tie c-sidebar-nav-icon"></i>
                        Administradores
                    </a>
                </li>
                <?php
            }
            ?>
            <li class="c-sidebar-nav-item">
                <a href="<?= $this->Url->build(['controller' => 'login', 'action' => 'sair']); ?>" class="c-sidebar-nav-link">
                    <i class="fas fa-sign-out-alt c-sidebar-nav-icon"></i>
                    Sair
                </a>
            </li>
        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized">
        </button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader no-print">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-menu">
                    </use>
                </svg>
            </button>
            <a class="c-header-brand d-lg-none" href="#">
                <img src="<?php echo $this->Url->build('/'); ?>img/logo-minimized-blue.png" class="c-sidebar-brand-minimized" height="46" alt="">
            </a>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                data-class="c-sidebar-lg-show" responsive="true">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-menu">
                    </use>
                </svg>
            </button>
            <ul class="c-header-nav d-md-down-none">
                <li class="c-header-nav-item px-3">
                    <a class="c-header-nav-link" href="<?= $this->Url->build(['controller' => 'dashboard']); ?>">
                        Início
                    </a>
                </li>
                <li class="c-header-nav-item px-3">
                    <a class="c-header-nav-link" href="<?= $this->Url->build(['controller' => 'sales']); ?>">
                        Calendário
                    </a>
                </li>
                <li class="c-header-nav-item px-3">
                    <a class="c-header-nav-link" href="<?= $this->Url->build(['controller' => 'sales', 'action' => 'add']); ?>">
                        <button class="btn btn-primary">Novo Recolhimento</button>
                    </a>
                </li>
            </ul>
            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item dropdown">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="c-avatar">
                            <img class="c-avatar-img" src="<?php if ($usuarioAtual['img']) { echo $this->Url->build('/') . 'img/uploads/' . $usuarioAtual['img']; } else  { echo $this->Url->build('/') . 'img/uploads/default.jpg'; } ?>" alt="user@email.com">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2">
                            <strong>
                                Configurações
                            </strong>
                        </div>
                        <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'profile']); ?>">
                            <svg class="c-icon mr-2">
                                <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-user">
                                </use>
                            </svg>
                            Perfil
                        </a>
                        <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'profile', 'action' => 'settings']); ?>">
                            <svg class="c-icon mr-2">
                                <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-settings">
                                </use>
                            </svg>
                            Configurações
                        </a>
                        <?php
                        if ($usuarioAtual['role_id'] == 1 || $usuarioAtual['role_id'] == 3 || $usuarioAtual['role_id'] == 4 || $usuarioAtual['role_id'] == 5 || $usuarioAtual['role_id'] == 6) {
                            ?>
                            <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'reports']); ?>">
                                <svg class="c-icon mr-2">
                                    <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-file">
                                    </use>
                                </svg>
                                Relatório
                            </a>
                            <?php
                        }
                        ?>
                        <div class="dropdown-divider">
                        </div>
                        <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'login', 'action' => 'sair']); ?>">
                            <svg class="c-icon mr-2">
                                <use xlink:href="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/sprites/free.svg#cil-account-logout">
                                </use>
                            </svg>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
            <div class="c-subheader px-3">
                <!-- Breadcrumb-->
                <ol class="breadcrumb border-0 m-0">
                    <li class="breadcrumb-item">
                        Riomix
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= $this->Url->build(['controller' => 'sales']); ?>">
                            Início
                        </a>
                    </li>
                    <!-- <li class="breadcrumb-item active">
                        Serviços
                    </li> -->
                    <!-- Breadcrumb Menu-->
                </ol>
            </div>
        </header>

        <script src="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/coreui/dist/js/coreui.bundle.js"></script>
        <div class="c-body">
            <?php
            $render = $this->Flash->render();
            if ($render) {
                ?>
                <div class="container-fluid my-3"><div class="alert alert-primary" role="alert"><?php echo $render; ?></div></div>
                <?php
            }
            ?>
            <?= $this->fetch('content'); ?>
            <footer class="c-footer no-print">
                <div>
                    <a href="https://coreui.io">
                        Riomix
                    </a>
                    &copy; Todos os direitos reservados
                </div>
                <!-- <div class="ml-auto">
                    Criado por &nbsp;
                    <a href="https://www.agenciakls.com.br/">
                        Agência KLS
                    </a>
                </div> -->
            </footer>
        </div>
    </div>
    <script src="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js"></script>
    <script src="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/icons/js/svgxuse.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
