<?php
session_start();

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

include "conexao.php";

// UPDATE: quando o formulário for enviado
if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome_item'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $sql = "UPDATE cardapio SET nome_item = ?, categoria = ?, descricao = ?, preco = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssdi", $nome, $categoria, $descricao, $preco, $id);
    mysqli_stmt_execute($stmt);

    header("Location: painel.php");
    exit;
}

// Buscar o item para preencher o formulário
$id = $_GET['id'];

$sql = "SELECT * FROM cardapio WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar item</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Editar item</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

        Nome: <input type="text" name="nome_item" value="<?php echo $item['nome_item']; ?>" required><br><br>

        Categoria:
        <select name="categoria">
            <option value="Café" <?php if ($item['categoria'] == "Café") echo "selected"; ?>>Café</option>
            <option value="Doce" <?php if ($item['categoria'] == "Doce") echo "selected"; ?>>Doce</option>
            <option value="Salgado" <?php if ($item['categoria'] == "Salgado") echo "selected"; ?>>Salgado</option>
            <option value="Bebida Gelada" <?php if ($item['categoria'] == "Bebida Gelada") echo "selected"; ?>>Bebida Gelada</option>
        </select><br><br>

        Descrição:<br>
        <textarea name="descricao"><?php echo $item['descricao']; ?></textarea><br><br>

        Preço: <input type="number" step="0.01" name="preco" value="<?php echo $item['preco']; ?>" required><br><br>

        <button type="submit" name="salvar">Salvar</button>
        <a href="painel.php">Cancelar</a>
    </form>
</body>
</html>
