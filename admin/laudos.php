<?php
session_start (); 
require_once("../mod_includes/php/ctracker.php");
include('../mod_includes/php/connect.php');
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<head>
<meta name="author" content="Gustavo Costa">
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biohélix - Biologia Molecular Diagnóstica</title>
<link rel="shortcut icon" href="../imagens/favicon.ico">
<link href="../css/estilo_admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/funcoes.js"></script>
<!-- TOOLBAR -->
<link href="../js/toolbar/jquery.toolbars.css" rel="stylesheet" />
<link href="../js/toolbar/bootstrap.icons.css" rel="stylesheet">
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script src="../js/toolbar/jquery.toolbar.js"></script>
<!-- TOOLBAR -->
<!-- TinyMCE -->
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../js/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript" src="../js/tiny_mce/tiny.js"></script>
<!-- /TinyMCE -->
</head>
<body>
<?php	
//TOPO
include('../mod_includes/php/funcoes-jquery.php');
include('../mod_includes/php/verificalogin.php');
include("../mod_topo_admin/topo.php");
//FIM TOPO

$pagina = $_GET['pagina'];
$page = "<a href='laudos.php?pagina=laudos&login=$login&n=$n'>Laudos</a>";
$num_por_pagina = 30;
$pag = $_GET['pag'];
if(!$pag){$primeiro_registro = 0; $pag = 1;}
else{$primeiro_registro = ($pag - 1) * $num_por_pagina;}
$fil_lau_numero = $_REQUEST['fil_lau_numero'];
if($fil_lau_numero == '')
{
	$lau_numero_query = " 1 = 1 ";
}
else
{
	$lau_numero_query = " CONCAT(lau_numero,'/',lau_ano) LIKE '%$fil_lau_numero%' ";
}
$fil_lau_status = $_REQUEST['fil_lau_status'];
if($fil_lau_status == '')
{
	$lau_status_query = " 1 = 1 ";
	$fil_lau_status_n = "Status";
}
else
{
	$lau_status_query = " lau_status = '$fil_lau_status' ";
	switch($fil_lau_status)
	{
		case 0 : $fil_lau_status_n = "Em Análise"; break;
		case 1 : $fil_lau_status_n = "Concluído"; break;
	}
	
}
$sql = "SELECT * FROM laudos 
		LEFT JOIN clientes ON clientes.cli_id = laudos.lau_cliente
		LEFT JOIN exames ON exames.exa_id = laudos.lau_tipo_laudo
		WHERE ".$lau_numero_query." AND ".$lau_status_query."
		ORDER BY lau_ano DESC, lau_numero DESC
		LIMIT $primeiro_registro, $num_por_pagina";
$consulta = "SELECT COUNT(*) FROM laudos
   		WHERE ".$lau_numero_query." AND ".$lau_status_query."";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
