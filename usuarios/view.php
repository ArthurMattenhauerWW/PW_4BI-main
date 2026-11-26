
<?php
require_once('../config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('functions.php');

// Verifica se o usuário está logado e é administrador
if (
    empty($_SESSION['user']) ||
    !isset($_SESSION['perfil']) ||
    $_SESSION['perfil'] !== 'admin'
) {
    include(HEADER_TEMPLATE);
    ?>

    <div class="alert alert-danger mt-4 container" role="alert">
        <h5>
            <i class="fa-solid fa-lock"></i>
            Acesso negado!
        </h5>

        Você não tem permissão para visualizar os dados dos usuários.
        Somente administradores logados podem acessar esta página.

        <hr>

        <a href="<?php echo BASEURL; ?>index.php"
           class="btn btn-azulclaro text-offwhite">
            <i class="fa-solid fa-circle-left"></i>
            Voltar para o início
        </a>
    </div>

    <?php
    include(FOOTER_TEMPLATE);
    exit;
}

// Verifica se o ID foi informado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: index.php');
    exit();
}

view($_GET['id']);

include(HEADER_TEMPLATE);
?>

<header class="container mt-4">
    <h2>Visualizar Usuário #<?php echo $usuario['id']; ?></h2>
    <hr />
</header>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> container" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message'], $_SESSION['type']); ?>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <dl class="dl-horizontal">
                <dt><strong>Nome:</strong></dt>
                <dd><?php echo htmlspecialchars($usuario['nome']); ?></dd>

                <dt class="mt-2"><strong>Usuário (Login):</strong></dt>
                <dd><?php echo htmlspecialchars($usuario['user']); ?></dd>

                <dt class="mt-2"><strong>Tipo de Perfil:</strong></dt>
                <dd>
                    <span class="badge bg-secondary">
                        <?php echo htmlspecialchars(ucfirst($usuario['perfil'])); ?>
                    </span>
                </dd>
            </dl>
        </div>

        <div class="col-md-6 text-center">
            <label><strong>Foto do Usuário:</strong></label><br>

            <img
                src="<?php echo BASEURL; ?>assets/img/<?php echo !empty($usuario['foto']) ? rawurlencode(basename($usuario['foto'])) : 'default.png'; ?>"
                alt="Foto do Usuário"
                class="img-thumbnail rounded-circle mt-2"
                style="max-height: 180px; width: 180px; object-fit: cover;"
            >
        </div>
    </div>

    <div id="actions" class="row mt-4">
        <div class="col-md-12">
            <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning">
                <i class="fa fa-pencil"></i> Editar
            </a>

            <a href="index.php" class="btn btn-azulclaro text-offwhite">
                <i class="fa-solid fa-circle-left text-offwhite"></i> Voltar
            </a>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
