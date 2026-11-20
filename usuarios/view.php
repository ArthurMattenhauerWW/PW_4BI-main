<?php
    //view.php
    include ("functions.php");
    view($_GET['id']);
    include (HEADER_TEMPLATE);
?>

    <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert" id="actions">
            <?php echo $_SESSION['message']; ?>
            <button type ="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cloese"></button>
        </div>

    <?php else : ?>
        <header>
            <h2 class="mt-3 text-azul">Usuário <?php echo $user['id']; ?></h2>
        </header>
        <hr>

        <dl class="dl-horizontal">
            <dt>Nome:</dt>
            <dd><?php echo $user['nome']; ?></dd>

            <dt>Login:</dt>
            <dd><?php echo $user['user']; ?></dd>

            <dt>Senha:</dt>
            <dd><?php echo $user['password']; ?></dd>

            <dt>Foto:</dt>
            <dd><?php 
                    if(!empty($user['foto'])) {
                        echo "<img src=\"fotos/" . $user['foto'] . "\" class=\"shadow p-1 mb-1 bg-body rounded\" width=\"300px\">";
                    } else {
                        echo "<img src=\"fotos/semimagem.jpg\" class=\"shadow p-1 mb-1 bg-body rounded\" width=\"300px\">";
                    }
                    ?>
            </dd>
        </dl>
    <?php endif; ?>
        <div id="actions" class="row">
            <div class="col-md-12">
                <?php if (empty($_SESSION['message'])) : ?>
                <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-azul text-offwhite"><i class="fa-solid fa-pen-to-square text-offwhite"></i> Editar</a>
                <?php endif; ?>
                <a href="index.php" class="btn btn-azulclaro text-offwhite"><i class="fa-solid fa-circle-left text-offwhite"></i> Voltar</a>
            </div>
        </div>
    
<?php include(FOOTER_TEMPLATE) ?>

<?php clear_message();  ?>