<?php

    include('../../banco/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        $id = isset($requestData['idcategoria']) ? $requestData['idcategoria'] : '';

        $sql = "DELETE FROM categorias WHERE idcategoria = $id";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $dados = array(
                "tipo" => "success",
                "mensagem" => "Categoria deletada com sucesso."
            );
        } else{
            $dados = array(
                "tipo" => "error",
                "mensagem" => "Não foi possível deletar a categoria."
            );
        }

        mysqli_close($conexao);

    } else {
        $dados = array(
            "tipo" => "info",
            "mensagem" => "Ops... não foi possível conectar ao banco de dados."
        );
    }

    echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);