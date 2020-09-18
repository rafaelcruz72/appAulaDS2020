<?php

use Mpdf\Mpdf;

require_once __DIR__ . '/vendor/autoload.php';

$html = "
<fieldset>
<h1>Recibo de Pagamento</h1>
<p class='center sub-titulo'>
Nº <strong>0001</strong> -
VALOR <strong>R$ 700,00</strong>
</p>
<p>Recebi(emos) de <strong>Rafael Anderson Cruz</strong></p>
<p>a quantia de <strong>Setecentos reais</strong></p>
<p>Correspondente a <strong>Serviços prestados...</strong></p>
<p>e para clareza firma(amos) o presente.</p>
<p class='direita'>Lins, 11 de Setembro de 2020.</p>
<p>Assinatura ..............................................</p>
<p>Nome <strong>Etec de Lins</strong></p>
<p>Endereço <strong>Rua São Pedro, 300 - Vila Perin</strong></p>
</fieldset>
";

$mpdf = new Mpdf();
$mpdf->setDisplayMode('fullpage');
$css = file_get_contents("css/estilo.css");
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($html);
$mpdf->Output();
?>

