<?php
    //delete.php
    include ("functions.php");
    
    if (isset($_GET['id'])) {
        try {
            //consultando o usuario para obter o nome do arquivo da foto
            $usuario = find("usuarios", $_GET['id']);
            //chamando a função delete para apagar o usuario do banco de dadoas
            delete($_GET['id']);
            //apagando o arquivo da foto do usuario na pasta fotos
            unlink("fotos/" . $usuario['foto']);
        } catch (Exception $e) {
            $_SESSION['message'] = "Não foi possível realizar a operação: " . $e->getMessage();
            $_SESSION['type'] = "danger";
        }
    }
?>
