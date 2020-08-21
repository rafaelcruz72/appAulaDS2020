<?php

    include('../../banco/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        $id = isset($requestData['idproduto']) ? $requestData['idproduto'] : '';

        $sql = "SELECT p.idproduto, p.nome, p.ativo, 
                       p.idcategoria, c.nome as categoria, 
                       DATE_FORMAT(p.datacriacao, '%d/%m/%Y %H:%i:%s') as datacriacao,
                       DATE_FORMAT(p.datamodificacao, '%d/%m/%Y %H:%i:%s') as datamodificacao,
                       p.descricao, p.imagem, p.estoque, p.estoque_min, p.valor
                FROM produtos p
                INNER JOIN categorias c ON c.idcategoria = p.idcategoria
                WHERE p.idproduto = $id";

        $resultado = mysqli_query($conexao, $sql);
        if($resultado && mysqli_num_rows($resultado) > 0){

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
                "mensagem" => "Não foi possível localizar o produto",
                "dados" => array()
            );
        }
    } else {
        $dados = array(
            "tipo" => "info",
            "mensagem" => "Ops... não foi possível conectar ao banco de dados",
            "dados" => array()
        );
    }

    echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);