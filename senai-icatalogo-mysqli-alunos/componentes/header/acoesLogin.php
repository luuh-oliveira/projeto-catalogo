<?php

session_start();

require("../../database/conexao.php");

function realizarLogin($usuario, $senha, $conexao){

    $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    $dadosUsuario = mysqli_fetch_array($resultado);

    if (isset($dadosUsuario["usuario"]) && isset($dadosUsuario["senha"]) && password_verify($senha, $dadosUsuario["senha"])) {
        
        $_SESSION["usuarioId"] = $dadosUsuario["id"];
        $_SESSION["nome"] = $dadosUsuario[ "nome"];
        
        // echo ($_SESSION["usuarioId"]);
        // echo ($_SESSION["nome"]);
        // exit;

        header("location: ../../produtos/index.php");

    } else {

        session_destroy();
        header("location: ../../index.php");
    }

}

switch ($_POST["acao"]) {
    case 'login':
        
        if (isset($_POST["usuario"]) && isset($_POST["senha"])) {

            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];

            realizarLogin($usuario, $senha, $conexao);
        
        }
        
        break;
    
    case 'logout':

        session_destroy();
        header("location: ../../index.php");

        break;

    default:
        # code...
        break;
}
