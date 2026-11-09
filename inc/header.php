<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>CRUD com Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }

        .btn-light {
            background-color: #cccccc;
            border-color: #cccccc;
            color: #FFFFFF;
        }

        .btn-light:hover {
            background-color: #999999;
            border-color: #999999;
            color: #FFFFFF;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top container" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASEURL; ?>"><i class="fa-solid fa-house-chimney"></i> CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcrud"
                aria-controls="navbarcrud" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcrud">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user-group"></i> Clientes
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>customers">
                                    <i class="fa-solid fa-user-group"></i> Gerenciar Clientes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>customers/add.php">
                                    <i class="fa-solid fa-user-plus"></i> Novo Cliente
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-boxes"></i> Produtos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>produtos">
                                    <i class="fa-solid fa-boxes"></i> Gerenciar Produtos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>produtos/add.php">
                                    <i class="fa-solid fa-box-open"></i> Novo Produto
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-users-gear"></i> Usuários
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios">
                                    <i class="fa-solid fa-users-gear"></i> Gerenciar Usuários
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios/add.php">
                                    <i class="fa-solid fa-user-gear"></i> Novo Usuário
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>

    <main class="container">