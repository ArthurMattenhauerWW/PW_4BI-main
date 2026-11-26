
<?php

require_once('../config.php');

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificação de acesso
if (empty($_SESSION['user'])) {
    header('location: index.php');
    exit;
}

// Carregar funções dos clientes
require_once('functions.php');

// Verificar se o ID foi informado
if (isset($_GET['id'])) {

    delete($_GET['id']);

} else {

    die("Erro: ID do cliente não definido.");

}

?>
