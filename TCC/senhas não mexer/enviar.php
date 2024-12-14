<?php
include('conexao.php');

// Captura o e-mail enviado pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);

    // Verificar se o e-mail está registrado
    $query = "SELECT id FROM clientes WHERE email = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $userId = $user['id'];
        $token = bin2hex(random_bytes(50)); // Gerar token único
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); 

        // Inserir token no banco de dados
        $query = "INSERT INTO tokens (user_id, token, expires) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($query);
        $stmt->bind_param("iss", $userId, $token, $expires);
        $stmt->execute();

        // Enviar o e-mail com o link de redefinição
        $resetLink = "http://seusite.com/redefinir_senha_form.php?token=$token";
        $subject = "Redefinição de Senha";
        $message = "Clique no seguinte link para redefinir sua senha: $resetLink";
        $headers = "From: no-reply@seusite.com\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

        mail($email, $subject, $message, $headers);

        echo "Instruções para redefinir a senha foram enviadas para o seu e-mail.";
    } else {
        echo "E-mail não encontrado.";
    }
}
