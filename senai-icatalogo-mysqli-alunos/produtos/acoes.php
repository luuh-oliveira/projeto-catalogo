<?php
    //
    session_start();

    require("../database/conexao.php");

    //Validação dos campos (15/10)
    function validarCampos()
    {
        //Array das mensagens de erro
        $erros = [];

        /*validação:
        - descrição*/
        if (!isset($_POST["descricao"]) || $_POST["descricao"] == "") {
            
            $erros[] = "O CAMPO DESCRIÇÃO É OBRIGATÓRIO";

        } 
        
        //- peso
        if (!isset($_POST["peso"]) || $_POST["peso"] == "") {
            
            $erros[] = "O CAMPO PESO É OBRIGATÓRIO";
            
        }elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {
            $erros[] = "O CAMPO PESO DEVE SER UM NÚMERO";
            
        }
        
        //- quantidade
        if (!isset($_POST["quantidade"]) || $_POST["quantidade"] == "") {
            
            $erros[] = "O CAMPO QUANTIDADE É OBRIGATÓRIO";
            
        }elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {
            $erros[] = "O CAMPO QUANTIDADE DEVE SER UM NÚMERO";
            
        }
        
        //- cor
        if (!isset($_POST["cor"]) || $_POST["cor"] == "") {
            
            $erros[] = "O CAMPO COR É OBRIGATÓRIO";
            
        } 
        
        //- tamanho
        if (!isset($_POST["tamanho"]) || $_POST["tamanho"] == "") {
            
            $erros[] = "O CAMPO TAMANHO É OBRIGATÓRIO";
            
        } 

        //- valor
        if (!isset($_POST["valor"]) || $_POST["valor"] == "") {
            
            $erros[] = "O CAMPO VALOR É OBRIGATÓRIO";
            
        }elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))) {
            $erros[] = "O CAMPO VALOR DEVE SER UM NÚMERO";
            
        }
        
        //- desconto
        if (!isset($_POST["desconto"]) || $_POST["desconto"] == "") {
            
            $erros[] = "O CAMPO DESCONTO É OBRIGATÓRIO";
            
        }elseif (!is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
            $erros[] = "O CAMPO DESCONTO DEVE SER UM NÚMERO";
            
        }
        
        //- categoria
        if (!isset($_POST["categoria"]) || $_POST["categoria"] == "") {
            
            $erros[] = "O CAMPO CATEGORIA É OBRIGATÓRIO";
            
        } 

        //- imagem
        if ($_FILES["foto"]["error"]== UPLOAD_ERR_NO_FILE) {

            $erros[] =  "O ARQUIVO PRECISA SER UMA IMAGEM";

        }else {
            $imagemInfos = getimagesize($_FILES["foto"]["tmp"]);

            if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {
                $erros[] = "O ARQUIVO NÃO PODE SER MAIOR QUE 2MB";
            }

            $width = $imagemInfos[0];
            $height = $imagemInfos[1];

            if ($width != $height) {
                $erros[] = "A IMAGEM PRECISA SER QUADRADA";
            }

        }

        return $erros;
        
    }

    switch ($_POST["acao"]) {

        case 'inserir':
            
            //
            $erros = validarCampos();

            if (count($erros) > 0) {
                
                $_SESSION["erros"] = $erros;

                header("location: novo/index.php");
                exit;
            }

            /* TRATAMENTO DA IMAGEM PARA UPLOAD: */

            //RECUPERA O NOME DO ARQUIVO
            $nomeArquivo = $_FILES["foto"]["name"];
            
            //RECUPERAR A EXTENSÃO DO ARQUIVO
            $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

            //DEFINIR UM NOVO NOME PARA O ARQUIVO DE IMAGEM
            $novoNome = md5(microtime()) . "." . $extensao;

            //UPLOAD DO ARQUIVO:
            move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");

            /* INSERÇÃO DE DADOS NA BASE DE DADOS DO MYSQL: */

            //RECEBEIMENTO DOS DADOS:
            $descricao = $_POST["descricao"];
            $peso = $_POST["peso"];
            $quantidade = $_POST["quantidade"];
            $cor = $_POST["cor"];
            $tamanho = $_POST["tamanho"];
            $valor = $_POST["valor"];
            $desconto = $_POST["desconto"];
            $categoriaId = $_POST["categoria"];

            //CRIAÇÃO DA INSTRUÇÃO SQL DE INSERÇÃO:
            $sql = "INSERT INTO tbl_produto 
            (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) 
            VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, 
            '$novoNome', $categoriaId)";

            //EXCUÇÃO DO SQL DE INSERÇÃO:
            $resultado = mysqli_query($conexao, $sql);

            //REDIRECIONAR PARA INDEX:
            header('location: index.php');
            break;
        
        case 'deletar':

            //Recebendo o id do produto a ser deletado
            $produtoId = $_POST["produtoId"];

            //Deletar as imgs da pasta fotos quando deletar um produto
            $sql = "SELECT imagem FROM tbl_produto WHERE id = $produtoId";
            $resultado = mysqli_query($conexao, $sql);
            $produto = mysqli_fetch_array($resultado);
                //Teste para saber se o nome da img está vindo corretamente
                // echo $produto[0];
                // exit;
            unlink("./fotos/" . $produto[0]);
            
            //Instrução SQL
            $sql = "DELETE FROM tbl_produto WHERE id = $produtoId";
            $resultado = mysqli_query($conexao, $sql);

            header("location: index.php");
            break;

        default:
            # code...
            break;
    }

?>