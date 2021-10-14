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



        //INSERÇÃO DE DADOS NA BASE DE DADOS DO MYSQL: 8/10

        //RECEBIMENTO DOS DADOS:    
        $descricao = $_POST["descricao"];
        $peso = $_POST["peso"];
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = $_POST["valor"];
        $desconto = $_POST["desconto"];
        $categoria_id = $_POST["categoria"];

        //CRIAÇÃO DA INSTRUÇÃO SQL DE INSERÇÃO:
        $sql = "INSERT INTO tbl_produto
        (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) /*CAMPOS QUE IRÃO RECEBER*/
        VALUES('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor , $desconto, '$novoNome', $categoria_id)";/*VALORES QUE OS CAMPOS IRÃO RECEBER */
        
        //OBS: AS VARIAVEIS QUE SÃO VARCHAR(TEXTO) SÃO ENVOLVIDAS POR ASPAS SIMPLES

        //EXECUÇÃO DO SQL DE INSERÇÃO:
        $resultado = mysqli_query($conexao, $sql);

        //REDIRECIONAR PARA INDEX:
        header('location: index.php');

        break;
    
    default:
        # code...
        break;
}




?>