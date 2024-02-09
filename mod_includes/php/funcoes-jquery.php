<script language="javascript">
function carregaBuscaCliente(valor, id)
{
	jQuery("#lau_cliente").val('');
	jQuery("#lau_cliente").val(valor);
	jQuery("#lau_cliente_id").val(id);
	jQuery('#suggestions').hide();
	jQuery("#autoSuggestionsList").html("");
	
}
function ativaItem (id)
{
	if(jQuery("#item_check_"+id).is(':checked'))
	{
		jQuery("#item_"+id).removeAttr('disabled');
	}
	else
	{
		jQuery("#item_"+id).val('');
		jQuery("#item_"+id).attr('disabled', true);
	}
}
jQuery(document).ready(function()
{
	jQuery("input[name=lau_cliente]").keyup(function()
	{
			
		jQuery.post("../mod_includes/php/procura_cliente.php",
		{
			busca:jQuery(this).val()
			
		},
		function(valor) // Carrega o resultado acima para o campo catadm
		{
			if(jQuery("#lau_cliente").val() != "")
			{
				jQuery('#suggestions').show();
				jQuery("#autoSuggestionsList").html(valor);
			}
			else
			{
				
				jQuery("#autoSuggestionsList").html("");
				jQuery('#suggestions').hide();
				
			}
		});
	});
	
	jQuery(".toggle_container").hide();
 	jQuery(".toggle_container_info").show();
 
	jQuery("h2.trigger").click(function(){
		jQuery(this).toggleClass("active").next().slideToggle("slow");
		return false;
	});
	jQuery("#fti_imagem").change(function()
	{
		/*var erro_n;
		for(i=0;i<20;i++)
		{
			var oFile = jQuery('#fti_imagem')[0].files[i];
			if (oFile.size > 1024 * 1024) 
			{
				alert(jQuery('#fti_imagem')[0].files[i].width());
				erro_n=1;
			}
			
		}
		if(erro_n == 1)
		{
			alert("aaa");
		}*/
		
		var files = this.files; // SELECIONA OS ARQUIVOS
    	var qtde = files.length; // CONTA QUANTOS TEM
		if(qtde > 20)
		{
			abreMask(
			'<img src=../imagens/x.gif> Você deve selecionar no máximo 20 fotos.<br><br>'+
			'<input value="Ok" type="button" class="close_janela" >' );
			jQuery("#bt_add_fotos").attr("disabled", true);
		}
		else
		{
			jQuery("#bt_add_fotos").removeAttr("disabled");
		}
		
		
	});
	jQuery("#ftl_imagem").change(function()
	{
		/*var erro_n;
		for(i=0;i<20;i++)
		{
			var oFile = jQuery('#fti_imagem')[0].files[i];
			if (oFile.size > 1024 * 1024) 
			{
				alert(jQuery('#fti_imagem')[0].files[i].width());
				erro_n=1;
			}
			
		}
		if(erro_n == 1)
		{
			alert("aaa");
		}*/
		
		var files = this.files; // SELECIONA OS ARQUIVOS
    	var qtde = files.length; // CONTA QUANTOS TEM
		if(qtde > 20)
		{
			abreMask(
			'<img src=../imagens/x.gif> Você deve selecionar no máximo 20 fotos.<br><br>'+
			'<input value="Ok" type="button" class="close_janela" >' );
			jQuery("#bt_add_fotos").attr("disabled", true);
		}
		else
		{
			jQuery("#bt_add_fotos").removeAttr("disabled");
		}
		
		
	});
	/* DIV LOGOUT */
	jQuery('input.close_janela').live('click', function() { 
		jQuery('#mask , .janela').fadeOut(100 , function() {
			jQuery('.janela').fadeOut(100 , function() {
			jQuery('#mask').remove();  
			jQuery('body').css({'overflow':'visible'});
			});
		}); 
		return false;
	});
	/* FIM DIV LOGOUT */
	

	/*----------- VERIFICAÇÃO FORMULÁRIO --------------*/
	
	jQuery("#bt_admins").click(function()
	{
		admins=0;
		if(jQuery("#adm_nome").val() == '' || jQuery("#adm_nome").val() == 'Nome')
		{
			admins++;
			jQuery("#adm_nome").css({"border" : "1px solid #F90F00"});
			jQuery('#adm_nome_erro').html("Digite o nome");	
		}
		if(jQuery("#adm_login").val() == '' || jQuery("#adm_login").val() == 'Login')
		{
			admins++;
			jQuery("#adm_login").css({"border" : "1px solid #F90F00"});
			jQuery('#adm_login_erro').html("Digite o login");	
		}
		if(jQuery("#adm_senha").val() == '' || jQuery("#adm_senha").val() == 'Senha')
		{
			admins++;
			jQuery("#adm_senha").css({"border" : "1px solid #F90F00"});
			jQuery('#adm_senha_erro').html("Digite a senha");	
		}
		if(admins == 0)
		{
			jQuery("#form_admins").submit();
		}
	});
	jQuery("#bt_clientes").click(function()
	{
		clientes=0;
		if(jQuery("#cli_nome").val() == '')
		{
			clientes++;
			jQuery("#cli_nome").css({"border" : "1px solid #F90F00"});
			jQuery('#cli_nome_erro').html("Digite o nome");	
		}
		else
		{
			jQuery("#cli_nome").css({"border" : "1px solid #CCC"});
			jQuery('#cli_nome_erro').html("&nbsp;");
		}
		if(jQuery("#cli_data_nasc").val() == '')
		{
			clientes++;
			jQuery("#cli_data_nasc").css({"border" : "1px solid #F90F00"});
			jQuery('#cli_data_nasc_erro').html("Digite a data de nasc.");	
		}
		if(jQuery("#cli_sexo").val() == '')
		{
			clientes++;
			jQuery("#cli_sexo").css({"border" : "1px solid #F90F00"});
			jQuery('#cli_sexo_erro').html("Selecione o sexo");	
		}
		
		if(clientes == 0)
		{
			jQuery("#form_clientes").submit();
		}
	});
	jQuery("#bt_exames").click(function()
	{
		exames=0;
		if(jQuery("#exa_nome").val() == '')
		{
			exames++;
			jQuery("#exa_nome").css({"border" : "1px solid #F90F00"});
			jQuery('#exa_nome_erro').html("Digite o nome do tipo de laudo");	
		}
		else
		{
			jQuery("#exa_nome").css({"border" : "1px solid #CCC"});
			jQuery('#exa_nome_erro').html("&nbsp;");
		}
		if(exames == 0)
		{
			jQuery("#form_exames").submit();
		}
	});
	
	jQuery("#bt_laudos").click(function()
	{
		laudos=0;
		if(jQuery("#lau_cliente").val() == '')
		{
			laudos++;
			jQuery("#lau_cliente").css({"border" : "1px solid #F90F00"});
			jQuery('#lau_cliente_erro').html("Selecione um cliente");	
		}
		else
		{
			jQuery("#lau_cliente").css({"border" : "1px solid #CCC"});
			jQuery('#lau_cliente_erro').html("&nbsp;");
		}
		if(jQuery("#lau_tipo_laudo").val() == '')
		{
			laudos++;
			jQuery("#lau_tipo_laudo").css({"border" : "1px solid #F90F00"});
			jQuery('#lau_tipo_laudo_erro').html("Selecione um tipo de laudo");	
		}
		else
		{
			jQuery("#lau_tipo_laudo").css({"border" : "1px solid #CCC"});
			jQuery('#lau_tipo_laudo_erro').html("&nbsp;");
		}
		if(jQuery("#lau_data_liberacao").val() == '' && jQuery("#lau_status1").is(':checked'))
		{
			laudos++;
			jQuery("#lau_data_liberacao").css({"border" : "1px solid #F90F00"});
			jQuery('#lau_data_liberacao_erro').html("Digite a data de liberação");	
		}
		else
		{
			jQuery("#lau_data_liberacao").css({"border" : "1px solid #AAA"});
			jQuery('#lau_data_liberacao_erro').html("&nbsp;");
		}
		if(tinyMCE.get('lau_resultado').getContent() == '' && jQuery("#lau_status1").is(':checked'))
		{
			laudos++;
			jQuery("#lau_resultado").css({"border" : "1px solid #F90F00"});
			jQuery('#lau_resultado_erro').html("Digite o resultado");	
		}
		else
		{
			jQuery("#lau_resultado").css({"border" : "1px solid #AAA"});
			jQuery('#lau_resultado_erro').html("&nbsp;");
		}
		if(laudos == 0)
		{
			jQuery("#form_laudos").submit();
		}
	});
	
	jQuery("select[name=lau_tipo_laudo]").change(function()
	{
		jQuery("#lau_conteudo").val('Carregando...');
		jQuery.post("../mod_includes/php/procura_laudo.php",
		{
			exa_id:jQuery(this).val()
			
		},
		function(valor) // Carrega o resultado acima para o campo catadm
		{
			tinyMCE.get('lau_conteudo').setContent(valor);
			//jQuery("#lau_conteudo").val();
		});
		
		jQuery("#lau_resultado").val('Carregando...');
		jQuery.post("../mod_includes/php/procura_resultado.php",
		{
			exa_id:jQuery(this).val()
			
		},
		function(valor) // Carrega o resultado acima para o campo catadm
		{
			//tinyMCE.activeEditor.setContent(valor);
			//jQuery("#lau_resultado").val(valor);
			tinyMCE.get('lau_resultado').setContent(valor);
		});
		
		jQuery("#lau_conteudo2").val('Carregando...');
		jQuery.post("../mod_includes/php/procura_laudo2.php",
		{
			exa_id:jQuery(this).val()
			
		},
		function(valor) // Carrega o resultado acima para o campo catadm
		{
			tinyMCE.get('lau_conteudo2').setContent(valor);
			//jQuery("#lau_conteudo").val();
		});
		
	});
	/*------------------- FIM VERIFICAÇÃO FORMULÁRIO ----------------------*/
});

