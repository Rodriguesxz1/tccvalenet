<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_corporativo = $_POST['email_corporativo'];
    $senha = $_POST['senha'];

    // Verifique se os campos estão recebendo os valores corretos
    if (empty($email_corporativo) || empty($senha)) {
        die("Por favor, preencha todos os campos.");
    }

    $sql = "SELECT Matricula, Nome, Senha, PermissaoID FROM Funcionarios WHERE EmailCorporativo = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email_corporativo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($matricula, $nome, $senha_bd, $permissao_id);
            $stmt->fetch();

            if ($senha === $senha_bd) {
                $_SESSION['matricula'] = $matricula;
                $_SESSION['nome'] = $nome;

                // Carregar a imagem associada ao tipo de login do funcionário
                $sql_imagem = "SELECT Imagem FROM Permissoes WHERE ID = ?";
                if ($stmt_imagem = $conn->prepare($sql_imagem)) {
                    $stmt_imagem->bind_param("i", $permissao_id);
                    $stmt_imagem->execute();
                    $stmt_imagem->bind_result($imagem);
                    $stmt_imagem->fetch();

                    $_SESSION['imagem'] = $imagem;

                    // Redirecionar para a página inicial ou dashboard
                    header('Location: dashboard.php'); // Certifique-se de criar esta página
                    exit();
                } else {
                    echo "Erro na preparação da consulta SQL (imagem): " . $conn->error;
                }
                $stmt_imagem->close();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Email não encontrado!";
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta SQL: " . $conn->error;
    }
} else {
    echo "Método de requisição não é POST.";
}

$conn->close();
?>
