<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Biohélix - Biologia Molecular Diagnóstica - Contato</title>
<META NAME="author" CONTENT="MogiComp Soluções Web">
<link href="css/estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="imagens/favicon.ico">

<link href="mod_includes/js/alert/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="mod_includes/js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="mod_includes/js/alert/jquery.alerts.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50339920-3', 'biohelix.com.br');
  ga('send', 'pageview');

</script>
</head>

<body>
<?php 
$pagina = $_GET['pagina'];
include("mod_topo/topo.php") ?>

<!--INICIO DO CONTEUDO-->
<?php include("banner.php") ?>

<div class="wrapper">
	<p class="titulo">Contato</p>
            <center>Rua Alfonsus De Guimarães, 22 - Vila Suissa - Mogi das Cruzes / SP - 08810-160	<br />
			Fone: (11) <span class='tel verde'>2378-6357</span> | Email: <span class='tel verde'>contato@biohelix.com.br</span>
            <br /><br />
			Ou, se preferir, envie-nos um e-mail. Basta preencher os campos abaixo e clicar em Enviar. <br /><br /></center>
            
            <form name='form_contato' id='form_contato' method='POST' action='contato.php?pagina=envia_contato'>
                 <table cellspacing="0" cellpadding="3" align="center" border="0" >
                    <tr height="45">
                       <td>
                       		<input type="text" name="nome" id="nome" value="Nome" onblur="if (this.value == '') this.value='Nome';" onfocus="if (this.value == 'Nome') this.value='';" class="form">
                       </td>
                    </tr>
                    <tr height="45">
                       <td>
                       		<input type="text" name="email" id="email" value="Email" onblur="if (this.value == '') this.value='Email';" onfocus="if (this.value == 'Email') this.value='';" class="form">
                       </td>
                       
                    </tr>
                    <tr height="45">
                       <td>
                       		<input type="text" name="assunto" id="assunto" value="Assunto" onblur="if (this.value == '') this.value='Assunto';" onfocus="if (this.value == 'Assunto') this.value='';" class="form">
                       </td>
                    </tr>
                    <tr>
                       <td>
                       		<textarea type="text" name="mensagem" id="mensagem" value="Mensagem" onblur="if (this.value == '') this.value='Mensagem';" onfocus="if (this.value == 'Mensagem') this.value='';" class="form">Mensagem</textarea>
                       </td>
                    </tr>
                    <tr height="50">
                       <td align='center' colspan='2'  valign='middle'>
                            <input type='submit' value='Enviar' size='10' class="but_form"/>
                       </td>
                    </tr>
                </table>
            </form>
</div>
<!--FIM DO CONTEUDO-->

<?php include("mod_rodape/rodape.php") ?>
</body>
</html>
<?php
if($pagina == 'envia_contato')
{
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$assunto = $_POST['assunto'];
	$mensagem = nl2br($_POST['mensagem']);
	
	$agora = time();
	$data = getdate($agora);
	$dia_semana = $data[wday];
	$dia_mes = $data[mday];
	$mes = $data[mon];
	$ano = $data[year];
	switch ($dia_semana)
	{
		case 0:
			$dia_semana = "Domingo";
		break;
		case 1:
			$dia_semana = "Segunda-feira";
		break;
		case 2:
			$dia_semana = "Terça-feira";
		break;
		case 3:
			$dia_semana = "Quarta-feira";
		break;
		case 4:
			$dia_semana = "Quinta-feira";
		break;
		case 5:
			$dia_semana = "Sexta-feira";
		break;
		case 6:
			$dia_semana = "Sábado";
		break;
	}
	switch ($mes)
	{
		case 1:
			$mes = "Janeiro";
		break;
		case 2:
			$mes = "Fevereiro";
		break;
		case 3:
			$mes = "Março";
		break;
		case 4:
			$mes = "Abril";
		break;
		case 5:
			$mes = "Maio";
		break;
		case 6:
			$mes = "Junho";
		break;
		case 7:
			$mes = "Julho";
		break;
		case 8:
			$mes = "Agosto";
		break;
		case 9:
			$mes = "Setembro";
		break;
		case 10:
			$mes = "Outubro";
		break;
		case 11:
			$mes = "Novembro";
		break;
		case 12:
			$mes = "Dezembro";
		break;
	}
	$datap = $dia_semana.', '.$dia_mes.' de '.$mes.' de '.$ano;


	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	require("mod_includes/php/phpmailer/class.phpmailer.php");
	 
	// Inicia a classe PHPMailer
	$mail = new PHPMailer();
	// Define os dados do servidor e tipo de conexão
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsSMTP();
	$mail->Host = "mail.biohelix.com.br"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->Username = 'autenticacao@biohelix.com.br'; // Usuário do servidor SMTP
	$mail->Password = 'infomogi123'; // Senha do servidor SMTP
	
	 
	// Define o remetente
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->From = "$email"; // Seu e-mail
	$mail->Sender = "autenticacao@biohelix.com.br"; // Seu e-mail
	$mail->FromName = "$nome"; // Seu nome
	
	 
	// Define os destinatário(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->AddAddress('contato@biohelix.com.br');
		
	// Define os dados técnicos da Mensagem
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	
	$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)
	 
	// Define a mensagem (Texto e Assunto)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->Subject  = "Contato Site - Biohélix - Biologia Molecular Diagnóstica"; // Assunto da mensagem
	
	$mail->Body = "
