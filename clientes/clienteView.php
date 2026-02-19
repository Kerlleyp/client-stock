<?php
    require_once __DIR__ . '/clienteClass.php';

    session_start();
    $clientes = $_SESSION['cliente'] ?? new Cliente();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>
<body>
    <header>
        <a href="../estoque/index.php">Estoque</a>
    </header>
    <h2>Adicionar Cliente</h2>
    <form action="cliente.php" method="post">
        <label for="nomeCliente">Cliente</label><br>
        <input type="text" name="nomeCliente" id="nomeCliente"><br>
        <label for="nomeProduto">Produto</label><br>
        <input type="text" name="nomeProduto" id="nomeProduto"><br>
        <label for="nomeMarca">Marca</label><br>
        <input type="text" name="nomeMarca" id="nomeMarca"><br>
        <label for="quantidade">Quantidade</label><br>
        <input type="number" name="quantidade" id="quantidade"><br><br>
        <input type="submit" name="adicionarCliente" value="Adicionar Cliente">
    </form>

<?php

    foreach ($clientes->arrayCliente as $chave => $cliente) {
        echo "<h2>{$cliente['nome']}</h2>";

        echo "<ul>";
    foreach ($cliente['produtos'] as $produto) {
        echo "<li>
                <strong>Produto:</strong> {$produto['produto']} <br>
                <strong>Marca:</strong> {$produto['marca']} <br>
                <strong>Quantidade:</strong> {$produto['quantidade']}<br>
                <strong>Preço:</strong> {$produto['preco']}
              </li><br>";
    }
        echo "</ul>";

        echo "<a href='cliente.php?remover={$chave}' 
            onclick=\"return confirm('Deseja realmente remover?')\">
            Remover Cliente
             </a><hr>";
    }

?>
</body>
</html>