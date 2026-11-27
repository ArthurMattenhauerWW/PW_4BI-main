
<?php

if (!defined('ABSPATH')) {
    include('../config.php');
}

require_once(DBAPI);

$usuarios = null;
$usuario = null;


/**
 * Listar todos os Usuários
 */
function index() {
    global $usuarios;

    $database = open_database();
    $result = $database->query("SELECT * FROM usuarios ORDER BY id DESC");

    if ($result->num_rows > 0) {
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $usuarios = null;
    }

    $database->close();
}


/**
 * Obter um Usuário por ID
 */
function view($id = null) {
    global $usuario;

    $database = open_database();
    $result = $database->query("SELECT * FROM usuarios WHERE id = " . (int)$id);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        $usuario = null;
    }

    $database->close();
}


/**
 * Registrar novo Usuário
 * Foto opcional -> semfoto.jpg
 */
function add() {

    if (!empty($_POST['usuario'])) {

        $usuario = $_POST['usuario'];

        // 1. Criptografar somente a senha do administrador
        if (!empty($usuario['password'])) {

            if ($usuario['perfil'] === 'admin') {
                $usuario['password'] = criptografia($usuario['password']);
            }
            // Usuário comum: mantém a senha sem criptografia
        }

        // 2. Tratar upload da foto
        if (!empty($_FILES['foto']['name'])) {

            $uploaded_name = $_FILES['foto']['name'];
            $target_dir = ABSPATH . 'assets/img/';

            $file_extension = pathinfo($uploaded_name, PATHINFO_EXTENSION);
            $new_filename = uniqid('user_') . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $usuario['foto'] = $new_filename;
            } else {
                $usuario['foto'] = 'semfoto.jpg';
            }

        } else {

            $usuario['foto'] = 'semfoto.jpg';

        }

        // 3. Salvar na base de dados
        $database = open_database();

        $nome = $database->real_escape_string($usuario['nome']);
        $user = $database->real_escape_string($usuario['user']);
        $password = $database->real_escape_string($usuario['password']);
        $perfil = $database->real_escape_string($usuario['perfil']);
        $foto = $database->real_escape_string($usuario['foto']);

        $sql = "INSERT INTO usuarios (nome, user, password, perfil, foto)
                VALUES ('$nome', '$user', '$password', '$perfil', '$foto')";

        if ($database->query($sql) === TRUE) {

            $_SESSION['message'] = "Usuário cadastrado com sucesso!";
            $_SESSION['type'] = "success";
            header('location: index.php');

        } else {

            $_SESSION['message'] = "Erro ao cadastrar usuário: " . $database->error;
            $_SESSION['type'] = "danger";

        }

        $database->close();
    }
}


/**
 * Atualizar / Editar Usuário
 * Mantém a foto atual se nenhuma nova for enviada
 */
function edit() {

    $database = open_database();

    if (isset($_GET['id'])) {

        $id = (int)$_GET['id'];

        if (isset($_POST['usuario'])) {

            $usuario = $_POST['usuario'];

            // 1. Criptografar somente se a senha foi preenchida
            if (!empty($usuario['password'])) {

                if ($usuario['perfil'] === 'admin') {
                    $usuario['password'] = criptografia($usuario['password']);
                }
                // Usuário comum: mantém a senha sem criptografia

            } else {

                unset($usuario['password']);

            }

            // 2. Tratar nova foto se enviada
            if (!empty($_FILES['foto']['name'])) {

                $uploaded_name = $_FILES['foto']['name'];
                $target_dir = ABSPATH . 'assets/img/';

                $file_extension = pathinfo($uploaded_name, PATHINFO_EXTENSION);
                $new_filename = uniqid('user_') . '.' . $file_extension;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $new_filename)) {
                    $usuario['foto'] = $new_filename;
                }
            }

            // 3. Construir query de atualização
            $nome = $database->real_escape_string($usuario['nome']);
            $user = $database->real_escape_string($usuario['user']);
            $perfil = $database->real_escape_string($usuario['perfil']);

            $sql = "UPDATE usuarios
                    SET nome = '$nome',
                        user = '$user',
                        perfil = '$perfil'";

            if (isset($usuario['password'])) {

                $password = $database->real_escape_string($usuario['password']);
                $sql .= ", password = '$password'";

            }

            if (isset($usuario['foto'])) {

                $foto = $database->real_escape_string($usuario['foto']);
                $sql .= ", foto = '$foto'";

            }

            $sql .= " WHERE id = $id";

            if ($database->query($sql) === TRUE) {

                $_SESSION['message'] = "Usuário atualizado com sucesso!";
                $_SESSION['type'] = "success";
                header('location: index.php');

            } else {

                $_SESSION['message'] = "Erro ao atualizar usuário: " . $database->error;
                $_SESSION['type'] = "danger";

            }

        } else {

            global $usuario;

            $result = $database->query("SELECT * FROM usuarios WHERE id = $id");

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
            }
        }

    } else {

        header('location: index.php');

    }

    $database->close();
}


/**
 * Apagar um Usuário
 */
function delete($id = null) {

    $database = open_database();

    $id = (int)$id;

    $sql = "DELETE FROM usuarios WHERE id = $id";

    if ($database->query($sql) === TRUE) {

        $_SESSION['message'] = "Usuário excluído com sucesso!";
        $_SESSION['type'] = "success";

    } else {

        $_SESSION['message'] = "Erro ao excluir usuário: " . $database->error;
        $_SESSION['type'] = "danger";

    }

    $database->close();

    header('location: index.php');
}
