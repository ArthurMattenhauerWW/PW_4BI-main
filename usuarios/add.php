
<?php

require_once('../config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        Somente administradores logados podem cadastrar usuários.

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

// Processa o cadastro
add();

// Inclui o cabeçalho
include(HEADER_TEMPLATE);

?>

<h2 class="mt-3">Cadastro de Usuário</h2>

<form action="add.php" method="post" enctype="multipart/form-data">

    <hr />

    <div class="row">

        <div class="col-md-6">

            <div class="form-group mb-3">

                <label for="nome">Nome</label>

                <input type="text"
                       class="form-control"
                       id="nome"
                       name="usuario[nome]"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="user">Usuário (Login)</label>

                <input type="text"
                       class="form-control"
                       id="user"
                       name="usuario[user]"
                       required>

            </div>


            <div class="form-group mb-3">

                <label for="password">Senha</label>

                <input type="password"
                       class="form-control"
                       id="password"
                       name="usuario[password]"
                       required>

            </div>


            <div class="form-group mb-3">

                <label><strong>Tipo de Perfil:</strong></label>

                <div class="form-check">

                    <input class="form-check-input"
                           type="radio"
                           name="usuario[perfil]"
                           id="perfilComum"
                           value="comum"
                           checked>

                    <label class="form-check-label" for="perfilComum">
                        Comum
                    </label>

                </div>

                <div class="form-check">

                    <input class="form-check-input"
                           type="radio"
                           name="usuario[perfil]"
                           id="perfilAdmin"
                           value="admin">

                    <label class="form-check-label" for="perfilAdmin">
                        Admin
                    </label>

                </div>

            </div>


            <div class="form-group mb-3">

                <label for="foto">Foto do Usuário</label>

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
                 style="max-height: 200px; display: none;">

        </div>

    </div>


    <div id="actions" class="row mt-3">

        <div class="col-md-12">

            <button type="submit" class="btn btn-azul text-offwhite">

                <i class="fa-solid fa-floppy-disk text-offwhite"></i>
                Cadastrar

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
        }

        reader.readAsDataURL(input.files[0]);

    }

}

</script>

<?php include(FOOTER_TEMPLATE); ?>
