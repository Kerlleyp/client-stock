<?php
  class Cliente {
        public $arrayCliente = [];

        public function adicionarCliente($nome, $produto, $marca, $quantidade, $preco) {
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
                "quantidade" => $quantidade,
                "preco" => $preco,
                "total" => 0
            ];

        return true;
        }

        // VERIFICA SE O CLIENTE E O PRODUTO EXISTE
        public function produtoExiste($nomeCliente, $nomeProduto){
            foreach($this->arrayCliente[$nomeCliente]['produtos'] as $produto){
                if($produto['produto'] == $nomeProduto) {
                    return true;
                }
            }
            return false;
        }

        // FAZ A SOMA DA QUANTIDADE CASO EXISTA
        public function somarQuantidade($nomeCliente, $nomeProduto, $quantidade){
            foreach ($this->arrayCliente[$nomeCliente]['produtos'] as &$produto) {
                if ($produto['produto'] == $nomeProduto) {
                    $produto['quantidade'] += $quantidade;
                    $produto['total'] = $produto['quantidade'] * $produto['preco'];
                }
            }
        }

        public function removerCliente($chave) {
            if (isset($this->arrayCliente[$chave])) {
                unset($this->arrayCliente[$chave]);
                return true;
            }
        return false;
        }
    }