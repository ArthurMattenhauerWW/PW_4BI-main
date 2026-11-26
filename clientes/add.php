<?php

require_once('../config.php');

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// VERIFICAÇÃO DE ACESSO
try {

    if (empty($_SESSION['user'])) {
        throw new Exception(
            "Para acessar esta página é necessário estar logado."
        );
    }

} catch (Exception $e) {

    // Exibir cabeçalho
    include(HEADER_TEMPLATE);
    ?>

    <div class="alert alert-danger mt-4" role="alert">
        <h5>
            <i class="fa-solid fa-lock"></i>
            Acesso negado!
        </h5>

        <?php echo htmlspecialchars($e->getMessage()); ?>

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

// Se chegou aqui, está logado e pode continuar
require_once('functions.php');

add();

include(HEADER_TEMPLATE);

?>

<style>

.foto-cliente-view {
    width: 250px;
    height: 250px;
    border-radius: 8px;
    object-fit: cover;
    object-position: center;
}

</style>
<h2 class="mt-3">Adicionar Cliente</h2>

<form action="add.php" method="post" enctype="multipart/form-data">

    <hr />

    <div class="row">

        <div class="col-md-6">

            <div class="form-group mb-3">
                <label for="nome">Nome</label>

                <input type="text"
                       class="form-control"
                       id="nome"
                       name="cliente[nome]"
                       maxlength="150"
                       required>
            </div>

            <div class="form-group mb-3">
                <label for="email">E-mail</label>

                <input type="email"
                       class="form-control"
                       id="email"
                       name="cliente[email]"
                       maxlength="150"
                       required>
            </div>

            <div class="row">

                <div class="form-group col-md-6 mb-3">
                    <label for="telefone">Telefone</label>

                    <input type="text"
                           class="form-control"
                           id="telefone"
                           name="cliente[telefone]"
                           maxlength="20"
                           required>
                </div>

                <div class="form-group col-md-6 mb-3">
                    <label for="cpf">CPF</label>

                    <input type="text"
                           class="form-control"
                           id="cpf"
                           name="cliente[cpf]"
                           maxlength="20"
                           required>
                </div>

            </div>

            <div class="form-group mb-3">
                <label for="criado_em">Data de Cadastro</label>

                <input type="text"
                       class="form-control"
                       id="criado_em"
                       value="<?php echo date('d/m/Y H:i:s'); ?>"
                       disabled>
            </div>

            <div class="form-group mb-3">
                <label for="foto">Foto do Cliente</label>

                <input type="file"
                       class="form-control"
                       id="foto"
                       name="foto"
                       accept="image/*"
                       onchange="previewImagem(event)">
            </div>

        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center">

            <img id="img-preview"
                 src="<?php echo BASEURL; ?>assets/img/default.png"
                 alt="Preview da Imagem"
                 class="foto-laptop-view"
                 style="display: none;">

        </div>

    </div>

    <div id="actions" class="row mt-3">

        <div class="col-md-12">

            <button type="submit" class="btn btn-azul text-offwhite">

                <i class="fa-solid fa-floppy-disk text-offwhite"></i>
                Salvar

            </button>

            <a href="index.php" class="btn btn-azulclaro text-offwhite">

                <i class="fa-solid fa-circle-left text-offwhite"></i>
                Cancelar

            </a>

        </div>

    </div>

</form>

<script>

function previewImagem(event) {

    const input = event.target;
    const preview = document.getElementById('img-preview');

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function(e) {

            preview.src = e.target.result;
            preview.style.display = 'block';

        };

        reader.readAsDataURL(input.files[0]);

    }

}

</script>

<?php include(FOOTER_TEMPLATE); ?>