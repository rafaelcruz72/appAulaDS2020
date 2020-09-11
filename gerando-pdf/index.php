<?php

use \Mpdf\Mpdf;

require_once __DIR__ . '/vendor/autoload.php';

$html = '<h1 style="text-align: center">Gerando PDF com HP</h1>
        <p>Testando o uso da biblioteca Mpdf</p>';

$mpdf = new Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();