<?php
include 'config.php';

// Recupera o email ou número de telefone enviado pelo cliente
$requestData = json_decode(file_get_contents('php://input'), true);
$emailOrPhone = $requestData['emailOrPhone'];

// Gere um token único para redefinição de senha
$token = bin2hex(random_bytes(32)); // Gera um token hexadecimal de 32 bytes

// Insere os dados na tabela de redefinição de senha
$sql = "INSERT INTO password_reset (emailOrPhone, token) VALUES ('$emailOrPhone', '$token')";
if ($conn->query($sql) === TRUE) {
    // Envie o link de redefinição de senha por e-mail ou mensagem de texto
    // Implemente a lógica para enviar o link aqui
    // Substitua 'mail()' com a função apropriada para enviar e-mails ou mensagens de texto
    if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
        // Se for um endereço de e-mail válido, envie um e-mail
        $to = $emailOrPhone;
        $subject = 'Link de Redefinição de Senha';
        $message = 'Clique neste link para redefinir sua senha: http://seusite.com/reset_password.php?token=' . $token;
        $headers = 'From: suaconta@example.com';
        if (mail($to, $subject, $message, $headers)) {
            echo json_encode(array('success' => true, 'message' => 'Um link de redefinição de senha foi enviado para o seu e-mail.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Erro ao enviar o e-mail de redefinição de senha. Por favor, tente novamente.'));
        }
    } else {
        // Se for um número de telefone, envie uma mensagem de texto
        // Implemente a lógica para enviar mensagem de texto para o número de telefone fornecido
        echo json_encode(array('success' => false, 'message' => 'Envio de mensagens de texto não implementado.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Erro ao salvar os dados de redefinição de senha.'));
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
