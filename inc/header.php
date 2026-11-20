<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Casa dos Laptops</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website da Casa dos Laptops">
    <meta name="keywords" content="casa dos laptops">
    <link rel="icon" type="image.png" href="<?php echo BASEURL; ?>assets/img/icon.png" class="foto-icon">
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
            background-color: #000d31 !important; /* Azul mais claro que o bg-dark */
        }
    </style>
</head>
<body>


    
    <nav class="navbar navbar-expand-lg navbar-azul bg-azul-claro fixed-top py-1" data-bs-theme="dark" >
        <div class="container-fluid"> 
            <a class="navbar-brand ms-2" href="<?php echo BASEURL; ?>index.php"><img src="<?php echo BASEURL; ?>assets/img/logo.png" alt="Logo" width=auto height="100" style="max-height: 100px;" class="ms-5 me-3"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarcrud" aria-controls="navbarcrud" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcrud">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-laptop"></i> Laptops
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-offwhite dropdown-azul" href="<?php echo BASEURL; ?>laptops"><i class="fa-solid fa-laptop-code"></i> Gerenciar Laptops</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-offwhite" href="<?php echo BASEURL; ?>laptops/add.php"><i class="fa-solid fa-laptop-medical"></i> Novo Laptop</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-3">
                    <?php if (isset($_SESSION['user'])) : //Verifica se está logado ?>
                        <?php if ($_SESSION['user'] == "admin") : //Verifica se está logado como admin ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user-lock"></i> Usuários
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item text-offwhite" href="<?php echo BASEURL; ?>usuarios"><i class="fa-solid fa-user-lock"></i> Gerenciar Usuários</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-offwhite" href="<?php echo BASEURL; ?>usuarios/add.php"><i class="fa-solid fa-user-tie"></i> Adicionar Usuário</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASEURL; ?>inc/logout.php">
                                Bem vindo <?php echo $_SESSION['user']; ?>! <i class="fa-solid fa-person-walking-arrow-right"></i> Desconectar
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASEURL; ?>inc/login.php" data-bs-toggle="modal" data-bs-target="#login-modal">
                                <i class="fa-solid fa-users"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (!isset($_SESSION['user'])) : ?>
    <!-- MODAL DE LOGIN -->
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?php echo BASEURL; ?>inc/valida.php" method="post">
                    <div class="modal-header" style="background-color:#000d31;">
                        <h5 class="modal-title text-offwhite" id="login-modal-label"><i class="fa-solid fa-user-lock"></i> Login</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="modal-login" placeholder="Usuário" name="login" required>
                            <label for="modal-login">Usuário</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="password" class="form-control" id="modal-senha" placeholder="Senha" name="senha" required>
                            <label for="modal-senha">Senha</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-azul text-offwhite"><i class="fa-solid fa-user-check text-offwhite"></i> Conectar</button>
                        <button type="button" class="btn btn-azulclaro text-offwhite" data-bs-dismiss="modal"><i class="fa-solid fa-circle-left text-offwhite"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Foca no campo de usuário quando o modal abre
        document.addEventListener('shown.bs.modal', function (e) {
            if (e.target.id === 'login-modal') document.getElementById('modal-login').focus();
        });
    </script>
    <?php endif; ?>

    <!-- CONTEÚDO DA PÁGINA -->
    <main class="container">