<?php

    include('../../banco/conexao');

    if($conexao){

        //obtém os dados da requisão
        $requestData = $_REQUEST;

        //verifica se existem algum campo obrigatório vazio e incluse a imagem do produto
        if(!empty($requestData['nome']) &&
           !empty($requestData['descricao']) &&
           !empty($requestData['ativo'])
        ){

            //Tratamento dos campos vindo da requisição
            $id = isset($requestData['idproduto']) ? $requestData['idproduto'] : '';
            $requestData['descricao'] = preg_replace("/(\\r)?\\n/i", "<br>", $requestData['descricao']); // executa uma troca de caracteres de retorno e quebra de linha usando uma expressão regular (REGEX), pela tab html <br>
            //$requestData = array_map('utf8_decode', $requestData);
            //converte o formato da data para o padrão MySQL
            $dataAgora = str_replace('/','-',$requestData['dataagora']); //troca o caracter '/' para '-'
            $dataAgora = date('Y-m-d H:i:s', srttotime($dataAgora)); //cria uma nova data a partir da data vindo da requisição, com o formato do MySQL
            $requestData['ativo'] = $requestData['ativo'] == "on" ? 'S' : 'N';

            $sql = "UPDATE produtos SET nome = '$requestData[nome]', descricao = '$requestData[descricao]', estoque = '$requestData[estoque]', estoque_min = '$requestData[estoque_min]', valor = '$requestData[valor]', ativo = '$requestData[ativo]', idproduto = '$requestData[idproduto]', datamodificacao = '$dataAgora' WHERE idproduto = $id";

            $resultado = mysqli_query($conexao, $sql);

            if($resultado){
                $dados = array( 
                    "tipo" => "success",
                    "mensagem" => "Produto alterado com sucesso."
                );
            } else {
                $dados = array( 
                    "tipo" => "error",
                    "mensagem" => "Não foi possível alterar o produto."
                );
            }

        } else {
            $dados = array( //caso exista algum campo obrigatório vazio
                "tipo" => "info",
                "mensagem" => "Existe(m) campo(s) obrigatório(s) vazio(s)"
            );
        }

        mysqli_close($conexao);

    } else {
        $dados = array( // caso não tem uma conexão com o banco de dados
            "tipo" => "info",
            "mensagem" => "Ops... não foi possível conectar ao banco de dados"
        );
    }

    echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);