if($pagina == "laudos")
{
	echo "
	<table class='texto' align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left'>
				<div class='titulo_adm'> $page  </div>
				<div id='interna'>
				<div id='icone'><input name='add-adm' value='Novo Laudo' type='button' onclick=javascript:window.location.href='laudos.php?pagina=adicionar_laudos&login=$login&n=".str_replace(' ','%20',"$n")."'; /></div>
				<div style='float:right'>
					<form name='form' id='form' enctype='multipart/form-data' method='post' action='laudos.php?pagina=laudos&login=$login&n=$n'>
					<input name='fil_lau_numero' id='fil_lau_numero' placeholder='N. Atendimento' value='$fil_lau_numero'>
					<select name='fil_lau_status' id='fil_lau_status'>
                    	<option value='$fil_lau_status'>$fil_lau_status_n</option>
						<option value='0'>Em Análise</option>
						<option value='1'>Concluído</option>
						<option value=''>Todos</option>
					</select>
					<input name='bt_filtrar' id='bt_filtrar' value='Filtrar' type='submit'>
					</form>
				</div>";
				if ($rows > 0)
				{
				echo "
				<table align='center' width='100%' border='0' cellspacing='0' cellpadding='10' class='bordatabela'>
					<tr>
						<td class='titulo_first'>Atendimento</td>
						<td class='titulo_tabela'>Cliente</td>
						<td class='titulo_tabela'>N. Geral do Exame</td>
						<td class='titulo_tabela'>Exame</td>
						<td class='titulo_tabela'>Data Entrada</td>
						<td class='titulo_tabela'>Data Liberação</td>
						<td class='titulo_tabela'>Status</td>
						<td class='titulo_last' align='center'>Gerenciar</td>
					</tr>";
						$c=0;
						for($x = 0; $x < $rows ; $x++)
						{
							$lau_id = mysql_result($query, $x, 'lau_id');
							$lau_numero = mysql_result($query, $x, 'lau_numero');
							$lau_ano = mysql_result($query, $x, 'lau_ano');
							$cli_nome = mysql_result($query, $x, 'cli_nome');
							$exa_nome = mysql_result($query, $x, 'exa_nome');
							$lau_num_geral = mysql_result($query, $x, 'lau_num_geral');
							$lau_dr = mysql_result($query, $x, 'lau_dr');
							$lau_data_entrada = implode("/",array_reverse(explode("-",mysql_result($query, $x, 'lau_data_entrada'))));
							$lau_data_liberacao = implode("/",array_reverse(explode("-",mysql_result($query, $x, 'lau_data_liberacao'))));
							$lau_status = mysql_result($query, $x, 'lau_status');
							if ($c == 0)
							{
							 $c1 = "";
							 $c=1;
							}
							else
							{
							$c1 = "linhapar";
							 $c=0;
							} 
							echo "
							<script type='text/javascript'>
								jQuery(document).ready(function($) {
							
									// Define any icon actions before calling the toolbar
									$('.toolbar-icons a').on('click', function( event ) {
										$(this).click();
										
									});
							
									$('#normal-button-$lau_id').toolbar({content: '#user-options-$lau_id', position: 'top', hideOnClick: true});
									$('#normal-button-bottom').toolbar({content: '#user-options', position: 'bottom'});
									$('#normal-button-small').toolbar({content: '#user-options-small', position: 'top', hideOnClick: true});
									$('#button-left').toolbar({content: '#user-options', position: 'left'});
									$('#button-right').toolbar({content: '#user-options', position: 'right'});
									$('#link-toolbar').toolbar({content: '#user-options', position: 'top' });
								});
							</script>
							<div id='user-options-$lau_id' class='toolbar-icons' style='display: none;'>
								<a href='laudos_pdf.php?pagina=laudos_pdf&lau_id=$lau_id&lau_login=$lau_login&login=$login&n=$n' target='_blank'><img border='0' src='../imagens/icon-pdf.png'></a>
								<a href='laudos.php?pagina=exibir_laudos&lau_id=$lau_id&lau_login=$lau_login&login=$login&n=$n'><img border='0' src='../imagens/icon-exibir.png'></a>
								<a href='laudos.php?pagina=editar_laudos&lau_id=$lau_id&lau_login=$lau_login&login=$login&n=$n'><img border='0' src='../imagens/icon-editar.png'></a>
								<a onclick=\"
									abreMask(
										'Deseja realmente excluir o laudo <b>$lau_numero/$lau_ano</b>?<br><br>'+
										'<input value=\' Sim \' type=\'button\' onclick=javascript:window.location.href=\'laudos.php?pagina=excluir_laudos&lau_id=$lau_id&lau_login=$lau_login&lau_nome=".str_replace(" ","%20","$lau_nome")."&login=".$login."&n=".str_replace(" ","%20","$n")."\';>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
										'<input value=\' Não \' type=\'button\' class=\'close_janela\'>');
									\">
									<img border='0' src='../imagens/icon-excluir.png'></i>
								</a>
							</div>
							";
							echo "<tr class='$c1'>
									  <td>$lau_numero/$lau_ano</td>
									  <td>$cli_nome</td>
									  <td>$lau_num_geral</td>
									  <td>$exa_nome</td>
									  <td>$lau_data_entrada</td>
									  <td>$lau_data_liberacao</td>
									  <td align=center>";
									  if($lau_status == 0)
									  {
										echo "Em Análise";
									  }
									  else
									  {
										echo "Concluído";
									  }
									  echo "
									  </td>
									  <td align=center><div id='normal-button-$lau_id' class='settings-button'><img src='../imagens/icon-cog-small.png' /></div></td>
								  </tr>";
						}
						echo "</table>";
						
						$variavel = "&pagina=laudos&login=$login&n=$n";
						$limite = 1;
						if (!$consulta)
						{
							$consulta = "SELECT COUNT(*) FROM laudos";
						}
						list($total_linhas) = mysql_fetch_array(mysql_query($consulta,$conexao));
						$total = $total_linhas/$num_por_pagina;
						$prox = $pag + 1;
						$ant = $pag - 1;
						$ultima_pag = ceil($total / $limite);
						$penultima = $ultima_pag - 1;  
						$adjacentes = 3;
						if ($pag>1)
						{
						  $paginacao = ' <a href="'.$PHP_SELF.'?pag='.$ant.''.$variavel.'"><font color=#000000><img src="../imagens/icon-anterior.png" width="16" border="0" ></font></a> ';
						}
						  
						if ($ultima_pag <= 10)
						{
						  for ($i=1; $i< $ultima_pag+1; $i++)
						  {
							if ($i == $pag)
							{
							  $paginacao .= ' <a class="atual" href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'"> ['.$i.'] </a> ';        
							} else
							{
							  $paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'"><font color=#000000> '.$i.' </font></a> ';  
							}
						  }
						}
						if ($ultima_pag > 10)
						{
						  if ($pag < 1 + (2 * $adjacentes))
						  {
							for ($i=1; $i< 2 + (2 * $adjacentes); $i++)
							{
							  if ($i == $pag)
							  {
								$paginacao .= ' <a class="atual" href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'">['.$i.']</a> ';        
							  }
							  else 
							  {
								$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'"><font color=#000000>'.$i.'</font></a> ';  
							  }
							}
							$paginacao .= ' ... ';
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$penultima.''.$variavel.'"><font color=#000000>'.$penultima.'</font></a> ';
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$ultima_pag.''.$variavel.'"><font color=#000000>'.$ultima_pag.'</font></a> ';
						  }
						  
						  elseif($pag > (2 * $adjacentes) && $pag < $ultima_pag - 3)
						  {
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag=1'.$variavel.'"><font color=#000000>1</font></a> ';        
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag=2'.$variavel.'"><font color=#000000>2</font></a> ... ';  
							for ($i = $pag-$adjacentes; $i<= $pag + $adjacentes; $i++)
							{
							  if ($i == $pag)
							  {
								$paginacao .= ' <a class="atual" href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'">['.$i.']</a> ';        
							  }
							  else
							  {
								$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'"><font color=#000000>'.$i.'</font></a> ';  
							  }
							}
							$paginacao .= ' ...';
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$penultima.''.$variavel.'"><font color=#000000>'.$penultima.'</font></a> ';
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$ultima_pag.''.$variavel.'"><font color=#000000>'.$ultima_pag.'</font></a> ';
						  }
						  else 
						  {
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag=1'.$variavel.'"><font color=#000000>1</font></a> ';        
							$paginacao .= ' <a href="'.$PHP_SELF.'?pag=1'.$variavel.'"><font color=#000000>2</font></a> ... ';  
							for ($i = $ultima_pag - (1 + (2 * $adjacentes)); $i <= $ultima_pag; $i++)
							{
							  if ($i == $pag)
							  {
								$paginacao .= ' <a class="atual" href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'">['.$i.']</a> ';        
							  } else {
								$paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'"><font color=#000000>'.$i.'</font></a> ';  
							  }
							}
						  }
						}
						if ($prox <= $ultima_pag && $ultima_pag > 2)
						{
						  $paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$prox.''.$variavel.'"><font color=#000000><img src="../imagens/icon-proxima.png" width="16" border="0"></font></a> ';
						}
				
						echo "<center>$paginacao</center>";
					}
					else
					{
					echo "<br><br><br>Não há nenhum laudo cadastrado.";
					}
					
						echo "
				</div>
				<div class='titulo_adm'>  </div>
				
			</td>
		</tr>
	</table>";
}
//FIM PRINCIPAL	

