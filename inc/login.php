<?php 
require_once('config.php'); 
include(ABSPATH . 'inc/header.php'); 
?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fa fa-sign-in"></i> Login</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php clear_message(); ?>
            <?php endif; ?>

            <!-- Formulário de Login -->
            <form action="<?php echo BASEURL; ?>inc/valida.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" name="login" class="btn btn-primary">Entrar</button>
                </div>

                <div class="mt-3 text-center">
                    <p>Ainda não tem uma conta? <a href="<?php echo BASEURL; ?>inc/add.php">Registe-se aqui</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(ABSPATH . 'inc/footer.php'); ?>