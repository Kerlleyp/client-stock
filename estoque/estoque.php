<?php
session_start();


// CLASSE ESTOQUE
class Estoque {
    public $arrayEstoque = [];

    public function adicionarProduto($nome, $marca, $preco, $quantidade) {
        $chave = strtolower(trim($nome) . '_' . trim($marca));

        if (!isset($this->arrayEstoque[$chave])) {
            $this->arrayEstoque[$chave] = [
                "nome" => $nome,
                "marca" => $marca,
                "quantidade" => $quantidade,
                "preco" => $preco
            ];
            return true;
        }
        return false;
    }

    public function atualizarProduto($chave, $quantidade = null, $preco = null) {
        if (!isset($this->arrayEstoque[$chave])) return false;

        if ($quantidade !== null && $quantidade !== '') {
            $this->arrayEstoque[$chave]['quantidade'] += (int)$quantidade;
        }
        if ($preco !== null) {
            $this->arrayEstoque[$chave]['preco'] = (float)$preco;
        }

        return true;
    }

    public function removerProduto($chave) {
        if (isset($this->arrayEstoque[$chave])) {
            unset($this->arrayEstoque[$chave]);
            return true;
        }
        return false;
    }

    public function Buscar($produto, $marca, $quantidadeComprada) {

        foreach ($this->arrayEstoque as &$item) {

            if ($produto === $item['nome'] && $marca === $item['marca']) {

                if ($item['quantidade'] >= $quantidadeComprada) {

                    $preco = $item['preco'];

                    // diminui do estoque
                    $item['quantidade'] -= $quantidadeComprada;

                    return $preco;
                } else {
                    return "Estoque insuficiente.";
                }
            }
        }

    return "Produto não encontrado.";
    }
}

// CARREGAR ESTOQUE DA SESSION
if (isset($_SESSION['estoque']) && $_SESSION['estoque'] instanceof Estoque) {
    $estoque = $_SESSION['estoque'];
} else {
    $estoque = new Estoque();
}

// PEGAR DADOS DO POST
$nomeProduto = $_POST['nomeProduto'] ?? '';
$nomeMarca   = $_POST['marcaProduto'] ?? '';
$quantidade  = $_POST['quantidade'] ?? 0;
$preco       = $_POST['preco'] ?? 0;

// ADICIONAR PRODUTO
if (isset($_POST['adicionarEstoque']) && $nomeProduto !== '' && $nomeMarca !== '') {
    if (!$estoque->adicionarProduto($nomeProduto, $nomeMarca, $preco, $quantidade)) {
        $_SESSION['msg'] = "Produto e Marca já existem!";
    } 
    $_SESSION['estoque'] = $estoque;
    header("Location: estoque.php");
    exit;
}

// ATUALIZAR PRODUTO (QUANTIDADE / PREÇO)
if (isset($_GET['index'])) {
    $chave = $_GET['index'];

    $estoque->atualizarProduto(
        $chave,
        $_POST['quantidade'] ?? null,
        $_POST['preco'] ?? null
    );

    $_SESSION['estoque'] = $estoque;
    header("Location: estoque.php");
    exit;
}

// REMOVER PRODUTO
if (isset($_GET['remover'])) {
    $chave = $_GET['remover'];

    $estoque->removerProduto($chave);
    $_SESSION['estoque'] = $estoque;
    header("Location: estoque.php");
    exit;
}
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
        <a href="../clientes/cliente.php">Clientes</a>
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
