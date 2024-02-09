<?php
include('connect.php');
$exa_id = $_POST['exa_id'];
$sqlprocura = "SELECT * FROM exames WHERE exa_id = '$exa_id'";
$queryprocura = mysql_query($sqlprocura, $conexao);
$rowsprocura = mysql_num_rows($queryprocura);
if($rowsprocura>0)
{
	while($row = mysql_fetch_array($queryprocura) )
	{
		echo $row['exa_conteudo2'];
	}
}
else
{
	echo "Selecione um tipo de laudo.";
}
?>