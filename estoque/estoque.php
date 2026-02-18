<?php
    require_once __DIR__ . '/estoqueClass.php';
    session_start();

    // CARREGAR ESTOQUE DA SESSION
   $estoque = $_SESSION['estoque'] ?? new Estoque();

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