<?php 
include ("conexao.php"); 

include ("banco-cliente.php"); 

$login=$_POST['login'];
$senha=$_POST['senha']; 


if(inserir($conexao, $login, $senha)){ echo ("Cliente inserido com sucesso"); 

}else{ 
$msg=mysqli_error($conexao); echo ($msg); 
} 

?> 