<?php
session_start();
if (!isset($_SESSION['matricula'])) {
    header('Location: login.php');
    exit();
}

$nome = $_SESSION['nome'];
$imagem = $_SESSION['imagem'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</h1>
    <img src="<?php echo htmlspecialchars($imagem); ?>" alt="Imagem de Permissão">
</body>
</html>
