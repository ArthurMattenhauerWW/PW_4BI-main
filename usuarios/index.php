
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

        Você não tem permissão para acessar o gerenciamento de usuários.
        Somente administradores podem acessar esta página.

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

// Se passou pela verificação, pode listar os usuários
index();

include(HEADER_TEMPLATE);
?>

<style>

.table {
    vertical-align: middle;
    margin-top: 15px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.table thead {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.table th {
    font-weight: 600;
    padding: 14px 12px;
}

.table td {
    padding: 12px;
}

.foto-usuario-index {
    max-width: 80px;
    height: auto;
    border-radius: 6px;
    object-fit: cover;
}

.actions .btn-sm {
    margin-left: 3px;
    margin-bottom: 2px;
    padding: 6px 12px;
    font-size: 0.85rem;
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
}

@media (max-width: 768px) {
    .actions {
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: flex-end;
    }

    .actions .btn-sm {
        width: 100%;
        max-width: 120px;
    }
}

</style>


<header>
    <div class="row">

        <div class="col-sm-6">
            <h2 class="mt-3 text-azul">Usuários</h2>
        </div>

        <div class="col-sm-6 text-end h2">

            <a class="btn btn-azul mt-3 text-offwhite" href="add.php">
                <i class="fa-solid fa-user-plus"></i>
                Novo Usuário
            </a>

            <a class="btn btn-azulclaro mt-3 text-offwhite" href="index.php">
                <i class="fa fa-refresh"></i>
                Atualizar
            </a>

        </div>

    </div>
</header>


<?php if (!empty($_SESSION['message'])): ?>

    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">

        <?php echo $_SESSION['message']; ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>

    </div>

    <?php
    unset($_SESSION['message']);
    unset($_SESSION['type']);
    ?>

<?php endif; ?>


<hr>


<div class="row mb-3">

    <div class="col-md-6">

        <div class="input-group">

            <span class="input-group-text">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>

            <input type="text"
                   id="searchUsuario"
                   class="form-control"
                   placeholder="Pesquisar por nome ou login...">

        </div>

    </div>

</div>


<table class="table table-hover" id="tabelaUsuarios">

    <thead>

        <tr>

            <th class="text-azul">ID</th>
            <th width="25%" class="text-azul">Nome</th>
            <th class="text-azul">Usuário (Login)</th>
            <th class="text-azul">Perfil</th>
            <th class="text-azul">Foto</th>
            <th class="text-azul text-end">Opções</th>

        </tr>

    </thead>


    <tbody>

        <?php if ($usuarios): ?>

            <?php foreach ($usuarios as $usuario): ?>

                <tr>

                    <td>
                        <?php echo $usuario['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($usuario['nome']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($usuario['user']); ?>
                    </td>

                    <td>
                        <span class="badge bg-secondary">
                            <?php echo htmlspecialchars(ucfirst($usuario['perfil'])); ?>
                        </span>
                    </td>

                    <td>

                        <img
                            src="<?php echo BASEURL; ?>assets/img/<?php echo !empty($usuario['foto']) ? rawurlencode(basename($usuario['foto'])) : 'default.png'; ?>"
                            alt="<?php echo htmlspecialchars($usuario['nome']); ?>"
                            class="foto-usuario-index">

                    </td>


                    <td class="actions text-end">

                        <!-- VISUALIZAR -->
                        <a href="view.php?id=<?php echo $usuario['id']; ?>"
                           class="btn btn-sm btn-azul text-offwhite">

                            <i class="fa-solid fa-eye"></i>
                            Visualizar

                        </a>


                        <!-- EDITAR -->
                        <a href="edit.php?id=<?php echo $usuario['id']; ?>"
                           class="btn btn-sm btn-azulclaro text-offwhite">

                            <i class="fa-solid fa-pencil"></i>
                            Editar

                        </a>


                        <!-- EXCLUIR -->
                        <a href="#"
                           class="btn btn-sm btn-azulclarissimo text-offwhite"
                           data-bs-toggle="modal"
                           data-bs-target="#delete-modal"
                           data-usuario="<?php echo $usuario['id']; ?>">

                            <i class="fa-solid fa-trash"></i>
                            Excluir

                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="6">Nenhum registro encontrado.</td>
            </tr>

        <?php endif; ?>

    </tbody>

</table>


<script>

document.getElementById('searchUsuario').addEventListener('keyup', function() {

    const termo = this.value.toLowerCase().trim();

    const linhas = document.querySelectorAll('#tabelaUsuarios tbody tr');

    linhas.forEach(function(linha) {

        const nome = linha.cells[1]?.textContent.toLowerCase() || '';
        const usuario = linha.cells[2]?.textContent.toLowerCase() || '';

        linha.style.display =
            nome.includes(termo) || usuario.includes(termo) ? '' : 'none';

    });

});

</script>


<?php
include "modal.php";
include FOOTER_TEMPLATE;
?>
