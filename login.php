<?php
session_start();
include "conexao.php";

$erro = "";

if (isset($_POST['entrar'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND senha = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $senha);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 1) {
        $dados = mysqli_fetch_assoc($resultado);
        $_SESSION['logado'] = true;
        $_SESSION['nome'] = $dados['nome'];
        header("Location: painel.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Login da Cafeteria</h1>

    <p style="color:red"><?php echo $erro; ?></p>

    <form method="POST">
        Usuário: <input type="text" name="usuario" required><br><br>
        Senha: <input type="password" name="senha" required><br><br>
        <button type="submit" name="entrar">Entrar</button>
    </form>
</body>
</html>
