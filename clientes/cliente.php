<?php
    //Class Estoque
    require_once __DIR__ . '/../estoque/estoqueClass.php';
    
    require_once __DIR__ . '/clienteClass.php';

    session_start();

    // CARREGAR CLIENTE DA SESSION
    if (isset($_SESSION['cliente']) && $_SESSION['cliente'] instanceof Cliente) {
        $clientes = $_SESSION['cliente'];
    } else {
        $clientes = new Cliente();
        $_SESSION['cliente'] = $clientes;
    }

    //Carrega Estoque
    if (isset($_SESSION['estoque']) && $_SESSION['estoque'] instanceof Estoque) {
        $estoque = $_SESSION['estoque'];
    } else {
        $estoque = new Estoque();
        $_SESSION['estoque'] = $estoque;
    }

    $nomeCliente = $_POST['nomeCliente'] ?? '';
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $nomeMarca   = $_POST['nomeMarca'] ?? '';
    $quantidade  = $_POST['quantidade'] ?? 0;
    

    //Adicionar Cliente
    if (isset($_POST['adicionarCliente']) && $nomeProduto !== '' && $nomeCliente !== '') {
       $preco = $estoque->Buscar($nomeProduto, $nomeMarca, $quantidade);

        if (is_numeric($preco)) {
            $clientes->adicionarCliente($nomeCliente, $nomeProduto, $nomeMarca, $quantidade, $preco);
            $_SESSION['cliente'] = $clientes;
        } else {
            echo $preco;
            exit;
        }
        $_SESSION['cliente'] = $clientes;
        header("Location: clienteView.php");
        exit;
    }


    // REMOVER PRODUTO
    if (isset($_GET['remover'])) {
        $chave = strtolower($_GET['remover']);

        $clientes->removerCliente($chave);
        $_SESSION['cliente'] = $clientes;
        header("Location: clienteView.php");
        exit;
    }
