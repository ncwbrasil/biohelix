<?php
session_start ();
require_once("../mod_includes/php/ctracker.php");
include('../mod_includes/php/connect.php');
include('../mod_includes/php/funcoes-jquery.php');
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="author" content="Gustavo Costa">
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biohélix - Biologia Molecular Diagnóstica</title>
<link rel="shortcut icon" href="../imagens/favicon.ico">
<link href="../css/estilo_admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50339920-3', 'biohelix.com.br');
  ga('send', 'pageview');

</script>
</head>

<div id='janela' class='janela' style='display:none;'> </div>
<?php
//session_register('biohelix_cliente');
$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM clientes 
		WHERE cli_login = '$login' AND cli_senha = md5('$senha')";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
if ($rows >0)
{
	$id = md5(mysql_result($query, 0, 'cli_id'));
	$status = mysql_result($query, 0, 'cli_status');
	$n = mysql_result($query, 0, 'cli_nome');

	if ($status == 0)
	{
		echo "&nbsp;
			<SCRIPT language='JavaScript'>
				abreMask(
				'<img src=../imagens/x.gif> Seu usuário está desativado, por favor contate o administrador do sistema.<br><br>'+
				'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>' );
			</SCRIPT>
			";
	}
	else
	{
	   	$_SESSION['biohelix_cliente'] = $login.md5($n).$id;
	   	echo "<script language='JavaScript'>self.location = 'meuslaudos.php?pagina=meuslaudos&login=$login&n=$n&id=$id'</script>";
	}

}
else
{
   $_SESSION['biohelix_cliente'] = 'N';
   echo "&nbsp;
   		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> Login ou Senha incorreta, por favor tente novamente.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>' );
		</SCRIPT>
   		";
}
?>