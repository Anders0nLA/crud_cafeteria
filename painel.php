<?php
session_start();

// Bloqueia quem não fez login
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

include "conexao.php";

// CREATE: cadastrar novo item
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome_item'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO cardapio (nome_item, categoria, descricao, preco) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssd", $nome, $categoria, $descricao, $preco);
    mysqli_stmt_execute($stmt);

    header("Location: painel.php");
    exit;
}

// READ: buscar todos os itens
$resultado = mysqli_query($conn, "SELECT * FROM cardapio");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Painel do Cardápio</h1>
    <p>Olá, <?php echo $_SESSION['nome']; ?> | <a href="logout.php">Sair</a></p>

    <h2>Cadastrar item</h2>
    <form method="POST">
        Nome: <input type="text" name="nome_item" required><br><br>

        Categoria:
        <select name="categoria">
            <option value="Café">Café</option>
            <option value="Doce">Doce</option>
            <option value="Salgado">Salgado</option>
            <option value="Bebida Gelada">Bebida Gelada</option>
        </select><br><br>

        Descrição:<br>
        <textarea name="descricao"></textarea><br><br>

        Preço: <input type="number" step="0.01" name="preco" required><br><br>

        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

    <h2>Itens do cardápio</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>

        <?php while ($item = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['nome_item']; ?></td>
            <td><?php echo $item['categoria']; ?></td>
            <td><?php echo $item['descricao']; ?></td>
            <td>R$ <?php echo $item['preco']; ?></td>
            <td>
                <a href="editar_item.php?id=<?php echo $item['id']; ?>">Editar</a>
                <a href="excluir_item.php?id=<?php echo $item['id']; ?>">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
