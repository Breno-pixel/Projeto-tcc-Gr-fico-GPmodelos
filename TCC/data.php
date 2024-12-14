<?php
session_start();

// Inicializa os dados na sessão se não estiverem definidos
if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = [
        'title' => '',
        'labels' => [],
        'values' => [],
        'colors' => []
    ];
}

// Verifica se houve uma requisição POST para adicionar novos dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

    if (is_array($postData)) {
        // Limpa dados existentes se o array estiver vazio
        if (empty($postData['data'])) {
            $_SESSION['data'] = [
                'title' => '',
                'labels' => [],
                'values' => [],
                'colors' => []
            ];
        } else {
            // Processa e adiciona novos dados
            $_SESSION['data']['title'] = $postData['title'] ?? '';
            $_SESSION['data']['labels'] = array_column($postData['data'], 'label');
            $_SESSION['data']['values'] = array_map(function($item) {
                return $item['value'];
            }, $postData['data']);
            $_SESSION['data']['colors'] = array_column($postData['data'], 'color');
        }
    }
}

// Criar um array associativo com os dados
$data = [
    'title' => $_SESSION['data']['title'],
    'labels' => $_SESSION['data']['labels'],
    'values' => $_SESSION['data']['values'],
    'colors' => $_SESSION['data']['colors']
];

// Retornar os dados como JSON
header('Content-Type: application/json');
echo json_encode($data);
?>