<?php

    include('../../banco/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        if(empty($requestData['nome']) || empty($requestData['ativo'])){
            $dados = array(
                "tipo" => "info",
                "mensagem" => "Existe(m) campo(s) obrigatório(s) em branco."
            );
        } else{
            $id = isset($requestData['idcategoria']) ? $requestData['idcategoria'] : '';
            $requestData['ativo'] = $requestData['ativo'] == "on" ? "S" : "N";

            $date = date_create_from_format('d/m/Y H:i:s', $requestData['dataagora']);
            $requestData['dataagora'] = date_format($date, 'Y-m-d H:i:s');

            $sql = "UPDATE categorias SET nome = '$requestData[nome]', ativo = '$requestData[ativo]', datamodificacao = '$requestData[dataagora]' WHERE idcategoria = $id ";

            $resultado = mysqli_query($conexao, $sql);

            if($resultado){
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Categoria alterada com sucesso."
                );
            } else {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => mysqli_error($conexao) //"Não foi possível altarar a categoria."
                );
            }
        }

        mysqli_close($conexao);

    } else {
        $dados = array(
            "tipo" => "info",
            "mensagem" => "Ops... não foi possível conectar ao banco de dados"
        );
    }

   echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); 