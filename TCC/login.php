<?php
include("conexao.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']); // Senha inserida pelo usuário

    if (empty($usuario)) {
        $error = "Preencha seu usuário";
    } elseif (empty($senha)) {
        $error = "Coloque uma senha";
    } else {
        // Busca o usuário no banco de dados
        $query = "SELECT id, nome, senha FROM clientes WHERE usuario = '$usuario'";
        $result = mysqli_query($conexao, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            // Obtém os dados do usuário encontrado
            $usuario_data = mysqli_fetch_assoc($result);
            $senha_armazenada = $usuario_data['senha']; // Senha criptografada no banco de dados

            // Verifica a senha utilizando password_verify()
            if (password_verify($senha, $senha_armazenada)) {
                // Se a senha estiver correta, inicia a sessão
                $_SESSION['id'] = $usuario_data['id'];
                $_SESSION['nome'] = $usuario_data['nome'];

                // Redireciona para a página principal (index.php)
                header("Location: index.php");
                exit();
            } else {
                // Senha incorreta
                $error = "Usuário ou senha incorretos";
            }
        } else {
            // Nenhum usuário encontrado com esse nome de usuário
            $error = "Usuário ou senha incorretos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container" style="position: absolute;">
    <h2 style="color: #fff;">Tela de Login</h2>
    <form action="login.php" method="post">
        <label style="color: #fff;" for="usuario">Nome de usuário:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label style="color: #fff;" for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <input type="submit" href="index.php" class="index_link" value="Entrar">

        <p>Não possui uma conta? Cadastre-se <a href="cadastro.php" class="cadastro-link">aqui.</a></p>
        <?php
        if (isset($error)) {
            echo "<p style='color: red;'>$error</p>";
        }
        ?>
    </form>
</div>
</body>
</html>
