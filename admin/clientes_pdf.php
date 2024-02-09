<?php
session_start (); 
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

$ip = "bd-mogicomp.sytes.net:3030";
$user = "root"; 
$senha = "m0507c1106";
$db = "biohelix";

$conexao =  mysql_connect("$ip","$user","$senha");
if($conexao)
{       
	if( !  mysql_select_db("$db",$conexao)  )
	{       
		die( mysql_error($conexao)); 
	
    }
}
else
{
		die('Não foi possível conectar ao banco de dados.');     
}


$login = $_GET['login'];
$n = $_GET['n'];
$pag = $_GET['pag'];


mysql_query("SET NAMES 'utf8'");

mysql_query('SET character_set_connection=utf8');

mysql_query('SET character_set_client=utf8');

mysql_query('SET character_set_results=utf8');
date_default_timezone_set('America/Sao_Paulo');

//header("Content-Type: text/html; charset=utf-8", true); 
ob_start();  //inicia o buffer
?>
<!--<img src='../imagens/topopdf.png'>-->
<style>
.topo 			{ margin:0 auto; text-align:center; padding: 0 0 15px 0;}
.rodape 		{ margin:0 auto; text-align:center; padding: 15px 0 0 0;}
.titulo				{ font-family:Calibri; font-size:24px; color:#00B5CC; margin:0 0 10px 0; text-indent:0px; }
.cliente			{ font-family:Calibri; font-size:13px; width:1000px; -webkit-print-color-adjust: exact; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; padding:20px 10px;}
table				{ font-family:Calibri; font-size:13px; color:#AAA; width:1000px; }
.verde			{ color:#00B5CC;}
.azul			{ color:#085491;}

</style>
<?php	
	$pagina = $_GET['pagina'];

	$cli_id = $_GET['cli_id'];
	$sqledit = "SELECT * FROM clientes WHERE cli_id = '$cli_id'";
	$queryedit = mysql_query($sqledit,$conexao);
	$rowsedit = mysql_num_rows($queryedit);

	if($rowsedit > 0)
	{
		$cli_id = mysql_result($queryedit, 0, 'cli_id');
		$cli_nome = mysql_result($queryedit, 0, 'cli_nome');
		$cli_data_nasc = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'cli_data_nasc'))));
		$cli_sexo = mysql_result($queryedit, 0, 'cli_sexo');
		$cli_rg = mysql_result($queryedit, 0, 'cli_rg');
		$cli_telefone = mysql_result($queryedit, 0, 'cli_telefone');
		$cli_email = mysql_result($queryedit, 0, 'cli_email');
		$cli_login = mysql_result($queryedit, 0, 'cli_login');
		$cli_senha = mysql_result($queryedit, 0, 'cli_senha_n');
		$cli_status = mysql_result($queryedit, 0, 'cli_status');
								
		echo "

			<!-- INICIO QUADRO -->
						<table class='cliente' align='center' cellspacing='0' cellpadding='5' width='1000'>
							<tr>
								<td align='left'>
									<p class='titulo'>&raquo; Dados Pessoais</p>
									<br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Nome:</b> $cli_nome<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Data Nascimento:</b> $cli_data_nasc<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Sexo:</b> $cli_sexo<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>RG:</b> $cli_rg<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Telefone:</b> $cli_telefone<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Email:</b> $cli_email<p><br><br>
									
									<p class='titulo'>&raquo; Dados de Acesso</p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Login:</b> $cli_login<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Senha:</b> $cli_senha<p><br>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Acesse <span class='azul'>www.biohelix.com.br</span> e digite o login e senha acima para visualizar seus exames.
								</td>	
							</tr>
						</table>			
		<!-- FIM QUADRO -->
		";
		}
		else
		{
			echo "Não foram encontrados laudos. <br>";
		}
$html = ob_get_clean();
$html = utf8_encode($html);

define('MPDF_PATH', '../js/mpdf/');
include(MPDF_PATH.'mpdf.php');
$mpdf = new mPDF(
 '',    // mode - default ''
 'A4',    // format - A4, for example, default ''
 0,     // font size - default 0
 '',    // default font family
 10,    // margin_left
 10,    // margin right
 40,     // margin top
 35,    // margin bottom
 5,     // margin header
 5,     // margin footer
 'P');  // L - landscape, P - portrait);
$mpdf->SetHTMLHeader('<div class=topo><img src=../imagens/logo.png><br><br><img src=../imagens/linha.png /></div>'); 
$mpdf->SetHTMLFooter('
<div class=rodape>
<img src=../imagens/linha.png />
<table align=center>
<tr>
<td align=center>
Dr. Walter Kleine Neto<br>CRBM: 7747	
</td>
<td align=center>
Dr. Wagner Kleine<br>CRBM: 12015
</td>
</tr>
<tr>
<td colspan=2 align=center>
<br>
<span class=azul>Bio</span><span class=verde>Hélix</span> Biologia Molecular - Rua Alfonsus de Guimarães, 22 - Mogi das Cruzes, SP - CEP: 08810-160<br>
Contato: (11) <span class=verde>2378-6357</span> | <span class=verde>contato@biohelix.com.br</span> | <span class=verde>www.biohelix.com.br</span><br> 
CNPJ: 15.143.683/0001-03 | Inscrição Conselho Regional de Biomedicina: 2013.3582-0 <br>
</td>
</tr>
<tr>
<td colspan=2 align=right>
{PAGENO} / {nbpg}
</td>
</tr>
</table>
</div>
');
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='UTF-8';
$mpdf->WriteHTML(utf8_decode("$html"));
$mpdf->Output();
exit();

?>
