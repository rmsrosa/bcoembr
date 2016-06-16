<?php 
/**
 * Module:      volunteers.sec.php 
 * Description: This module displays the public-facing competition volunteers
 *              specified in the contest_info database table. 
 * 
 */
 
/* ---------------- PUBLIC Pages Rebuild Info ---------------------

Beginning with the 1.3.0 release, an effort was begun to separate the programming
layer from the presentation layer for all scripts with this header.

All Public pages have certain variables in common that build the page:

	$warningX = any warnings
  
	$primary_page_info_vol = any information related to the page
	
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
	$primary_page_info_vol = "";
	$header_vol_1_1 = "";
	$page_info_vol_1 = "";
	$header_vol_1_2 = "";
	$page_info_vol_2 = "";
	
	etc., etc., etc.

 * ---------------- END Rebuild Info --------------------- */


 
$primary_page_info_vol = "";
$header_vol_1_1 = "";
$page_info_vol_1 = "";
$header_vol_1_2 = "";
$page_info_vol_2 = "";
$header_vol_1_3 = "";
$page_info_vol_3 = "";

$header_vol_1_1 .= "<h2>Juízes e Auxiliares</h2>";
if (($judge_window_open > 0) && (!$logged_in)) { 
	$page_info_vol_1 .= sprintf("<p>Se você <em>está</em> registrado no sistema, faça o <a href=\"%s\">log in</a> e escolha <em>Editar Conta</em> no menu Minha Conta indicado pelo ícone <span class=\"fa fa-user\"></span> no topo do menu.</p>",build_public_url("login","default","default","default",$sef,$base_url));
	if ($registration_open < 2) $page_info_vol_1 .= sprintf("<p>Se você <em>não</em> está registrado no sistema e gostaria de ser Juiz ou Auxiliar, <a href=\"%s\">por favor registre-se</a>.</p>",build_public_url("register","judge","default","default",$sef,$base_url));
}

elseif (($judge_window_open > 0) && ($logged_in)) {
	$page_info_vol_1 .= sprintf("<p>Como você já está registrado, <a href=\"%s\">acesse a sua conta</a> para ver se você já se ofereceu para ser Juiz ou Auxiliar.</p>",build_public_url("list","default","default","default",$sef,$base_url));
}

else {
	$page_info_vol_1 .= sprintf("<p>Se você gostaria de ser Juiz ou Auxiliar, por favor faça o registro a partir de %s.</p>",getTimeZoneDateTime($_SESSION['prefsTimeZone'], $row_contest_dates['contestJudgeOpen'], $_SESSION['prefsDateFormat'],  $_SESSION['prefsTimeFormat'], "long", "date-time"));
}

if ($registration_open < 2) {
$header_vol_1_2 .= "<h2>Equipe</h2>";
$page_info_vol_2 .= sprintf("<p>Se você gostaria de se oferecer para participar como ajudante na equipe da competição, <a href=\"%s\">entre em contato</a> com os organizadores.", build_public_url("contact","default","default","default",$sef,$base_url));
}

if (!empty($row_contest_info['contestVolunteers'])) {
	$header_vol_1_3 .= "<h2>Outras Informações</h2>";
	$page_info_vol_3 .= $row_contest_info['contestVolunteers'];
}

// --------------------------------------------------------------
// Display
// --------------------------------------------------------------
if (($action != "print") && ($msg != "default")) echo $msg_output;
//if ((($_SESSION['contestLogo'] != "") && (file_exists($_SERVER['DOCUMENT_ROOT'].$sub_directory.'/user_images/'.$_SESSION['contestLogo']))) && ((judging_date_return() > 0) || (NHC))) echo $competition_logo;
//if ($action != "print") echo $print_page_link;

echo $header_vol_1_1;
echo $page_info_vol_1;
echo $header_vol_1_2;
echo $page_info_vol_2;
echo $header_vol_1_3;
echo $page_info_vol_3;
?>

