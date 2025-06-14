<?php
// configurando a conexão com db
$host = 'localhost:3308';
$dbname = 'baooce';
$user = 'root';
$pass =  'Gabriela#1302';
//criando a conexão com db via MySQLI
$conn = new mysqli($host,$user,$pass,$dbname);


if($conn->connect_error){
    die("Erro na conexão: ". $conn->connect_error);
}else
?>