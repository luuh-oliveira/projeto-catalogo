<?php

/*Parâmetros de conexão mysqli
1- Host (onde o banco de dados está rodando)
2- User (usuário do banco)
3- Password
4- Database (nome do banco)
*/

const HOST = 'localhost';
const USER = 'root';
const PASSWORD = 'bcd127';
const DATABASE = 'icatalogo';

$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

if ($conexao === false) {

    die(mysqli_connect_error());

}

// echo '<pre>';
// var_dump($conexao);
// echo '</pre>';

?>