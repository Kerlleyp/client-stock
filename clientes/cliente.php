<?php
    session_start();

    //CLASS CLIENTE
    class Cliente {
        public $arrayCliente = [];

        public function adicionarProduto($nome, $produto, $marca, $quantidade) {
        $chave = strtolower(trim($nome) . '_' . trim($marca));

        if (!isset($this->arrayCliente[$chave])) {
            $this->arrayCliente[$chave] = [
                "nome" => $nome,
                "produto" => $produto,
                "marca" => $marca,
                "quantidade" => $quantidade,
            ];
            return true;
        }
        return false;
        }
    }
    // CARREGAR ESTOQUE DA SESSION
    if (isset($_SESSION['cliente']) && $_SESSION['cliente'] instanceof Cliente) {
        $estoque = $_SESSION['cliente'];
    } else {
        $clientes = new Cliente();
    }

    $nomeCliente = $_POST['nomeCliente'] ?? '';
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $nomeMarca   = $_POST['nomeMarca'] ?? '';
    $quantidade  = $_POST['quantidade'] ?? 0;

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
        <a href="../estoque/estoque.php">Estoque</a>
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
        <input type="submit" value="Adicionar Cliente">
    </form>
</body>
</html>