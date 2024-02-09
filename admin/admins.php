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
</head>
<?php	
//TOPO
include('../mod_includes/php/funcoes-jquery.php');
include('../mod_includes/php/verificalogin.php');
include("../mod_topo_admin/topo.php");
//FIM TOPO

$pagina = $_GET['pagina'];
$page = "<a href='admins.php?pagina=admins&login=$login&n=$n'>Admins</a>";
$num_por_pagina = 20;
$pag = $_GET['pag'];
if(!$pag){$primeiro_registro = 0; $pag = 1;}
else{$primeiro_registro = ($pag - 1) * $num_por_pagina;}
$sql = "SELECT * FROM admins LIMIT $primeiro_registro, $num_por_pagina";
$consulta = "SELECT COUNT(*) FROM admins";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
if($pagina == "admins")
{
	echo "
	<table class='texto' align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left'>
				<div class='titulo_adm'> $page  </div>
				<div id='interna'>
				<div id='icone'><input name='add-adm' value='Novo Admin' type='button' onclick=javascript:window.location.href='admins.php?pagina=adicionar_admins&login=$login&n=".str_replace(' ','%20',"$n")."'; /></div>
				";
				if ($rows > 0)
				{
				echo "
				<table align='center' width='100%' border='0' cellspacing='0' cellpadding='10' class='bordatabela'>
					<tr>
						<td class='titulo_first'>ID</td>
						<td class='titulo_tabela'>Nome</td>
						<td class='titulo_tabela'>Login</td>
						<td class='titulo_tabela' align='center'>Status</td>
						<td class='titulo_last' align='center'>Gerenciar</td>
					</tr>";
						$c=0;
						for($x = 0; $x < $rows ; $x++)
						{
							$adm_id = mysql_result($query, $x, 'adm_id');
							$adm_nome = mysql_result($query, $x, 'adm_nome');
							$adm_login = mysql_result($query, $x, 'adm_login');
							$adm_senha = mysql_result($query, $x, 'adm_senha');
							$adm_status = mysql_result($query, $x, 'adm_status');
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
							
									$('#normal-button-$adm_id').toolbar({content: '#user-options-$adm_id', position: 'top', hideOnClick: true});
									$('#normal-button-bottom').toolbar({content: '#user-options', position: 'bottom'});
									$('#normal-button-small').toolbar({content: '#user-options-small', position: 'top', hideOnClick: true});
									$('#button-left').toolbar({content: '#user-options', position: 'left'});
									$('#button-right').toolbar({content: '#user-options', position: 'right'});
									$('#link-toolbar').toolbar({content: '#user-options', position: 'top' });
								});
							</script>
							<div id='user-options-$adm_id' class='toolbar-icons' style='display: none;'>
								";
								if($adm_status == 1)
								{
									echo "<a href='admins.php?pagina=desativar_user&adm_id=$adm_id&adm_login=$adm_login&login=$login&n=$n'><img border='0' src='../imagens/icon-ativa-desativa.png'></a>";
								}
								else
								{
									echo "<a href='admins.php?pagina=ativar_user&adm_id=$adm_id&adm_login=$adm_login&login=$login&n=$n'><img border='0' src='../imagens/icon-ativa-desativa.png'></a>";
								}
								echo "
								<a href='admins.php?pagina=editar_admins&adm_id=$adm_id&adm_login=$adm_login&login=$login&n=$n'><img border='0' src='../imagens/icon-editar.png'></a>
								<a onclick=\"
									abreMask(
										'Deseja realmente excluir o administrador <b>$adm_nome</b>?<br><br>'+
										'<input value=\' Sim \' type=\'button\' onclick=javascript:window.location.href=\'admins.php?pagina=excluir_admins&adm_id=$adm_id&adm_login=$adm_login&adm_nome=".str_replace(" ","%20","$adm_nome")."&login=".$login."&n=".str_replace(" ","%20","$n")."\';>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
										'<input value=\' Não \' type=\'button\' class=\'close_janela\'>');
									\">
									<img border='0' src='../imagens/icon-excluir.png'></i>
								</a>
							</div>
							";
							echo "<tr class='$c1'>
									  <td>";print str_pad($adm_id,2,"0",STR_PAD_LEFT);echo "</td>
									  <td>$adm_nome</td>
									  <td>$adm_login</td>
									  <td align=center>";
									  if($adm_status == 1)
									  {
										echo "<img border='0' src='../imagens/icon-ativo.png' width='15' height='15'>";
									  }
									  else
									  {
										echo "<img border='0' src='../imagens/icon-inativo.png' width='15' height='15'>";
									  }
									  echo "
									  </td>
									  <td align=center><div id='normal-button-$adm_id' class='settings-button'><img src='../imagens/icon-cog-small.png' /></div></td>
								  </tr>";
						}
						echo "</table>";
						
						$variavel = "&pagina=admins&login=$login&n=$n";
						$limite = 1;
						if (!$consulta)
						{
							$consulta = "SELECT COUNT(*) FROM admins";
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
						  $paginacao = ' <a href="'.$PHP_SELF.'?pag='.$ant.''.$variavel.'"><font color=#000000><img src="../imagens/anterior.png" width="16" border="0" ></font></a> ';
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
						  $paginacao .= ' <a href="'.$PHP_SELF.'?pag='.$prox.''.$variavel.'"><font color=#000000><img src="../imagens/proxima.png" width="16" border="0"></font></a> ';
						}
				
						echo "<center>$paginacao</center>";
					}
					else
					{
					echo "<br><br><br>Não há nenhum administrador cadastrado.";
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
if($pagina == 'adicionar_admins')
{
	echo "	
	<form name='form_admins' id='form_admins' enctype='multipart/form-data' method='post' action='admins.php?pagina=adicionar_admins-envia&id=$id&login=$login&n=$n'>
	<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center'>
				<div class='titulo_adm'> $page &raquo; Adicionar  </div>
				<table class='texto' align='center' cellspacing='0'>
					<tr>
						<td align='center'>
							<input type='text' name='adm_nome'  id='adm_nome' placeholder='Nome'>
							<br>
							<div id='adm_nome_erro' class='left'>&nbsp;</div>
						</td>
					</tr>
					<tr>
						<td align='center'>
							<input type='text' name='adm_login' id='adm_login' placeholder='Login'>
							<br>
							<div id='adm_login_erro' class='left'>&nbsp;</div>
						</td>
					</tr>
					<tr>
						<td align='center'>
							<input type='password' name='adm_senha' id='adm_senha' placeholder='Senha'>
							<br>
							<div id='adm_senha_erro' class='left'>&nbsp;</div>
						</td>
					</tr>
					<tr>
						<td align='left' valign='middle'>
							<input type='radio' name='adm_status' value='1' checked> Ativo <br>
							<input type='radio' name='adm_status' value='0'> Inativo<br>
						</td>	
					</tr>
					<tr>
						<td height='60' colspan='4' align='center' valign='bottom'>
							<input type='button' id='bt_admins' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp; 
							<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='admins.php?pagina=admins&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
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
if($pagina == 'editar_admins')
{
	$adm_id = $_GET['adm_id'];
	$sqledit = "SELECT * FROM admins WHERE adm_id = '$adm_id'";
	$queryedit = mysql_query($sqledit,$conexao);
	$rowsedit = mysql_num_rows($queryedit);

	if($rowsedit > 0)
	{
		$adm_id = mysql_result($queryedit, 0, 'adm_id');
		$adm_nome = mysql_result($queryedit, 0, 'adm_nome');
		$adm_login = mysql_result($queryedit, 0, 'adm_login');
		$adm_senha = mysql_result($queryedit, 0, 'adm_senha');
		$adm_status = mysql_result($queryedit, 0, 'adm_status');
		if($adm_login == "administrador")
		{		
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/x.gif> O administrador <b>$adm_nome</b> não pode ser alterado.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
			</SCRIPT>
		";
		}
		else
		{	
			echo "
			<form name='form_admins' id='form_admins' enctype='multipart/form-data' method='post' action='admins.php?pagina=editar_admins-envia&adm_id=$adm_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='center'>
						<div class='titulo_adm'> $page &raquo; Editar: $adm_nome ($adm_id)  </div>
						<table align='center' cellspacing='8'>
							<tr>
								<td align='center'>
									<input type='text' name='adm_nome' id='adm_nome' value='$adm_nome' placeholder='Nome'>
									<br>
									<div id='adm_nome_erro' class='left'>&nbsp;</div>
								</td>
							</tr>
							<tr>
								<td align='center'>
									<input type='text' name='adm_login' id='adm_login' value='$adm_login' placeholder='Login'>
									<br>
									<div id='adm_login_erro' class='left'>&nbsp;</div>
								</td>
							</tr>
							<tr>
								<td align='center'>
									<input type='password' name='adm_senha' id='adm_senha' value='$adm_senha' placeholder='Senha'>
									<br>
									<div id='adm_senha_erro' class='left'>&nbsp;</div>
								</td>
							</tr>
							<tr>
								<td align='left'>";
								if($adm_status == 1)
								{
									echo "<input type='radio' name='adm_status' value='1' checked> Ativo <br>
										  <input type='radio' name='adm_status' value='0'> Inativo
										 ";
								}
								else
								{
									echo "<input type='radio' name='adm_status' value='1'> Ativo <br>
										  <input type='radio' name='adm_status' value='0' checked> Inativo
										 ";
								}
								echo "
								</td>	
							</tr>
							<tr>
								<td height='60' colspan='4' align='center' valign='bottom'>
									<input type='button' id='bt_admins' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='admins.php?pagina=admins&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
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
}	
// FIM EDITAR USUÁRIO

//INICIO ENVIA DADOS ADICIONAR
if($pagina == "adicionar_admins-envia")
{
	$adm_nome = $_POST['adm_nome'];
	$adm_login = $_POST['adm_login'];
	$adm_senha = md5($_POST['adm_senha']);
	$adm_status = $_POST['adm_status'];
	$sql = "SELECT * FROM admins WHERE adm_login = '$adm_login'";
	$query = mysql_query($sql,$conexao);
	$rows = mysql_num_rows($query);
	if ($rows > 0)
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> O administrador <b>$adm_nome</b> já existe. Por favor escolha outro login.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
		</SCRIPT>
			 ";
	}
	else
	{
		$sql = "INSERT INTO admins (
		adm_nome,
		adm_login,
		adm_senha,
		adm_status
		) 
		VALUES 
		(
		'$adm_nome',
		'$adm_login',
		'$adm_senha',
		'$adm_status'
		)";
		if(mysql_query($sql,$conexao))
		{
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/ok.gif> Cadastrado efetuado com sucesso.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'admins.php?pagina=admins&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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
if($pagina == 'editar_admins-envia')
{
	$adm_id = $_GET['adm_id'];
	$adm_nome = $_POST['adm_nome'];
	$adm_login = $_POST['adm_login'];
	$adm_senha = md5($_POST['adm_senha']);
	$adm_status = $_POST['adm_status'];
	$sqledit = "SELECT * FROM admins WHERE adm_id = '$adm_id'";
	$queryedit = mysql_query($sqledit,$conexao);
	$rowsedit = mysql_num_rows($queryedit);

	if($rowsedit > 0)
	{
		$logincompara = mysql_result($queryedit, 0, 'adm_login');
		$senhacompara = mysql_result($queryedit, 0, 'adm_senha');
		
	}
	if($_POST['adm_senha'] == $senhacompara && $_POST['adm_login'] == $logincompara)
	{
		
		$sqlEnviaEdit = "UPDATE admins SET ADM_NOME = '$adm_nome', adm_status = '$adm_status' WHERE adm_id = $adm_id ";
	}
	elseif($_POST['adm_senha'] != $senhacompara && $_POST['adm_login'] != $logincompara)
	{
		$sqllogin = "SELECT * FROM admins WHERE adm_login = '$adm_login'";
		$querylogin = mysql_query($sqllogin,$conexao);
		$rowslogin = mysql_num_rows($querylogin);
		if ($rowslogin > 0)
		{
			$erro = "<img src=../imagens/x.gif> O Administrador <font color=#0066CC>".$adm_login."</font> já existe. Por favor escolha outro login.";
		}
		else
		{
			$sqlEnviaEdit = "UPDATE admins SET ADM_NOME = '$adm_nome', adm_login = '$adm_login', adm_senha = '$adm_senha', adm_status = '$adm_status' WHERE adm_id = $adm_id ";
		}
	}
	elseif($_POST['adm_senha'] == $senhacompara && $_POST['adm_login'] != $logincompara)
	{
		
		$sqllogin = "SELECT * FROM admins WHERE adm_login = '$adm_login'";
		$querylogin = mysql_query($sqllogin,$conexao);
		$rowslogin = mysql_num_rows($querylogin);
		if ($rowslogin > 0)
		{
			$erro = "<img src=../imagens/x.gif> O Administrador <font color=#0066CC>".$adm_login."</font> já existe. Por favor escolha outro login.";
		}
		else
		{
			$sqlEnviaEdit = "UPDATE admins SET ADM_NOME = '$adm_nome', adm_login = '$adm_login', adm_status = '$adm_status' WHERE adm_id = $adm_id ";
		}
	}
	elseif($_POST['adm_senha'] != $senhacompara && $_POST['adm_login'] == $logincompara)
	{ 
		$sqlEnviaEdit = "UPDATE admins SET ADM_NOME = '$adm_nome', adm_senha = '$adm_senha', adm_status = '$adm_status' WHERE adm_id = $adm_id ";
	}
	if($adm_nome == 'null' || $adm_login == 'null' || $adm_senha == 'null' )
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> Por favor preencha todos os campos.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>');
		</SCRIPT>
		";
	}
	elseif(mysql_query ($sqlEnviaEdit,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Dados alterados com sucesso.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'admins.php?pagina=admins&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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

if($pagina == 'excluir_admins')
{
	$adm_id = $_GET['adm_id'];
	$adm_login = $_GET['adm_login'];
	$adm_nome = $_GET['adm_nome'];
	$excluir_admins = $_GET['excluir_admins'];
	if($adm_login == 'administrador')
	{
		echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/x.gif> O administrador <b>".$adm_nome."</b> não pode ser excluído.<br><br>'+
				'<input value=\' OK \' type=\'button\'  onclick=javascript:window.history.back();>' );
			</SCRIPT>
			";
	}
	else
	{
		$sql = "DELETE FROM admins WHERE adm_id = '$adm_id'";
					
		if(mysql_query($sql,$conexao))
		{
			echo "
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/ok.gif> Exclusão realizada com sucesso<br><br>'+
				'<input value=\' OK \' type=\'button\'  onclick=javascript:window.location.href=\'admins.php?pagina=admins&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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
}
if($pagina == 'ativar_user')
{
	$adm_id = $_GET['adm_id'];
	$adm_login = $_GET['adm_login'];

	$sql = "SELECT * FROM admins WHERE adm_id = '$adm_id'";
	$query = mysql_query($sql,$conexao);
	$adm_login = mysql_result($query, 0, 'adm_login');
	$adm_nome = mysql_result($query, 0, 'adm_nome');
	if($adm_login == "administrador" )
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> O administrador <b>$adm_nome</b> não pode ser alterado.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back(); >');
		</SCRIPT>
		";
	}
	else
	{
		$sql = "UPDATE admins SET adm_status = 1 WHERE adm_id = '$adm_id' ";
		mysql_query($sql,$conexao);
		echo "
		<script linguage='JavaScript'>
			window.location.href = 'admins.php?pagina=admins&login=$login&n=$n';
		</script>
			 ";
	}

}
if($pagina == 'desativar_user')
{
	$adm_id = $_GET['adm_id'];
	$adm_login = $_GET['adm_login'];

	$sql = "SELECT * FROM admins WHERE adm_id = '$adm_id'";
	$query = mysql_query($sql,$conexao);
	$adm_login = mysql_result($query, 0, 'adm_login');
	$adm_nome = mysql_result($query, 0, 'adm_nome');
	if($adm_login == "administrador")
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> O administrador <b>$adm_nome</b> não pode ser alterado.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back(); >');
		</SCRIPT>
		";
	}
	else
	{
		$sql = "UPDATE admins SET adm_status = 0 WHERE adm_id = '$adm_id' ";
		mysql_query($sql,$conexao);
		echo "
		<script linguage='JavaScript'>
			window.location.href = 'admins.php?pagina=admins&login=$login&n=$n';
		</script>
			 ";
	}

}

?>
<?php
include('../mod_rodape_admin/rodape.php'); 
?>