/* --------- FUNCOES GERAIS  ------------ */
function selecionaPlano(pla_id,pla_valor)
{
	jQuery("#pla_id").val(pla_id);
	jQuery("#destaques").css({"display":""});
	
	jQuery("#anu_valor_plano").val(pla_valor);
	
	for(i=1; i < 6; i++)
	{
		jQuery("#assinar_dest"+i).css({"background-color":"#2F489C"});
		jQuery("#dest_nome"+i).css({"background-color":"#2F489C"});
		jQuery("#dest_ext"+i).removeClass("zoom");
		
		if(i == pla_id)
		{
			jQuery("#assinar"+pla_id).css({"background-color":"#F90F00"});
			jQuery("#plano_nome"+pla_id).css({"background-color":"#F90F00"});
			jQuery("#plano_ext"+pla_id).addClass("zoom");
		}
		else
		{
			jQuery("#assinar"+i).css({"background-color":"#2F489C"});
			jQuery("#plano_nome"+i).css({"background-color":"#2F489C"});
			jQuery("#plano_ext"+i).removeClass("zoom");
			jQuery("#plano_ext"+i).addClass("normal");
		}
	}
	
	
	
	jQuery.post("../mod_includes/php/calcula_total.php",
	{
		pla_id:pla_id
		
	},
	function(valor) // Carrega o resultado acima para o campo catadm
	{
		jQuery("#total").val(valor.replace(".", ","));
	});
	for(x=1;x<4;x++)
	{
		jQuery("#anu_destaque"+x).attr("checked", false);
	}
}
function selecionaDestaque(des_id)
{

	if(jQuery("#anu_destaque"+des_id).is(':checked'))
	{
		jQuery("#anu_destaque"+des_id).attr('checked', false)
		jQuery("#assinar_dest"+des_id).css({"background-color":"#2F489C"});
		jQuery("#dest_nome"+des_id).css({"background-color":"#2F489C"});
		jQuery("#dest_ext"+des_id).removeClass("zoom");
		jQuery("#dest_ext"+des_id).addClass("normal");
		jQuery.post("../mod_includes/php/calcula_destaque.php",
		{
			des_id:des_id
		},
		function(valor) // Carrega o resultado acima para o campo catadm
		{
			jQuery("#total").val((parseFloat(jQuery("#total").val().replace(",","."))-parseFloat(valor)).toFixed(2).replace(".", ","));
			jQuery("#des_valor"+des_id).val('');
			jQuery("#destaque"+des_id).css({"display":"none"});
		});
	}
	else
	{
		jQuery("#anu_destaque"+des_id).attr('checked', true)
		jQuery("#assinar_dest"+des_id).css({"background-color":"#F90F00"});
		jQuery("#dest_nome"+des_id).css({"background-color":"#F90F00"});
		jQuery("#dest_ext"+des_id).removeClass("normal");
		jQuery("#dest_ext"+des_id).addClass("zoom");
		jQuery.post("../mod_includes/php/calcula_destaque.php",
		{
			des_id:des_id
		},
		function(valor) // Carrega o resultado acima para o campo catadm
		{	
			jQuery("#total").val((parseFloat(jQuery("#total").val().replace(",","."))+parseFloat(valor)).toFixed(2).replace(".", ","));
			jQuery("#des_valor"+des_id).val(jQuery("#des_valor_"+des_id).val());
			jQuery("#destaque"+des_id).css({"display":""});
		});
		
	}
}
function link_mask(url)
{
	document.location.href=url;
}

