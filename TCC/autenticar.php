<?php 
// Inclui a conexão ao banco de dados e o arquivo com a função de inserção
include("conexao.php"); 
include("banco-cliente.php"); 

// Recebe os dados do formulário
$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha']; // Mantém a senha original recebida do usuário

// Verifica se o nome de usuário já existe no banco de dados
$query_verifica_usuario = "SELECT * FROM clientes WHERE usuario = '{$usuario}'";
$resultado_verifica_usuario = mysqli_query($conexao, $query_verifica_usuario);

if (mysqli_num_rows($resultado_verifica_usuario) > 0) {
    // Se o nome de usuário já existe, exibe uma mensagem de erro
    $mensagem = "Erro: Nome de usuário já existente. Por favor, escolha outro.";
} else {
    // Criptografa a senha para maior segurança ao armazenar no banco de dados
    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Insere os dados do novo usuário no banco de dados com a senha criptografada
    if (inserir($conexao, $nome, $usuario, $senha_criptografada)) {
        // Mensagem de sucesso, exibe a senha original digitada pelo usuário
        $mensagem = "Usuário inserido com sucesso! Efetue o login.";
    } else {
        // Em caso de erro na inserção, exibe a mensagem de erro
        $msg = mysqli_error($conexao);
        $mensagem = "Erro ao inserir cliente: " . $msg;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação</title>
    <style>
        body {
            background-color: rgb(7, 7, 7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center; 
            color: white;
        }

        .message {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .limite {
            width: 20%;
            margin: 0 auto; 
        }

        .limite a {
            display: block;
            text-decoration: none;
        }

        .limite button {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 17px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            box-sizing: border-box;
        }

        .limite button:hover {
            background-color: #45a049; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <?php echo $mensagem; ?>
        </div>
        <div class="limite">
            <a href="login.php">
                <button>Efetuar login</button>
            </a>
        </div>
    </div>
</body>
</html>
