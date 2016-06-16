<?php
/*
This script is to add/update the list of cpfs of the allowed participants (e.g. members of the ACervAs). This script must be ran separately and directly, not from inside the system. This can actually be removed from the server and executed locally, if preferred.
*/

header('Content-Type: text/html; charset=utf-8');

$hostname = "";
$username = "";
$password = "";
$database = "";

$connection = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error());

/* The following string should contain a list of cpf numbers to be removed from the database, each cpf in a separate line. Example:
$cpf_string = "12345678900
09876543211
10293847566
"
*/

$cpf_remove_string = "
";

$cpf_remove_array = explode("\n", $cpf_remove_string);

$cpf_remove_array = array_filter($cpf_remove_array);

$cpf_remove_array = array_unique($cpf_remove_array);
	
echo count($cpf_remove_array)." linhas distintas na string.<br>";

$num_cpfs = 0;

$cpf_query = "DELETE FROM `allowedcompetidores` WHERE `allowedCPF` IN (";
	
foreach ($cpf_remove_array as $cpf) {
	if ($cpf != NULL) {
		$cpf = preg_replace('/[^0-9,]|,[0-9]*$/','',$cpf);
		if (strlen($cpf) < 11)	{
			$len = 11 - strlen($cpf);
			for ($i=1; $i <= $len; $i++) {
				$cpf = "0".$cpf;
			}
		};
		if (strlen($cpf) != 11) echo " Warning: cpf com mais de  11 digitos!!<br>";
		else {
			$cpf_query .= "'".$cpf."', ";
			$num_cpfs += 1;
			$cpf_total_array[] = $cpf;
		}
	}
}
	
echo $num_cpfs." cpfs válidos.<br>";

$cpf_query = rtrim($cpf_query,', ');

$cpf_query .=")";

//echo $cpf_query;

mysql_select_db($database, $connection);

echo "<br>".mysql_affected_rows($connection)."<br>";

$result = mysql_query($cpf_query, $connection) or die(mysql_error());

echo mysql_info($connection)."<br><br><br>";

mysql_close($connection);

?>