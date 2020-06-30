<?php

    include('../../banco/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        $id = isset($requestData['idcategoria']) ? $requestData['idcategoria'] : '';

        $sql = "SELECT * FROM categorias WHERE idcategoria = $id ";
        $resultado = mysqli_query($conexao, $sql);

        if($resultado && mysqli_num_rows($resultado) > 0){

            while($linha = mysqli_fetch_assoc($resultado)){
                $dadosCategoria = array_map('utf8_encode', $linha);
            }

            $dados = array(
                "tipo" =>"success",
                "mensagem" => "",
                "dados" => $dadosCategoria
            );

        } else{
            $dados = array(
                "tipo" => "info",
                "mensagem" => "Não possível localizar a categoria.",
                "dados" => array()
            );
        }

        mysqli_close($conexao);

    } else{
        $dados = array(
            "tipo" => "error",
            "mensagem" => "Não possível conecar ao banco de dados",
            "dados" => array()
        );
    }

echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);