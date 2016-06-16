<?php 
/**
 * Module:      reg_open.sec.php
 * Description: This module houses information regarding registering for the competition,
 *              judging dates, etc. Shown while the registration window is open.
 *
 */
/* ---------------- PUBLIC Pages Rebuild Info ---------------------

Beginning with the 1.3.0 release, an effort was begun to separate the programming
layer from the presentation layer for all scripts with this header.

All Public pages have certain variables in common that build the page:

	$warningX = any warnings
  
	$primary_page_info = any information related to the page
	
	$header1_X = an <h2> header on the page
	$header2_X = an <h3> subheader on the page
	
	$page_infoX = the bulk of the information on the page.
	$help_page_link = link to the appropriate page on help.brewcompetition.com
	$print_page_link = the "Print This Page" link
	$competition_logo = display of the competition's logo
	
	$labelX = the various labels in a table or on a form
	$messageX = various messages to display
	
	$print_page_link = "<p><span class='icon'><img src='".$base_url."images/printer.png' border='0' alt='Print' title='Print' /></span><a id='modal_window_link' class='data' href='".$base_url."output/print.php?section=".$section."&amp;action=print' title='Print'>Print This Page</a></p>";
	$competition_logo = "<img src='".$base_url."user_images/".$_SESSION['contestLogo']."' width='".$_SESSION['prefsCompLogoSize']."' style='float:right; padding: 5px 0 5px 5px' alt='Competition Logo' title='Competition Logo' />";
	
Declare all variables empty at the top of the script. Add on later...
	$warning1 = "";
	$primary_page_info = "";
	$header1_1 = "";
	$page_info1 = "";
	$header1_2 = ""; 
	$page_info2 = "";
	
	etc., etc., etc.

 * ---------------- END Rebuild Info --------------------- */

$message1 = "";
$header1_2 = ""; 
$page_info2 = "";
$header1_3 = ""; 
$page_info3 = "";
$header1_4 = ""; 
$page_info4 = "";
$header1_5 = ""; 
$page_info5 = "";
$header1_6 = ""; 
$page_info6 = "";
$header1_7 = ""; 
$page_info7 = "";
$header1_8 = ""; 
$page_info8 = "";






$header1_1 .= "<h2>O Registro de Juízes e Auxiliares está <span class='text-success'>Aberto</span></h2>"; 
if (($registration_open == "1") && (!isset($_SESSION['loginUsername']))) { 
	$page_info1 .= "<p>Se você <em>não</em> se registrou e gostaria de ser Juiz ou Auxiliar, <a href='".build_public_url("register","judge","default",$sef,$base_url)."'>por favor, faça o registro</a>.</p>";
	$page_info1 .= sprintf("<p>Se você <em>já está</em> registrado no sistema, faça o <a href=\"%s\">log in</a> e então clique em <em>Editar Conta</em> dentro da opção Minha Conta indicada pelo <span class=\"fa fa-user\"></span> ícone no topo do menu.</p>",build_public_url("login","default","default","default",$sef,$base_url));
}

elseif (($registration_open == "1") && (isset($_SESSION['loginUsername']))) { 
	$page_info1 .= "<p>Como você já está registrado no sistema, você pode <a href='".build_public_url("list","default","default","default",$sef,$base_url)."'>conferir os dados da sua conta</a> para ver se você já informou se gostaria de ser Juiz ou Auxiliar.</p>";
	$page_info1 .= "";
}
else $page_info1 .= sprintf("<p>Se você gostaria de ser Juiz ou Auxiliar nessa competição, por favor retorne para fazer o registro a partir de %s.</p>",$judge_open);


if ($entry_window_open == 1) {
	$header1_2 .= "<h2>O Período de Inscrição está <span class='text-success'>Aberto</a></h2>"; 
	$page_info2 .= "<p>";
	$page_info2 .= "Para incluir as suas amostras no sistema, ";
	if (!isset($_SESSION['loginUsername'])) $page_info2 .= "por favor vá para o <a href='".build_public_url("register","default","default","default",$sef,$base_url)."'>processo de registro</a> ou faça o <a href='".build_public_url("login","default","default","default",$sef,$base_url)."'>log in</a> se você já criou uma conta.";
	else $page_info2 .= "use o <a href='".build_public_url("brew","entry","add","default",$sef,$base_url)."'>formulário de inclusão de amostra</a>.";
	$page_info2 .= "</p>";
}

$header1_3 .= "<a name='rules'></a><h2>Regras Gerais</h2>";
$page_info3 .= $row_contest_rules['contestRules'];




// --------------------------------------------------------------
// Display
// --------------------------------------------------------------

echo $header1_2;
echo $page_info2;
echo $header1_1;
echo $page_info1;

echo $header1_3;
echo $page_info3;
echo $header1_4;
echo $page_info4;
echo $header1_5;
echo $page_info5;
echo $header1_6;
echo $page_info6;
echo $header1_6;
echo $page_info7;
echo $header1_8;
echo $page_info8;



?>