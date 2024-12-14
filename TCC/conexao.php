<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tcc";


$conexao = mysqli_connect($servername, $username, $password, $dbname);


if (!$conexao) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
