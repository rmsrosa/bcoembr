<?php 

/*
 * Module:      process_acervianos.inc.php
 * Description: This module does all the heavy lifting for adding/editing info in the "acervianos" table
 */

//require('../paths.php');
//require(LIB.'common.lib.php');

if ((isset($_SESSION['loginUsername'])) && (isset($_SESSION['userLevel']))) {
	
	if (NHC) {
		// Place NHC SQL calls below
		
		
	}
	// end if (NHC)
	
	else {
	
		if ($action == "add") {
			$cpf = $_POST['acervianoCPF'];

			$insertSQL = sprintf("INSERT INTO $acervianos_db_table (
			acervianoFirstName, 
			acervianoLastName, 
			acervianoCPF, 
			acervianoPhone,
			acervianoACervA,
			acervianoEmail
			) 
			VALUES 
			(%s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE acervianoFirstName = VALUES(acervianoFirstName), acervianoLastName = VALUES(acervianoLastName), acervianoPhone=VALUES(acervianoPhone), acervianoEmail = VALUES(acervianoEmail)",
							   GetSQLValueString(capitalize($_POST['acervianoFirstName']), "text"),
							   GetSQLValueString(capitalize($_POST['acervianoLastName']), "text"),
							   GetSQLValueString(format_cpf($cpf), "text"),
							   GetSQLValueString($_POST['acervianoPhone'], "text"),
							   GetSQLValueString($_POST['acervianoACervA'], "text"),
							   GetSQLValueString(strtolower($_POST['acervianoEmail']), "text"));
//			echo $insertSQL;				   
			mysql_select_db($database, $brewing);
			mysql_query("SET NAMES 'utf8'");
			mysql_real_escape_string($insertSQL);
			$result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());
			$pattern = array('\'', '"');
			$insertGoTo = str_replace($pattern, "", $insertGoTo); 
			header(sprintf("Location: %s", stripslashes($insertGoTo)));
		}

		elseif ($action == "bulkadd") {
			
			$acervianosACervA = GetSQLValueString($_POST['acervianosACervA'], "text");
			$acervianos_string = $_POST['acervianoslist'];

			$checkacervianoFirstName = $_POST['checkacervianoFirstName'];
			$checkacervianoLastName = $_POST['checkacervianoLastName'];
			$checkacervianoPhone = $_POST['checkacervianoPhone'];
			$checkacervianoEmail = $_POST['checkacervianoEmail'];
			
			$anycheck = $checkacervianoFirstName || $checkacervianoLastName || $checkacervianoPhone || $checkacervianoEmail;			
			
			$acervianos_array = explode("\n", $acervianos_string);
			$acervianos_array = array_filter($acervianos_array);
			$acervianos_array = array_unique($acervianos_array);

//			var_dump($cpf_array);

			if ($anycheck) {

				$acervianosIndex = -1;
				if ($checkacervianoFirstName) {
					$acervianosIndex += 1;
					$insertFirstNamePre = "acervianoFirstName,";
					$insertFirstNamePos = "acervianoFirstName=VALUES(acervianoFirstName),";
					$FirstNameIndex = $acervianosIndex;
				}
				else {
					$insertFirstNamePre = "";
					$inserFirstNamePos = "";					
				}
				if ($checkacervianoLastName) {
					$acervianosIndex += 1;
					$insertLastNamePre = "acervianoLastName,";
					$insertLastNamePos = "acervianoLastName=VALUES(acervianoLastName),";
					$LastNameIndex = $acervianosIndex;
				}
				else {
					$insertLastNamePre = "";
					$insertLastNamePos = "";					
				}
				$acervianosIndex += 1;
				$insertCPFPre = "acervianoCPF,";
				$CPFIndex = $acervianosIndex;
				if ($checkacervianoPhone) {
					$acervianosIndex += 1;
					$insertPhonePre = "acervianoPhone,";
					$insertPhonePos = "acervianoPhone=VALUES(acervianoPhone),";
					$PhoneIndex = $acervianosIndex;
				}
				else {
					$insertPhonePre = "";
					$insertPhonePos = "";					
				}				
				if ($checkacervianoEmail) {
					$acervianosIndex += 1;
					$insertEmailPre = "acervianoEmail,";
					$insertEmailPos = "acervianoEmail=VALUES(acervianoEmail),";
					$EmailIndex = $acervianosIndex;
				}
				else {
					$insertEmailPre = "";
					$insertEmailPos = ",";					
				}				
				
				$insertSQL = "INSERT INTO $acervianos_db_table (".$insertFirstNamePre.$insertLastNamePre.$insertCPFPre.$insertPhonePre.$insertEmailPre."acervianoACervA) VALUES ";

				foreach ($acervianos_array as $acerviano_string) {

					$acerviano_array = explode(",", $acerviano_string);
					$acerviano_array = array_filter($acerviano_array);
//					print_r($acerviano_array);
					
					if (count($acerviano_array) == $acervianosIndex+1) {

						if ($checkacervianoFirstName) $acervianoFirstName = GetSQLValueString(trim($acerviano_array[$FirstNameIndex]),"text").","; else $acervianoFirstName = "";
						if ($checkacervianoLastName) $acervianoLastName = GetSQLValueString(trim($acerviano_array[$LastNameIndex]),"text").","; else $acervianoLastName = "";
						if ($checkacervianoPhone) $acervianoPhone = GetSQLValueString(trim($acerviano_array[$PhoneIndex]),"text").","; else $acervianoPhone = "";	
						if ($checkacervianoEmail) $acervianoEmail = GetSQLValueString(trim($acerviano_array[$EmailIndex]),"text").","; else $acervianoEmail = "";

						$cpf = $acerviano_array[$CPFIndex];

						if ($cpf) {
							$cpf = format_cpf($cpf);
							$acervianoCPF = "'".$cpf."',";
							$insertSQL .= " (".$acervianoFirstName.$acervianoLastName.$acervianoCPF.$acervianoPhone.$acervianoEmail.$acervianosACervA."),";
						}
					}
				}

				$insertSQL = rtrim($insertSQL,',');

				$insertSQL  .= " ON DUPLICATE KEY UPDATE ".$insertFirstNamePos.$insertLastNamePos.$insertPhonePos.$insertEmailPos;
				$insertSQL = rtrim($insertSQL,',');

			}
					
			else {

				$insertSQL = "REPLACE INTO $acervianos_db_table ( 
				acervianoCPF, 
				acervianoACervA
				) 
				VALUES";

				foreach ($acervianos_array as $cpf) {
					$cpf = trim($cpf);
					if ($cpf) {
						$cpf = format_cpf($cpf);
						$insertSQL .= " ('".$cpf."',".$acervianosACervA."),";
					}
				}
				$insertSQL = rtrim($insertSQL,',');
			}
						
//			echo $insertSQL;				   
			mysql_select_db($database, $brewing);
			mysql_query("SET NAMES 'utf8'");
			mysql_real_escape_string($insertSQL);
			$result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());

			$pattern = array('\'', '"');
			$massUpdateGoTo = str_replace($pattern, "", $massUpdateGoTo); 
			header(sprintf("Location: %s", stripslashes($massUpdateGoTo)));

		}		

		elseif ($action == "bulkdelete") {

			$cpf_acerva = GetSQLValueString($_POST['acervianosACervA'], "text");
			$cpf_string = $_POST['acervianosCPFs'];
			$cpf_array = explode("\n", $cpf_string);
			$cpf_array = array_filter($cpf_array);
			$cpf_array = array_unique($cpf_array);

			$insertSQL = "DELETE FROM $acervianos_db_table WHERE acervianoACervA = ".$cpf_acerva." AND acervianoCPF IN (";

			foreach ($cpf_array as $cpf) {
				$cpf = trim($cpf);
				if ($cpf) {
					$insertSQL .= GetSQLValueString(format_cpf($cpf), "text").",";
				}
			}

			$insertSQL = rtrim($insertSQL,',');
			$insertSQL .= ')';
			
//			echo $insertSQL;				   
			mysql_select_db($database, $brewing);
			mysql_query("SET NAMES 'utf8'");
			mysql_real_escape_string($insertSQL);
			$result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());
			$pattern = array('\'', '"');
			$massUpdateGoTo = str_replace($pattern, "", $massUpdateGoTo); 

			header(sprintf("Location: %s", stripslashes($massUpdateGoTo)));
			
		}
		
		
		elseif ($action == "edit") {
			$cpf = $_POST['acervianoCPF'];

			$updateSQL = sprintf("UPDATE $acervianos_db_table SET 
			acervianoFirstName=%s, 
			acervianoLastName=%s, 
			acervianoCPF=%s, 
			acervianoPhone=%s,
			acervianoACervA=%s,
			acervianoEmail=%s
			WHERE id=%s",
							   GetSQLValueString(capitalize($_POST['acervianoFirstName']), "text"),
							   GetSQLValueString(capitalize($_POST['acervianoLastName']), "text"),
							   GetSQLValueString(format_cpf($cpf), "text"),
							   GetSQLValueString($_POST['acervianoPhone'], "text"),
							   GetSQLValueString($_POST['acervianoACervA'], "text"),
							   GetSQLValueString(strtolower($_POST['acervianoEmail']), "text"),
							   GetSQLValueString($id, "int"));
							   
			mysql_select_db($database, $brewing);
			mysql_query("SET NAMES 'utf8'");
			mysql_real_escape_string($updateSQL);
			$result1 = mysql_query($updateSQL, $brewing) or die(mysql_error());
			$pattern = array('\'', '"');
			$updateGoTo = str_replace($pattern, "", $updateGoTo); 
			header(sprintf("Location: %s", stripslashes($updateGoTo)));
			
		}
	
	} // end else NHC

} 

else echo "<p>Not available.</p>";


?>