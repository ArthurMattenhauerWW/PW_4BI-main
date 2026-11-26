
<?php

require_once('../config.php');

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar funções
require_once('functions.php');

// Controle de acesso: somente administrador
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

        Você não tem permissão para acessar esta página.
        Somente administradores logados podem editar usuários.

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

// Processa a edição
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

.foto-laptop-edit {
    max-width: 100%;
    max-height: 250px;
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 50%;
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


<h2 class="mt-3">Atualizar Usuário Cadastrado</h2>

<form action="edit.php?id=<?php echo $usuario['id']; ?>"
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
                       name="usuario[nome]"
                       value="<?php echo htmlspecialchars($usuario['nome']); ?>"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="user">Usuário (Login)</label>

                <input type="text"
                       class="form-control"
                       id="user"
                       name="usuario[user]"
                       value="<?php echo htmlspecialchars($usuario['user']); ?>"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="password">Senha</label>

                <input type="password"
                       class="form-control"
                       id="password"
                       name="usuario[password]">

                <small class="text-muted">
                    Deixe em branco para manter a senha atual.
                </small>

            </div>


            <div class="form-group mb-3">

                <label><strong>Tipo de Perfil:</strong></label>

                <div class="form-check mt-1">

                    <input class="form-check-input"
                           type="radio"
                           name="usuario[perfil]"
                           id="perfilComum"
                           value="comum"
                           <?php echo ($usuario['perfil'] == 'comum') ? 'checked' : ''; ?>>

                    <label class="form-check-label" for="perfilComum">
                        Comum
                    </label>

                </div>

                <div class="form-check">

                    <input class="form-check-input"
                           type="radio"
                           name="usuario[perfil]"
                           id="perfilAdmin"
                           value="admin"
                           <?php echo ($usuario['perfil'] == 'admin') ? 'checked' : ''; ?>>

                    <label class="form-check-label" for="perfilAdmin">
                        Admin
                    </label>

                </div>

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


        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">

            <label class="mb-2">
                <strong>Foto Atual / Pré-visualização:</strong>
            </label>

            <img id="img-preview"
                 src="<?php echo BASEURL; ?>assets/img/<?php echo !empty($usuario['foto']) ? rawurlencode(basename($usuario['foto'])) : 'default.png'; ?>"
                 alt="<?php echo htmlspecialchars($usuario['nome']); ?>"
                 class="foto-laptop-edit">

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
        }

        reader.readAsDataURL(input.files[0]);

    }

}

</script>

<?php include(FOOTER_TEMPLATE); ?>
