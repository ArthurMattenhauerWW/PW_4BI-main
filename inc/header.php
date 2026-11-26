
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar a foto do usuário
$fotoUsuario = 'logo.png';

if (!empty($_SESSION['foto'])) {
    $nomeFoto = basename($_SESSION['foto']);
    $caminhoFoto = ABSPATH . 'assets/img/' . $nomeFoto;

    if (is_file($caminhoFoto)) {
        $fotoUsuario = $nomeFoto;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Casa dos Laptops</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website da Casa dos Laptops">
    <meta name="keywords" content="casa dos laptops">

    <link rel="icon" href="<?php echo BASEURL; ?>assets/img/icon.png">

    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/all.min.css">

    <style>
        body {
            padding-top: 130px;
            padding-bottom: 20px;
        }

        .btn-light {
            background-color: #cccccc;
            border-color: #cccccc;
            color: #FFFFFF;
        }

        .btn-light:hover {
            background-color: #999999;
            border-color: #cccccc;
            color: #FFFFFF;
        }

        .bg-azul-claro {
            background-color: #000d31 !important;
        }

        .navbar .container-fluid {
            padding-right: 25px;
            padding-left: 25px;
        }

        /* FOTO DO USUÁRIO */
        .foto-usuario {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            display: block;
        }

        .foto-usuario:hover {
            opacity: 0.85;
        }

        /* DROPDOWN */
        .navbar .dropdown-menu {
            background-color: #000d31;
            border: none;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .navbar .dropdown-item {
            color: #ffffff;
            border-radius: 5px;
            padding: 9px 12px;
        }

        .navbar .dropdown-item:hover {
            background-color: #203f70;
            color: #ffffff;
        }

        .navbar .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 991px) {
            .navbar-nav {
                align-items: flex-start !important;
            }

            .navbar .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }

            .foto-usuario {
                margin-top: 5px;
            }
        }
    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-azul bg-azul-claro fixed-top py-2"
     data-bs-theme="dark">

    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand ms-2"
           href="<?php echo BASEURL; ?>index.php">

            <img src="<?php echo BASEURL; ?>assets/img/logo.png"
                 alt="Logo Casa dos Laptops"
                 height="90"
                 style="max-height: 90px;"
                 class="me-3">

        </a>

        <!-- BOTÃO MOBILE -->
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarcrud"
                aria-controls="navbarcrud"
                aria-expanded="false"
                aria-label="Abrir menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarcrud">

            <!-- MENU ESQUERDO -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">

                <!-- CLIENTES -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">

                        <i class="fa-solid fa-users"></i> Clientes

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="<?php echo BASEURL; ?>clientes">

                                <i class="fa-solid fa-users-rectangle"></i>
                                Gerenciar Clientes

                            </a>
                        </li>

                        <?php if (isset($_SESSION['user'])) : ?>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item"
                                   href="<?php echo BASEURL; ?>clientes/add.php">

                                    <i class="fa-solid fa-user-plus"></i>
                                    Novo Cliente

                                </a>
                            </li>

                        <?php endif; ?>

                    </ul>

                </li>

                <!-- LAPTOPS -->
                <li class="nav-item dropdown ms-lg-3">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">

                        <i class="fa-solid fa-laptop"></i> Laptops

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="<?php echo BASEURL; ?>laptops">

                                <i class="fa-solid fa-laptop-code"></i>
                                Gerenciar Laptops

                            </a>
                        </li>

                        <?php if (isset($_SESSION['user'])) : ?>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item"
                                   href="<?php echo BASEURL; ?>laptops/add.php">

                                    <i class="fa-solid fa-laptop-medical"></i>
                                    Novo Laptop

                                </a>
                            </li>

                        <?php endif; ?>

                    </ul>

                </li>

                <!-- USUÁRIOS: SOMENTE ADMIN -->
                <?php if (
                    isset($_SESSION['user']) &&
                    isset($_SESSION['perfil']) &&
                    $_SESSION['perfil'] == "admin"
                ) : ?>

                    <li class="nav-item dropdown ms-lg-3">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            <i class="fa-solid fa-users-gear"></i> Usuários

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item"
                                   href="<?php echo BASEURL; ?>usuarios">

                                    <i class="fa-solid fa-users-gear"></i>
                                    Gerenciar Usuários

                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item"
                                   href="<?php echo BASEURL; ?>usuarios/add.php">

                                    <i class="fa-solid fa-user-plus"></i>
                                    Adicionar Usuário

                                </a>
                            </li>

                        </ul>

                    </li>

                <?php endif; ?>

            </ul>

            <!-- MENU DIREITO: FOTO E LOGIN -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

                <?php if (isset($_SESSION['user'])) : ?>

                    <!-- FOTO DO USUÁRIO -->
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0"
                           href="#"
                           id="userDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                           
                            <img
                                src="<?php echo BASEURL; ?>assets/img/<?php echo htmlspecialchars($fotoUsuario, ENT_QUOTES, 'UTF-8'); ?>"
                                alt="Foto do usuário"
                                class="foto-usuario"
                                onerror="this.onerror=null; this.src='<?php echo BASEURL; ?>assets/img/logo.png';"
                            >

                        </a>

                        <!-- DROPDOWN DA FOTO -->
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            aria-labelledby="userDropdown">

                            <li>
                                <span class="dropdown-item-text text-white small">

                                    Logado como:<br>

                                    <strong>
                                        <?php echo htmlspecialchars($_SESSION['user']); ?>
                                    </strong>

                                </span>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>

                                <a class="dropdown-item text-danger fw-bold"
                                   href="<?php echo BASEURL; ?>inc/logout.php">

                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                    Desconectar

                                </a>

                            </li>

                        </ul>

                    </li>

                <?php else : ?>

                    <!-- LOGIN -->
                    <li class="nav-item">

                        <a class="nav-link"
                           href="#"
                           data-bs-toggle="modal"
                           data-bs-target="#login-modal">

                            <i class="fa-solid fa-user"></i> Login

                        </a>

                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>


<!-- MODAL DE LOGIN -->
<?php if (!isset($_SESSION['user'])) : ?>

    <div class="modal fade"
         id="login-modal"
         tabindex="-1"
         aria-labelledby="login-modal-label"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <form action="<?php echo BASEURL; ?>inc/valida.php"
                      method="post">

                    <div class="modal-header"
                         style="background-color:#000d31;">

                        <h5 class="modal-title text-white"
                            id="login-modal-label">

                            <i class="fa-solid fa-user-lock"></i> Login

                        </h5>

                        <button type="button"
                                class="btn-close btn-close-white"
                                data-bs-dismiss="modal"
                                aria-label="Fechar">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="form-floating mb-2">

                            <input type="text"
                                   class="form-control"
                                   id="modal-login"
                                   placeholder="Usuário"
                                   name="login"
                                   required>

                            <label for="modal-login">Usuário</label>

                        </div>

                        <div class="form-floating mb-2">

                            <input type="password"
                                   class="form-control"
                                   id="modal-senha"
                                   placeholder="Senha"
                                   name="senha"
                                   required>

                            <label for="modal-senha">Senha</label>

                        </div>

                        <div class="text-center mt-3">

                            <p class="mb-0">
                                Ainda não tem conta?

                                <a href="<?php echo BASEURL; ?>usuarios/add.php">
                                    Cadastre-se aqui
                                </a>
                            </p>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit"
                                class="btn btn-azul text-offwhite">

                            <i class="fa-solid fa-user-check"></i>
                            Conectar

                        </button>

                        <button type="button"
                                class="btn btn-azulclaro text-offwhite"
                                data-bs-dismiss="modal">

                            <i class="fa-solid fa-circle-left"></i>
                            Cancelar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('shown.bs.modal', function (e) {

            if (e.target.id === 'login-modal') {
                document.getElementById('modal-login').focus();
            }

        });
    </script>

<?php endif; ?>


<!-- CONTEÚDO DA PÁGINA -->
<main class="container">
