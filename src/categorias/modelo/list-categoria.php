<?php

    include('../../banco/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        $colunas = $requestData['columns'];

        $sql = "SELECT IDCATEGORIA, NOME, ATIVO, DATAMODIFICACAO FROM CATEGORIAS WHERE 1=1 ";
        $resultado = mysqli_query($conexao, $sql);
        $qtdeLinhas = mysqli_num_rows($resultado);

        if(!empty($requestData['search']['value'])){

            $sql .= " AND (IDCATGORIA LIKE '$requestData[search][value]%' ";
            $sql .= " OR NOME LIKE '$requestData[search][value]%') ";
        }

        $resultado = mysqli_query($conexao, $sql);
        $totalFiltrados = mysqli_num_rows($resultado);

        $colunaOrdem = $resultado['order'][0]['column'];
        $ordem = $clounas[$colunaOrdem];
        $direcao = $resquestData['order'][0]['dir'];

        $sql .= " ORDER BY $ordem $direcao LIMIT $requestData[start], $requestData[length]";

        $resultado = mysqi_query($conexao, $sql);

        $dados = array();
        while($linha = mysqli_fetch_assoc($resultado)){
            $dados[] = array_map('utf8_encode', $linha);
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
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