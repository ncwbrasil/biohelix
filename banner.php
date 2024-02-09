<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Banner</title>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
<script type="text/javascript"> 
	$(document).ready(function(){
		$('#slide_fotos').cycle({
			fx: 'fade',
			pager: '#pager' ,
			timeout: 4000,
			next:   '#next',
			prev:   '#prev',
			pause: 1
		});
	
		$('#pause').click(function() { 
			$('#slide_fotos').cycle('pause'); 
		});
		
		$('#play').click(function() { 
			$('#slide_fotos').cycle('resume'); 
		});
	
	});
</script>
<!--[if IE 7]>
<style>
#slideshow 		{ width: 960px;height: 280px;	position: relative; margin:0 auto;}
#slideshow img 	{ width: 960px; height: 280px; position: absolute;left:-40px; border:none;}
<style>
<![endif]-->

<style  type="text/css">
@media
only screen and (max-device-width : 1024px){ #slideshow-control 	{ display:none;} }

@media
only screen and (-webkit-min-device-pixel-ratio : 1.5),
only screen and (min-device-pixel-ratio : 1.5) { #slideshow-control 	{ display:none;} }

#slideshow 					{ width:960px;height: 280px;position:relative; margin:0 auto; background:none;}
#slide_fotos p 				{ position: absolute;right:0;top:210px;z-index:3;padding:10px 20px;}
#slide_fotos 				{ height: 100%;overflow: hidden;}
#slide_fotos  img			{ border:none;}
#pager 						{ position:relative; z-index:10; margin:0 auto; text-align:center; display:inline; margin-left:15px; top:-8px;}
#pager a 					{ text-decoration:none; color:#000;width:10px;height:10px;line-height:10px;text-align:center;display:inline-block;font-size:1px;font-family:Arial, Helvetica, sans-serif; margin:2px; color:#DDD; background:#DDD;-moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;  border:1px solid #EFEFEF;}
#pager a.activeSlide 		{ color:#333; text-decoration:underline; background:#333;-moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px; border:1px solid #EFEFEF;}
#slideshow-control #prev 	{ position:absolute; left:-40px; top:100px; z-index:9999; border:none;}
#slideshow-control #next 	{ position:absolute; right:-40px; top:100px; z-index:9999; border:none;}
#comandos					{ margin:0 auto; margin-top:15px; text-align:center; z-index:9999;}
#slideshow .sombra			{ position:relative; top:-15px;}
li							{ list-style:none;}
</style>

</head>

<body>
    <div id="slideshow">
        <div id="slideshow-control">
            <a id="prev" href="#"><img src="imagens/prev.png" alt="Anterior" /></a>
            <a id="next" href="#"><img src="imagens/next.png" alt="Próximo" /></a>
        </div>
        <ul id="slide_fotos">
            <li><img src='imagens/banner-01.jpg' border='0' /></li>
            <li><img src='imagens/banner-02.jpg' border='0' /></li>
            <li><img src='imagens/banner-03.jpg' border='0' /></li>
        </ul>
        <div class="sombra"><img src='imagens/banner-sombra.png' border='0' /></div>
    </div>
<div id="comandos">
    <!--<div id="pager"></div> /pager -->
</div>
</body>
</html>