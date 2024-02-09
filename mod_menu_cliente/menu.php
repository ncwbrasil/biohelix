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
            	<a href="../index.php" class="top_link" target="_parent"><img src="../imagens/icon-home.png" border="0" /><!--[if gte IE 7]><!--></a><!--<![endif]--><!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
   		</ul> 
             
        <ul class="menu">   
            <li class="top">
            	<a href="meuslaudos.php?pagina=meuslaudos&login=<?php echo $login;?>&n=<?php echo $n;?>&id=<?php echo $id;?>" class="top_link" target="_parent">Meus Laudos<!--[if gte IE 7]><!--></a><!--<![endif]-->
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
    <br />
    <p class='bemvindo'>Olá <b><?php echo $n;?></b></p>
</div>
<div id='janela' class='janela' style='display:none;'> </div>
