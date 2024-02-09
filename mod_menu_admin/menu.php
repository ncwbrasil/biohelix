<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../mod_menu_admin/menu.css" rel="stylesheet" type="text/css" />
</head>
 
<body>
<div class="containermenu bodytext">
    <div class="textomenu"> 
    	<ul class="menu">   
            <li class="first">
            	<a href="admin.php?pagina=admin&login=<?php echo $login;?>&n=<?php echo $n;?>" class="top_link" target="_parent"><img src="../imagens/icon-home.png" border="0" /><!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
   		</ul> 
        <ul class="menu">   
            <li class="top">
            	<a href="admins.php?pagina=admins&login=<?php echo $login;?>&n=<?php echo $n;?>" class="top_link" target="_parent">Admins<!--[if gte IE 7]><!--></a><!--<![endif]-->
            </li>
   		</ul>        
               
        <ul class="menu">   
            <li class="top">
            	<a href="clientes.php?pagina=clientes&login=<?php echo $login;?>&n=<?php echo $n;?>" class="top_link" target="_parent">Clientes<!--[if gte IE 7]><!--></a><!--<![endif]-->
            </li>
   		</ul>
        
        <ul class="menu">   
            <li class="top">
            	<a href="exames.php?pagina=exames&login=<?php echo $login;?>&n=<?php echo $n;?>" class="top_link" target="_parent">Exames<!--[if gte IE 7]><!--></a><!--<![endif]-->
            </li>
   		</ul>
             
        <ul class="menu">   
            <li class="top">
            	<a href="laudos.php?pagina=laudos&login=<?php echo $login;?>&n=<?php echo $n;?>" class="top_link" target="_parent">Laudos<!--[if gte IE 7]><!--></a><!--<![endif]-->
            </li>
   		</ul>
               
        
            
        <ul class="menu">   
            <li class="toplast">
            	<a onclick="
                	abreMask(
                    'Deseja realmente sair do sistema?<br><br>'+
                    '<input value=\' Sim \' type=\'button\' onclick=javascript:window.location.href=\'logout.php?pagina=logout\';>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
                    '<input value=\' Não \' type=\'button\' class=\'close_janela\'>');
                " class="top_link" target="_parent">Sair<!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
   		</ul> 
        
    </div>
</div>
<div id='janela' class='janela' style='display:none;'> </div>
