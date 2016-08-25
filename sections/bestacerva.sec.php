<?php
/**
 * Module:      bestacervas.sec.php 
 * Description: This module displays the list of the best acervas, ordered by the sum of points obtained by their members.
 *              
 * 
 */


/* ---------------- PUBLIC Pages Rebuild Info ---------------------

Beginning with the 1.3.0 release, an effort was begun to separate the programming
layer from the presentation layer for all scripts with this header.

All Public pages have certain variables in common that build the page:
  
	$primary_page_info = any information related to the page
	
	$header1_X = an <h2> header on the page
	$header2_X = an <h3> subheader on the page
	
	$page_infoX = the bulk of the information on the page.
	$print_page_link = the "Print This Page" link
	$competition_logo = display of the competition's logo
	
	$labelX = the various labels in a table or on a form
	$table_headX = all table headers (column names)
	$table_bodyX = table body info
	$messageX = various messages to display
	
	$print_page_link = "<p><span class='icon'><img src='".$base_url."images/printer.png' border='0' alt='Print' title='Print' /></span><a id='modal_window_link' href='".$base_url."output/print.php?section=".$section."&amp;action=print' title='Print'>Print This Page</a></p>";
	$competition_logo = "<img src='".$base_url."user_images/".$_SESSION['contestLogo']."' width='".$_SESSION['prefsCompLogoSize']."' style='float:right; padding: 5px 0 5px 5px' alt='Competition Logo' title='Competition Logo' />";
	
Declare all variables empty at the top of the script. Add on later...
	$primary_page_info = "";
	$header1_1 = "";
	$page_info1 = "";
	$header1_2 = "";
	$page_info2 = "";
	
	$table_head1 = "";
	$table_body1 = "";
	
	etc., etc., etc.

 * ---------------- END Rebuild Info --------------------- */
 
$header1_1 = "";
$table_head1 = "";
$table_body1 = ""; 
$page_info_1 = "";
 
$bestacerva = array();

if (!$display_bestbrewer) {
	$bestbrewer = array();
	include(DB.'scores_bestbrewer.db.php');
	do { 
		
		if (array_key_exists($bb_row_scores['uid'], $bestbrewer)) {
			$place = floor($bb_row_scores['scorePlace']);
			if (($place == $bb_row_scores['scorePlace']) && ($place >= 1) && ($place <= 5))	$bestbrewer[$bb_row_scores['uid']]['Places'][$place-1] += 1;
			$bestbrewer[$bb_row_scores['uid']]['Scores'][] = $bb_row_scores['scoreEntry'];
		} 
	else {
			$bestbrewer[$bb_row_scores['uid']]['Name'] = $bb_row_scores['brewerFirstName']." ".$bb_row_scores['brewerLastName'];
			// I don't know why, but 'scorePlace' is set to float in the database, not integer, so I must be careful here.
			if ($bb_row_scores['brewCoBrewer'] != "") $bestbrewer[$bb_row_scores['uid']]['Name'] .= "<br>Co-Brewer: ".$bb_row_scores['brewCoBrewer'];
			$bestbrewer[$bb_row_scores['uid']]['ACervA'] = $bb_row_scores['brewerACervA'];
			$bestbrewer[$bb_row_scores['uid']]['Clube'] = $bb_row_scores['brewerClubs'];
			$bestbrewer[$bb_row_scores['uid']]['Places'] = array(0,0,0,0,0);
			$place = floor($bb_row_scores['scorePlace']);
			if (($place == $bb_row_scores['scorePlace']) && ($place >= 1) && ($place <= 5))	$bestbrewer[$bb_row_scores['uid']]['Places'][$place-1] = 1;
		
			$bestbrewer[$bb_row_scores['uid']]['Scores'] = array();
			$bestbrewer[$bb_row_scores['uid']]['Scores'][0] = $bb_row_scores['scoreEntry'];
		}
	
	} while ($bb_row_scores = mysql_fetch_assoc($bb_scores));
	
	foreach (array_keys($bestbrewer) as $key) {
		$points = best_brewer_points($key,$bestbrewer[$key]['Places'],$bestbrewer[$key]['Scores']);
		$bestbrewer[$key]['Points'] = $points;
	}
}

foreach (array_keys($bestbrewer) as $key) {
	if ($bestbrewer[$key]['ACervA']) {
		if (array_key_exists($bestbrewer[$key]['ACervA'], $bestacerva)) {
			$bestacerva[$bestbrewer[$key]['ACervA']]['Points'] += $bestbrewer[$key]['Points'];
			for ($i=0; $i<= 4; $i++) $bestacerva[$bestbrewer[$key]['ACervA']]['Places'][$i] += $bestbrewer[$key]['Places'][$i];
			$bestacerva[$bestbrewer[$key]['ACervA']]['Winners'] += 1;
		}
		else {
			$bestacerva[$bestbrewer[$key]['ACervA']]['Points'] = $bestbrewer[$key]['Points'];
			$bestacerva[$bestbrewer[$key]['ACervA']]['Places'] = $bestbrewer[$key]['Places'];
			$bestacerva[$bestbrewer[$key]['ACervA']]['Winners'] = 1;
		}
	}
}

