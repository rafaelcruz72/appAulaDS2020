<?php
    
    //obter a conexão com o banco de dados
    include('../../banco/conexao.php');

    //verificar se existe uma conexão
    if($conexao){

        //obtém os dados da requisão
        $requestData = $_REQUEST;

        //obtém os dados da imagem
        $imagem = $_FILES['imagem'];

        //verifica se existem algum campo obrigatório vazio e incluse a imagem do produto
        if(!empty($requestData['nome']) &&
           !empty($requestData['descricao']) &&
           !empty($requestData['ativo']) &&
           !empty($_FILES['imagem']) && $_FILES['imagem']['error'] != 0 //qualquer valor diferente de 0, indica que a imagem está com erro
        ){

            //Tratamento dos campos vindo da requisição
            $requestData['descricao'] = preg_replace("/(\\r)?\\n/i", "<br>", $requestData['descricao']); // executa uma troca de caracteres de retorno e quebra de linha usando uma expressão regular (REGEX), pela tab html <br>
            //$requestData = array_map('utf8_decode', $requestData);
            //converte o formato da data para o padrão MySQL
            $dataAgora = str_replace('/','-',$requestData['dataagora']); //troca o caracter '/' para '-'
            $dataAgora = date('Y-m-d H:i:s', srttotime($dataAgora)); //cria uma nova data a partir da data vindo da requisição, com o formato do MySQL

            //preparar o processo de upload
            $pasta = "imagens/"; //determina o nome da pasta de destino das imagens
            //verifica se a pasta em questão não existe no servidor, caso não exista, cria a pasta e aplica as permissões de leitura e gravação
            if(!file_exists($pasta)) mkdir($pasta, 0755);

            $nomeTemporario = $_FILES['imagem']['tmp_name']; //obtém o nome temporário da imagem
            $nomeArquivo = $_FILES['imagem']['name']; //obtém o nome original da imagem
            $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION); //obtém a extensão do nome da imagem. A função pathinfo retorna infomações sobre o arquivo
            $extensao = strtolower($extensao); //converte a extensão para minúsculo
            $tipoArquivo = array('jpg', 'jpeg', 'png', 'gif'); //cria um array contendo os tipos de imagens válidas para o projeto
            //verifica se a extensão da imagem é válida
            if(in_array($extensao, $tipoArquivo)){

                //cria um nome único para imagem
                $novoNome = uniqid(time()) . '.' . $extensao;
                //cria o destino + novo nome do arquivo para realizar o upload
                $destino = $pasta . $novoNome; /***** */
                //executa e verifica se o upload teve sucesso
                if(move_uploaded_file($nomeTemporario, $destino)){

                    //prepara o comando INSERT
                    $sql = "INSERT INTO produtos (nome, descricao, estoque, estoque_min, valor, ativo, idcategoria, imagem, datacriacao, datamodificacao) VALUES ('$requestData[nome]','$requestData[descricao]','$requestData[estoque]','$requestData[estoque_min]','$requestData[valor]','$requestData[ativo]','$requestData[idcategoria]','$destino','$dataAgora','$dataAgora')";
                    //executa o comando INSERT
                    $resultado = mysqli_query($conexao, $sql);
                    //verifica se houve sucesso
                    if($resultado){
                        $dados = array(
                            "tipo" => "success",
                            "mensagem" => "Produto cadastro com sucesso."
                        );
                    } else { // caso não teve sucesso na execução do INSERT
                        $dados = array(
                            "tipo" => "error",
                            "mensagem" => "Erro ao cadastrar o produto."
                        );
                        unlink($destino); //exclui o arquivo da pasta caso o comando INSERT falhe
                    }
                } else{ // caso não teve sucesso ao mover o arquivo da pasta temporária para o destino
                    $dados = array(
                        "tipo" => "error",
                        "mensagem" => "Não foi possível realizar o upload da imagem."
                    );
                }
            } else{ // caso o tipo da imagem seja inválida
                $dados = array(
                    "tipo" => "info",
                    "mensagem" => "Tipo da imagem só ser JPG, JPEG, PNG, GIF"
                );
            }
            
        } else {
            $dados = array( //caso exista algum campo obrigatório vazio
                "tipo" => "info",
                "mensagem" => "Existe(m) campo(s) obrigatório(s) vazio(s)"
            );
        }

        //fecha a conexão
        mysqli_close($conexao); /** */

    } else {
        $dados = array( // caso não tem uma conexão com o banco de dados
            "tipo" => "info",
            "mensagem" => "Ops... não foi possível conectar ao banco de dados"
        );
    }

    //retorna para o front-end o objeto json com a mensagem
    echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);