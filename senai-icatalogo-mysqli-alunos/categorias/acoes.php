<?php

session_start();

//Conexão com banco de dados
require('../database/conexao.php');

/*Tratamento dos dados vindos do formulário 
    - Tipos da ação
    - Execução dos processos da ação solicitada
*/

//função de validação
function validaCampos()
{
    $erros = [];

    if (!isset($_POST["descricao"]) || $_POST["descricao"] == "") {
        
        $erros[] = "O campo descrição é de preenchimento obrigatório";

    }
    return $erros;

}

switch ($_POST["acao"]) {
    case 'inserir':

        //validação
        $erros = validaCampos();

        if (count($erros) > 0) {
            
            $_SESSION["erros"] = $erros;

            header("location: index.php");

            exit;
        }

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
    
    case 'deletar':
        $categoriaId= $_POST["categoriaId"];

        $sql = "DELETE FROM tbl_categoria WHERE id = $categoriaId";
        $resultado = mysqli_query($conexao, $sql);

        header("location: index.php");

        break;
    
    case 'editar':
        
        $id = $_POST["id"];
        $descricao = $_POST["descricao"];

        $sql = "UPDATE tbl_categoria SET descricao = '$descricao' WHERE id = $id";
        $resultado = mysqli_query($conexao, $sql);

        header("location: index.php");

        break;
    default:
        # code...
        break;
}




?>