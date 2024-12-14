<?php
include("protect.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="index2.css">
</head>
<body>
    <div class="barra">

        <div class="logo">
            <?php 
            session_start(); 
            
            if (isset($_SESSION['nome']) && !empty($_SESSION['nome'])) {
                echo 'Bem-vindo, ' . htmlspecialchars($_SESSION['nome']) . ' | <a href="logout.php" style="color: red; text-decoration: none;">Sair da conta</a>';
            } else {
                // mensagem padrão quando não estiver logado
                echo 'Bem-vindo!';
            }
            ?>
        </div>

        <div class="menu">
            <a href="login.php">Login</a>
            <a href="cadastro.php">Cadastro</a>
            <a href="ajuda.php">Ajuda</a>
        </div>
    </div>

    <style>
    /* Estilos para a página */
    .sobre {
        width: 700px;
        height: 700px;
        margin-top: 2%;
        margin-bottom: 10%;
    }

    h4 {
        font-size: 30px;
        color: #999999;
        margin-left: 30px;
        margin-bottom: 200px;
    }

    button {
    margin-top: 50px;
    padding: 0.9rem 1.8rem;
    font-size: 30px;
    font-weight: 700;
    color: black;
    border: 3px solid rgb(252, 70, 100);
    cursor: pointer;
    position: relative;
    background-color: transparent;
    text-decoration: none;
    overflow: hidden;
    z-index: 1;
    font-family: inherit;
    }

    button::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(252, 70, 100);
    transform: translateX(-100%);
    transition: all .3s;
    z-index: -1;
    }

    button:hover::before {
    transform: translateX(0);
   }

    </style>

    <!-- Slogan GPmodelos -->
    <img src="imagens/slogan.png">

    <p style="font-size: 80px; margin-left: 30px; margin-top: 12%">
        Crie gráficos em<br>questão de minutos!
    </p>

    <!-- Texto introdução -->
    <h4>
        Crie gráficos gratuitamente, com o GPmodelos, <br>você tem a possibilidade de desenvolver o gráfico <br> que deseja com facilidade.
        Nossa plataforma oferece <br> ferramentas fáceis de manipular para criar gráficos simples <br> que facilitam tanto a visualização, quanto a interpretação dos dados.
    </h4>

    <!-- Gráfico gif -->
    <img style="width: 380px; position: absolute; margin-top: -540px; margin-left: 1200px;" src="imagens/Grafico.gif">

    <!-- sobre nós -->
    <center>
        <section id="texto"></section>
        <h1>Quem somos?</h1>
        
        <div class="sobre">
            <h4>
                Bem-vindo(a) ao GPmodelos, somos um grupo de jovens que compreendem a necessidade de como apresentar dados de forma clara e eficiente, usufruindo das ferramentas e aplicando-as. Foi pensando nisso que nasceu o GPmodelos, um site cujo objetivo é facilitar a ergonomia da criação de um gráfico. Prezamos pelo tempo e qualidade, e em nosso site você verá isso! Crie desde gráficos básicos como o de pizza, até mais complexos como o de área polar! Adicione quantas colunas quiser, e se desejar, tens a possibilidade de baixar o gráfico com apenas um clique! Nossa ferramenta é projetada para ser acessível a todos, independentemente do nível de habilidade técnica. Tá' esperando o que para começar a criar gráficos? Experimente hoje!
            </h4>
        </div>

    </center>

    <h1 style="text-align: center; margin-bottom: 100px">
        Alguns dos modelos gráficos mais popularmente usados:
    </h1>

    <div class="info">
        <div class="colunas">
            <h3>Gráficos de colunas</h3>
            <p>Os gráficos de colunas são úteis para mostrar comparações entre itens ou alterações de dados durante um período de tempo.</p>
        </div>
        <div class="barras">
            <h3>Gráficos de barra</h3>
            <p>Os gráficos de barra são perfeitos para comparar diferentes categorias. Para comparar dados entre vários grupos ou categorias, eles são frequentemente usados.</p>
        </div>
        <div class="pizza">
            <h3>Gráficos de pizza</h3>
            <p>Os gráficos de pizza são úteis para demonstrar a composição total. Eles facilitam a visualização da proporção das partes em relação ao conjunto.</p>
        </div>
    </div>

    <center>
        <a href="verifica-login.php">
            <button>
                Experimente já!
            </button>
        </a>
    </center>

    <!-- Rodapé -->
    <footer style="background-color: #0C0FA8; color: white; padding: 20px; text-align: center; font-family: Share Tech, sans-serif; margin-top: 15%;">
        <div>
            <p>&copy; 2024 GPmodelos. Todos os direitos reservados.</p>
            <p><a href="#texto" style="color: #FFFFFF; text-decoration: none;">Sobre Nós</a> | <a href="pp.php" style="color: #FFFFFF; text-decoration: none;">Política de Privacidade</a></p>
            <p>Desenvolvido por <a href="index.php" style="color: #FFFFFF; text-decoration: underline;">GPmodelos</a></p>
        </div>
    </footer>
</body>
</html>