//INICIO ADICIONAR USUÁRIO
if($pagina == 'adicionar_laudos')
{
	echo "	
	<form name='form_laudos' id='form_laudos' enctype='multipart/form-data' method='post' action='laudos.php?pagina=adicionar_laudos-envia&id=$id&login=$login&n=$n'>
	<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center'>
				<div class='titulo_adm'> $page &raquo; Adicionar  </div>
				<table class='texto' align='center' cellspacing='0' cellpadding='5' width='700'>
					<tr>
						<td align='left'>
							<div class='suggestion'>
							<input name='lau_cliente_id' id='lau_cliente_id'  type='hidden' value='' />
							<input name='lau_cliente' id='lau_cliente' type='text' placeholder='Digite o Nome ou RG do cliente' autocomplete='off' />
								<div class='suggestionsBox' id='suggestions' style='display: none;'>
									<div class='suggestionList' id='autoSuggestionsList'>
										&nbsp;
									</div>
								</div>
							<br>
							<div id='lau_cliente_erro' class='left'>&nbsp;</div>
							</div>
							
							<br>
							<input name='lau_num_geral' id='lau_num_geral' placeholder='Número Geral do Exame'>
							<br><br>
							<input name='lau_dr' id='lau_dr' placeholder='Dr(a)'>
							<br>
							<br>
							<input name='lau_data_entrada' id='lau_data_entrada' placeholder='Data de Entrada' onkeypress='return mascaraData(this,event);'>
							<input name='lau_data_liberacao' id='lau_data_liberacao' placeholder='Data de Liberação' onkeypress='return mascaraData(this,event);'>
							<br>
							<div id='lau_data_entrada_erro' class='left'>&nbsp;</div>
							<div id='lau_data_liberacao_erro' class='left'>&nbsp;</div>
							<br>
							<select name='lau_tipo_laudo' id='lau_tipo_laudo'>
								<option value=''>Selecione o Exame</option>
								"; 
								$sql = " SELECT * FROM exames ORDER BY exa_id ASC";
								$query = mysql_query($sql,$conexao);
								while($row = mysql_fetch_array($query) )
								{
									echo "<option value='".$row['exa_id']."'>".$row['exa_nome']."</option>";
								}
								echo "
							</select>
							<br>
							<div id='lau_tipo_laudo_erro' class='left'>&nbsp;</div>
							<br>
							<textarea name='lau_conteudo'  id='lau_conteudo'  rows='7'>Selecione um tipo de laudo.</textarea>
							<br><br>
							Resultado:<br>
							<textarea name='lau_resultado' id='lau_resultado' placeholder='Resultado' rows='25'></textarea>
							<br>
							<div id='lau_resultado_erro' class='left'>&nbsp;</div>
							<br>
							<textarea name='lau_conteudo2'  id='lau_conteudo2'  rows='25'>Selecione um tipo de laudo.</textarea>
							<br><br>
							<input type='text' name='lau_resultado_final' id='lau_resultado_final' placeholder='Resultado final (ex: 200%, Positivo, Não detectado, Presença de mutação, etc.)' class='normal'>
							<br><br>
							Resultados anteriores:<br>
							<input type='text' name='lau_ra_num1' id='lau_ra_num1' placeholder='N. Exame' class='normal'>
							<input type='text' name='lau_ra_data1' id='lau_ra_data1' placeholder='Data Exame' class='normal' onkeypress='return mascaraData(this,event);'>
							<input type='text' name='lau_ra_res1' id='lau_ra_res1' placeholder='Resultado' class='normal'>
							<br><br>
							<input type='text' name='lau_ra_num2' id='lau_ra_num2' placeholder='N. Exame' class='normal'>
							<input type='text' name='lau_ra_data2' id='lau_ra_data2' placeholder='Data Exame' class='normal' onkeypress='return mascaraData(this,event);'>
							<input type='text' name='lau_ra_res2' id='lau_ra_res2' placeholder='Resultado' class='normal'>
							<br><br>
							<input type='radio' name='lau_status' id='lau_status0' value='0' checked> Em Análise &nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='lau_status' id='lau_status1' value='1'> Concluído
							
						</td>	
					</tr>
					<tr>
						<td height='60' colspan='4' align='center' valign='bottom'>
							<input type='button' id='bt_laudos' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='laudos.php?pagina=laudos&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
						</td>
					</tr>
				</table>
				<div class='titulo_adm'> </div>
			</td>
		</tr>
	</table>
	</form>
	";
}
//FIM ADICIONAR USUÁRIO

