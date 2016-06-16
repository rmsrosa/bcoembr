<?php
/*
This file should contain a string with a list of cpfs separated by newlines, for the script uploadcpfs.php to insert/replace these cpfs into the database of allowedcompetidores. Example:
$cpf_string = "123.456.789-00
09876543211
102938475-66
"
The script will strip off any symbol other than digits and will complete with zeros on the left of any cpf which has less than 11 digits. Empty lines or lines with garbage or with more than 11 digits will be discarded.
*/

$acerva = "ACervA Piauí";

$cpf_string = "
"
?>