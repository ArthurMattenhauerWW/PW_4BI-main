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

.table th {
    font-weight: 600;
    padding: 14px 12px;
}

.table td {
    padding: 12px;
}

.foto-cliente-index {
    width: 80px;
    height: 80px;
    border-radius: 6px;
    object-fit: cover;
    object-position: center;
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
            <h2 class="mt-3 text-azul">Clientes</h2>
        </div>

        <div class="col-sm-6 text-end h2">

            <?php if (isset($_SESSION['user'])) : ?>

                <a class="btn btn-azul mt-3 text-offwhite" href="add.php">
                    <i class="fa-solid fa-user-plus"></i>
                    Novo Cliente
                </a>

            <?php endif; ?>

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
                   id="searchCliente"
                   class="form-control"
                   placeholder="Pesquisar por nome...">

        </div>

    </div>

</div>


<table class="table table-hover" id="tabelaClientes">

    <thead>

        <tr>

            <th class="text-azul">ID</th>
            <th width="25%" class="text-azul">Nome</th>
            <th class="text-azul">E-mail</th>
            <th class="text-azul">Telefone</th>
            <th class="text-azul">Foto</th>
            <th class="text-azul">Cadastrado em</th>
            <th class="text-azul text-end">Opções</th>

        </tr>

    </thead>


    <tbody>

        <?php if ($clientes): ?>

            <?php foreach ($clientes as $cliente): ?>

                <tr>

                    <td>
                        <?php echo $cliente['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($cliente['nome']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($cliente['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($cliente['telefone']); ?>
                    </td>

                    <td>

                        <img
                            src="<?php echo BASEURL; ?>assets/img/<?php echo rawurlencode(basename($cliente['foto'])); ?>"
                            alt="<?php echo htmlspecialchars($cliente['nome']); ?>"
                            class="foto-cliente-index">

                    </td>

                    <td>

                        <?php
                        $dt = new DateTime(
                            $cliente['data_cad'],
                            new DateTimeZone('America/Sao_Paulo')
                        );

                        echo $dt->format("d/m/Y");
                        ?>

                    </td>


                    <td class="actions text-end">

                        <!-- VISUALIZAR: TODOS PODEM -->
                        <a href="view.php?id=<?php echo $cliente['id']; ?>"
                           class="btn btn-sm btn-azul text-offwhite">

                            <i class="fa-solid fa-eye"></i>
                            Visualizar

                        </a>


                        <?php if (isset($_SESSION['user'])) : ?>

                            <!-- EDITAR: SOMENTE LOGADOS -->
                            <a href="edit.php?id=<?php echo $cliente['id']; ?>"
                               class="btn btn-sm btn-azulclaro text-offwhite">

                                <i class="fa-solid fa-pencil"></i>
                                Editar

                            </a>


                            <!-- EXCLUIR: SOMENTE LOGADOS -->
                            <a href="#"
                               class="btn btn-sm btn-azulclarissimo text-offwhite"
                               data-bs-toggle="modal"
                               data-bs-target="#delete-modal"
                               data-cliente="<?php echo $cliente['id']; ?>">

                                <i class="fa-solid fa-trash"></i>
                                Excluir

                            </a>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="8">Nenhum cliente encontrado.</td>
            </tr>

        <?php endif; ?>

    </tbody>

</table>


<script>

document.getElementById('searchCliente').addEventListener('keyup', function() {

    const termo = this.value.toLowerCase().trim();

    const linhas = document.querySelectorAll('#tabelaClientes tbody tr');

    linhas.forEach(function(linha) {

        const nome = linha.cells[1]?.textContent.toLowerCase() || '';

        linha.style.display = nome.includes(termo) ? '' : 'none';

    });

});

</script>


<?php
include "modal.php";
include FOOTER_TEMPLATE;
?>