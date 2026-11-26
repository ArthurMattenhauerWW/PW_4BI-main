<?php
ob_start();

include "../config.php";
include DBAPI;

$cliente = null;
$clientes = null;

/**
 * Formatar Datas
 */
function formatdata($data, $formato) {
    $dt = new DateTime($data, new DateTimeZone("America/Sao_Paulo"));
    return $dt->format($formato);
}

/**
 * Listagem de Clientes
 */
function index() {
    global $clientes;
    $clientes = find("clientes");
}

/**
 * Visualização de um Cliente
 */
function view($id = null) {
    global $cliente;
    $cliente = find('clientes', $id);
}


function add() {

    if (!empty($_POST['cliente'])) {

        $cliente = $_POST['cliente'];

        // Define a data e hora de São Paulo
        
        // Trata o upload da foto
        if (!empty($_FILES['foto']['name'])) {

            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nomeFoto = uniqid('cliente_') . '.' . $ext;
            $destino = __DIR__ . '/../assets/img/' . $nomeFoto;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $cliente['foto'] = $nomeFoto;
            } else {
                $cliente['foto'] = 'semfoto.jpg';
            }

        } else {

            // Se nenhuma foto foi enviada
            $cliente['foto'] = 'semfoto.jpg';
        }

        save('clientes', $cliente);

        header('location: index.php');
        exit();
    }
}
/**
 * Salvar um registro na tabela
 */
function save($table = null, $data = null) {

    $database = open_database();

    $columns = null;
    $values = null;

    foreach ($data as $key => $value) {
        $columns .= trim($key, "'") . ",";
        $values .= "'" . $database->real_escape_string($value) . "',";
    }

    // Remove a última vírgula
    $columns = rtrim($columns, ',');
    $values = rtrim($values, ',');

    $sql = "INSERT INTO $table ($columns) VALUES ($values);";

    try {

        $database->query($sql);

        $_SESSION['message'] = 'Cliente cadastrado com sucesso.';
        $_SESSION['type'] = 'success';

    } catch (Exception $e) {

        $_SESSION['message'] = 'Não foi possível realizar a operação.';
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/**
 * Atualização/Edição de Cliente
 * Mantém a foto atual se nenhuma nova for enviada
 */
function edit() {

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        if (isset($_POST['cliente'])) {

            $cliente = $_POST['cliente'];

            if (!empty($_FILES['foto']['name'])) {

                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $nomeFoto = uniqid('cliente_') . '.' . $ext;
                $destino = __DIR__ . '/../assets/img/' . $nomeFoto;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                    $cliente['foto'] = $nomeFoto;
                }

            } else {

                // Mantém a foto atual no banco de dados
                unset($cliente['foto']);
            }

            update("clientes", $id, $cliente);

            header("location: index.php");
            exit();

        } else {

            global $cliente;
            $cliente = find("clientes", $id);
        }

    } else {

        header('location: index.php');
        exit();
    }
}

/**
 * Atualiza um registro em uma tabela por ID
 */
function update($table = null, $id = 0, $data = null) {

    $database = open_database();

    $items = null;

    foreach ($data as $key => $value) {
        $items .= trim($key, "'") . "='" .
        $database->real_escape_string($value) . "',";
    }

    // Remove a última vírgula
    $items = rtrim($items, ',');

    $sql = "UPDATE $table SET $items WHERE id=" . intval($id) . ";";

    try {

        $database->query($sql);

        $_SESSION['message'] = 'Cliente atualizado com sucesso.';
        $_SESSION['type'] = 'success';

    } catch (Exception $e) {

        $_SESSION['message'] = 'Não foi possível realizar a operação.<br>' . $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/**
 * Exclusão de Cliente
 */
function delete($id = null) {

    global $cliente;

    $cliente = remove('clientes', $id);

    header('location: index.php');
    exit();
}

/**
 * Remove um registro de uma tabela
 */
function remove($table = null, $id = null) {

    $database = open_database();

    try {

        if ($id) {

            $sql = "DELETE FROM $table WHERE id = " . intval($id);
            $result = $database->query($sql);

            if ($result) {

                $_SESSION['message'] = "Cliente removido com sucesso.";
                $_SESSION['type'] = 'success';
            }
        }

    } catch (Exception $e) {

        $_SESSION['message'] = "Não foi possível realizar a operação.<br>" . $e->getMessage();
        $_SESSION['type'] = "danger";
    }

    close_database($database);
}