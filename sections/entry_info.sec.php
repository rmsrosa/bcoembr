<?php 
/**
 * Module:      entry_info.sec.php
 * Description: This module houses public-facing information including entry.
 *              requirements, dropoff, shipping, and judging locations, etc.
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

 
include(DB.'dropoff.db.php');

include(DB.'judging_locations.db.php');
include(DB.'styles.db.php');
include(DB.'entry_info.db.php');

$primary_page_info = "";

$header1_1 = "";
$page_info1 = "";

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

$header1_9 = "";
$page_info9 = "";

$header1_10 = "";
$page_info10 = "";

$header1_11 = "";
$page_info11 = "";

$header1_12 = "";
$page_info12 = "";

$header1_13 = "";
$page_info13 = "";

$header1_14 = "";
$page_info14 = "";

$header1_15 = "";
$page_info15 = "";

$header1_16 = "";
$page_info16 = "";

// Registration Window

if (!$logged_in) {
	$header1_2 .= "<a name=\"reg_window\"></a><h2>Registro de Contas</h2>";
	if ($registration_open == 0) $page_info2 .= sprintf("<p>Você poderá criar a sua conta a partir de <strong class=\"text-success\">%s</strong>, até <strong class=\"text-success\">%s</strong>.</p><p>Juízes e Auxiliares podem se registrar a partir de <strong class=\"text-success\">%s</strong> até <strong class=\"text-success\">%s</strong>.</p>", $reg_open, $reg_closed, $judge_open, $judge_closed);
	elseif ($registration_open == 1) $page_info2 .= sprintf("<p>Você pode criar a sua conta de hoje até <strong class=\"text-success\">%s</strong>.</p><p>Juízes e Auxiliares podem se registrar de hoje até <strong class=\"text-success\">%s</strong>.</p>", $reg_closed, $judge_closed);
	elseif (($registration_open == 2) && ($judge_window_open == 1)) $page_info2 .= sprintf("Registro de contas <strong class=\"text-success\">apenas para Juízes e Auxiliares</strong> aberto até %s.", $judge_closed); 
	else $page_info2 .= "<p>O registro de contas está <strong class=\"text-danger\">fechado</strong>.</p>";
}
else $page_info2 .= sprintf("<p class=\"lead\">Bem-vindo %s! <small>Veja as informações da sua conta <a href=\"%s\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Veja os detalhes da sua conta e a lista de amostras\">aqui</a>.</small></p>",$_SESSION['brewerFirstName'],build_public_url("list","default","default","default",$sef,$base_url));

// Entry Window
$header1_3 .= "<a name=\"entry_window\"></a><h2>Inclusão de Amostras</h2>";
if ($entry_window_open == 0) $page_info3 .= sprintf("<p>Você poderá incluir as suas amostras no sistema a partir de <strong class=\"text-success\">%s</strong>, até <strong class=\"text-success\">%s</strong>.</p>",$entry_open, $entry_closed);
elseif ($entry_window_open == 1) $page_info3 .= sprintf("<p>Você pode incluir as suas amostras no sistema de hoje até <strong class=\"text-success\">%s</strong>.</p>",$entry_closed);
else $page_info3 .= "<p>A inclusão de amostras na competição está <strong class=\"text-danger\">fechada</strong>.</p>";



if ($entry_window_open < 2) {
	
	// Entry Fees
	$header1_4 .= "<a name=\"entry\"></a><h2>Taxa de Inscrição</h2>";
	$page_info4 .= sprintf("<p>%s%s (%s) por amostra. ",$currency_symbol,number_format($_SESSION['contestEntryFee'],2,',',''),$currency_code);
	if ($_SESSION['contestEntryFeeDiscount'] == "Y") $page_info4 .= sprintf("%s%s por amostra depois de %s amostras. ",$currency_symbol,number_format($_SESSION['contestEntryFee2'],2),addOrdinalNumberSuffix($_SESSION['contestEntryFeeDiscountNum']));
	if ($_SESSION['contestEntryCap'] != "") $page_info4 .= sprintf("%s%s por um número ilimitado de amostras. ",$currency_symbol,number_format($_SESSION['contestEntryCap'],2));
	if (NHC) $page_info4 .= sprintf("%s%s for AHA members.",$currency_symbol,number_format($_SESSION['contestEntryFeePasswordNum'],2));
	$page_info4 .= "</p>";
	
	// Entry Limit
	if ($row_limits['prefsEntryLimit'] != "") {
		$header1_5 .= "<a name=\"entry_limit\"></a><h2>Limite de Inscrições</h2>";
		$page_info5 .= sprintf("<p>Há um limite de %s (%s) amostra(s) para essa competição.</p>",readable_number($row_limits['prefsEntryLimit']),$row_limits['prefsEntryLimit']);
	}
	
	if ((!empty($row_limits['prefsUserEntryLimit'])) || (!empty($row_limits['prefsUserSubCatLimit'])) || (!empty($row_limits['prefsUSCLExLimit']))) {
		$header1_16 .= "<h2>Limites por Inscrição</h2>";
		
		if (!empty($row_limits['prefsUserEntryLimit'])) {
			if ($row_limits['prefsUserEntryLimit'] == 1) $page_info16 .= sprintf("<p>Cada inscrição está limitada a incluir %s amostra nessa competição.</p>",readable_number($row_limits['prefsUserEntryLimit'])." (".$row_limits['prefsUserEntryLimit'].")");
			else $page_info16 .= sprintf("<p>Cada inscrição está limitada a incluir até %s amostras nessa competição.</p>",readable_number($row_limits['prefsUserEntryLimit'])." (".$row_limits['prefsUserEntryLimit'].")");
		}
		
		if (!empty($row_limits['prefsUserSubCatLimit'])) { 
			$page_info16 .= "<p>";
			if ($row_limits['prefsUserSubCatLimit'] == 1) $page_info16 .= sprintf("Cada inscrição está limitada a incluir %s amostra(s) por sub-categoria ",readable_number($row_limits['prefsUserSubCatLimit'])." (".$row_limits['prefsUserSubCatLimit'].")");
			else $page_info16 .= sprintf("Cada inscrição está limitada a %s amostras por sub-categoria ",readable_number($row_limits['prefsUserSubCatLimit'])." (".$row_limits['prefsUserSubCatLimit'].")");
			if (!empty($row_limits['prefsUSCLExLimit'])) $page_info16 .= " (exceções estão detalhadas abaixo)";
			$page_info16 .= ".";
			$page_info16 .= "</p>";
	
		}
		
		if (!empty($row_limits['prefsUSCLExLimit'])) { 
		$excepted_styles = explode(",",$row_limits['prefsUSCLEx']);
		if (count($excepted_styles) == 1) $sub = "sub-categoria"; else $sub = "sub-categorias";
			if ($row_limits['prefsUSCLExLimit'] == 1) $page_info16 .= sprintf("<p>Cada inscrição está limitada a %s para o seguinte %s: </p>",readable_number($row_limits['prefsUSCLExLimit'])." (".$row_limits['prefsUSCLExLimit'].")",$sub);
			else $page_info16 .= sprintf("<p>Cada inscrição está limitada a %s amostras para o seguinte %s: </p>",readable_number($row_limits['prefsUSCLExLimit'])." (".$row_limits['prefsUSCLExLimit'].")",$sub);
			$page_info16 .= "<div class=\"row\">";
			$page_info16 .= "<div class=\"col col-lg-6 col-md-8 col-sm-10 col-xs-12\">";
			$page_info16 .= style_convert($row_limits['prefsUSCLEx'],"7");
			$page_info16 .= "</div>";
			$page_info16 .= "</div>";
	
		}
		
	}
	
	// Payment
	$header1_6 .= "<a name=\"payment\"></a><h2>Pagamento</h2>";
	$page_info6 .= "<p>Após criar a sua conta e incluir amostras no sistema, você deverá pagar a taxa de inscrição. As formas de pagamento aceitas são:</p>";
	$page_info6 .= "<ul>";
	if ($_SESSION['prefsCash'] == "Y") $page_info6 .= "<li>Dinheiro</li>";
	if ($_SESSION['prefsCheck'] == "Y") $page_info6 .= sprintf("<li>Cheque, em nome de  <em>%s</em></li>",$_SESSION['prefsCheckPayee']);
	if ($_SESSION['prefsPaypal'] == "Y") $page_info6 .= "<li>Cartão de crédito/débito via PayPal</li>";
	//if ($_SESSION['prefsGoogle'] == "Y") $page_info6 .= "<li>Google Wallet</li>"; 
	$page_info6 .= "</ul>";

}

if ($totalRows_judging > 1) $header1_7 .= "<h2>Locais e datas do Julgamento</h2>";
else $header1_7 .= "<h2>Local e Data do Julgamento</h2>";
if ($totalRows_judging == 0) $page_info7 .= "<p>As datas da competição ainda serão determinadas. Volte mais tarde.</p>";
else {
	do {
		$page_info7 .= "<p>";
		if ($row_judging['judgingLocName'] != "") $page_info7 .= "<strong>".$row_judging['judgingLocName']."</strong>";
		if ($row_judging['judgingLocation'] != "") $page_info7 .= "<br><a href=\"".$base_url."output/maps.output.php?section=driving&amp;id=".str_replace(' ', '+', $row_judging['judgingLocation'])."\" target=\"_blank\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Map to ".$row_judging['judgingLocName']."\">".$row_judging['judgingLocation']."</a> <span class=\"fa fa-map-marker\"></span>";
		else $page_info7 .= $row_judging['judgingLocName'];
		if ($row_judging['judgingDate'] != "") $page_info7 .=  "<br />".getTimeZoneDateTime($_SESSION['prefsTimeZone'], $row_judging['judgingDate'], $_SESSION['prefsDateFormat'],  $_SESSION['prefsTimeFormat'], "long", "date-time");
		$page_info7 .= "</p>";
	} while ($row_judging = mysql_fetch_assoc($judging));
}


// Categories Accepted
$header1_8 .= "";
$page_info8 .= "";

if ($entry_window_open < 2) $header1_8 .= sprintf("<a name=\"categories\"></a><h2>%s - Categorias Aceitas</h2>",str_replace("2"," 2",$row_styles['brewStyleVersion']));
else $header1_8 .= sprintf("<a name=\"categories\"></a><h2>%s - Categorias de Julgamento</h2>",str_replace("2"," 2",$row_styles['brewStyleVersion']));
$page_info8 .= "<table class=\"table table-striped table-bordered table-responsive\">";
$page_info8 .= "<tr>"; 

$styles_endRow = 0;
$styles_columns = 3;   // number of columns
$styles_hloopRow1 = 0; // first row flag

do {
	if (($styles_endRow == 0) && ($styles_hloopRow1++ != 0)) $page_info8 .= "<tr>";
	
	$page_info8 .= "<td width=\"33%\">";
	$page_info8 .= ltrim($row_styles['brewStyleGroup'], "0").$row_styles['brewStyleNum']." ".$row_styles['brewStyle']; 
	if ($row_styles['brewStyleOwn'] == "custom") $page_info8 .= " (Custom Style)";
	$page_info8 .= "</td>";
	
	$styles_endRow++;
	if ($styles_endRow >= $styles_columns) { $styles_endRow = 0; }
		
} while ($row_styles = mysql_fetch_assoc($styles));

if ($styles_endRow != 0) {
		while ($styles_endRow < $styles_columns) {
			$page_info8 .= "<td>&nbsp;</td>";
			$styles_endRow++;
		}
	$page_info8 .= "</tr>"; 
}


$page_info8 .= "</table>";

// Bottle Acceptance
if (($row_contest_info['contestBottles'] != "") && ($entry_window_open < 2)) {
	$header1_9 .= "<a name=\"bottle\"></a><h2>Regras para a Aceitação de Garrafas</h2>";
	$page_info9 .= $row_contest_info['contestBottles'];
}

// Shipping Locations
if (($_SESSION['contestShippingAddress'] != "") && ($shipping_window_open < 2)) {
	$header1_10 .= "<a name=\"shipping\"></a><h2>Informações para o envio das amostras</h2>";
	$page_info10 .= sprintf("<p>As garrafas serão aceitas no Local de Entrega das Garrafas de <strong class=\"text-success\">%s</strong> até <strong class=\"text-success\">%s</strong>.</p>",$shipping_open,$shipping_closed);
	$page_info10 .= "<p>Envie as amostras para:</p>";
	$page_info10 .= "<p>";
	$page_info10 .= $_SESSION['contestShippingName'];
	$page_info10 .= "<br>";
	$page_info10 .= $_SESSION['contestShippingAddress'];
	$page_info10 .= "</p>";
    $page_info10 .= "<h3>Empacotamento e envio</h3>";
    $page_info10 .= "<p><strong>Embale cuidadosamente suas garrafas em uma caixa resistente. Forre o interior da caixa com um saco plástico. Embale cada carrafa com sua proteção individual! Não sobrecarregue o pacote!</strong>";
	$page_info10 .= "<p>Escreva claramente na embalagem \"Frágil! Este lado para cima\".  Utilize plástico bolha para embalar cada garrafa. Evitar utilizar pedacinhos de isopor ou papel.</p>";
    $page_info10 .= "<p>Coloque <em>cada</em> etiqueta das garrafas em um saco plástico (ou utilize fita transparente para plastificar) antes de fixar a mesma com o elástico. Assim, em caso de algum dano com as garrafas, ainda poderemos identificar as amostras.</p>";
    $page_info10 .= "<p>Caso alguma garrafa chegue danificada e haja tempo suficiente, a organização entrará em contato para solicitar garrafas extras, se necessário.</p>";
    $page_info10 .= "<p>É de responsabilidade do cervejeiro seguir todas as leis e regulamentos eventualmente aplicáveis ao transporte de líquidos e/ou vidro pela forma de envio escolhida.</p>";
}

// Drop Off
if (($totalRows_dropoff > 0) && ($dropoff_window_open < 2)) {
	if ($totalRows_dropoff == 1) $header1_11 .= "<a name=\"drop\"></a><h2>Local para a Entrega das Garrafas</h2>";
	else $header1_11 .= "<a name=\"drop\"></a><h2>Locais para a Entrega das Garrafas</h2>";
	$page_info11 .= sprintf("<p>Garrafas aceitas no local de entrega de <strong class=\"text-success\">%s</strong> até <strong class=\"text-success\">%s</strong>.</p>",$dropoff_open,$dropoff_closed);
	
	do {
		$page_info11 .= "<p>";
		if ($row_dropoff['dropLocationWebsite'] != "") $page_info11 .= sprintf("<a href=\"%s\" target=\"_blank\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Vá para a página ".$row_dropoff['dropLocationName']." \"><strong>%s</strong></a> <span class=\"fa fa-external-link\"></span>",$row_dropoff['dropLocationWebsite'],$row_dropoff['dropLocationName']);
		else $page_info11 .= sprintf("<strong>%s</strong>",$row_dropoff['dropLocationName']);
		$page_info11 .= "<br />";
		$page_info11 .= "<a href=\"".$base_url."output/maps.output.php?section=driving&amp;id=".str_replace(' ', '+', $row_dropoff['dropLocation'])."\" target=\"_blank\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Map to ".$row_dropoff['dropLocationName']."\">".$row_dropoff['dropLocation']."</a> <span class=\"fa fa-map-marker\"></span>";
		$page_info11 .= "<br />";
		$page_info11 .= $row_dropoff['dropLocationPhone'];
		$page_info11 .= "<br />";
		if ($row_dropoff['dropLocationNotes'] != "") $page_info11 .= sprintf("*<em>%s</em>",$row_dropoff['dropLocationNotes']);
		$page_info11 .= "</p>";
	 } while ($row_dropoff = mysql_fetch_assoc($dropoff));
}

// Best of Show
if ($row_contest_info['contestBOSAward'] != "") {
	$header1_12 .= "<a name=\"bos\"></a><h2>Best of Show</h2>";
	$page_info12 .= $row_contest_info['contestBOSAward'];;
}

// Awards and Awards Ceremony Location
if ($row_contest_info['contestAwards'] != "") {
	$header1_13 .= "<a name=\"awards\"></a><h2>Prêmios</h2>";
	$page_info13 .= $row_contest_info['contestAwards'];;
}

if ($_SESSION['contestAwardsLocName'] != "") {
	$header1_14 .= "<a name=\"ceremony\"></a><h2>Cerimônia de Premiação</h2>";
	$page_info14 .= "<p>";
	$page_info14 .= sprintf("<strong>%s</strong>",$_SESSION['contestAwardsLocName']);
	if ($_SESSION['contestAwardsLocation'] != "") $page_info14 .= sprintf("<br /><a href=\"".$base_url."output/maps.output.php?section=driving&amp;id=".str_replace(' ', '+', $_SESSION['contestAwardsLocation'])."\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Mapa para ".$_SESSION['contestAwardsLocName']." \" target=\"_blank\">%s</a> <span class=\"fa fa-map-marker\"></span>",$_SESSION['contestAwardsLocation']);
	if ($_SESSION['contestAwardsLocTime'] != "") $page_info14 .= sprintf("<br />%s",getTimeZoneDateTime($_SESSION['prefsTimeZone'], $_SESSION['contestAwardsLocTime'], $_SESSION['prefsDateFormat'],  $_SESSION['prefsTimeFormat'], "long", "date-time"));
	$page_info14 .= "</p>";
	
}

// Circuit Qualification
if ($row_contest_info['contestCircuit'] != "") {
	$header1_15 .= "<a name=\"circuit\"></a><h2>Circuit Qualification</h2>";
	$page_info15 .= $row_contest_info['contestCircuit'];
}


// --------------------------------------------------------------
// Display
// --------------------------------------------------------------

// Display Registration Window
echo $header1_2;
echo $page_info2;

// Display Entry Window
echo $header1_3;
echo $page_info3;

// Display Entry Fees
echo $header1_4;
echo $page_info4;

// Display Categories Accepted
echo $header1_8;
echo $page_info8;

// Display Entry Limits
echo $header1_5;
echo $page_info5;

// Display Per Entrant Limit
echo $header1_16;
echo $page_info16;

// Display Payment Info
echo $header1_6;
echo $page_info6;

// Display Bottle Acceptance Rules
echo $header1_9;
echo $page_info9;

// Display Drop Off Locations and Acceptance Dates
echo $header1_11;
echo $page_info11;

// Display Shipping Location and Acceptance Dates
echo $header1_10;
echo $page_info10;

// Display Judging Dates
echo $header1_7;
echo $page_info7;

// Display Best of Show
echo $header1_12;
echo $page_info12;

// Display Awards and Awards Ceremony Location
echo $header1_13;
echo $page_info13;
echo $header1_14;
echo $page_info14;

// Display Circuit Qualification
echo $header1_15;
echo $page_info15;

?>