function abreMask (msg)
{
	
	
	jQuery('body').append('<div id="mask"></div>');
	jQuery('#mask').fadeIn(300);
	jQuery('#janela').html(msg);
	jQuery("#janela").fadeIn(300);
	jQuery('#janela').css({"display":""});
	//jQuery('body').css({'overflow':'hidden'});
	
	var popMargTopJanela = (jQuery("#janela").height() + 24) / 2; 
	var popMargLeftJanela = (jQuery("#janela").width() + 24) / 2; 
	
	jQuery("#janela").css({ 
		'margin-top' : -popMargTopJanela,
		'margin-left' : -popMargLeftJanela
	});
}
function descricaoPlano (msg)
{
	jQuery('body').append('<div id="mask"></div>');
	//jQuery('#mask').fadeIn(300);
	jQuery('#janela_plano').html(msg);
	jQuery("#janela_plano").fadeIn(300);
	jQuery('#janela_plano').css({"display":""});
	//jQuery('body').css({'overflow':'hidden'});
	
	var popMargTopJanela = (jQuery("#janela_plano").height() + 24) / 2; 
	var popMargLeftJanela = (jQuery("#janela_plano").width() + 24) / 2; 
	
	jQuery("#janela_plano").css({ 
		'margin-top' : -popMargTopJanela,
		'margin-left' : -popMargLeftJanela
	});
}
/*jQuery('input.close_janela, #mask').live('click', function() { 
	jQuery('#mask , .janela_plano').fadeOut(100 , function() {
		jQuery('#mask').remove();  
		jQuery('body').css({'overflow':'visible'});
	}); 
	return false;
});*/
function PrintDiv(div)
{
	$('#'+div).show().printElement();
}