foreach (array_keys($bestacerva) as $key) {
	$ba_sorter[$key] = $bestacerva[$key]['Points'];
}

arsort($ba_sorter);

$show_4th = FALSE;
$show_HM = FALSE;

$ba_count = 0;
$ba_position = 0;
$ba_previouspoints = 0;
if ($_SESSION['prefsShowACervA'] == -1) $ba_max_position = count(array_keys($ba_sorter));
else $ba_max_position = $_SESSION['prefsShowACervA'];

foreach (array_keys($ba_sorter) as $key) {
	$ba_count += 1;
	$points = $bestacerva[$key]['Points'];
	if ($points != $ba_previouspoints) { 
		$ba_position = $ba_count;
		$ba_previouspoints = $points;
	}
	if ($ba_position <= $ba_max_position) {
		if ($bestacerva[$key]['Places'][3] > 0) $show_4th = TRUE;
		if ($bestacerva[$key]['Places'][4] > 0) $show_HM = TRUE;
	}
	else break;
}

// --------------------------------------------------------------
// Display
// --------------------------------------------------------------


?>

<?php

$ba_name = "ACervAs";

$header1_1 .= "<h2>".$ba_name." (".get_acervianos_count('paid-received-regionais')." estaduais/regionais)</h2>";

$table_head1 .= "<tr>
			<th width=\"1%\" nowrap>Colocação</th>
			<th>ACervA</th>";
$table_head1 .= "<th>Cervejeiros<br>Habilitados</th>";
$table_head1 .= "<th>Cervejeiros<br>Inscritos</th>";
$table_head1 .= "<th>Cervejeiros<br>Premiados</th>";
$table_head1 .= "<th>Cervejas<br>Inscritas</th>";
$table_head1 .= "<th>Ouros</th>";
$table_head1 .= "<th>Pratas</th>";
$table_head1 .= "<th>Bronzes</th>";
if ($show_4th) $table_head1 .= "<th>".addOrdinalNumberSuffix(4)."</th>";
if ($show_HM) $table_head1 .= "<th>MH</th>";
$table_head1 .= "<th>Pontos</th>
		</tr>";
 
$ba_count = 0;
$ba_position = 0;
$ba_previouspoints = 0;
 
foreach (array_keys($ba_sorter) as $key) {
	$ba_count += 1;
	$points = $bestacerva[$key]['Points'];
	if ($points != $ba_previouspoints) { 
		$ba_position = $ba_count;
		$ba_previouspoints = $points;
		$ba_display_position = display_place($ba_position,0);
	}
	else $ba_display_position = "";
	if ($ba_position <= $ba_max_position) {
		$table_body1 .= "<tr>";
		$table_body1 .= "<td>".$ba_display_position."</td>";
		$table_body1 .= "<td>".$key."</td>";
		$table_body1 .= "<td>".get_acervianos_count("system-unique", $key)."</td>";
		$table_body1 .= "<td>".get_acervianos_count("paid-received", $key)."</td>";
		$table_body1 .= "<td>".$bestacerva[$key]['Winners']."</td>";
		$table_body1 .= "<td>".get_acervianos_count("paid-received-entries", $key)."</td>";
		$table_body1 .= "<td>".$bestacerva[$key]['Places'][0]."</td>";
		$table_body1 .= "<td>".$bestacerva[$key]['Places'][1]."</td>";
		$table_body1 .= "<td>".$bestacerva[$key]['Places'][2]."</td>";
		if ($show_4th) $table_body1 .= "<td>".$bestacerva[$key]['Places'][3]."</td>";
		if ($show_HM) $table_body1 .= "<td>".$bestacerva[$key]['Places'][4]."</td>";
		if ((isset($_SESSION['loginUsername'])) && ($_SESSION['userLevel'] <= "1")) $table_body1 .= "<td>".$points."</td>";
		else $table_body1 .= "<td>".floor($points)."</td>";
		$table_body1 .= "</tr>";
	}
	else break;
}

$page_info_1 .= "Os critérios de desempate, conforme definidos pelo regulamento da competição para ordenar os melhores cervejeiros, foram aplicados automaticamente e de maneira cumulativa entre os cervejeiros de cada ACervA.";

// --------------------------------------------------------------
// Display
// --------------------------------------------------------------

?>

<div class="bcoem-winner-table">
	<?php echo $header1_1; ?>
    <table class='table table-responsive table-striped table-bordered'>
    <thead>
        <?php echo $table_head1; ?>
    </thead>
    <tbody>
        <?php echo $table_body1; ?>
    </tbody>
    </table>
    <?php echo $page_info_1; ?>
</div>


<!-- Public Page Rebuild completed 08.26.15 --> 

