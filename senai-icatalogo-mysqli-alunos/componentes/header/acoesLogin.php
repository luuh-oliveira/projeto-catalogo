<?php

session_start();

require("../../database/conexao.php");

function realizarLogin($usuario, $senha, $conexao){

    $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    $dadosUsuario = mysqli_fetch_array($resultado);

    if (isset($dadosUsuario["usuario"]) && isset($dadosUsuario["senha"])) {
        
        $_SESSION["id"] = session_id();
        
        header("../index.php");

    } else {
        session_unset();
        session_destroy();

        header("../index.php");
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

    default:
        # code...
        break;
}
