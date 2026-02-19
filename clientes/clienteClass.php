<?php
  class Cliente {
        public $arrayCliente = [];

        public function adicionarCliente($nome, $produto, $marca, $quantidade, $preco) {
            $chave = strtolower(trim($nome)) . '_' . uniqid();;

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
                "preco" => $preco
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