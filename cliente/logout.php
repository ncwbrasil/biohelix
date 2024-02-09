<?php
require_once("../mod_includes/php/ctracker.php");
session_start (); 
$pagina = $_GET['pagina'];
if($pagina == 'logout')
{
	unset($_SESSION['biohelix_cliente']);
	session_write_close();
	echo "<SCRIPT LANGUAGE='JavaScript'>
			window.location.href = '../index.php';
		  </SCRIPT>";
}

?>
