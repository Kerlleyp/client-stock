<?php
    session_start();
    //require_once __DIR__ . '/../estoque/estoque.php';

    //CLASS CLIENTE
    class Cliente {
        public $arrayCliente = [];

        public function adicionarCliente($nome, $produto, $marca, $quantidade) {
            $chave = strtolower(trim($nome));

            // Se cliente não existir, cria
            if (!isset($this->arrayCliente[$chave])) {
                $this->arrayCliente[$chave] = [
                "nome" => $nome,
                "produtos" => []
            ];
         }

            // Adiciona produto ao cliente
            $this->arrayCliente[$chave]['produtos'][] = [
                "produto" => $produto,
                "marca" => $marca,
                "quantidade" => $quantidade
            ];

        return true;
        }

        public function removerCliente($chave) {
            if (isset($this->arrayCliente[$chave])) {
                unset($this->arrayCliente[$chave]);
                return true;
            }
        return false;
        }
    }
    // CARREGAR CLIENTE DA SESSION
    if (isset($_SESSION['cliente']) && $_SESSION['cliente'] instanceof Cliente) {
        $clientes = $_SESSION['cliente'];
    } else {
        $clientes = new Cliente();
    }

    $nomeCliente = $_POST['nomeCliente'] ?? '';
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $nomeMarca   = $_POST['nomeMarca'] ?? '';
    $quantidade  = $_POST['quantidade'] ?? 0;
    

    //Adicionar Cliente
    if (isset($_POST['adicionarCliente']) && $nomeCliente !== '') {
        $clientes->adicionarCliente($nomeCliente, $nomeProduto, $nomeMarca, $quantidade);
        $_SESSION['cliente'] = $clientes;
        header("Location: cliente.php");
        exit;
    }


    // REMOVER PRODUTO
    if (isset($_GET['remover'])) {
        $chave = strtolower($_GET['remover']);

        $clientes->removerCliente($chave);
        $_SESSION['cliente'] = $clientes;
        header("Location: cliente.php");
        exit;
    }

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
                <strong>Quantidade:</strong> {$produto['quantidade']}
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