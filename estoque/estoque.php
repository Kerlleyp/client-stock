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
                $this->arrayEstoque[] = [
                    "nome" => $nome,
                    "marca" => $marca,
                    "quantidade" => $quantidade,
                    "preco" => $preco
                ];
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

        // Adicionar produto
        if(isset($_POST['adicionarEstoque']) && $nomeProduto !== '' && $nomeMarca !== '') {
            $existe = false;
            foreach($estoque->arrayEstoque as $produto) {
                if(strtolower($produto['nome']) === strtolower($nomeProduto) &&
                    strtolower($produto['marca']) === strtolower($nomeMarca)) {
                    $existe = true;
                    break;
                }
            }

            if(!$existe) {
                $estoque->adicionarProduto($nomeProduto, $nomeMarca, $preco, $quantidade);
                $_SESSION['estoque'] = $estoque;
                header("Location: estoque.php");
                exit;
            } else {
                echo "Produto e Marca já existem!";
            }
        }

        //Procura o index do produto que sera removido
        if(isset($_GET['remover'])){
            $index = (int)$_GET['remover'];

            if(isset($estoque->arrayEstoque[$index])){
                unset($estoque->arrayEstoque[$index]);
                $estoque->arrayEstoque = array_values($estoque->arrayEstoque); //organizar
                $_SESSION['estoque'] = $estoque;
            }
        }
        
        foreach($estoque->arrayEstoque as $index => $produtos) {
            echo 'Nome: '. $produtos['nome'] . '<br>' . 'Marca: ' . $produtos['marca'];
            echo '<form action="estoque.php?index='. $index .'" method="POST">
                    <label for="quantidade">Quantidade: '. $produtos['quantidade']. '</label><br>
                    <input type="number" name="quantidade" id="quantidade'.$index.'"><br>
                    <input type="submit" value="Adicionar"><br>
                </form>';
            echo '<form action="estoque.php?index='. $index .'"method="POST">
                    <label for="preco">Preço: '. $produtos['preco'] .'</label><br>
                    <input type="number" name="preco" id="preco'. $index.'"><br>
                    <input type="submit" value="Adicionar">
                </form>';
            echo ' <a href="?remover=' . $index . '" onclick="return confirm(\'Deseja realmente remover?\')">Remover</a><br><br>';
        }

        $_SESSION['estoque'] = $estoque;
    ?>
</body>
</html>