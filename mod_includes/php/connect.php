<?php
require_once("ctracker.php");
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

$ip = "localhost";
$user = "biohelix_admin"; 
$senha = "info2012mogi";
$db = "biohelix_site";

$conexao =  mysql_connect("$ip","$user","$senha");
if($conexao)
{       
	if( !  mysql_select_db("$db",$conexao)  )
	{       
		die( mysql_error($conexao)); 
	
    }
}
else
{
		die('Não foi possível conectar ao banco de dados.');     
}


$login = $_GET['login'];
$n = $_GET['n'];
$id = $_GET['id'];
$pag = $_GET['pag'];


mysql_query("SET NAMES 'utf8'");

mysql_query('SET character_set_connection=utf8');

mysql_query('SET character_set_client=utf8');

mysql_query('SET character_set_results=utf8');
?>
