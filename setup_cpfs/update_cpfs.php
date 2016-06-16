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

$current_dir = getcwd() or die("Unable to get current directory.");

$cpf_files = array_diff(scandir($current_dir."/cpf_files"), array('..', '.')) or die("Unable to read files.");

//print_r($cpf_files);

//$cpf_files = array("acervacarioca", "acervagaucha", "acervabaiana", "acervacearense", "acervacandanga", "acervacapixaba", "acervaparanaense", "acervapotiguar");

echo count($cpf_files)." arquivos de cpfs encontrados.<br><br><br>";

$num_cpfs_total = 0;

$cpf_total_array = array();

foreach ($cpf_files as $cpf_file) {

	$cpf_string = "";
	
	include $current_dir."/cpf_files/".$cpf_file;
	
	$cpf_array = explode("\n", $cpf_string);

	echo $acerva.":<br><br>";
	echo count($cpf_array)." linhas na string de cpfs.<br>";

	$cpf_array = array_filter($cpf_array);
	
	echo count($cpf_array)." linhas não-nulas na string.<br>";

	$cpf_array = array_unique($cpf_array);
	
	echo count($cpf_array)." linhas distintas na string.<br>";

	$num_cpfs = 0;

	$cpf_query = "REPLACE INTO `allowedcompetidores`(`allowedCPF`) VALUES";
	
	foreach ($cpf_array as $cpf) {
		if ($cpf != NULL) {
			$cpf = preg_replace('/[^0-9,]|,[0-9]*$/','',$cpf);
			if (strlen($cpf) < 11)	{
//				echo " Fix: ";
				$len = 11 - strlen($cpf);
				for ($i=1; $i <= $len; $i++) {
					$cpf = "0".$cpf;
//					echo " i = ".$i.", added 0, up to 11 - strlen(cpf) = ".;
				}
			};
//			echo "array element = ".$cpf.", length = ".strlen($cpf); 
			if (strlen($cpf) != 11) echo " Warning: cpf com mais de  11 digitos!!<br>";
			else {
				$cpf_query .= " ('".$cpf."'),";
				$num_cpfs += 1;
				$cpf_total_array[] = $cpf;
			}
//			else echo "<br>";
		}
//		else echo "NULL<br>";
	}
	
	$num_cpfs_total += $num_cpfs;
	
	echo $num_cpfs." cpfs válidos.<br>";

	$cpf_query = rtrim($cpf_query,',');

//	echo $cpfs_query."<br>";

	mysql_select_db($database, $connection);

	$result = mysql_query($cpf_query, $connection) or die(mysql_error());

//	echo mysql_affected_rows($connection)." linhas afetadas da tabela.<br>";
	
	echo mysql_info($connection)."<br><br><br>";
}

echo $num_cpfs_total." cpfs válidos no total.<br><br>";

$cpf_total_array = array_unique($cpf_total_array);
	
echo count($cpf_total_array)." cpfs válidos distintos no total.<br><br>";

mysql_close($connection);

?>