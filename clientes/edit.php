
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

edit();

include(HEADER_TEMPLATE);

?>

<style>

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #ced4da;
    padding: 10px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-control:disabled {
    background-color: #e9ecef;
    opacity: 1;
}

.foto-cliente-edit {
    width: 250px;
    height: 250px;
    max-width: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    margin-top: 10px;
}

#actions .btn {
    margin-right: 8px;
    padding: 8px 16px;
}

#actions .btn i {
    margin-right: 6px;
}

</style>


<h2 class="mt-3">Atualizar Cliente Cadastrado</h2>

<form action="edit.php?id=<?php echo $cliente['id']; ?>"
      method="post"
      enctype="multipart/form-data">

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
                       value="<?php echo htmlspecialchars($cliente['nome']); ?>"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="email">E-mail</label>

                <input type="email"
                       class="form-control"
                       id="email"
                       name="cliente[email]"
                       maxlength="150"
                       value="<?php echo htmlspecialchars($cliente['email']); ?>"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="telefone">Telefone</label>

                <input type="text"
                       class="form-control"
                       id="telefone"
                       name="cliente[telefone]"
                       maxlength="20"
                       value="<?php echo htmlspecialchars($cliente['telefone']); ?>"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="cpf">CPF</label>

                <input type="text"
                       class="form-control"
                       id="cpf"
                       name="cliente[cpf]"
                       maxlength="20"
                       value="<?php echo htmlspecialchars($cliente['cpf']); ?>"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="criado_em">Data do Cadastro</label>

                <input type="text"
                       class="form-control"
                       id="criado_em"
                       value="<?php
                           echo !empty($cliente['criado_em'])
                               ? date('d/m/Y H:i:s', strtotime($cliente['criado_em']))
                               : '';
                       ?>"
                       disabled>

            </div>


            <div class="form-group mb-3">

                <label for="foto">Trocar Foto (opcional)</label>

                <input type="file"
                       class="form-control"
                       id="foto"
                       name="foto"
                       accept="image/*"
                       onchange="previewImagem(event)">

                <small class="text-muted">
                    Deixe vazio para manter a foto atual.
                </small>

            </div>

        </div>


        <div class="col-md-6 d-flex align-items-center justify-content-center">

            <img id="img-preview"
                 src="<?php echo BASEURL; ?>assets/img/<?php echo rawurlencode(basename($cliente['foto'])); ?>"
                 alt="<?php echo htmlspecialchars($cliente['nome']); ?>"
                 class="foto-cliente-edit">

        </div>

    </div>


    <div id="actions" class="row mt-3">

        <div class="col-md-12">

            <button type="submit" class="btn btn-azul text-offwhite">

                <i class="fa-solid fa-floppy-disk"></i>
                Salvar

            </button>

            <a href="index.php" class="btn btn-azulclaro text-offwhite">

                <i class="fa-solid fa-ban"></i>
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
        };

        reader.readAsDataURL(input.files[0]);

    }

}

</script>

<?php include(FOOTER_TEMPLATE); ?>
