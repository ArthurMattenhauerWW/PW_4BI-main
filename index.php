
<?php
include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include DBAPI;
include(HEADER_TEMPLATE);

$erro = null;

try {
    $db = open_database();
} catch (Exception $e) {
    $erro = $e;
}
?>

<style>
.btn-azul,
.btn-azulclaro {
    display: block;
    width: 100%;
    padding: 20px 15px;
    border-radius: 12px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    margin-bottom: 20px;
}

.icone-branco {
    color: #ffffff;
    margin-bottom: 12px;
    transition: transform 0.3s ease;
}

.btn-azul p,
.btn-azulclaro p {
    font-size: 1.1rem;
    font-weight: 600;
    margin-top: 10px;
    margin-bottom: 0;
    color: #ffffff;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.alert-danger {
    border-radius: 8px;
    border-left: 5px solid #dc3545;
    padding: 15px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}
</style>

<h1 class="mt-3 text-azul">Bem-Vindos ao Nosso Site!</h1>
<hr />

<?php if (!empty($_SESSION['bem_vindo'])) : ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        <?php echo htmlspecialchars($_SESSION['bem_vindo']); ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>
    </div>

    <?php unset($_SESSION['bem_vindo']); ?>

<?php endif; ?>

<?php if ($db): ?>

    <!-- MÓDULO: CLIENTES -->
    <h4 class="text-secondary mb-3">
        <i class="fa-solid fa-users"></i> CLIENTES
    </h4>

    <div class="row mb-2">

        <div class="col-xs-6 col-sm-6 col-md-3">
            <a href="clientes" class="btn btn-azulclaro text-offwhite">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa-solid fa-users fa-5x icone-branco"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Ver Clientes</p>
                    </div>
                </div>
            </a>
        </div>

        <?php if (isset($_SESSION['user'])) : ?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <a href="clientes/add.php" class="btn btn-azul text-offwhite">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa-solid fa-user-plus fa-5x icone-branco"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Novo Cliente</p>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

    </div>

    <hr class="my-3">

    <!-- MÓDULO: LAPTOPS -->
    <h4 class="text-secondary mb-3">
        <i class="fa-solid fa-laptop"></i> Laptops
    </h4>

    <div class="row mb-2">

        <div class="col-xs-6 col-sm-6 col-md-3">
            <a href="laptops" class="btn btn-azulclaro text-offwhite">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa-solid fa-laptop-code fa-5x icone-branco"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Ver Laptops</p>
                    </div>
                </div>
            </a>
        </div>

        <?php if (isset($_SESSION['user'])) : ?>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <a href="laptops/add.php" class="btn btn-azul text-offwhite">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa-solid fa-laptop-medical fa-5x icone-branco"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Novo Laptop</p>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

    </div>

    <!-- MÓDULO: USUÁRIOS (Apenas para Admin) -->
    <?php
    if (
        isset($_SESSION['user']) &&
        isset($_SESSION['perfil']) &&
        $_SESSION['perfil'] == "admin"
    ) :
    ?>

        <hr class="my-3">

        <h4 class="text-secondary mb-3">
            <i class="fa-solid fa-user-gear"></i> Usuários
        </h4>

        <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-3">
                <a href="usuarios" class="btn btn-azulclaro text-offwhite">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <i class="fa-solid fa-users-gear fa-5x icone-branco"></i>
                        </div>
                        <div class="col-xs-12 text-center">
                            <p>Ver Usuários</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3">
                <a href="usuarios/add.php" class="btn btn-azul text-offwhite">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <i class="fa-solid fa-user-gear fa-5x icone-branco"></i>
                        </div>
                        <div class="col-xs-12 text-center">
                            <p>Novo Usuário</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    <?php endif; ?>

<?php else: ?>

    <div class="alert alert-danger" role="alert">
        <p>
            <b>ERRO:</b> Não foi possível Conectar ao Banco de Dados!<br>
            <?= $erro; ?>
        </p>
    </div>

<?php endif; ?>

<?php include(FOOTER_TEMPLATE); ?>
