<?php

session_start();

require("../../database/conexao.php");

switch ($_POST["acao"]) {
    case 'login':
        
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        break;
    
    default:
        # code...
        break;
}




?>