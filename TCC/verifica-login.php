<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['nome']) || empty($_SESSION['nome'])) {
    // Se não estiver logado, exibe uma mensagem e redireciona após 5 segundos
    echo '<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Não está logado</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #0C0FA8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .message {
                text-align: center;
                background-color:  #333;
                padding: 20px;
                border: 2px solid #0C0FA8;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #d9534f;
            }
            p {
                font-size: 18px;
            }
        </style>
        <meta http-equiv="refresh" content="5;url=login.php">
    </head>
    <body>
        <div class="message">
            <h1>Você não está logado!</h1>
            <p>Você será redirecionado para a página de login em <span id="countdown">5</span> segundos.</p>
        </div>

        <script>
            // Função para criar a contagem regressiva de 5 segundos
            var countdownElement = document.getElementById("countdown");
            var countdown = 5;

            // Intervalo que reduz o valor da contagem a cada segundo
            var interval = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;

                // Quando a contagem chegar a zero, para o intervalo
                if (countdown <= 0) {
                    clearInterval(interval);
                }
            }, 1000); // 1000 ms = 1 segundo
        </script>
    </body>
    </html>';
    exit;
} else {
    // Se estiver logado, redireciona diretamente para a página principal
    header("Location: principal.php");
    exit;
}

