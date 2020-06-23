<?php

    include('../../banco/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        $colunas = $requestData['columns'];

        $sql = "SELECT IDCATEGORIA, NOME, ATIVO, DATAMODIFICACAO FROM CATEGORIAS WHERE 1=1 ";
        $resultado = mysqli_query($conexao, $sql);
        $qtdeLinhas = mysqli_num_rows($resultado);

        if(!empty($requestData['search']['value'])){

            $sql .= " AND (IDCATEGORIA LIKE '$requestData[search][value])%' ";
            $sql .= " OR NOME LIKE '$requestData[search][value])%' )";
        }

        $resultado = mysqli_query($conexao, $sql);
        $totalFiltrados = mysqli_num_rows($resultado);

        $colunaOrdem = $requestData['order'][0]['column'];
        $ordem = $colunas[$colunaOrdem];
        $direcao = $requestData['order'][0]['dir'];



    } else{
        $json_data = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
    }

    echo json_encode($json_data, JSON_UNDESCAPED_SLASHES, JSON_UNDESCAPED_UNICODE);

