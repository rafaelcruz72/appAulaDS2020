<?php

    include('../../banco/conexao.php');

    if($conexao){

        $resquestData = $_REQUEST;

        $colunas = $resquestData['columns'];

        $sql = "SELECT IDCATEGORIA, NOME, ATIVO, DATAMODIFICACAO FROM CATEGORIAS WHERE 1=1 ";
        $resultado = mysqli_query($conexao, $sql);
        $qtdeLinhas = mysqli_num_rows($resultado);

        if(!empyt($resquestData['search']['value'])){

            $sql .= " AND (IDCATEGORIA LIKE '$resquestData[search][value])%' ";
            $sql .= " OR NOME LIKE '$resquestData[search][value])%')";
        }

        $resultado = mysqli_query($conexao, $sql);
        $totalFiltrados = mysqli_num_rows($resultado);

        $colunaOrdem = $resquestData['order'][0]['column'];
        $ordem = $colunas[$colunaOrdem];
        $direcao = $resquestData['order'][0]['dir'];

        $sql .= " ORDER BY $ordem $direcao LIMIT $resquestData[start], $resquestData[length] ";

        $resultado = mysqli_query($conexao, $sql);

        $dados = array();
        while($linha = mysqli_fetch_assoc($resultado)){
            $dados[] = array_map('utf8_encode', $linha);
        }

        $json_data = array(
            "draw" => intval($resquestData['draw']),
            "recordsTotal" => intval($qtdeLinhas),
            "recordsFiltered" => intval($totalFiltrados),
            "data" => $dados
        );

        mysqli_close($conexao);

    } else{
        $json_data = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
    }

    echo json_encode($json_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);