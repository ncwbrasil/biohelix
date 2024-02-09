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
<title>Biohélix - Biologia Molecular Diagnóstica - Meus Laudos</title>
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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50339920-3', 'biohelix.com.br');
  ga('send', 'pageview');

</script>
</head>
<?php	
//TOPO
include('../mod_includes/php/funcoes-jquery.php');
include('../mod_includes/php/verificalogincliente.php');
include("../mod_topo_cliente/topo.php");
//FIM TOPO

$pagina = $_GET['pagina'];
$page = "<a href='meuslaudos.php?pagina=meuslaudos&login=$login&n=$n&id=$id'>Meus Laudos</a>";
$num_por_pagina = 5;
$pag = $_GET['pag'];
if(!$pag){$primeiro_registro = 0; $pag = 1;}
else{$primeiro_registro = ($pag - 1) * $num_por_pagina;}
$sql = "SELECT * FROM laudos 
		INNER JOIN clientes ON clientes.cli_id = laudos.lau_cliente
		LEFT JOIN exames ON exames.exa_id = laudos.lau_tipo_laudo
		WHERE md5(cli_id) = '$id'
		ORDER BY lau_data_liberacao DESC
		LIMIT $primeiro_registro, $num_por_pagina
		";
$consulta = "SELECT COUNT(*) FROM laudos WHERE md5(lau_cliente) = '$id'";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
if($pagina == "meuslaudos")
{
	echo "
	<table class='texto' align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left'>
				<div class='titulo_adm'> $page  </div>
				<div id='interna'>
				";
				if ($rows > 0)
				{
				echo "
				<table align='center' width='100%' border='0' cellspacing='0' cellpadding='10' class='bordatabela'>
					<tr>
						<td class='titulo_first'>Atendimento</td>
						<td class='titulo_tabela'>Data Entrada</td>
						<td class='titulo_tabela'>Data Liberação</td>
						<td class='titulo_tabela'>Exame</td>
						<td class='titulo_tabela'>Dr(a)</td>
						<td class='titulo_tabela'>Status</td>
						<td class='titulo_last' align='center'>Exibir Laudo</td>
					</tr>";
						$c=0;
						for($x = 0; $x < $rows ; $x++)
						{
							$lau_id = mysql_result($query, $x, 'lau_id');
							$lau_numero = mysql_result($query, $x, 'lau_numero');
							$lau_ano = mysql_result($query, $x, 'lau_ano');
							$cli_nome = mysql_result($query, $x, 'cli_nome');
							$exa_nome = mysql_result($query, $x, 'exa_nome');
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
								
							</div>
							";
							echo "<tr class='$c1'>
									  <td>$lau_numero/$lau_ano</td>
									  <td>$lau_data_entrada</td>
									  <td>$lau_data_liberacao</td>
									  <td>$exa_nome</td>
									  <td>$lau_dr</td>
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
									  <td align=center>";
									  if($lau_status == 1)
									  {
									  	echo "
										<a href='laudo_pdf.php?pagina=laudo_pdf&lau_id=$lau_id&lau_login=$lau_login&login=$login&n=$n&id=$id' target='_blank'><img border='0' src='../imagens/icon-pdf.png'></a>
										";
									  }
									  echo "
									  </td>
								  </tr>";
						}
						echo "</table>";
						
						$variavel = "&pagina=meuslaudos&login=$login&n=$n&id=$id";
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
								$paginacao .= ' a<a class="atual" href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'">['.$i.']</a> ';        
							  }
							  else
							  {
								$paginacao .= ' a<a href="'.$PHP_SELF.'?pag='.$i.''.$variavel.'"><font color=#000000>'.$i.'</font></a> ';  
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

?>
<?php
include('../mod_rodape_admin/rodape.php'); 
?>