//INICIO EDITAR USUÁRIO
if($pagina == 'editar_laudos')
{
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
		$lau_numero = mysql_result($queryedit, 0, 'lau_numero');
		$lau_ano = mysql_result($queryedit, 0, 'lau_ano');
		$lau_cliente = mysql_result($queryedit, 0, 'lau_cliente');
		$cli_nome = mysql_result($queryedit, 0, 'cli_nome');
		$cli_id = mysql_result($queryedit, 0, 'cli_nome');
		$cli_data_nasc = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'cli_data_nasc'))));
		$lau_tipo_laudo = mysql_result($queryedit, 0, 'lau_tipo_laudo');
		$exa_nome = mysql_result($queryedit, 0, 'exa_nome');
		$lau_num_geral = mysql_result($queryedit, 0, 'lau_num_geral');
		$lau_dr = mysql_result($queryedit, 0, 'lau_dr');
		$lau_data_entrada = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_data_entrada'))));
		$lau_data_liberacao = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_data_liberacao'))));
		$lau_conteudo = mysql_result($queryedit, 0, 'lau_conteudo');
		$lau_conteudo2 = mysql_result($queryedit, 0, 'lau_conteudo2');
		$lau_resultado = mysql_result($queryedit, 0, 'lau_resultado');
		$lau_resultado_final = mysql_result($queryedit, 0, 'lau_resultado_final');
		$lau_status = mysql_result($queryedit, 0, 'lau_status');
		$lau_ra_num1 = mysql_result($queryedit, 0, 'lau_ra_num1');
		$lau_ra_data1 = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_ra_data1'))));
		$lau_ra_res1 = mysql_result($queryedit, 0, 'lau_ra_res1');
		$lau_ra_num2 = mysql_result($queryedit, 0, 'lau_ra_num2');
		$lau_ra_data2 = implode("/",array_reverse(explode("-",mysql_result($queryedit, 0, 'lau_ra_data2'))));
		$lau_ra_res2 = mysql_result($queryedit, 0, 'lau_ra_res2');
		
		/*if($lau_status == 1)
		{
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/x.gif> Este laudo não pode ser editado pois já foi concluído.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
			</SCRIPT>
				"; 
		}
		else
		{*/
			echo "
			<form name='form_laudos' id='form_laudos' enctype='multipart/form-data' method='post' action='laudos.php?pagina=editar_laudos-envia&lau_id=$lau_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='left'>
						<div class='titulo_adm'> $page &raquo; Editar: $lau_numero/$lau_ano </div>
						<table align='center' cellspacing='0' cellpadding='5' width='700'>
							<tr>
								<td align='left'>
									<div class='suggestion'>
									<input name='lau_cliente_id' id='lau_cliente_id' type='hidden' value='$lau_cliente' />
									<input name='lau_cliente' id='lau_cliente' type='text' value='$cli_nome ($cli_data_nasc)' placeholder='Digite o Nome ou RG do cliente' autocomplete='off' />
										<div class='suggestionsBox' id='suggestions' style='display: none;'>
											<div class='suggestionList' id='autoSuggestionsList'>
												&nbsp;
											</div>
										</div>
									<br>
									<div id='lau_cliente_erro' class='left'>&nbsp;</div>
									</div>
									<br>
									<input name='lau_num_geral' id='lau_num_geral' value='$lau_num_geral' placeholder='Número Geral do Exame'>
									<br><br>
									<input name='lau_dr' id='lau_dr' value=\"".$lau_dr."\" placeholder='Dr(a)'>
									<br><br>
									<input name='lau_data_entrada' id='lau_data_entrada' value='$lau_data_entrada' placeholder='Data de Entrada' onkeypress='return mascaraData(this,event);'>
									<input name='lau_data_liberacao' id='lau_data_liberacao' value='$lau_data_liberacao' placeholder='Data de Liberação' onkeypress='return mascaraData(this,event);'>
									<br>
									<div id='lau_data_entrada_erro' class='left'>&nbsp;</div>
									<div id='lau_data_liberacao_erro' class='left'>&nbsp;</div>
									<br>
									<select name='lau_tipo_laudo' id='lau_tipo_laudo'>
										<option value='$lau_tipo_laudo'>$exa_nome</option>
										"; 
										$sql = " SELECT * FROM exames ORDER BY exa_id ASC";
										$query = mysql_query($sql,$conexao);
										while($row = mysql_fetch_array($query) )
										{
											echo "<option value='".$row['exa_id']."'>".$row['exa_nome']."</option>";
										}
										echo "
									</select>
									<br>
									<div id='lau_tipo_laudo_erro' class='left'>&nbsp;</div>
									<br>
									<textarea name='lau_conteudo' id='lau_conteudo' rows='5'>$lau_conteudo</textarea>
									<br><br>
									Resultado:<br>
									<textarea name='lau_resultado' id='lau_resultado' placeholder='Resultado' rows='25'>$lau_resultado</textarea>
									<br>
									<div id='lau_resultado_erro' class='left'>&nbsp;</div>
									<br>
									<textarea name='lau_conteudo2' id='lau_conteudo2' rows='25'>$lau_conteudo2</textarea>
									<br><br>
									<input type='text' name='lau_resultado_final' id='lau_resultado_final' value='$lau_resultado_final' placeholder='Resultado final (ex: 200%, Positivo, Não detectado, Presença de mutação, etc.)' class='normal'>
									<br><br>
									Resultados anteriores:<br>
									<input type='text' name='lau_ra_num1' id='lau_ra_num1' value='$lau_ra_num1' placeholder='N. Exame' class='normal'>
									<input type='text' name='lau_ra_data1' id='lau_ra_data1' value='$lau_ra_data1' placeholder='Data Exame' class='normal' onkeypress='return mascaraData(this,event);'>
									<input type='text' name='lau_ra_res1' id='lau_ra_res1' value='$lau_ra_res1' placeholder='Resultado' class='normal'>
									<br><br>
									<input type='text' name='lau_ra_num2' id='lau_ra_num2' value='$lau_ra_num2' placeholder='N. Exame' class='normal'>
									<input type='text' name='lau_ra_data2' id='lau_ra_data2' value='$lau_ra_data2' placeholder='Data Exame' class='normal' onkeypress='return mascaraData(this,event);'>
									<input type='text' name='lau_ra_res2' id='lau_ra_res2' value='$lau_ra_res2' placeholder='Resultado' class='normal'>
									<br><br>
									";
									if($lau_status == 0)
									{
										echo "<input type='radio' name='lau_status' id='lau_status0' value='0' checked> Em Análise &nbsp;&nbsp;&nbsp; 
											  <input type='radio' name='lau_status' id='lau_status1' value='1'> Concluído
											 ";
									}
									else
									{
										echo "<input type='radio' name='lau_status' id='lau_status0' value='0'> Em Análise &nbsp;&nbsp;&nbsp; 
											  <input type='radio' name='lau_status' id='lau_status1' value='1' checked> Concluído
											 ";
									}
									echo "
								</td>	
							</tr>
							<tr>
								<td height='60' colspan='4' align='center' valign='bottom'>
									<input type='button' id='bt_laudos' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='laudos.php?pagina=laudos&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
								</td>
							</tr>
						</table>
						<div class='titulo_adm'>   </div>
					</td>
				</tr>
			</table>
			</form>
			";
		//}
	}
}	
// FIM EDITAR USUÁRIO

