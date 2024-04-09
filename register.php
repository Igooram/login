<?php
include 'config.php';

// Verifica se os dados foram submetidos via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografa a senha

    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        // Redireciona para a página de login após o cadastro
        header("Location: login.php");
        exit();
    } else {
        // Se houver um erro, exibe uma mensagem de erro
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
