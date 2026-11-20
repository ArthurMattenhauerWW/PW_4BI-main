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
function index() {
    global $users;
    if(!empty($_POST['users'])){
        $users = filter("users", "nome like '%" . $_POST['users'] . "%'");
    } else {
        $users = find_all("users");
    }
}


function upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo){
    try {
        $nomearquivo = basename($arquivo_destino);
        $uploadOK = 1;
        //verificando se o arquivo é uma imagem
        if(isset($_POST["submit"])) {
            $check = getimagesize($nome_temp);
            if($check !== false) {
                $_SESSION['message'] = "File is an image - " . $check["mime"] . ".";
                $_SESSION['type'] = 'info';
                $uploadOK = 1;
            } else {
                $uploadOK = 0;
                throw new Exception("O arquivo não é uma imagem!");
            }
        }

        //verificando se o arquivo ja existe na pasta
        if (file_exists($arquivo_destino)) {
            $uploadOK = 0;
            throw new Exception("Desculpe, o arquivo já existe!");
        }

        //verificando o tamanho do arquivo
        if ($tamanho_arquivo > 5000000) {
            $uploadOK = 0;
            throw new Exception("Desculpe, mas o arquivo é muito grande!");
        }

        //permitindo certos formatos
        if($tipo_arquivo != "jpg" && $tipo_arquivo != "png" && $tipo_arquivo !="jpeg" && $tipo_arquivo !="gif" ) {
            $uploadOK = 0;
            throw new Exception("Desculpe, mas o arquivo não pode ser enviado.");
        }

        //verificando se $uploadOK foi definido como 0 devido a um erro
        if  ($uploadOK == 0) {
            throw new Exception("Desculpe, mas o arquivo não pode ser enviado");
        } else {
            //se tudo estiver ok, tentamos fazer o upload do arquivo
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $arquivo_destino)) {
                //colocando o nome do arquivo da foto do usuario no vetor
                $_SESSION['message'] = "O arquivo " . htmlspecialchars($nomearquivo) . " foi armazenado.";
                $_SESSION['type'] = "success";
            } else {
                throw new Exception("Desculpe, mas o arquivo não pode ser enviado.");
            }
        }


    } catch (Exception $e) {
        $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
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
function add() {
    if (!empty($_POST['usuario'])) {
        try {
            $user = $_POST['usuario'];

            if (!empty($_FILES["foto"]["name"])) {
                //upload da foto
                $pasta_destino = "fotos/"; //pasta onde ficam as fotos
                $arquivo_destino = $pasta_destino . basename($_FILES["fotos"]["name"]); //caminho completo até o arquivo que será gravado
                $nomearquivo = basename($_FILES["foto"]["name"]); //nome do arquivo
                $resolucao_arquivo = getimagesize($_FILES["foto"]["tmp_name"]); 
                $tamanho_arquivo = $_FILES["foto"]["size"]; //tamanho do arquivo em bytes
                $nome_temp = $_FILES["foto"]["tmp_name"]; //nome e caminho do arquivo no servidor
                $tipo_arquivo = strtolower(pathinfo($arquivo_destino, PATHINFO_EXTENSION)); //extensão do arquivo

                //chamada da função upload para gravar a imagem
                upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo);

                $user['foto'] = $nomearquivo;
            }
            //criptografando a senha
            if(!empty($usuario['password'])) {
                $senha = criptografia($user['passoword']);  
                $usuario['password'] = $senha;
            }

            $user['foto'] = $nomearquivo;

            save('usuarios', $usuario);
            header('Location: index.php');
        } catch (Exception $e) {
            $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
            $_SESSION['type'] = "danger"; 
        }

        //$today = date_create('now', new DateTimeZone('America/Sao_Paulo'));
        //$today = new DateTime("now", new DateTimeZone("-0300"));
    }
}
// Modifique os elementos abaixo, pois não estão adaptados ainda
/**
 * Atualizacao/Edicao de Usuário
 */
function edit() {
        try {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if (isset($_POST['usuario'])) {

                    $user = $_POST['usuario'];

                    //criptografando a senha
                    if(!empty($usuario['password'])) {
                        $senha = criptografia($user['passoword']);  
                        $usuario['password'] = $senha;
                    }

                    if (!empty($_FILES["foto"]["name"])) {
                        //upload da foto
                        $pasta_destino = "fotos/"; //pasta onde ficam as fotos
                        $arquivo_destino = $pasta_destino . basename($_FILES["fotos"]["name"]); //caminho completo até o arquivo que será gravado
                        $nomearquivo = basename($_FILES["foto"]["name"]); //nome do arquivo
                        $resolucao_arquivo = getimagesize($_FILES["foto"]["tmp_name"]); 
                        $tamanho_arquivo = $_FILES["foto"]["size"]; //tamanho do arquivo em bytes
                        $nome_temp = $_FILES["foto"]["tmp_name"]; //nome e caminho do arquivo no servidor
                        $tipo_arquivo = strtolower(pathinfo($arquivo_destino, PATHINFO_EXTENSION)); //extensão do arquivo

                        //chamada da função upload para gravar a imagem
                        upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo);

                        $user['foto'] = $nomearquivo;
                    }
                    
                    
                    $user['foto'] = $nomearquivo;

                    update('usuarios', $id, $usuario);
                    header('Location: index.php');
                } else {
                    global $usuario;
                    $usuario = find("usuarios", $id);
                }
                } else {
                    header("Location: index.php");
                }
        } catch (Exception $e) {
                    $_SESSION['message'] = "Aconteceu um erro: " . $e->getMessage();
                    $_SESSION['type'] = "danger";
        }
        //$today = date_create('now', new DateTimeZone('America/Sao_Paulo'));
        //$today = new DateTime("now", new DateTimeZone("-0300"));
    }

    //$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
    // $now = new DateTime("now", new DateTimeZone("-0300"));
    // if (isset($_GET['id'])) {

    

    //     $id = $_GET['id'];

    //     if (isset($_POST['customer'])) {

    //         $customer = $_POST['customer'];
    //         $customer['modified'] = $now->format("Y-m-d H:i:s");

    //         update("customers", $id, $customer);
    //         header("location: index.php");
    //     } else {

    //         global $customer;
    //         $customer = find("customers", $id);
    //     }
    // } else {
    //     header("location: index.php");
    // }


/**
 *  Exclusão de um Cliente
 */
function delete($id = null)
{

    global $customer;
    $customer = remove("customers", $id);

    header("location: index.php");
}

function clear_message() {
    $_SESSION['message'] = null;
    $_SESSION['type'] = null;
}

?>