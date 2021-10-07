<?php

require("../database/conexao.php");

switch ($_POST["acao"]) {
    case 'inserir':
        
        // tratamento da imagem para upload
        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";

        // recupera o nome do arquivo
        $nomeArquivo = $_FILES["foto"]["name"];

        // recuperar a extensão do arquivo
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        // definir um novo nome para o arquivo de imagem
        $novoNome = md5(microtime()) . "." . $extensao;

        // upload do arquivo
        move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");

        break;
    
    default:
        # code...
        break;
}




?>