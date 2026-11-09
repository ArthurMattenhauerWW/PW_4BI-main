<?php
include "functions.php";
index();
include HEADER_TEMPLATE;
?>

<header>
    <div class="row">
        <div class="col-sm-6">
            <h2>Usuários</h2>
        </div>
        <div class="col-sm-6 text-end h2">
            <a class="btn btn-secondary" href="add.php"><i class="fa-solid fa-user-gear"></i> Novo Usuário</a>
            <a class="btn btn-light" href="index.php"><i class="fa-solid fa-refresh"></i> Atualizar</a>
        </div>
    </div>
</header>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <?php echo $_SESSION['message']; ?>
    </div>
<?php //clear_messages(); ?>
<?php endif; ?>

<hr>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th style="width:20%;">Nome</th>
            <th>Login</th>
            <th>Foto</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($users): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php echo $user['id']; ?>
                    </td>
                    <td>
                        <?php echo $user['nome']; ?>
                    </td>
                    <td>
                        <?php echo $user['user']; ?>
                    </td>
                    <td>
                        <?php
                        $foto = BASEURL . "usuarios/foto/semimagem.jpg";
                        if (!empty($user['foto'])) {
                            $foto = BASEURL . "usuarios/foto/{$user['foto']}";
                        }
                        ?>
                        <img src="<?= $foto; ?>" class="img-thumbnail shadow" style="width: 150px;">
                    </td>
                    <td class="actions text-start">
                        <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-light"><i
                                class="fa-solid fa-eye"></i> Visualizar</a>
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-secondary"><i
                                class="fa-solid fa-pencil"></i> Editar</a>
                        <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#delete-modal"
                            data-user="<?= $user['id']; ?>">
                            <i class="fa-solid fa-trash"></i> Excluir
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

<?php
include "modal.php";
include FOOTER_TEMPLATE;
?>