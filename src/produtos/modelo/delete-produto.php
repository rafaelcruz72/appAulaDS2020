<?php

    include('../../banco/conexao.php');

    if($conexao){

        //obtém os dados da requisão
        $requestData = $_REQUEST;

        //verifica se existem algum campo obrigatório vazio e incluse a imagem do produto
        if(!empty($requestData['idproduto']) && isset($requestData['idproduto'])){

            $sql = "DELETE FROM produtos WHERE idproduto = '$requestData[idproduto]'";

            $resultado = mysqli_query($conexao, $sql);

            if($resultado){
                $dados = array( 
                    "tipo" => "success",
                    "mensagem" => "Produto deletado com sucesso."
                );
            } else {
                $dados = array( 
                    "tipo" => "error",
                    "mensagem" => "Não foi possível deletar o produto."
                );
            }

        } else {
            $dados = array( //caso exista algum campo obrigatório vazio
                "tipo" => "info",
                "mensagem" => "É necessário escolher um produto."
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
