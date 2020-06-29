<?php

include('../../banco/conexao.php');

if(!$conexao){
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'OPS, não foi possível obter uma conexão com o banco de dados, tente mais tarde..'
    );
} else{

    $requestaData = $_REQUEST;

    if(empty($requestaData['nome']) || empty($requestaData['ativo']) ){
        $dados = array(
            'tipo' => 'info',
            'mensagem' => 'Existe(m) campo(s) obrigatório(s) vazio(s).'
        );
    } else {

        //$requestaData = array_map('utf8_decode', $requestaData);

        $requestaData['ativo'] = $requestaData['ativo'] == "on" ? "S" : "N";

        $requestaData['dataagora'] = date('Y-d-m H:i:s', strtotime($requestaData['dataagora']));

        $sqlComando = "INSERT INTO categorias (nome, ativo, datacriacao, datamodificacao)
         VALUES ('$requestaData[nome]', '$requestaData[ativo]', '$requestaData[dataagora]', '$requestaData[dataagora]')";

         $resultado = mysqli_query($conexao, $sqlComando);

         if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Categoria criada com sucesso.'
            );
         } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível criar a categoria.'.mysqli_error($conexao)
            );
         }
    }

    mysqli_close($conexao);
}

echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);