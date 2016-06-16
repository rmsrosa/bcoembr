<?php
if(isset($_POST['user_name'])) {
	$user_name = strtolower($_POST['user_name']);
	include('../paths.php');
	include(CONFIG.'config.php');  
	include(INCLUDES.'url_variables.inc.php');
	include(INCLUDES.'db_tables.inc.php');
	include(LIB.'common.lib.php');
	
	mysql_select_db($database, $brewing);
	
	if (NHC) { 
		
	}
	else {
		$sql_check = mysql_query("SELECT user_name FROM ".$users_db_table." WHERE user_name='".$user_name."'");
		if (mysql_num_rows($sql_check)) echo "<span class=\"text-danger\"><span class=\"glyphicon glyphicon-exclamation-sign\"></span> O endereço de email informado já está em uso. Por favor, escolha outro.</span>";
		else echo "<span class=\"text-success\"><span class=\"glyphicon glyphicon-ok\"></span> O endereço de email informado ainda não está cadastrado.</span>";
	} // end else NHC
}
?>