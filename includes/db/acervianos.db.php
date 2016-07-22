<?php
mysql_query("SET NAMES 'utf8'");	
$query_acerviano = "SELECT * FROM $acervianos_db_table";
if ($action == "edit")  $query_acerviano .= " WHERE id='$id'"; else $query_acerviano .= " ORDER BY acervianoACervA,acervianoFirstName"; 
$acerviano = mysql_query($query_acerviano, $brewing) or die(mysql_error());
$row_acerviano = mysql_fetch_assoc($acerviano);
$totalRows_acerviano = mysql_num_rows($acerviano);
?>