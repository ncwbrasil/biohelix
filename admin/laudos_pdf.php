<?php
session_start (); 
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

$ip = "localhost";
$user = "biohelix_admin"; 
$senha = "info2012mogi";
$db = "biohelix_site";
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
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');

$login = $_GET['login'];
$n = $_GET['n'];
$pagina = $_GET['pagina'];
$lau_id = $_GET['lau_id'];
$sqledit = "SELECT * FROM laudos 
			LEFT JOIN clientes ON clientes.cli_id = laudos.lau_cliente
			LEFT JOIN exames ON exames.exa_id = laudos.lau_tipo_laudo
			WHERE lau_id = '$lau_id'";
$queryedit = mysql_query($sqledit,$conexao);
$rowsedit = mysql_num_rows($queryedit);

if($rowsedit > 0)
{
	$lau_id = mysql_result($queryedit, 0, 'lau_id');
	$lau_cliente = mysql_result($queryedit, 0, 'lau_cliente');
	$cli_id = mysql_result($queryedit, 0, 'cli_id');
	$cli_nome = mysql_result($queryedit, 0, 'cli_nome');
	$cli_data_nasc = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'cli_data_nasc'))));
	$cli_sexo = mysql_result($queryedit, 0, 'cli_sexo');
	$cli_rg = mysql_result($queryedit, 0, 'cli_rg');
	$cli_telefone = mysql_result($queryedit, 0, 'cli_telefone');
	$cli_email = mysql_result($queryedit, 0, 'cli_email');
	$lau_tipo_laudo = mysql_result($queryedit, 0, 'lau_tipo_laudo');
	$exa_id = mysql_result($queryedit, 0, 'exa_id');
	$exa_nome = mysql_result($queryedit, 0, 'exa_nome');
	$lau_numero = mysql_result($queryedit, 0, 'lau_numero');
	$lau_ano = mysql_result($queryedit, 0, 'lau_ano');
	$lau_num_geral = mysql_result($queryedit, 0, 'lau_num_geral');
	$lau_dr = mysql_result($queryedit, 0, 'lau_dr');
	$lau_data_entrada = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_data_entrada'))));
	$lau_data_liberacao = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_data_liberacao'))));
	$lau_conteudo = mysql_result($queryedit, 0, 'lau_conteudo');
	$lau_conteudo2 = mysql_result($queryedit, 0, 'lau_conteudo2');
	$lau_resultado = mysql_result($queryedit, 0, 'lau_resultado');
	$lau_resultado_final = nl2br(mysql_result($queryedit, 0, 'lau_resultado_final'));
	$lau_status = mysql_result($queryedit, 0, 'lau_status');
	$lau_ra_num1 = mysql_result($queryedit, 0, 'lau_ra_num1');
	$lau_ra_data1 = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_ra_data1'))));
	$lau_ra_res1 = mysql_result($queryedit, 0, 'lau_ra_res1');
	$lau_ra_num2 = mysql_result($queryedit, 0, 'lau_ra_num2');
	$lau_ra_data2 = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_ra_data2'))));
	$lau_ra_res2 = mysql_result($queryedit, 0, 'lau_ra_res2');
	
}
//header("Content-Type: text/html; charset=utf-8", true); 
ob_start();  //inicia o buffer
?>
<!--<img src='../imagens/topopdf.png'>-->
<style>
.topo 			{ margin:0 auto; text-align:center; padding: 0 0 15px 0;}
.rodape 		{ margin:0 auto; text-align:center; padding: 15px 0 0 0;}
.rod			{ color: #999; font-size:11px; font-family:Calibri; }
.titulo_adm		{ width:960px; margin:0 auto; font-size:18px; color:#999; text-align:left; border-bottom:1px dashed #DDD; padding:0 0 10px 10px; margin:20px 0 10px 0;}
.laudo			{ font-family:Calibri; font-size:11px;  -webkit-print-color-adjust: exact; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; padding:20px 10px;}
.titulo_laudo	{ font-size:18px; font-weight:bold; text-align:center; }
.verde			{ color:#00B5CC;}
.azul			{ color:#085491;}
#resultados_anteriores		{ border-collapse:collapse; width:1000px; }
#resultados_anteriores tr td{ border: 1px solid #CCC; text-align:center;}
#resultados_anteriores .titulo_ant{ background:#EEE; text-align:center;}
#resultados_anteriores .esquerda{ text-align:left;}

</style>
<?php	
	echo "
	<table align='center' border='0'  cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center'>
				<div >
				<table class='laudo' align='center' cellspacing='0' cellpadding='5' width='1000'>
					<tr>
						<td align='justify'>
							<b>Nome:</b> $cli_nome</option>
						</td>
						<td>
							<b>Data Nascimento:</b> $cli_data_nasc</option>
						</td>
						<td>
							<b>Sexo:</b> $cli_sexo</option>
						</td>
					</tr>
					<tr>
						<td align='justify'>
							<b>RG:</b> $cli_rg</option>
						</td>
						<td>
							<b>Telefone:</b> $cli_telefone</option>
						</td>
						<td>
							<b>Email:</b> $cli_email</option>
						</td>
					</tr>
					<tr>
						<td align='justify'>
							<b>N. Atendimento:</b> $lau_numero/$lau_ano</option>
						</td>
						<td>
							<b>Dr(a):</b> $lau_dr</option>
						</td>
					</tr>
					<tr>
						<td align='justify'>
							<b>N° Geral do Exame:</b> $lau_num_geral</option>
						</td>
						<td align='justify'>
							<b>Data Entrada:</b> $lau_data_entrada</option>
						</td>
						<td>
							<b>Data de Liberação:</b> $lau_data_liberacao</option>
						</td>
					</tr>
					<tr>
						<td align='center' colspan='3'>
							<br><br>
							<p class='titulo_laudo'>$exa_nome</p>
						</td>
					</tr>
					<tr>
						<td align='justify' colspan='3'>
							$lau_conteudo
						</td>
					</tr>
					<tr>
						<td align='justify' colspan='3'>
							<b>Resultado: </b><br>
							$lau_resultado
						</td>
					</tr>
					<tr>
						<td align='justify' colspan='3'>
							<b>$lau_resultado_final </b>
						</td>
					</tr>
					<tr>
						<td align='justify' colspan='3'>
							$lau_conteudo2
						</td>
					</tr>
					<tr>
						<td align='justify' colspan='3'>
							<b>Resultado(s) anterior(es):</b><br>
							<table id='resultados_anteriores' cellspacing='0' cellpadding='5'>
								<tr>
									<td class='titulo_ant'>
										<b>N. Exame</b>
									</td>
									<td class='titulo_ant'>
										<b>Data do Exame</b>
									</td>
									<td class='titulo_ant'>
										<b>Resultado</b>
									</td>
								</tr>
								<tr>
									<td>
										<b>$lau_ra_num1</b>
									</td>
									<td>
										<b>$lau_ra_data1</b>
									</td>
									<td>
										<b>$lau_ra_res1</b>
									</td>
								</tr>
								<tr>
									<td>
										<b>$lau_ra_num2</b>
									</td>
									<td>
										<b>$lau_ra_data2</b>
									</td>
									<td>
										<b>$lau_ra_res2</b>
									</td>
								</tr>
								";
								/*$sql_anterior = "SELECT * FROM laudos 
												 LEFT JOIN clientes ON clientes.cli_id = laudos.lau_cliente
												 LEFT JOIN exames ON exames.exa_id = laudos.lau_tipo_laudo
												 WHERE lau_cliente = $cli_id AND 
												 	   lau_id < $lau_id AND 
													   lau_data_entrada <= '".implode("-",array_reverse(explode("/",$lau_data_entrada)))."' AND 
													   exa_id = '$exa_id'
												 ORDER BY lau_data_entrada DESC, lau_id DESC LIMIT 0,2";
								$query_anterior = mysql_query($sql_anterior,$conexao);
								$rows_anterior = mysql_num_rows($query_anterior);
								if($rows_anterior > 0)
								{
									while($row = mysql_fetch_array($query_anterior))
									{
										echo "
										<tr>
											<td>
												".$row['lau_numero']."/".$row['lau_ano']."
											</td>
											<td>
												".implode("/",array_reverse(explode("-",$row['lau_data_entrada'])))."
											</td>
											<td class='esquerda'>
												".nl2br($row['lau_resultado_final'])."
											</td>
										</tr>";
									}
								}
								else
								{
									echo "
									<tr>
										<td colspan='3'>
											Sem resultados anteriores
										</td>
									</tr>
									";
								}*/
								echo "
							</table>
						</td>
					</tr>
				</table>
				</div>
				<div class='titulo_adm'>   </div>
			</td>
		</tr>
	</table>
	";
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
 55,    // margin bottom
 5,     // margin header
 5,     // margin footer
 'P');  // L - landscape, P - portrait);
$mpdf->SetHTMLHeader('<div class=topo><img src=../imagens/logo.png><br><br><img src=../imagens/linha.png /></div>'); 
$mpdf->SetHTMLFooter('
<div class=rodape>
<img src=../imagens/linha.png />
<table align=center class=rod>
<tr>
<td align=center>
<img src="../imagens/ass_walter.jpg" height="70"><br>
Dr. Walter Kleine Neto<br>CRBM: 7747	
</td>
<td align=center>
<img src="../imagens/ass_wagner.jpg" height="70"><br>
Dr. Wagner Kleine<br>CRBM: 12015
</td>
</tr>
<tr>
<td colspan=2 align=center>
<br>
<span class=azul>Bio</span><span class=verde>Hélix</span> Biologia Molecular - Rua Alfonsus de Guimarães, 22 - Mogi das Cruzes, SP - CEP: 08810-160<br>
Contato: (11) <span class=verde>2378-6357</span> | <span class=verde>contato@biohelix.com.br</span> | <span class=verde>www.biohelix.com.br</span><br> 
CNPJ: 15.143.683/0001-03 | Inscrição Conselho Regional de Biomedicina: 2013.3582-0
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