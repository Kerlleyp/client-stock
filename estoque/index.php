<?php 
    require_once __DIR__ . '/estoqueClass.php';
    session_start();
    // CARREGAR ESTOQUE DA SESSION
    $estoque = $_SESSION['estoque'] ?? new Estoque();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
</head>
<body>
    <header>
        <a href="../clientes/clienteView.php">Clientes</a>
    </header>

<h2>Adicionar Produto</h2>
<form action="estoque.php" method="POST">
    <label for="nomeProduto">Nome do Produto:</label><br>
    <input type="text" name="nomeProduto" id="nomeProduto" placeholder="Ex: Arroz, Feijão..." required><br>
    <label for="marcaProduto">Marca do Produto:</label><br>
    <input type="text" name="marcaProduto" id="marcaProduto" placeholder="Ex: Codil, Kaiser..." required><br>
    <label for="quantidade">Quantidade:</label><br>
    <input type="number" name="quantidade" id="quantidade" value="0"><br>
    <label for="preco">Preço:</label><br>
    <input type="number" name="preco" id="preco" step="0.01" value="0"><br><br>
    <input type="submit" name="adicionarEstoque" value="Adicionar Produto">
</form>

<?php
    // MENSAGEM DE ERRO
    if (!empty($_SESSION['msg'])) {
        echo '<p style="color:red">' . $_SESSION['msg'] . '</p>';
        unset($_SESSION['msg']);
    }

    // LISTA DE PRODUTOS
    if (!empty($estoque->arrayEstoque)) {
        echo '<h2>Estoque Atual</h2>';

        foreach ($estoque->arrayEstoque as $chave => $produto) {
            echo "<strong>Nome:</strong> {$produto['nome']}<br>";
            echo "<strong>Marca:</strong> {$produto['marca']}<br>";
            echo "<strong>Quantidade:</strong> {$produto['quantidade']}<br>";
            echo "<strong>Preço:</strong> R$ {$produto['preco']}<br>";

            // Formulário para atualizar quantidade
            echo "<form action='estoque.php?index={$chave}' method='POST'>
                    <label>Adicionar Quantidade:</label><br>
                    <input type='number' name='quantidade'><br>
                    <input type='submit' value='Atualizar Quantidade'>
                 </form>";

            // Formulário para atualizar preço
            echo "<form action='estoque.php?index={$chave}' method='POST'>
                    <label>Atualizar Preço:</label><br>
                    <input type='number' step='0.01' name='preco'><br>
                    <input type='submit' value='Atualizar Preço'>
                 </form>";

            // Link para remover
            echo "<a href='estoque.php?remover={$chave}' onclick=\"return confirm('Deseja realmente remover?')\">Remover</a><hr>";
        }
    }
?>
</body>
</html>
