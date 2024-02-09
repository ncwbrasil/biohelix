<?php
session_start (); 
require_once("../mod_includes/php/ctracker.php");
include('../mod_includes/php/connect.php');
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><head>
<meta name="author" content="MogiComp">
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
?>

<div id='janela' class='janela' style='display:none;'> </div>

<?php
	//include('check_data_fim.php');
	echo "
	
	<table class='texto' align='center' border='0' width='960' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='left'>
				<div class='titulo_adm'> Bem vindo ao sistema de gerenciamento  </div>
				<div id='interna'>
					<table with='100%'>
						<tr>
							<td align='justify' valign='top'>
								Este sistema contém as seguintes funcionalidades:<br>
								<ul>
									<li><b>Gerenciador de Admins:</b></li>
										<ul>
											<li>Adicionar/editar/excluir administradores que poderão entrar no sistema;</li>
										</ul>
									<li><b>Gerenciador de Clientes:</b></li>
										<ul>
											<li>Adicionar/editar/excluir os Clientes/Pacientes;</li>
										</ul>
									<li><b>Gerenciador de Exames:</b></li>
										<ul>
											<li>Adicionar/editar/excluir os tipos (modelos) de exames;</li>
										</ul>
									<li><b>Gerenciador de Laudos:</b></li>
										<ul>
											<li>Adicionar/editar/excluir os laudos;</li>
										</ul>
								</ul>
								<br>
								<div style='line-height:30px; float:left; width:49%;'>
								Legendas de ações: <img src='../imagens/icon-cog.png' valign='middle' height='17'><br />
								<div style='padding-left:15px'>
								<img src='../imagens/icon-ativa-desativa.png' valign='top'> Ativa ou Desativa<br />
								<img src='../imagens/icon-exibir.png' valign='top'> Exibir <br />
								<img src='../imagens/icon-editar.png' valign='top'> Editar<br />
								<img src='../imagens/icon-excluir.png' valign='top'> Excluir<br />
								</div>
								</div>
								<div style='line-height:30px; float:left; width:49%;'>
								Legendas de status:<br />
								<div style='padding-left:15px'>
								<img src='../imagens/icon-ativo.png' style='padding:5px 6px;' valign='middle'> Ativado<br />
								<img src='../imagens/icon-inativo.png' style='padding:5px 6px' valign='middle'> Desativado<br />
								</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class='titulo_adm'>  </div>
				
			</td>
		</tr>
	</table>";
?>
<?php
include('../mod_rodape_admin/rodape.php');
?>
