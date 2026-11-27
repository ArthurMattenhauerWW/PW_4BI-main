
<?php

// Iniciar sessão antes de qualquer saída HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config.php");
require_once(DBAPI);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASEURL . "index.php");
    exit;
}

// Verificar campos vazios
if (empty($_POST['login']) || empty($_POST['senha'])) {
    $_SESSION['message'] = "Preencha o usuário e a senha!";
    $_SESSION['type'] = "danger";

    header("Location: " . BASEURL . "index.php");
    exit;
}

$bd = null;

try {

    // Conectar ao banco
    $bd = open_database();

    $bd->select_db(DB_NAME);

    // Dados recebidos do formulário
    $usuario = trim($_POST['login']);
    $senha = $_POST['senha'];

    // Buscar usuário pelo login
    $sql = "SELECT id, nome, user, password, perfil, foto
            FROM usuarios
            WHERE user = ?
            LIMIT 1";

    $stmt = $bd->prepare($sql);

    if (!$stmt) {
        throw new Exception("Erro ao preparar consulta: " . $bd->error);
    }

    $stmt->bind_param("s", $usuario);

    $stmt->execute();

    // Receber os dados encontrados
    $stmt->bind_result(
        $id,
        $nome,
        $user,
        $password,
        $perfil,
        $foto
    );

    if ($stmt->fetch()) {

        // Verificar senha conforme o perfil
        if ($perfil === 'admin') {

            // Administrador: senha criptografada
            $senhaCorreta = ($password === criptografia($senha));

        } else {

            // Usuário comum: senha sem criptografia
            $senhaCorreta = ($password === $senha);

        }

        if ($senhaCorreta) {

            // Renovar identificador da sessão
            session_regenerate_id(true);

            // Guardar informações do usuário na sessão
            $_SESSION['id'] = $id;
            $_SESSION['nome'] = $nome;
            $_SESSION['user'] = $user;
            $_SESSION['perfil'] = $perfil;
            $_SESSION['foto'] = $foto;

            // Mensagem de boas-vindas
            $_SESSION['bem_vindo'] = "Bem-vindo, " . $nome . "!";

            $stmt->close();
            $bd->close();

            // Voltar para a página inicial
            header("Location: " . BASEURL . "index.php");
            exit;

        } else {

            throw new Exception(
                "Não foi possível entrar! Verifique seu usuário e senha."
            );

        }

    } else {

        throw new Exception(
            "Não foi possível entrar! Verifique seu usuário e senha."
        );

    }

} catch (Exception $e) {

    $_SESSION['message'] = "Ocorreu um erro: " . $e->getMessage();
    $_SESSION['type'] = "danger";

    if ($bd instanceof mysqli) {
        $bd->close();
    }

    header("Location: " . BASEURL . "index.php");
    exit;
}

?>
