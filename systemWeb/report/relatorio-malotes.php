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
	$pdf = new FPDF("P");
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(190,10,utf8_decode('Relatório de Malotes'),0,0,"C");
	$pdf->Ln(15);
	
	//montar cabeçalho do pdf
	$pdf->SetFont("Arial","I",10);
	$pdf->Cell(10,7,"#",1,0,"C");
	$pdf->Cell(60,7,"CLIENTE",1,0,"C");
	$pdf->Cell(30,7,"DATA",1,0,"C");
	$pdf->Cell(60,7,"REFERENCIA",1,0,"C");

	$pdf->Ln();
	
	//select 
	$reply = $database->select("SELECT pc.*, c.name, c.code FROM pouch_check pc, client c WHERE idClient_Pousch = idClient ORDER BY date_e, idPouch");
	
	if (!empty($reply)){
		foreach ($reply as $row){	
			$pdf->Cell(10,7,utf8_decode($row->idPouch),1,0,"C");
			$pdf->Cell(60,7,utf8_decode($row->idClient_Pousch)." - ".utf8_decode($row->name),1,0,"L");
			$pdf->Cell(30,7,($row->date_e),1,0,"C");
			$pdf->Cell(60,7,utf8_decode($row->reference),1,0,"L");
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
	