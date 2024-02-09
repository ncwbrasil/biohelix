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
<?php	
//TOPO
include('../mod_includes/php/funcoes-jquery.php');
include('../mod_includes/php/verificalogin.php');
include("../mod_topo_admin/topo.php");
//FIM TOPO

$pagina = $_GET['pagina'];
$page = "<a href='exames.php?pagina=exames&login=$login&n=$n'>Exames</a>";
$num_por_pagina = 20;
$pag = $_GET['pag'];
if(!$pag){$primeiro_registro = 0; $pag = 1;}
else{$primeiro_registro = ($pag - 1) * $num_por_pagina;}
$sql = "SELECT * FROM exames LIMIT $primeiro_registro, $num_por_pagina";
$consulta = "SELECT COUNT(*) FROM exames";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
if($pagina == "exames")
{
	echo "
	<table class='texto' align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left'>
				<div class='titulo_adm'> $page  </div>
				<div id='interna'>
				<div id='icone'><input name='add-adm' value='Novo Exame' type='button' onclick=javascript:window.location.href='exames.php?pagina=adicionar_exames&login=$login&n=".str_replace(' ','%20',"$n")."'; /></div>
				";
				if ($rows > 0)
				{
				echo "
				<table align='center' width='100%' border='0' cellspacing='0' cellpadding='10' class='bordatabela'>
					<tr>
						<td class='titulo_first'>ID</td>
						<td class='titulo_tabela'>Nome</td>
						<td class='titulo_last' align='center'>Gerenciar</td>
					</tr>";
						$c=0;
						for($x = 0; $x < $rows ; $x++)
						{
							$exa_id = mysql_result($query, $x, 'exa_id');
							$exa_nome = mysql_result($query, $x, 'exa_nome');
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
							
									$('#normal-button-$exa_id').toolbar({content: '#user-options-$exa_id', position: 'top', hideOnClick: true});
									$('#normal-button-bottom').toolbar({content: '#user-options', position: 'bottom'});
									$('#normal-button-small').toolbar({content: '#user-options-small', position: 'top', hideOnClick: true});
									$('#button-left').toolbar({content: '#user-options', position: 'left'});
									$('#button-right').toolbar({content: '#user-options', position: 'right'});
									$('#link-toolbar').toolbar({content: '#user-options', position: 'top' });
								});
							</script>
							<div id='user-options-$exa_id' class='toolbar-icons' style='display: none;'>
								<a href='exames.php?pagina=exibir_exames&exa_id=$exa_id&exa_login=$exa_login&login=$login&n=$n'><img border='0' src='../imagens/icon-exibir.png'></a>
								<a href='exames.php?pagina=editar_exames&exa_id=$exa_id&exa_login=$exa_login&login=$login&n=$n'><img border='0' src='../imagens/icon-editar.png'></a>
								<a onclick=\"
									abreMask(
										'Deseja realmente excluir o tipo de laudo <b>$exa_nome</b>?<br><br>'+
										'<input value=\' Sim \' type=\'button\' onclick=javascript:window.location.href=\'exames.php?pagina=excluir_exames&exa_id=$exa_id&exa_login=$exa_login&exa_nome=".str_replace(" ","%20","$exa_nome")."&login=".$login."&n=".str_replace(" ","%20","$n")."\';>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
										'<input value=\' Não \' type=\'button\' class=\'close_janela\'>');
									\">
									<img border='0' src='../imagens/icon-excluir.png'></i>
								</a>
							</div>
							";
							echo "<tr class='$c1'>
									  <td>";print str_pad($exa_id,2,"0",STR_PAD_LEFT);echo "</td>
									  <td>$exa_nome</td>
									  <td align=center><div id='normal-button-$exa_id' class='settings-button'><img src='../imagens/icon-cog-small.png' /></div></td>
								  </tr>";
						}
						echo "</table>";
						
						$variavel = "&pagina=exames&login=$login&n=$n";
						$limite = 1;
						if (!$consulta)
						{
							$consulta = "SELECT COUNT(*) FROM exames";
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
					echo "<br><br><br>Não há nenhum exame cadastrado.";
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
if($pagina == 'adicionar_exames')
{
	echo "	
	<form name='form_exames' id='form_exames' enctype='multipart/form-data' method='post' action='exames.php?pagina=adicionar_exames-envia&id=$id&login=$login&n=$n'>
	<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center'>
				<div class='titulo_adm'> $page &raquo; Adicionar  </div>
				<table class='texto' align='center' cellspacing='0' cellpadding='5' width='700'>
					<tr>
						<td align='left'>
							<input type='text' name='exa_nome'  id='exa_nome' placeholder='Nome'>
							<br>
							<div id='exa_nome_erro' class='left'>&nbsp;</div>
							<br>
							<textarea name='exa_conteudo'  id='exa_conteudo' placeholder='Conteudo' rows='7'></textarea>
							<br><br>
							Resultado:<br>
							<textarea name='exa_resultado' id='exa_resultado' placeholder='Resultado' rows='25' ></textarea>
							<br><br>
							<textarea name='exa_conteudo2'  id='exa_conteudo2' placeholder='Conteudo 2' rows='25'></textarea>
						</td>	
					</tr>
					<tr>
						<td height='60' colspan='4' align='center' valign='bottom'>
							<input type='button' id='bt_exames' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='exames.php?pagina=exames&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
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
if($pagina == 'editar_exames')
{
	$exa_id = $_GET['exa_id'];
	$sqledit = "SELECT * FROM exames WHERE exa_id = '$exa_id'";
	$queryedit = mysql_query($sqledit,$conexao);
	$rowsedit = mysql_num_rows($queryedit);

	if($rowsedit > 0)
	{
		$exa_id = mysql_result($queryedit, 0, 'exa_id');
		$exa_nome = mysql_result($queryedit, 0, 'exa_nome');
		$exa_conteudo = mysql_result($queryedit, 0, 'exa_conteudo');
		$exa_conteudo2 = mysql_result($queryedit, 0, 'exa_conteudo2');
		$exa_resultado = mysql_result($queryedit, 0, 'exa_resultado');
		
			echo "
			<form name='form_exames' id='form_exames' enctype='multipart/form-data' method='post' action='exames.php?pagina=editar_exames-envia&exa_id=$exa_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='left'>
						<div class='titulo_adm'> $page &raquo; Editar: $exa_nome </div>
						<table align='center' cellspacing='0' cellpadding='5' width='700'>
							<tr>
								<td align='left'>
									<input type='text' name='exa_nome' id='exa_nome' value='$exa_nome' placeholder='Nome'>
									<br>
									<div id='exa_nome_erro' class='left'>&nbsp;</div>
									<br>
									<textarea name='exa_conteudo' id='exa_conteudo' placeholder='Conteudo' rows='7'>$exa_conteudo</textarea>
									<br><br>
									Resultado:<br>
									<textarea name='exa_resultado' id='exa_resultado' placeholder='Resultado' rows='25'>$exa_resultado</textarea>
									<br><br>
									<textarea name='exa_conteudo2' id='exa_conteudo2' placeholder='Conteudo 2' rows='25'>$exa_conteudo2</textarea>
								</td>	
							</tr>
							<tr>
								<td height='60' colspan='4' align='center' valign='bottom'>
									<input type='button' id='bt_exames' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='exames.php?pagina=exames&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
								</td>
							</tr>
						</table>
						<div class='titulo_adm'>   </div>
					</td>
				</tr>
			</table>
			</form>
			";
	}
}	
// FIM EDITAR USUÁRIO

//INICIO EXIBIR LAUDO
if($pagina == 'exibir_exames')
{
	$exa_id = $_GET['exa_id'];
	$sqledit = "SELECT * FROM exames WHERE exa_id = '$exa_id'";
	$queryedit = mysql_query($sqledit,$conexao);
	$rowsedit = mysql_num_rows($queryedit);

	if($rowsedit > 0)
	{
		$exa_id = mysql_result($queryedit, 0, 'exa_id');
		$exa_nome = mysql_result($queryedit, 0, 'exa_nome');
		$exa_conteudo = mysql_result($queryedit, 0, 'exa_conteudo');
		$exa_conteudo2 = mysql_result($queryedit, 0, 'exa_conteudo2');
		$exa_resultado = mysql_result($queryedit, 0, 'exa_resultado');
		
			echo "
			<form name='form_exames' id='form_exames' enctype='multipart/form-data' method='post' action='exames.php?pagina=editar_exames-envia&exa_id=$exa_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='center'>
						<div class='titulo_adm'> $page &raquo; Exibir: $exa_nome  </div>
						<div class='laudo'>
						<table align='center' cellspacing='0' cellpadding='5' width='90%'>
							<tr>
								<td align='justify'>
									<p class='titulo_laudo'>$exa_nome</p><br>
									$exa_conteudo
									<br><br>
									$exa_resultado
									<br><br>
									$exa_conteudo2
								</td>	
							</tr>
							<tr>
								<td height='60' colspan='4' align='center' valign='bottom'>
									<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='exames.php?pagina=exames&login=$login&n=".str_replace(" ","%20","$n")."'; value='Voltar'/></center>
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
if($pagina == "adicionar_exames-envia")
{
	$exa_nome = $_POST['exa_nome'];
	$exa_conteudo = $_POST['exa_conteudo'];
	$exa_conteudo2 = $_POST['exa_conteudo2'];
	$exa_resultado = $_POST['exa_resultado'];
	$sql = "SELECT * FROM exames WHERE exa_login = '$exa_login'";
	$query = mysql_query($sql,$conexao);
	$rows = mysql_num_rows($query);
	if ($rows > 0)
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> O login <b>$exa_login</b> já existe. Por favor escolha outro login.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
		</SCRIPT>
			 ";
	}
	else
	{
		$sql = "INSERT INTO exames (
		exa_nome,
		exa_conteudo,
		exa_conteudo2,
		exa_resultado
		) 
		VALUES 
		(
		'$exa_nome',
		'$exa_conteudo',
		'$exa_conteudo2',
		'$exa_resultado'
		)";
		if(mysql_query($sql,$conexao))
		{
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/ok.gif> Cadastrado efetuado com sucesso.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'exames.php?pagina=exames&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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
}
//FIM ENVIA DADOS ADICIONAR

//INICIO ENVIA DADOS EDITAR	
if($pagina == 'editar_exames-envia')
{
	$exa_id = $_GET['exa_id'];
	$exa_nome = $_POST['exa_nome'];
	$exa_conteudo = $_POST['exa_conteudo'];
	$exa_conteudo2 = $_POST['exa_conteudo2'];
	$exa_resultado = $_POST['exa_resultado'];
	
	$sqlEnviaEdit = "UPDATE exames SET 
					 exa_nome = '$exa_nome', 
					 exa_conteudo = '$exa_conteudo', 
					 exa_conteudo2 = '$exa_conteudo2', 
					 exa_resultado = '$exa_resultado'  
					 WHERE exa_id = $exa_id ";

	if(mysql_query ($sqlEnviaEdit,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Dados alterados com sucesso.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'exames.php?pagina=exames&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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

if($pagina == 'excluir_exames')
{
	$exa_id = $_GET['exa_id'];
	$exa_login = $_GET['exa_login'];
	$exa_nome = $_GET['exa_nome'];
	$excluir_exames = $_GET['excluir_exames'];
	$sql = "DELETE FROM exames WHERE exa_id = '$exa_id'";
				
	if(mysql_query($sql,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Exclusão realizada com sucesso<br><br>'+
			'<input value=\' OK \' type=\'button\'  onclick=javascript:window.location.href=\'exames.php?pagina=exames&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
		</SCRIPT>
			";
	}
	else
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> Não foi possível excluir este exame pois ele já esta relacionado com um laudo de algum cliente.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back(); >');
		</SCRIPT>
		";
	}
}

?>
<?php
include('../mod_rodape_admin/rodape.php'); 
?>