//INICIO EXIBIR LAUDO
if($pagina == 'exibir_laudos')
{
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
		$lau_numero = mysql_result($queryedit, 0, 'lau_numero');
		$lau_ano = mysql_result($queryedit, 0, 'lau_ano');
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
		
			echo "
			<form name='form_laudos' id='form_laudos' enctype='multipart/form-data' method='post' action='laudos.php?pagina=editar_laudos-envia&lau_id=$lau_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='center'>
						<div class='titulo_adm'> $page &raquo; Exibir: $lau_numero/$lau_ano  </div>
						<div class='laudo'>
						<table align='center' cellspacing='0' cellpadding='5' width='90%'>
							<tr>
								<td align='justify'>
									<b>Nome Cliente:</b> $cli_nome</option>
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
								<td align='justify'>
									<b>Telefone:</b> $cli_telefone</option>
								</td>
								<td align='justify'>
									<b>Email:</b> $cli_email</option>
								</td>
							</tr>
							<tr>
								<td>
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
								<td align='justify' colspan='3'>
									<p class='titulo_laudo'>$exa_nome</p>
									<br>
									$lau_conteudo
								</td>
							</tr>
							<tr>
								<td align='justify' colspan='3'>
									<br><b>Resultado: </b><br>
									$lau_resultado
								</td>
							</tr>
							<tr>
								<td align='justify' colspan='3'>
									<br> $lau_resultado_final <br>
									
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
									<table width='100%' id='resultados_anteriores' cellspacing='0' cellpadding='5'>
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
							<tr>
								<td height='60' colspan='4' align='center' valign='bottom'>
									<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='laudos.php?pagina=laudos&login=$login&n=".str_replace(" ","%20","$n")."'; value='Voltar'/></center>
								</td>
							</tr>
						</table>
						</div>
						<div class='titulo_adm'>   </div>
					</td>
				</tr>
			</table>
			</form>
			";
	}
}	
// FIM EXIBIR LAUDO

