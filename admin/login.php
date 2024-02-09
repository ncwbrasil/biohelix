<?php
require_once("../mod_includes/php/ctracker.php");
include('../mod_includes/php/connect.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">
<?php
$pagina = $_GET['pagina'];

include("../mod_topo_admin/topo_login.php");


echo "
<form autocomplete='off' method='POST' action='envialogin.php'>
    <table class='texto' align='center' border='0' width='940' cellspacing='0' cellpadding='0'>
    <tr>
		<td align='left'>
			<div class='titulo_adm'> Acesso Restrito  </div>
			<div id='interna'>
        	<table align='center' class='margemtab' cellspacing='10'>
            	<tr>
					<td>
						<span class='textopeq'>Digite seu usuário e senha para acessar o sistema.</span><br>
        			</td>
				</tr>
				<tr>
                	<td align='center'>
		 				<input name='login' id='login' placeholder='Login' size='20'>
                    </td>
				</tr>
				<tr >
					<td align='center'>
                    	<input type='password' name='senha' id='senha' placeholder='Senha' size='20'>
                	</td>
				</tr>
				<tr >
					<td  align='center' height='30' valign='bottom'>
						<input type='submit' value=' Entrar no Sistema ' name='B1'>
        			</td>
				</tr>
            </table>
			</div>
			<div class='titulo_adm'> </div>
        </td>
    </tr>
</table>
</form>
";
include('../mod_rodape_admin/rodape.php');
";
</body>
</html>";
include('../mod_includes/php/funcoes-jquery.php');