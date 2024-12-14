<?php
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['nome'])) {
    echo json_encode([]); // Retorna uma lista vazia se o usuário não estiver logado
    exit;
}

// Simulação de dados do histórico (substituir com consulta ao banco de dados)
$historico = [
    ['atividade' => 'Criou gráfico de barras', 'data' => '2024-09-25 14:30'],
    ['atividade' => 'Editou gráfico de pizza', 'data' => '2024-09-24 10:15'],
    ['atividade' => 'Baixou gráfico de radar', 'data' => '2024-09-23 17:45'],
];

// Retorna o histórico em formato JSON
echo json_encode($historico);
