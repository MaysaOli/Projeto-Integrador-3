<?php
$dbHost = 'localhost';
$dbUername = 'root';
$dbPassword = 'lorenzo';
$dbName = 'estudante';

$conexao = new mysqli($dbHost, $dbUername, $dbPassword, $dbName);

//if (!$conexao ->connect_errno)
//{
//  echo "Erro";
//}
//else
//{
//    echo "Conexão efetuada com sucesso";
//}

?>