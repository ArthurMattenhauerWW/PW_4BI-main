<?php
    //edit.php
    include ("functions.php");
    edit();
    include (HEADER_TEMPLATE);
?>

    <header>
        <h2 class="mt-3 text-azul">Atualizar Usuário</h2>
    </header>

    <form action="edit.php?id=<?php echo $user['id']; ?>" method="post" enctype="multipart/form-data" >
        <!-- area de campos do form -->
         <hr>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="user[nome]" value="<?php echo $user['nome']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="user">Usuario (Login)</label>
                    <input type="text" class="form-control" name="user[user]" value="<?php echo $user['user']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" name="user[password]" value="">
                </div>
            </div>
            <div class="row">
                <?php 
                    $foto = "";
                    if(!empty($usuario['foto'])){
                        $foto = "semimagem.jpg";
                    } else {
                        $foto = $usuario['foto'];
                    }
                ?>
                <div class="form-group col-md-4">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" src="fotos/<?php echo $foto ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="pre">Pré-visualização:</label>
                    <img class="form-control shadow p-2 mb-2 bg-body rounded" id="imgPreview" src="fotos/<?php echo $foto ?>" alt="Foto do usuário">
                </div>
            </div>
        <div id="actions" class="row">
            <div class="cpç-md-12">
                <button type="submit" class="btn btn-azul text-offwhite"><i class="fa-solid fa-floppy-disk text-offwhite"></i> Salvar</button>
                <a href="index.php" class="btn btn-azulclaro text-offwhite"><i class="fa-solid fa-circle-left text-offwhite"></i> Cancelar</a>
            </div>
        </div>
    </form>

<?php include(FOOTER_TEMPLATE); ?>

<script>
    $(document).ready(() => {
        $("$foto").change(function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
