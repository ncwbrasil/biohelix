<div id='janela' class='janela' style='display:none;'> </div>
<?php
$sqlverifica = "SELECT * FROM clientes 
				WHERE md5(cli_id) = \"$id\" AND cli_nome = \"$n\" AND cli_login = \"$login\" AND cli_status = 1";
$queryverifica = mysql_query($sqlverifica, $conexao);
$rowsverifica = mysql_num_rows($queryverifica);
if($rowsverifica > 0)
{
	
}
else
{
	unset($_SESSION['biohelix_cliente']);
	session_write_close();
	echo "&nbsp;
		 <SCRIPT language='JavaScript'>
		 	abreMask(
			'<img src=../imagens/x.gif> Você não tem permissão para acessar esta área. Por favor faça Login.<br><br>'+
			'<input value=\' Ok \' type=\'button\' onclick=javascript:window.location.href=\'login.php\';>' );
		</SCRIPT>
		 ";
		 
}

if ((!isset($_SESSION['biohelix_cliente']))  OR ($_SESSION['biohelix_cliente'] != $login.md5($n).$id))
{	
	unset($_SESSION['biohelix_cliente']);
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
