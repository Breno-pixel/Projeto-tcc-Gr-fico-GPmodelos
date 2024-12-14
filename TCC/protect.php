<?php
// // Inicia a sessão se ainda não foi iniciada
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    ("Faça login para acessar essa página. <p><a href=\"login.php\">Entrar</a></p>");
} else echo "";


?>
