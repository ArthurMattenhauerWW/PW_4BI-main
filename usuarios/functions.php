<?php
ob_start();

include "../config.php";
include DBAPI;

$users = null;
$user = null;

/**
 *  Fomatar as datas
 */
function formatadata($data, $formato)
{
    $dt = new DateTime($data, new DateTimeZone("America/Sao_Paulo")); // "-0300"
    return $dt->format($formato);
}

/**
 *  Fomatar as telefones
 */
function telefone($tel)
{ //15997332244
    return "(" . substr($tel, 0, 2) . ")" . substr($tel, 2, 5)
        . "-" . substr($tel, 7, 4);
}

/**
 *  Fomatar as telefones
 */
function cep($cep)
{
    // Se vira para fazer
}

/**
 *  Listagem de Usuários
 */
function index()
{
    global $users;
    $users = find_all("usuarios");
}

/**
 *  Visualização de um Usuário
 */
function view($id = null)
{
    global $user;
    $user = find("usuarios", $id);
}

/**
 *  Cadastro de Usuários
 */
function add()
{

    if (!empty($_POST['usuario'])) {

        //$today = date_create('now', new DateTimeZone('America/Sao_Paulo'));
        //$today = new DateTime("now", new DateTimeZone("-0300"));

        $user = $_POST['usuario'];
        //$customer['modified'] = $customer['created'] = $today->format("Y-m-d H:i:s");

        save("usuarios", $user);
        header("location: index.php");
    }
}
// Modifique os elementos abaixo, pois não estão adaptados ainda
/**
 * Atualizacao/Edicao de Usuário
 */
function edit()
{

    //$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
    $now = new DateTime("now", new DateTimeZone("-0300"));
    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        if (isset($_POST['customer'])) {

            $customer = $_POST['customer'];
            $customer['modified'] = $now->format("Y-m-d H:i:s");

            update("customers", $id, $customer);
            header("location: index.php");
        } else {

            global $customer;
            $customer = find("customers", $id);
        }
    } else {
        header("location: index.php");
    }
}

/**
 *  Exclusão de um Cliente
 */
function delete($id = null)
{

    global $customer;
    $customer = remove("customers", $id);

    header("location: index.php");
}

?>