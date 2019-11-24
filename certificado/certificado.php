<?php
    require 'vendor/autoload.php';
    use GuzzleHttp\Client;
    require 'lib/Fpdf/fpdf.php';

    function GET($url){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return json_decode($response->getBody());
    }

    //init certificado
    function showPDF($array, $idCertified){
        $pdf = new FPDF('L');
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 40);
        $pdf->Cell(280, 30, utf8_decode('CERTIFICADO DE PARTICIPAÇÃO'), 1, 0, 'C');

        $pdf->Ln(60);
        $pdf->SetFont('Times', '', 15);
        $pdf->Cell(280, 10, utf8_decode('CONFERIMOS A'), 0, 0, 'C');

        $pdf->Ln(20);
        $pdf->SetFont('Times', 'IB', 35);
        $pdf->Cell(280, 10, utf8_decode('*'.$array[$idCertified]->usuario->nome.'*'), 'B', 0, 'C');

        $pdf->Ln(20);
        $pdf->SetFont('Times', '', 15);
        $pdf->Cell(280, 10, utf8_decode('O CERTIFICADO PELA PARTICIPAÇÃO DO EVENTO'), 0, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 15);
        $pdf->Cell(280, 10, utf8_decode($array[$idCertified]->evento->nome), 0, 0, 'C');

        $date_day = date('d', $array[$idCertified]->evento->dataevento);
        $date_month = date('n', $array[$idCertified]->evento->dataevento);

        switch ($date_month) {
            case 1 : $date_month = 'JANEIRO'; break;
            case 2 : $date_month = 'FEVEREIRO'; break;
            case 3 : $date_month = 'MARÇO'; break;
            case 4 : $date_month = 'ABRIL'; break;
            case 5 : $date_month = 'MAIO'; break;
            case 6 : $date_month = 'JUNHO'; break;
            case 7 : $date_month = 'JULHO'; break;
            case 8 : $date_month = 'AGOSTO'; break;
            case 9 : $date_month = 'SETEMBRO'; break;
            case 10 : $date_month = 'OUTUBRO'; break;
            case 11 : $date_month = 'NOVEMBRO'; break;
            case 12 : $date_month = 'DEZEMBRO'; break;
        }

        $date_year = date('Y', $array[$idCertified]->evento->dataevento);


        $pdf->Ln(10);
        $pdf->SetFont('Times', '', 15);
        $pdf->Cell(280, 10, utf8_decode("NO DIA {$date_day} DE {$date_month} DE {$date_year}"), 0, 0, 'C');

        $pdf->Ln(33);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(280, 10, utf8_decode("CERTIFICADO NR. {$idCertified}"), 0, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(280, 10, utf8_decode('VALIDE O CERTIFICADO EM'), 0, 0, 'C');

        $pdf->Ln(5);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(280, 10, utf8_decode('www.ms-api.syscoffe.com.br/certificado/validar/{NÚMERO DO CERTIFICADO}'), 0, 0, 'C');


        //Nome do PDF
        $file = "certificado.pdf";
        /*
        GERAR COMO
        I: Envia o arquivo para o navegador. O visualizador de PDF é usado se disponível.
        D: Enviar para o navegador e forçar o arquivo um download com o nome especificado.
        F: Salva o arquivo local com o nome dado por name(pode incluir um caminho).
        S: Retorna o documento como uma string.
        DEFAULT: O valor padrão é I.
        */
        $type = "I";
        $pdf->Output($file, $type);
    }

    function getData($idCertified) {
        $token = "d690caea5ae5641c9cceec11628c6aef";
        $url = "http://ms-api.syscoffe.com.br/certificado/api/show/{$idCertified}/{$token}";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);

        return json_decode( $response->getBody() );
    }



    if ( isset($_GET['id']) && !empty($_GET['id']) ) {

        $idCertified = $_GET['id'];

        $array = getData($idCertified);

        if ( array_key_exists('erro') || empty($array) ) {
            echo "Problemas ao gerar certificado. Por favor, tente mais tarde!";
        } else {
            showPDF($array, $idCertified);
        }

    }

    ?>