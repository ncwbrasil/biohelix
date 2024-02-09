<div id='janela' class='janela' style='display:none;'> </div>
<?php
$sqlverifica = "SELECT * FROM admins 
				WHERE adm_nome = \"$n\" AND adm_login = \"$login\" AND adm_status = 1";
$queryverifica = mysql_query($sqlverifica, $conexao);
$rowsverifica = mysql_num_rows($queryverifica);
if($rowsverifica > 0)
{
	
}
else
{
	unset($_SESSION['biohelix']);
	session_write_close();
	echo "&nbsp;
		 <SCRIPT language='JavaScript'>
		 	abreMask(
			'<img src=../imagens/x.gif> Você não tem permissão para acessar esta área. Por favor faça Login.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'login.php\';>' );
		</SCRIPT>
		 ";
		 
}

if ((!isset($_SESSION['biohelix']))  OR ($_SESSION['biohelix'] != $login.md5($n)))
{	
	unset($_SESSION['biohelix']);
	session_write_close();
	echo "&nbsp;
		<SCRIPT language='JavaScript'>
			abreMask(
			'<img src=../imagens/x.gif> Você não tem permissão para acessar esta área. Por favor faça Login.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'login.php\';>' );
		</SCRIPT>
		 ";
	exit;
}
?>