function submitenter(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		jQuery("#form_newsletter").submit();
		return false;
	}
	else
	return true;
} 	
		
	function sleep(milliseconds)
	{
		setTimeout(function(){
		var start = new Date().getTime();
		while ((new Date().getTime() - start) < milliseconds){
		// Do nothing
		}
		},0);
	}
	
	function blink(selector)
	{
		jQuery(selector).fadeOut('slow', function() {
			jQuery(this).fadeIn('slow', function() {
				blink(this);
			});
		});
	}
	blink('.piscar');
	
	function validaCPF(cpf)
	{
		cpf = cpf.replace(".", "");
		cpf = cpf.replace(".", "");
		cpf = cpf.replace("-", "");
	
		  var numeros, digitos, soma, i, resultado, digitos_iguais;
		  digitos_iguais = 1;
		  if (cpf.length < 11)
				return false;
		  for (i = 0; i < cpf.length - 1; i++)
				if (cpf.charAt(i) != cpf.charAt(i + 1))
					  {
					  digitos_iguais = 0;
					  break;
					  }
		  if (!digitos_iguais)
				{
				numeros = cpf.substring(0,9);
				digitos = cpf.substring(9);
				soma = 0;
				for (i = 10; i > 1; i--)
					  soma += numeros.charAt(10 - i) * i;
				resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
				if (resultado != digitos.charAt(0))
					   return false;
				numeros = cpf.substring(0,10);
				soma = 0;
				for (i = 11; i > 1; i--)
					  soma += numeros.charAt(11 - i) * i;
				resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
				if (resultado != digitos.charAt(1))
					  return false;
				return true;
				}
		  else
				return false;
	}
	
	function validaCNPJ(cnpj)
	{
		//cpf = cpf.replace(".", "");
		//cpf = cpf.replace(".", "");
		//cpf = cpf.replace("-", "");
	
		 cnpj = cnpj.replace(/[^\d]+/g,'');
	 
		if(cnpj == '') return false;
		 
		if (cnpj.length != 14)
			return false;
	 
		// Elimina CNPJs invalidos conhecidos
		if (cnpj == "00000000000000" || 
			cnpj == "11111111111111" || 
			cnpj == "22222222222222" || 
			cnpj == "33333333333333" || 
			cnpj == "44444444444444" || 
			cnpj == "55555555555555" || 
			cnpj == "66666666666666" || 
			cnpj == "77777777777777" || 
			cnpj == "88888888888888" || 
			cnpj == "99999999999999")
			return false;
			 
		// Valida DVs
		tamanho = cnpj.length - 2
		numeros = cnpj.substring(0,tamanho);
		digitos = cnpj.substring(tamanho);
		soma = 0;
		pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--) {
		  soma += numeros.charAt(tamanho - i) * pos--;
		  if (pos < 2)
				pos = 9;
		}
		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if (resultado != digitos.charAt(0))
			return false;
			 
		tamanho = tamanho + 1;
		numeros = cnpj.substring(0,tamanho);
		soma = 0;
		pos = tamanho - 7;
		for (i = tamanho; i >= 1; i--) {
		  soma += numeros.charAt(tamanho - i) * pos--;
		  if (pos < 2)
				pos = 9;
		}
		resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if (resultado != digitos.charAt(1))
			  return false;
			   
		return true;
	}
	
	function validaRG(numero)
	{
		numero = numero.replace(".", "");
		numero = numero.replace(".", "");
		numero = numero.replace("-", "");
		/*
		##  Igor Carvalho de Escobar
		##    www.webtutoriais.com
		##   Java Script Developer
		*/
		var numero = numero.split("");
		tamanho = numero.length;
		vetor = new Array(tamanho);
	 
		if(tamanho>=1)
		{
		 vetor[0] = parseInt(numero[0]) * 2; 
		}
		if(tamanho>=2){
		 vetor[1] = parseInt(numero[1]) * 3; 
		}
		if(tamanho>=3){
		 vetor[2] = parseInt(numero[2]) * 4; 
		}
		if(tamanho>=4){
		 vetor[3] = parseInt(numero[3]) * 5; 
		}
		if(tamanho>=5){
		 vetor[4] = parseInt(numero[4]) * 6; 
		}
		if(tamanho>=6){
		 vetor[5] = parseInt(numero[5]) * 7; 
		}
		if(tamanho>=7){
		 vetor[6] = parseInt(numero[6]) * 8; 
		}
		if(tamanho>=8){
		 vetor[7] = parseInt(numero[7]) * 9; 
		}
		if(tamanho>=9){
			if(numero[8] == 'x')
			{
				vetor[8] = 10*100;
			}
			else
			{
				vetor[8] = parseInt(numero[8]) * 100;
			}
		}
		 
		 total = 0;
		 
		if(tamanho>=1){
		 total += vetor[0];
		}
		if(tamanho>=2){
		 total += vetor[1]; 
		}
		if(tamanho>=3){
		 total += vetor[2]; 
		}
		if(tamanho>=4){
		 total += vetor[3]; 
		}
		if(tamanho>=5){
		 total += vetor[4]; 
		}
		if(tamanho>=6){
		 total += vetor[5]; 
		}
		if(tamanho>=7){
		 total += vetor[6];
		}
		if(tamanho>=8){
		 total += vetor[7]; 
		}
		if(tamanho>=9){
		 total += vetor[8]; 
		}
		 
		 alert(total);
		 resto = total % 11;
		if(resto!=0){
		return false;
		}
		else{
		return true;
		}
	}
</script>