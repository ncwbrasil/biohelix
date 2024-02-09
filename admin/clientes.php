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
function geraSenha($tamanho, $maiusculas = false, $minusculas = false, $simbolos = false)
{
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	
	$caracteres .= $num;
	if ($maiusculas) $caracteres .= $lmai;
	if ($minusculas) $caracteres .= $lmin;
	if ($simbolos) $caracteres .= $simb;
	
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
	$rand = mt_rand(1, $len);
	$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}

//TOPO
include('../mod_includes/php/funcoes-jquery.php');
include('../mod_includes/php/verificalogin.php');
include("../mod_topo_admin/topo.php");
//FIM TOPO

$pagina = $_GET['pagina'];
$page = "<a href='clientes.php?pagina=clientes&login=$login&n=$n'>Clientes</a>";
$num_por_pagina = 20;
$pag = $_GET['pag'];
if(!$pag){$primeiro_registro = 0; $pag = 1;}
else{$primeiro_registro = ($pag - 1) * $num_por_pagina;}

$fil_cli_nome = $_REQUEST['fil_cli_nome'];
if($fil_cli_nome == '')
{
	$cli_nome_query = " 1 = 1 ";
}
else
{
	$cli_nome_query = " cli_nome LIKE '%$fil_cli_nome%' ";
}

