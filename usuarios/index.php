<?php
include "functions.php";
index();
include HEADER_TEMPLATE;
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
.table th { font-weight: 600; padding: 14px 12px; }
.table td { padding: 12px; }
.actions .btn-sm {
    margin-left: 3px;
    margin-bottom: 2px;
    padding: 6px 12px;
    font-size: 0.85rem;
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
}
</style>

<header>
    <div class="row">
        <div class="col-sm-6">
            <h2 class="mt-3 text-azul">Usuários</h2>
        </div>
        <div class="col-sm-6 text-end h2">
            <a class="btn btn-azul mt-3 text-offwhite" href="add.php"><i class="fa-solid fa-user-gear"></i> Novo Usuário</a>
            <a class="btn btn-azulclaro mt-3 text-offwhite" href="index.php"><i class="fa fa-refresh"></i> Atualizar</a>
        </div>
    </div>
</header>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <?php echo $_SESSION['message']; ?>
    </div>
<?php //clear_messages(); ?>
<?php endif; ?>

<hr>

<table class="table table-hover">
    <thead>
        <tr>
            <th class="text-azul">ID</th>
            <th class="text-azul" style="width:20%;">Nome</th>
            <th class="text-azul">Login</th>
            <th class="text-azul">Foto</th>
            <th class="text-azul text-end">Opções</th>
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
                    <td class="actions text-end">
                        <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-azul text-offwhite"><i
                                class="fa-solid fa-eye"></i> Visualizar</a>
                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-azulclaro text-offwhite"><i
                                class="fa-solid fa-pencil"></i> Editar</a>
                        <a href="#" class="btn btn-sm btn-azulclarissimo text-offwhite" data-bs-toggle="modal" data-bs-target="#delete-modal"
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