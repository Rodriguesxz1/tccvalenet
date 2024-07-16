<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $data_de_nascimento = $_POST['data_de_nascimento'];
    $email_corporativo = $_POST['email_corporativo'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha para segurança
    $permissao_id = $_POST['permissao_id'];

    // Verificar se o email corporativo já está registrado
    $sql_check = "SELECT * FROM Funcionarios WHERE EmailCorporativo = ?";
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check === false) {
        die("Erro na preparação da consulta SQL (verificação): " . $conn->error);
    }
    $stmt_check->bind_param("s", $email_corporativo);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Usuário já registrado com este email.";
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    // Consulta para obter o caminho da imagem associada à permissão
    $sql_imagem = "SELECT Imagem FROM Permissoes WHERE ID = ?";
    $stmt_imagem = $conn->prepare($sql_imagem);
    if ($stmt_imagem === false) {
        die("Erro na preparação da consulta SQL (imagem): " . $conn->error);
    }
    $stmt_imagem->bind_param("i", $permissao_id);
    $stmt_imagem->execute();
    $stmt_imagem->bind_result($imagem);
    $stmt_imagem->fetch();
    $stmt_imagem->close();

    // Inserir novo funcionário com caminho da imagem
    $sql_insert = "INSERT INTO Funcionarios (Nome, DataDeNascimento, EmailCorporativo, PermissaoID, Senha, Imagem) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    if ($stmt_insert === false) {
        die("Erro na preparação da consulta SQL (inserção): " . $conn->error);
    }

    $stmt_insert->bind_param("ssssss", $nome, $data_de_nascimento, $email_corporativo, $permissao_id, $senha, $imagem);

    if ($stmt_insert->execute()) {
        echo "Funcionário cadastrado com sucesso!";
    } else {
        echo "Erro: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$conn->close();
?>
