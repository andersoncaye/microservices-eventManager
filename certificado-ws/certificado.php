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
    function showPDF($idCertified, $usuario, $evento){
        $pdf = new FPDF('L');
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 40);
        $pdf->Cell(280, 30, utf8_decode('CERTIFICADO DE PARTICIPAÇÃO'), 1, 0, 'C');

        $pdf->Ln(60);
        $pdf->SetFont('Times', '', 15);
        $pdf->Cell(280, 10, utf8_decode('CONFERIMOS A'), 0, 0, 'C');

        $pdf->Ln(20);
        $pdf->SetFont('Times', 'IB', 35);
        $pdf->Cell(280, 10, utf8_decode('*'.$usuario->nome.'*'), 'B', 0, 'C');

        $pdf->Ln(20);
        $pdf->SetFont('Times', '', 15);
        $pdf->Cell(280, 10, utf8_decode('O CERTIFICADO PELA PARTICIPAÇÃO DO EVENTO'), 0, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 15);
        $pdf->Cell(280, 10, utf8_decode($evento->nome), 0, 0, 'C');


        $date = str_split($evento->dataevento);
        $date_day   = $date[8].$date[9];
        $date_month = (int) $date[5].$date[6];
        $date_year  = $date[0].$date[1].$date[2].$date[3];

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

    function getData($url) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return json_decode( $response->getBody() );
    }



    if ( isset($_GET['id']) && !empty($_GET['id']) ) {
        $token = "d690caea5ae5641c9cceec11628c6aef";
        $idCertified = (int) $_GET['id'];
        $array_ids = getData("http://ms-api.syscoffe.com.br/certificado/api/show/{$idCertified}/{$token}");
        if ( empty($array_ids) || array_key_exists('erro', $array_ids) ){
            echo "Problemas ao gerar certificado. Por favor, tente mais tarde!";
        } else {
//        $id_inscricao   = $array_ids->id_inscricao;
//        $inscricao = getData("https://sofftest.azurewebsites.net/api/inscricoes/{$id_inscricao}?token={$token}");

//        $id_registro    = $array_ids->id_registro;
//        $registro = getData("https://sofftest.azurewebsites.net/api/registros/{$id_registro}?token={$token}");

            sleep(5);
            $id_usuario = $array_ids->id_usuario;
            $usuario = getData("http://ms-api.syscoffe.com.br/usuario/api/show/{$id_usuario}/{$token}");

            sleep(5);
            $id_evento = $array_ids->id_evento;
            $evento = getData("https://sofftest.azurewebsites.net/api/eventos/{$id_evento}?token={$token}");

            if (array_key_exists('erro', $evento) || empty($evento) ||
                array_key_exists('erro', $usuario) || empty($usuario)) {
                echo "Problemas ao gerar certificado. Por favor, tente mais tarde!";
            } else {
                showPDF($idCertified, $usuario, $evento);
            }
        }

    }

    ?>