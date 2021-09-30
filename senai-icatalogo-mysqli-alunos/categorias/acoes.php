<?php

//Conexão com banco de dados
require('../database/conexao.php');

/*Tratamento dos dados vindos do formulário 
    - Tipos da ação
    - Execução dos processos da ação solicitada
*/

switch ($_POST["acao"]) {
    case 'inserir':

        $descricao = $_POST["descricao"];

        //Montagem da instrução sql da inserção de dados
        $sql = "INSERT INTO tbl_categoria (descricao) VALUES ('$descricao')";

        /*mysqli_query - Parâmetros
            1- Uma conexão aberta e válida
            2- Uma instrução sql válida
        */

        $resultado = mysqli_query($conexao, $sql);

        header("location: index.php");

        // echo "<pre>";
        // var_dump($resultado);
        // echo "</pre>";

        break;
    
    default:
        # code...
        break;
}




?>