$sql = "SELECT * FROM clientes WHERE ".$cli_nome_query." ORDER BY cli_data_cadastro DESC LIMIT $primeiro_registro, $num_por_pagina";
$consulta = "SELECT COUNT(*) FROM clientes WHERE ".$cli_nome_query." ";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
$rows2 = mysql_result(mysql_query($consulta,$conexao),0,"COUNT(*)");
if($pagina == "clientes")
{
	echo "
	<table class='texto' align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left'>
				<div class='titulo_adm'> $page  </div>
				<div id='interna'>
				<div id='icone'><input name='add-adm' value='Novo Cliente' type='button' onclick=javascript:window.location.href='clientes.php?pagina=adicionar_clientes&login=$login&n=".str_replace(' ','%20',"$n")."'; /></div>
				<div style='float:left'>
					Total de Clientes: $rows2 <br>
				</div>
				<div style='float:right'>
					<form name='form' id='form' enctype='multipart/form-data' method='post' action='clientes.php?pagina=clientes&login=$login&n=$n'>
					<input name='fil_cli_nome' id='fil_cli_nome' placeholder='Nome' value='$fil_cli_nome'>
					<input name='bt_filtrar' id='bt_filtrar' value='Filtrar' type='submit'>
					</form>
				</div>
				";
				if ($rows > 0)
				{
				echo "
				<table align='center' width='100%' border='0' cellspacing='0' cellpadding='10' class='bordatabela'>
					<tr>
						<td class='titulo_first'>Nome</td>
						<td class='titulo_tabela'>Data Nasc.</td>
						<td class='titulo_tabela'>Sexo</td>
						<td class='titulo_tabela'>RG</td>
						<td class='titulo_tabela'>Telefone</td>
						<td class='titulo_tabela'>Login</td>
						<td class='titulo_tabela'>Senha</td>
						<td class='titulo_tabela' align='center'>Status</td>
						<td class='titulo_last' align='center'>Gerenciar</td>
					</tr>";
						$c=0;
						for($x = 0; $x < $rows ; $x++)
						{
							$cli_id = mysql_result($query, $x, 'cli_id');
							$cli_nome = mysql_result($query, $x, 'cli_nome');
							$cli_data_nasc = implode("/",array_reverse(explode("-",mysql_result($query, $x, 'cli_data_nasc'))));
							$cli_sexo = mysql_result($query, $x, 'cli_sexo');
							$cli_rg = mysql_result($query, $x, 'cli_rg');
							$cli_telefone = mysql_result($query, $x, 'cli_telefone');
							$cli_email = mysql_result($query, $x, 'cli_email');
							$cli_login = mysql_result($query, $x, 'cli_login');
							$cli_senha = mysql_result($query, $x, 'cli_senha');
							$cli_senha_n = mysql_result($query, $x, 'cli_senha_n');
							$cli_status = mysql_result($query, $x, 'cli_status');
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
							
									$('#normal-button-$cli_id').toolbar({content: '#user-options-$cli_id', position: 'top', hideOnClick: true});
									$('#normal-button-bottom').toolbar({content: '#user-options', position: 'bottom'});
									$('#normal-button-small').toolbar({content: '#user-options-small', position: 'top', hideOnClick: true});
									$('#button-left').toolbar({content: '#user-options', position: 'left'});
									$('#button-right').toolbar({content: '#user-options', position: 'right'});
									$('#link-toolbar').toolbar({content: '#user-options', position: 'top' });
								});
							</script>
							<div id='user-options-$cli_id' class='toolbar-icons' style='display: none;'>
								";
								if($cli_status == 1)
								{
									echo "<a href='clientes.php?pagina=desativar_user&cli_id=$cli_id&cli_login=$cli_login&login=$login&n=$n'><img border='0' src='../imagens/icon-ativa-desativa.png'></a>";
								}
								else
								{
									echo "<a href='clientes.php?pagina=ativar_user&cli_id=$cli_id&cli_login=$cli_login&login=$login&n=$n'><img border='0' src='../imagens/icon-ativa-desativa.png'></a>";
								}
								echo "
								<a href='clientes_pdf.php?pagina=clientes_pdf&cli_id=$cli_id&cli_login=$cli_login&login=$login&n=$n' target='_blank'><img border='0' src='../imagens/icon-pdf.png'></a>
								<a href='clientes.php?pagina=exibir_clientes&cli_id=$cli_id&cli_login=$cli_login&login=$login&n=$n'><img border='0' src='../imagens/icon-exibir.png'></a>
								<a href='clientes.php?pagina=editar_clientes&cli_id=$cli_id&cli_login=$cli_login&login=$login&n=$n'><img border='0' src='../imagens/icon-editar.png'></a>
								<a onclick=\"
									abreMask(
										'Deseja realmente excluir o cliente <b>$cli_nome</b>? Atenção: ao excluir este cliente, todos os respectivos laudos e dados de acesso também serão excluídos permanentemente.<br><br>'+
										'<input value=\' Sim \' type=\'button\' onclick=javascript:window.location.href=\'clientes.php?pagina=excluir_clientes&cli_id=$cli_id&cli_login=$cli_login&cli_nome=".str_replace(" ","%20","$cli_nome")."&login=".$login."&n=".str_replace(" ","%20","$n")."\';>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
										'<input value=\' Não \' type=\'button\' class=\'close_janela\'>');
									\">
									<img border='0' src='../imagens/icon-excluir.png'></i>
								</a>
							</div>
							";
							echo "<tr class='$c1'>
									  <td>$cli_nome</td>
									  <td>$cli_data_nasc</td>
									  <td>$cli_sexo</td>
									  <td>$cli_rg</td>
									  <td>$cli_telefone</td>
									  <td>$cli_login</td>
									  <td>$cli_senha_n</td>
									  <td align=center>";
									  if($cli_status == 1)
									  {
										echo "<img border='0' src='../imagens/icon-ativo.png' width='15' height='15'>";
									  }
									  else
									  {
										echo "<img border='0' src='../imagens/icon-inativo.png' width='15' height='15'>";
									  }
									  echo "
									  </td>
									  <td align=center><div id='normal-button-$cli_id' class='settings-button'><img src='../imagens/icon-cog-small.png' /></div></td>
								  </tr>";
						}
						echo "</table>";
						
						$variavel = "&pagina=clientes&login=$login&n=$n";
						$limite = 1;
						if (!$consulta)
						{
							$consulta = "SELECT COUNT(*) FROM clientes";
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
					echo "<br><br><br>Não há nenhum cliente cadastrado.";
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
if($pagina == 'adicionar_clientes')
{
	echo "	
	<form name='form_clientes' id='form_clientes' enctype='multipart/form-data' method='post' action='clientes.php?pagina=adicionar_clientes-envia&id=$id&login=$login&n=$n'>
	<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center'>
				<div class='titulo_adm'> $page &raquo; Adicionar  </div>
				<table class='texto' align='center' cellspacing='0' cellpadding='5' width='700'>
					<tr>
						<td align='left'>
							<input type='text' name='cli_nome'  id='cli_nome' placeholder='Nome'>
							<input type='text' name='cli_data_nasc'  id='cli_data_nasc' placeholder='Data Nascimento' onkeypress='return mascaraData(this,event);' >
							<select name='cli_sexo' id='cli_sexo'>
								<option value=''>Sexo</option>
								<option value='Masculino'>Masculino</option>
								<option value='Feminino'>Feminino</option>
							</select>
							<br>
							<div id='cli_nome_erro' class='left'>&nbsp;</div>
							<div id='cli_data_nasc_erro' class='left'>&nbsp;</div>
							<div id='cli_sexo_erro' class='left'>&nbsp;</div>
							<br>
							<input type='text' name='cli_rg'  id='cli_rg' placeholder='RG' >
							<input type='text' name='cli_telefone'  id='cli_telefone' placeholder='Telefone c/ DDD' onkeypress='return mascaraTEL(this);' maxlength='14'>
							<input type='text' name='cli_email'  id='cli_email' placeholder='Email'>
							<br>
							<br>
							<input type='radio' name='cli_status' value='1' checked> Ativo &nbsp;&nbsp;&nbsp;&nbsp;
							<input type='radio' name='cli_status' value='0'> Inativo
							<br>
							
						</td>	
					</tr>
					<tr>
						<td height='60' colspan='4' align='center' valign='bottom'>
							<input type='button' id='bt_clientes' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='clientes.php?pagina=clientes&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
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
if($pagina == 'editar_clientes')
{
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
		$cli_senha = mysql_result($queryedit, 0, 'cli_senha');
		$cli_status = mysql_result($queryedit, 0, 'cli_status');
		
			echo "
			<form name='form_clientes' id='form_clientes' enctype='multipart/form-data' method='post' action='clientes.php?pagina=editar_clientes-envia&cli_id=$cli_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='left'>
						<div class='titulo_adm'> $page &raquo; Editar: $cli_nome ($cli_id)  </div>
						<table align='center' cellspacing='0' cellpadding='5' width='700'>
							<tr>
								<td align='left'>
									<input type='text' name='cli_nome' id='cli_nome' value='$cli_nome' placeholder='Nome'>
									<input type='text' name='cli_data_nasc' id='cli_data_nasc' value='$cli_data_nasc' placeholder='Data Nascimento' onkeypress='return mascaraData(this,event);' >
									<select name='cli_sexo' id='cli_sexo'>
										<option value='$cli_sexo'>$cli_sexo</option>
										<option value='Masculino'>Masculino</option>
										<option value='Feminino'>Feminino</option>
									</select>
									<br>
									<div id='cli_nome_erro' class='left'>&nbsp;</div>
									<div id='cli_data_nasc_erro' class='left'>&nbsp;</div>
									<div id='cli_sexo_erro' class='left'>&nbsp;</div>
									<br>
									<input type='text' name='cli_rg'  id='cli_rg' value='$cli_rg'  placeholder='RG' >
									<input type='text' name='cli_telefone' id='cli_telefone' value='$cli_telefone' placeholder='Telefone c/ DDD' onkeypress='return mascaraTEL(this);' maxlength='14'>
									<input type='text' name='cli_email' id='cli_email' value='$cli_email' placeholder='Email'>
									<br><br>
									";
									if($cli_status == 1)
									{
										echo "<input type='radio' name='cli_status' value='1' checked> Ativo &nbsp;&nbsp;&nbsp; 
											  <input type='radio' name='cli_status' value='0'> Inativo
											 ";
									}
									else
									{
										echo "<input type='radio' name='cli_status' value='1'> Ativo &nbsp;&nbsp;&nbsp; 
											  <input type='radio' name='cli_status' value='0' checked> Inativo
											 ";
									}
									echo "
								</td>	
							</tr>
							<tr>
								<td height='60' colspan='4' align='center' valign='bottom'>
									<input type='button' id='bt_clientes' value='Salvar' />&nbsp;&nbsp;&nbsp;&nbsp; 
									<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='clientes.php?pagina=clientes&login=$login&n=".str_replace(" ","%20","$n")."'; value='Cancelar'/></center>
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

//INICIO EDITAR USUÁRIO
if($pagina == 'exibir_clientes')
{
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
			<form name='form_clientes' id='form_clientes' enctype='multipart/form-data' method='post' action='clientes.php?pagina=editar_clientes-envia&cli_id=$cli_id&login=$login&n=$n'>
			<table align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
				<tr>
					<td align='left'>
						<div class='titulo_adm'> $page &raquo; Editar: $cli_nome ($cli_id)  </div>
						<div class='contentPrint' id='imprimir'> 
						<table align='center' cellspacing='0' cellpadding='5' width='700'>
							<tr>
								<td align='left'>
									<div class='titulo'>Dados Pessoais</div>
									<b>Nome:</b> $cli_nome<p>
									<b>Data Nascimento:</b> $cli_data_nasc<p>
									<b>RG:</b> $cli_rg<p>
									<b>Sexo:</b> $cli_sexo<p>
									<b>Telefone:</b> $cli_telefone<p>
									<b>Email:</b> $cli_email<p><br>
									
									<div class='titulo'>Dados de Acesso</div>
									<b>Login:</b> $cli_login<p>
									<b>Senha:</b> $cli_senha<p>
								</td>	
							</tr>
						</table>
						</div>
						<center>
							<input type='button' id='botao_cancelar' onclick=javascript:window.location.href='clientes.php?pagina=clientes&login=$login&n=".str_replace(" ","%20","$n")."'; value='Voltar'/>
						</center>
						<div class='titulo_adm'>   </div>
					</td>
				</tr>
			</table>
			</form>
			<script type='text/javascript' src='../js/jquery-1.3.2.js'></script>
			<script type='text/javascript' src='../js/elementPrint.js'></script>
			";
	}
}	
// FIM EDITAR USUÁRIO

//INICIO ENVIA DADOS ADICIONAR
if($pagina == "adicionar_clientes-envia")
{
	$cli_nome = $_POST['cli_nome'];
	$cli_data_nasc = implode("-",array_reverse(explode("/",$_POST['cli_data_nasc'])));
	$cli_sexo = $_POST['cli_sexo'];
	$cli_rg = $_POST['cli_rg'];
	$cli_telefone = $_POST['cli_telefone'];
	$cli_email = $_POST['cli_email'];
	$cli_status = $_POST['cli_status'];
	
	$sql = "INSERT INTO clientes (
	cli_nome,
	cli_data_nasc,
	cli_sexo,
	cli_rg,
	cli_telefone,
	cli_email,
	cli_status
	) 
	VALUES 
	(
	'$cli_nome',
	'$cli_data_nasc',
	'$cli_sexo',
	'$cli_rg',
	'$cli_telefone',
	'$cli_email',
	'$cli_status'
	)";
	if(mysql_query($sql,$conexao))
	{
		$ultimo_id = mysql_insert_id();
		$cli_login = geraSenha(5,false,true,false).$ultimo_id;
		$cli_senha_n = geraSenha(6,false,false,false);
		$cli_senha = md5($cli_senha_n);
		
		$sql_update = "UPDATE clientes SET
					   cli_login = '$cli_login',
					   cli_senha = '$cli_senha',
					   cli_senha_n = '$cli_senha_n'
					   WHERE cli_id = $ultimo_id
					   ";
		if(mysql_query($sql_update,$conexao))
		{
			
		}
		
					   
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Cadastrado efetuado com sucesso.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'clientes.php?pagina=clientes&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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
if($pagina == 'editar_clientes-envia')
{
	$cli_id = $_GET['cli_id'];
	$cli_nome = $_POST['cli_nome'];
	$cli_data_nasc = implode("-",array_reverse(explode("/",$_POST['cli_data_nasc'])));
	$cli_sexo = $_POST['cli_sexo'];
	$cli_rg = $_POST['cli_rg'];
	$cli_telefone = $_POST['cli_telefone'];
	$cli_email = $_POST['cli_email'];
	$cli_status = $_POST['cli_status'];
	$sqledit = "SELECT * FROM clientes WHERE cli_id = '$cli_id'";
	$queryedit = mysql_query($sqledit,$conexao);
	$rowsedit = mysql_num_rows($queryedit);

	$sqlEnviaEdit = "UPDATE clientes SET 
						 cli_nome = '$cli_nome', 
						 cli_data_nasc = '$cli_data_nasc', 
						 cli_sexo = '$cli_sexo', 
						 cli_rg = '$cli_rg', 
						 cli_telefone = '$cli_telefone', 
						 cli_email = '$cli_email', 
						 cli_status = '$cli_status' 
						 WHERE cli_id = $cli_id ";
	
	if(mysql_query ($sqlEnviaEdit,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Dados alterados com sucesso.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'clientes.php?pagina=clientes&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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

if($pagina == 'excluir_clientes')
{
	$cli_id = $_GET['cli_id'];
	$cli_login = $_GET['cli_login'];
	$cli_nome = $_GET['cli_nome'];
	$excluir_clientes = $_GET['excluir_clientes'];
	$sql = "DELETE FROM clientes WHERE cli_id = '$cli_id'";
				
	if(mysql_query($sql,$conexao))
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/ok.gif> Exclusão realizada com sucesso<br><br>'+
			'<input value=\' OK \' type=\'button\'  onclick=javascript:window.location.href=\'clientes.php?pagina=clientes&login=$login&n=".str_replace(" ","%20","$n")."\';>' );
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
if($pagina == 'ativar_user')
{
	$cli_id = $_GET['cli_id'];
	$cli_login = $_GET['cli_login'];

	$sql = "SELECT * FROM clientes WHERE cli_id = '$cli_id'";
	$query = mysql_query($sql,$conexao);
	$cli_login = mysql_result($query, 0, 'cli_login');
	$cli_nome = mysql_result($query, 0, 'cli_nome');
	if($cli_login == "cliente" )
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> O cliente <b>$cli_nome</b> não pode ser alterado.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back(); >');
		</SCRIPT>
		";
	}
	else
	{
		$sql = "UPDATE clientes SET cli_status = 1 WHERE cli_id = '$cli_id' ";
		mysql_query($sql,$conexao);
		echo "
		<script linguage='JavaScript'>
			window.location.href = 'clientes.php?pagina=clientes&login=$login&n=$n';
		</script>
			 ";
	}

}
if($pagina == 'desativar_user')
{
	$cli_id = $_GET['cli_id'];
	$cli_login = $_GET['cli_login'];

	$sql = "SELECT * FROM clientes WHERE cli_id = '$cli_id'";
	$query = mysql_query($sql,$conexao);
	$cli_login = mysql_result($query, 0, 'cli_login');
	$cli_nome = mysql_result($query, 0, 'cli_nome');
	if($cli_login == "cliente")
	{
		echo "
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> O cliente <b>$cli_nome</b> não pode ser alterado.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back(); >');
		</SCRIPT>
		";
	}
	else
	{
		$sql = "UPDATE clientes SET cli_status = 0 WHERE cli_id = '$cli_id' ";
		mysql_query($sql,$conexao);
		echo "
		<script linguage='JavaScript'>
			window.location.href = 'clientes.php?pagina=clientes&login=$login&n=$n';
		</script>
			 ";
	}

}

?>
<?php
include('../mod_rodape_admin/rodape.php'); 
?>
