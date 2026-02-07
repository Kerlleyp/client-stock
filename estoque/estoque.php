<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
</head>
<body>
    <form action="estoque.php" method="POST">
        <label for="nomeProduto">Nome do Produto</label><br>
        <input type="text" name="nomeProduto" id="nomeProduto"><br>
        <label for="marcaProduto">Marca do Produto</label><br>
        <input type="text" name="marcaProduto" id="marcaProduto"><br>
        <input type="submit" name="adicionarEstoque" value="Adicionar">
    </form>
    <?php 
        session_start();
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
        }

        //valido a session
        if(isset($_SESSION['estoque']) && $_SESSION['estoque'] instanceof Estoque) {
            $estoque = $_SESSION['estoque'];
        } else {
            $estoque = new Estoque();
        }


        $nomeProduto = isset($_POST["nomeProduto"]) ? trim($_POST["nomeProduto"]) : '';
        $nomeMarca = isset($_POST["marcaProduto"]) ? trim($_POST["marcaProduto"]) : '';;
        $quantidade = $_POST["quantidade"] ?? 0;
        $preco = $_POST["preco"] ?? 0;
    
         // atualizar produto
        if(isset($_GET['index'])) {
            $index = $_GET['index'];

            if(isset($estoque->arrayEstoque[$index])) {

                //atualiza a Quantidade
                if(isset($_POST['quantidade']) && $_POST['quantidade'] !== '') {
                    $estoque->arrayEstoque[$index]['quantidade'] += (int)$_POST['quantidade'];
                    $_SESSION['estoque'] = $estoque;
                };
                
                //atualiza o Preço
                if(isset($_POST['preco'])) {
                    $estoque->arrayEstoque[$index]['preco'] = (float)$_POST['preco'];
                    $_SESSION['estoque'] = $estoque;
                }
            }
            header("Location: estoque.php");
            exit;
        }

        if (isset($_POST['adicionarEstoque']) && $nomeProduto !== '' && $nomeMarca !== '') {
            if (!$estoque->adicionarProduto($nomeProduto, $nomeMarca, $preco, $quantidade)) {
                echo "Produto e Marca já existem!";
            } else {
                $_SESSION['estoque'] = $estoque;
                header("Location: estoque.php");
                exit;
            }
        }


        //Procura o index do produto que sera removido
       if (isset($_GET['remover'])) {
            $chave = $_GET['remover'];

            if (isset($estoque->arrayEstoque[$chave])) {
                unset($estoque->arrayEstoque[$chave]);
                $_SESSION['estoque'] = $estoque;
            }

            header("Location: estoque.php");
            exit;
        }

        
        foreach($estoque->arrayEstoque as $chave => $produtos) {
            echo 'Nome: '. $produtos['nome'] . '<br>' . 'Marca: ' . $produtos['marca'];
            echo '<form action="estoque.php?index='. $chave .'" method="POST">
                    <label for="quantidade">Quantidade: '. $produtos['quantidade']. '</label><br>
                    <input type="number" name="quantidade" id="quantidade'.$chave.'"><br>
                    <input type="submit" value="Adicionar"><br>
                </form>';
            echo '<form action="estoque.php?index='. $chave .'"method="POST">
                    <label for="preco">Preço: '. $produtos['preco'] .'</label><br>
                    <input type="number" name="preco" id="preco'. $chave.'"><br>
                    <input type="submit" value="Adicionar">
                </form>';
            echo ' <a href="?remover=' . $chave . '" onclick="return confirm(\'Deseja realmente remover?\')">Remover</a><br><br>';
        }

        $_SESSION['estoque'] = $estoque;
    ?>
</body>
</html>