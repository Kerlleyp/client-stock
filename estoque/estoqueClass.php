<?php
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

        // BUSCA O PRODUTO NO ESTOQUE
        public function Buscar($produto, $marca, $quantidadeComprada) {

            $quantidadeComprada = (int) $quantidadeComprada;

            if ($quantidadeComprada <= 0) {
                $_SESSION['msgCliente'] = "Quantidade inválida.";
                //$_SESSION['cliente'] = $clientes;
                header("Location: clienteView.php");
                exit;
            }

            foreach ($this->arrayEstoque as &$item) {

                if ($produto === $item['nome'] && $marca === $item['marca']) {

                    if ($item['quantidade'] >= $quantidadeComprada) {

                        $preco = $item['preco'];

                        $total = $preco * $quantidadeComprada;

                        $item['quantidade'] -= $quantidadeComprada;

                        return $total;

                    } else {
                        $_SESSION['msgCliente'] = "Estoque insuficiente.";
                        header("Location: clienteView.php");
                        exit;
                    }
                }
            }

            $_SESSION['msgCliente'] = "Produto não encontrado.";
            header("Location: clienteView.php");
            exit;
        }
    }
