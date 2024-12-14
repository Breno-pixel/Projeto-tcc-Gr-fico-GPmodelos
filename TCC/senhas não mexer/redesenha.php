<?php
$token = $_GET['token']; // O token é enviado via URL
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
</head>
<body>
    <h2>Redefinir Senha</h2>
    <form action="atualizar_senha.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="senha">Nova Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <input type="submit" value="Redefinir Senha">
    </form>
</body>
</html>
