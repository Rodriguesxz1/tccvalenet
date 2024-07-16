<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Funcionário</title>
</head>
<body>
    <form action="register_process.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Data de Nascimento: <input type="date" name="data_de_nascimento" required><br>
        Email Corporativo: <input type="email" name="email_corporativo" required><br>
        Senha: <input type="password" name="senha" required><br>
        Permissão: <select name="permissao_id" required>
            <option value="1">Administrador</option>
            <option value="2">Operador</option>
            <option value="3">Leitor</option>
        </select><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