//INICIO ENVIA DADOS ADICIONAR
if($pagina == "adicionar_laudos-envia")
{
	$lau_ano = date("y");
	$lau_cliente_id = $_POST['lau_cliente_id'];
	$lau_tipo_laudo = $_POST['lau_tipo_laudo'];
	$lau_num_geral = $_POST['lau_num_geral'];
	$lau_dr = addslashes($_POST['lau_dr']);
	$lau_data_entrada = "'".implode("-",array_reverse(explode("/",$_POST['lau_data_entrada'])))."'";if($lau_data_entrada == "''"){$lau_data_entrada = 'null';}
	$lau_data_liberacao = "'".implode("-",array_reverse(explode("/",$_POST['lau_data_liberacao'])))."'"; if($lau_data_liberacao == "''"){$lau_data_liberacao = 'null';} 
	$lau_conteudo = $_POST['lau_conteudo'];
	$lau_conteudo2 = $_POST['lau_conteudo2'];
	$lau_resultado = $_POST['lau_resultado'];
	$lau_resultado_final = $_POST['lau_resultado_final'];
	$lau_status = $_POST['lau_status'];
	$lau_ra_num1 = $_POST['lau_ra_num1'];
	$lau_ra_data1 = "'".implode("-",array_reverse(explode("/",$_POST['lau_ra_data1'])))."'";if($lau_ra_data1 == "''"){$lau_ra_data1 = 'null';}
	$lau_ra_res1 = $_POST['lau_ra_res1'];
	$lau_ra_num2 = $_POST['lau_ra_num2'];
	$lau_ra_data2 = "'".implode("-",array_reverse(explode("/",$_POST['lau_ra_data2'])))."'";if($lau_ra_data2 == "''"){$lau_ra_data2 = 'null';}
	$lau_ra_res2 = $_POST['lau_ra_res2'];
	
		$sql = "INSERT INTO laudos (
		lau_cliente,
		lau_tipo_laudo,
		lau_num_geral,
		lau_dr,
		lau_data_entrada,
		lau_data_liberacao,
		lau_conteudo,
		lau_conteudo2,
		lau_resultado,
		lau_resultado_final,
		lau_status,
		lau_ra_num1,
		lau_ra_data1,
		lau_ra_res1,
		lau_ra_num2,
		lau_ra_data2,
		lau_ra_res2
		) 
		VALUES 
		(
		'$lau_cliente_id',
		'$lau_tipo_laudo',
		'$lau_num_geral',
		'$lau_dr',
		$lau_data_entrada,
		$lau_data_liberacao,
		'$lau_conteudo',
		'$lau_conteudo2',
		'$lau_resultado',
		'$lau_resultado_final',
		'$lau_status',
		'$lau_ra_num1',
		$lau_ra_data1,
		'$lau_ra_res1',
		'$lau_ra_num2',
		$lau_ra_data2,
		'$lau_ra_res2'
		)";
		if(mysql_query($sql,$conexao))
		{
			$ultimo_id = mysql_insert_id();
			$sql_numero = "SELECT MAX(lau_numero) as numero, lau_ano FROM laudos WHERE lau_ano = '$lau_ano'";
			$query_numero = mysql_query($sql_numero,$conexao);
			$rows_numero = mysql_num_rows($query_numero);
			if($rows_numero > 0)
			{
				$ultimo_numero = mysql_result($query_numero,0,'numero');
				$proximo_numero = $ultimo_numero+1;
				
				$sql_update = "UPDATE laudos SET
							   lau_numero = '$proximo_numero',
							   lau_ano = '$lau_ano'
							   WHERE lau_id = $ultimo_id ";
				if(mysql_query($sql_update))
				{
				}
			}
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/ok.gif> Cadastrado efetuado com sucesso.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'laudos.php?pagina=laudos&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
			</SCRIPT>
				";
		}
		else
		{
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/x.gif> Por favor preencha todos os campos.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
			</SCRIPT>
				"; 
		}	
}

