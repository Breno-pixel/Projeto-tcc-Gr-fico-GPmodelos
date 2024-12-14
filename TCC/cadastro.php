<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>

<style>
    /* Estilo para a mensagem de erro */
    .erro {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }
    /* Estilos gerais da página */
    .container {
        text-align: center;
        margin-top: 50px;
    }
    #confirmButton {
        width: 20%;
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
        cursor: pointer;
        background-color: #4CAF50;
        color: #fff;
    }
    #confirmationMessage {
        margin-top: 20px;
        font-size: 24px;
        color: green;
    }
    #loading {
        margin-top: 10px;
        font-size: 24px;
        color: green;
        display: none;
    }
</style>

<div class="container" style="position: absolute;">
    <h2 style="color: #fff;">Tela de Cadastro</h2>
    <form id="registrationForm" action="autenticar.php" method="post">
        <label style="color: #fff;" for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label style="color: #fff;" for="usuario">Nome de usuário:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label style="color: #fff;" for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>  

        <div class="recap">
            <button type="button" id="confirmButton">Não sou um robô</button>
            <div id="loading">Verificando...</div>
            <div id="confirmationMessage"></div>
        </div>

        <input type="submit" id="submitButton" value="Cadastrar" disabled>
    </form>

    <!-- Exibe a mensagem de erro caso o usuário já exista -->
    <?php if (isset($_GET['erro']) && $_GET['erro'] == 'usuario_existente'): ?>
        <div class="erro">Nome de usuário já existente! Escolha outro.</div>
    <?php endif; ?>

    <p><a href="login.php" class="cadastro-link">Já possui um cadastro?</a></p>
</div>

<script>
    // Simula a verificação do captcha "Não sou um robô"
    document.getElementById('confirmButton').addEventListener('click', function() {
        document.getElementById('loading').style.display = 'block';
        document.getElementById('confirmationMessage').style.display = 'none';

        setTimeout(function() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('confirmationMessage').innerHTML = '<img style="width: 60px" src="imagens/loading.gif" alt="Loading">';
            document.getElementById('confirmationMessage').style.display = 'block';

            document.getElementById('submitButton').disabled = false;
        }, 2000);
    });

    // Impede o envio do formulário sem a verificação do captcha
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        if (document.getElementById('submitButton').disabled) {
            event.preventDefault();
            alert('Por favor, confirme que você não é um robô.');
        }
    });
</script>

</body>
</html>