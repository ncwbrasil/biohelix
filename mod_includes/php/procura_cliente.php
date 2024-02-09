<?php
include('connect.php');
?>

<?php
$busca = str_replace(".","",str_replace("-","",$_POST['busca']));
$sqlprocura = "SELECT * FROM clientes WHERE (cli_nome LIKE '%$busca%' OR cli_rg LIKE '%$busca%') ORDER BY cli_nome ASC";
$queryprocura = mysql_query($sqlprocura, $conexao);
$rowsprocura = mysql_num_rows($queryprocura);
if($rowsprocura>0)
{
	while($rowsprocura = mysql_fetch_array($queryprocura) )
	{
		echo "<input id='campo' value='&raquo; ".$rowsprocura['cli_nome']." (".implode("/",array_reverse(explode("-",$rowsprocura['cli_data_nasc']))).") - ".$rowsprocura['cli_rg']." ' name='campo' onclick='carregaBuscaCliente(this.value,\"".$rowsprocura['cli_id']."\");'><br>";
	}
	
}
else
{
	echo "<script> jQuery('#suggestions').hide();</script>"; 
	echo "";
}
?>