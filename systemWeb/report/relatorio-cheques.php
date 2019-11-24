<?php
	define('HERE', $_SERVER['HTTP_HOST'].'/SYSCoffe/systemSimpleInPhp_ProgInternet_Univates/');
	//define('HERE', $_SERVER['HTTP_HOST']);
	include '../system/config.php';
	require "../system/Database.php";
	require "../fpdf/fpdf.php";
	$database = new \system\Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

//	$servidor = DB_HOST;
//	$usuario = DB_USER;
//	$senha = DB_PASS;
//	$dbname = DB_NAME;
//
//	//Criar a conexão
//	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
//	if(!$conn){
//		die("Falha na conexao: " . mysqli_connect_error());
//	}else{
//		//echo "Conexao realizada com sucesso";
//	}
	
	///instanciar novo pdf
/// //Inicia O documento PDF com orientação P - Retrato (Picture) OU L - Paisagem (Landscape)
	$pdf = new FPDF("L");
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(297,10,utf8_decode('Relatório de Cheques'),0,0,"C");
	$pdf->Ln(15);
	
	//montar cabeçalho do pdf
	$pdf->SetFont("Arial","I",10);
	$pdf->Cell(10,7,"#",1,0,"C");
	$pdf->Cell(15,7,"MALOTE",1,0,"C");
	$pdf->Cell(25,7,"DATA",1,0,"C");
	$pdf->Cell(30,7,"VALOR",1,0,"C");
	$pdf->Cell(23,7,"NR CHEQUE",1,0,"C");
	$pdf->Cell(60,7,"TITULAR",1,0,"C");
	$pdf->Cell(60,7,"CPF/CNPJ",1,0,"C");
	$pdf->Cell(15,7,"BANCO",1,0,"C");
	$pdf->Cell(18,7,"AGENCIA",1,0,"C");
	$pdf->Cell(20,7,"CONTA",1,0,"C");


	$pdf->Ln();
	
	//select 
	$reply = $database->select("SELECT * FROM check_doc ORDER BY date");
	
	if (!empty($reply)){
		foreach ($reply as $row){	
			$pdf->Cell(10,7,utf8_decode($row->idCheck),1,0,"C");
            $pdf->Cell(15,7,"NR ".utf8_decode($row->idPouch_Check),1,0,"C");
            $pdf->Cell(25,7,utf8_decode($row->date),1,0,"C");
            $pdf->Cell(30,7,"R$ ".utf8_decode($row->value),1,0,"L");
            $pdf->Cell(23,7,utf8_decode($row->numberCheck),1,0,"C");
            $pdf->Cell(60,7,utf8_decode($row->nameHolder),1,0,"L");
            $pdf->Cell(60,7,utf8_decode($row->docCpfOrCnpj),1,0,"C");
            $pdf->Cell(15,7,utf8_decode($row->numberBank),1,0,"C");
            $pdf->Cell(18,7,utf8_decode($row->numberAgency),1,0,"R");
            $pdf->Cell(20,7,utf8_decode($row->numberAccount),1,0,"R");
			$pdf->Ln();
		}
	}
//Nome do PDF
	$file = "relatorio-malotes.pdf";
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
	
	
	
	/*$id = "1";
	$result_usuario = "SELECT * FROM usuarios WHERE id = '$id' LIMIT 1";
	$resultado_usuario = mysqli_query($conn, $result_usuario);	
	$row_usuario = mysqli_fetch_assoc($resultado_usuario);	
	
	
	$pagina = 
		"<html>
			<body>
				<h1>Informações do Usuário</h1>
				Id: ".$row_usuario['id']."<br>
				Nome: ".$row_usuario['nome']."<br>
				E-mail: ".$row_usuario['email']."<br>
				Senha: ".$row_usuario['senha']."<br>
				<h4>http://www.celke.com.br</h4>
			</body>
		</html>
		";

	$arquivo = "Cadastro01.pdf";
	*/
	
?>
	