//FIM ENVIA DADOS ADICIONAR

//INICIO ENVIA DADOS EDITAR	
if($pagina == 'editar_laudos-envia')
{
	$lau_id = $_GET['lau_id'];
	$lau_cliente_id = $_POST['lau_cliente_id'];
	$lau_tipo_laudo = $_POST['lau_tipo_laudo'];
	$lau_num_geral = $_POST['lau_num_geral'];
	$lau_dr = addslashes($_POST['lau_dr']);
	$lau_data_entrada = "'".implode("-",array_reverse(explode("/",$_POST['lau_data_entrada'])))."'";if($lau_data_entrada == "''"){$lau_data_entrada = 'null';}
	$lau_data_liberacao = "'".implode("-",array_reverse(explode("/",$_POST['lau_data_liberacao'])))."'"; if($lau_data_liberacao == "''"){$lau_data_liberacao = 'null';} 
	$lau_conteudo = $_POST['lau_conteudo'];
	$lau_conteudo2 = $_POST['lau_conteudo2'];
	$lau_resultado = $_POST['lau_resultado'];
	$lau_resultado_final = $_POST['lau_resultado_final'];
	$lau_status = $_POST['lau_status'];
	$lau_ra_num1 = $_POST['lau_ra_num1'];
	$lau_ra_data1 = "'".implode("-",array_reverse(explode("/",$_POST['lau_ra_data1'])))."'";if($lau_ra_data1 == "''"){$lau_ra_data1 = 'null';}
	$lau_ra_res1 = $_POST['lau_ra_res1'];
	$lau_ra_num2 = $_POST['lau_ra_num2'];
	$lau_ra_data2 = "'".implode("-",array_reverse(explode("/",$_POST['lau_ra_data2'])))."'";if($lau_ra_data2 == "''"){$lau_ra_data2 = 'null';}
	$lau_ra_res2 = $_POST['lau_ra_res2'];
	
	$sqlEnviaEdit = "UPDATE laudos SET 
					 lau_cliente = '$lau_cliente_id', 
					 lau_tipo_laudo = '$lau_tipo_laudo', 
					 lau_num_geral = '$lau_num_geral', 
					 lau_dr = '$lau_dr', 
					 lau_data_entrada = $lau_data_entrada, 
					 lau_data_liberacao = $lau_data_liberacao, 
					 lau_conteudo = '$lau_conteudo', 
					 lau_conteudo2 = '$lau_conteudo2', 
					 lau_resultado = '$lau_resultado', 
					 lau_resultado_final = '$lau_resultado_final', 
					 lau_status = '$lau_status',
					 lau_ra_num1 = '$lau_ra_num1',
					 lau_ra_data1 = $lau_ra_data1,
					 lau_ra_res1 = '$lau_ra_res1',
					 lau_ra_num2 = '$lau_ra_num2',
					 lau_ra_data2 = $lau_ra_data2,
					 lau_ra_res2 = '$lau_ra_res2'
					 WHERE lau_id = $lau_id ";
	if(mysql_query ($sqlEnviaEdit,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Dados alterados com sucesso.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'laudos.php?pagina=laudos&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
		</SCRIPT>
			";
	}
	else
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> Por favor preencha todos os campos.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
		</SCRIPT>
		";
	}
	
}
//FIM ENVIA DADOS EDITAR

if($pagina == 'excluir_laudos')
{
	$lau_id = $_GET['lau_id'];
	$lau_login = $_GET['lau_login'];
	$lau_nome = $_GET['lau_nome'];
	$excluir_laudos = $_GET['excluir_laudos'];
	$sql = "DELETE FROM laudos WHERE lau_id = '$lau_id'";
				
	if(mysql_query($sql,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Exclusão realizada com sucesso<br><br>'+
			'<input value=\' OK \' type=\'button\'  onclick=javascript:window.location.href=\'laudos.php?pagina=laudos&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
		</SCRIPT>
			";
	}
	else
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> A exclusão não foi realizada devido a um erro desconhecido.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back(); >');
		</SCRIPT>
		";
	}
}


?>
<?php
include('../mod_rodape_admin/rodape.php'); 
?>