<head>
	<style type='text/css'>
		.margem 		{ padding-top:20px; padding-bottom:20px; padding-left:20px;padding-right:20px;}
		a:link 			{}
		a:visited 		{}
		a:hover 		{ text-decoration: underline; color:#095591; }
		a:active 		{ text-decoration: none; }
		.texto			{ font-family:'Calibri'; color:#666; font-size:12px; text-align:justify; font-weight:normal;}
		hr				{ border:none; border-top:1px solid #25A4BC;}
	</style>
</head>
<body class='fundo'>
	<table style='font-family:Calibri;' align='center' border='0' bordercolor='#B61245' width='100%' cellspacing='0' cellpadding='0'>
	<tr>
		<td align='left'>
			<font size='2' color='#095591'><b>Mensagem enviada:</b></font> <span class='texto'>$datap</span> 
			<hr>
			<table class='texto'>
				<tr>
					<td align='right'>
						<b>Nome:</b>
					</td>
					<td align='left'>
						$nome
					</td>
				</tr>
				<tr>
					<td align='right'>
						<b>Email:</b>
					</td>
					<td align='left'>
						$email
					</td>
				</tr>
				<tr>
					<td align='right'>
						<b>Assunto:</b>
					</td>
					<td align='left'>
						$assunto
					</td>
				</tr>
				<tr>
					<td align='right'>
						<b>Mensagem:</b>
					</td>
					<td align='left' valign='top'>
						$mensagem
					</td>
				</tr>
			</table>
			<hr>
			<font size=1>Email enviado automaticamente pelo formulário de contato do site - Biohélix - Biologia Molecular Diagnóstica</font>
		</td>
	</tr>
	</table>
</body>
";
/*$mail->AltBody = 'Este é o corpo da mensagem de teste, em Texto Plano! \r\n 
<IMG src="http://seudomínio.com.br/imagem.jpg" alt=":)"  class="wp-smiley"> ';*/
 
// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("/home/login/documento.pdf", "novo_nome.pdf");  // Insere um anexo
 
// Envia o e-mail
$enviado = $mail->Send($nome, $email, $assunto, $mensagem);
 
// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

// Exibe uma mensagem de resultado
if ($enviado)
{
	echo "<script linguage='javascript'>
		  jAlert('<img src=imagens/ok.gif> <font color=#095591 size=2>$nome</font>,<br> Sua mensagem foi enviada com sucesso, em breve responderemos.','Concluído', function () { window.location.href = 'contato.php'; });
		  </script>";
}
else
{
	echo "<script linguage='javascript'>
		  jAlert('<img src=imagens/x.gif> Erro ao enviar mensagem.<br>$mail->ErrorInfo','Erro', function () { window.history.back(); });
		  </script>"; 
}
}
?>