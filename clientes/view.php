
<?php

require_once('../config.php');
include("functions.php");

view($_GET['id'] ?? null);

include HEADER_TEMPLATE;

?>

<style>

.foto-cliente-view {
    width: 250px;
    height: 250px;
    max-width: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    margin-top: 10px;
}

#actions .btn {
    margin-right: 8px;
}

#actions .btn i {
    margin-right: 6px;
}

</style>


<h2 class="mt-3">
    Cliente <?php echo htmlspecialchars($cliente['nome']); ?>
</h2>

<hr>

<?php if (!empty($_SESSION['message'])) : ?>

    <div class="alert alert-<?php echo $_SESSION['type']; ?>">
        <?php echo $_SESSION['message']; ?>
    </div>

    <?php
    unset($_SESSION['message']);
    unset($_SESSION['type']);
    ?>

<?php endif; ?>


<div class="row">

    <div class="col-md-8">

        <div class="row">

            <div class="col-sm-6">

                <dl>

                    <dt>Nome:</dt>
                    <dd><?php echo htmlspecialchars($cliente['nome']); ?></dd>

                    <dt>E-mail:</dt>
                    <dd><?php echo htmlspecialchars($cliente['email']); ?></dd>

                    <dt>Telefone:</dt>
                    <dd><?php echo htmlspecialchars($cliente['telefone']); ?></dd>

                    <dt>CPF:</dt>
                    <dd><?php echo htmlspecialchars($cliente['cpf']); ?></dd>

                </dl>

            </div>

            <div class="col-sm-6">

                <dl>

                    <dt>Data de Cadastro:</dt>

                    <dd>
                        <?php
                        if (
                            !empty($cliente['criado_em']) &&
                            $cliente['criado_em'] != '0000-00-00 00:00:00'
                        ) {
                            echo formatdata(
                                $cliente['criado_em'],
                                "d/m/Y - H:i:s"
                            );
                        } else {
                            echo 'Data não informada';
                        }
                        ?>
                    </dd>

                </dl>

            </div>

        </div>

    </div>


    <div class="col-md-4 text-center">

        <dl>

            <dt>Foto:</dt>

            <dd>

                <img src="<?php echo BASEURL; ?>assets/img/<?php echo rawurlencode(basename($cliente['foto'])); ?>"
                     alt="<?php echo htmlspecialchars($cliente['nome']); ?>"
                     class="foto-cliente-view img-fluid">

            </dd>

        </dl>

    </div>

</div>


<div id="actions" class="row">

    <div class="col-md-12">

        <?php if (!empty($_SESSION['user'])) : ?>

            <a href="edit.php?id=<?php echo $cliente['id']; ?>"
               class="btn btn-azul text-offwhite">

                <i class="fa-solid fa-file-pen"></i>
                Editar

            </a>

        <?php endif; ?>

        <a href="index.php"
           class="btn btn-azulclaro text-offwhite">

            <i class="fa-solid fa-circle-left text-offwhite"></i>
            Voltar

        </a>

    </div>

</div>


<?php include FOOTER_TEMPLATE; ?>
