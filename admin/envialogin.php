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
</head>

<div id='janela' class='janela' style='display:none;'> </div>
<?php
$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM admins 
		WHERE adm_login = '$login' AND adm_senha = md5('$senha')";

$query = mysql_query($sql,$conexao);
$rows = mysql_num_rows($query);
if ($rows >0)
{
	$status = mysql_result($query, 0, 'adm_status');
	$n = mysql_result($query, 0, 'adm_nome');

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
	   	$_SESSION['biohelix'] = $login.md5($n);
	   	echo "<script language='JavaScript'>self.location = 'admin.php?login=$login&n=$n'</script>";
	}

}
else
{
   $_SESSION['biohelix'] = 'N';
   echo "&nbsp;
   		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> Login ou Senha incorreta, por favor tente novamente.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.history.back();>' );
		</SCRIPT>
   		";
}
?>