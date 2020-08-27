<?php

    include('../../banco/conexao.php');

    if($conexao){

        //obtém os dados da requisão
        $requestData = $_REQUEST;

        //verifica se existem algum campo obrigatório vazio e incluse a imagem do produto
        if(!empty($requestData['idcategoria']) && isset($requestData['idcategoria'])){

            $sql = "SELECT p.idproduto, p.nome, p.ativo, 
                       p.idcategoria, c.nome as categoria, 
                       DATE_FORMAT(p.datacriacao, '%d/%m/%Y %H:%i:%s') as datacriacao,
                       DATE_FORMAT(p.datamodificacao, '%d/%m/%Y %H:%i:%s') as datamodificacao,
                       p.descricao, p.imagem, p.estoque, p.estoque_min, p.valor
                FROM produtos p
                INNER JOIN categorias c ON c.idcategoria = p.idcategoria
                WHERE p.idcategoria ='$requestData[idcategoria]'";

            $resultado = mysqli_query($conexao, $sql);

            if($resultado){
                $dadosProdutos = array();
                while($linha = mysqli_fetch_assoc($resultado)){
                    $dadosProdutos[] = array_map('utf8_encode', $linha);
                }

                $dados = array( 
                    "tipo" => "success",
                    "mensagem" => "",
                    "dados" => $dadosProdutos
                );

            } else {
                $dados = array( 
                    "tipo" => "error",
                    "mensagem" => "Não foi possível encontrar o produtos da categoria.",
                    "dados" => array()
                );
            }

        } else {
            $dados = array( //caso exista algum campo obrigatório vazio
                "tipo" => "info",
                "mensagem" => "É necessário escolher uma categoria.",
                "dados" => array()
            );
        }

        mysqli_close($conexao);

    } else {
        $dados = array( // caso não tem uma conexão com o banco de dados
            "tipo" => "info",
            "mensagem" => "Ops... não foi possível conectar ao banco de dados",
            "dados" => array()
        );
    }

    echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);