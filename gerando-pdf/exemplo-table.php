<?php

use \Mpdf\Mpdf;

require_once __DIR__ . '/vendor/autoload.php';

include '../src/banco/conexao.php';

if(!$conexao){
    echo 'Sem conexão';
    exit;
}

$data = date('d/m/Y H:i:s');
$cabecalho = "<table class='tbl_cabecalho'>
    <tr>
        <td align='left'>ETEC de Lins</td>
        <td align='right'>Gerado em : $data</td>
    </tr>
</table>";

$rodape = "<table class='tbl_rodape'>
<tr>
    <td align='left'>www.eteclins.com.br</td>
    <td align='right'>Página {PAGENO}</td>
</tr>
</table>";

$titulo = "<h2 class='titulo'>Relatório de Produtos</h2>";

$tabela = "<table id='tabela'>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Estoque</th>
        <th>Estoque Min.</th>
        <th>Valor</th>
        <th>Ativo</th>
    </tr>";

$sql = "SELECT * FROM produtos";
$resultado = mysqli_query($conexao, $sql);
while($linha = mysqli_fetch_assoc($resultado)){
    $tabela .= "<tr>";
    $tabela .= "<td>{$linha['idproduto']}</td>";
    $tabela .= "<td>{$linha['nome']}</td>";
    $tabela .= "<td>{$linha['descricao']}</td>";
    $tabela .= "<td>{$linha['estoque']}</td>";
    $tabela .= "<td>{$linha['estoque_min']}</td>";
    $tabela .= "<td>{$linha['valor']}</td>";
    $tabela .= "<td>{$linha['ativo']}</td>";
    $tabela .= "</tr>";
}

$tabela .= "</table>";

$mpdf = new Mpdf();
$mpdf->SetHTMLHeader($cabecalho);
$mpdf->SetHTMLFooter($rodape);
$css = file_get_contents('css/relatorio.css');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($titulo);
$mpdf->WriteHTML($tabela);

$mpdf->Output();