<link href="css/estilo.css" rel="stylesheet" type="text/css" />

<div class="topo">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="auto" align="center">
            <div class="logo">
                <img src="imagens/logo.png" border="0" />
            </div>
        </td>
        <td align="right">
        
       		<form autocomplete='off' method='POST' action='cliente/envialogin.php'>
            <span class='acesse'>Digite login e senha para acessar seus exames</span>&nbsp;&nbsp;<br />
        	<input name="login" id="login" type="text" placeholder="Login"/>
            <input name="senha" id="senha" type="password" placeholder="Senha">
      		<input name="entrar" type="submit" id="entrar" value="Ok" class="botao" />
            </form>
        	<?php include("mod_menu/menu.php") ?>
        </td>
      </tr>
    </table>
</div>
<br />
