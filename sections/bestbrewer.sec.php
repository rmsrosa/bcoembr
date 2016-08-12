<?php
/**
 * Module:      bestbrewer.sec.php 
 * Description: This module displays the best brewers, ordered by the sum of points obtained for his entries
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
 
$bestbrewer = array();
			
include(DB.'scores_bestbrewer.db.php');
			
do { 

	if (array_key_exists($bb_row_scores['uid'], $bestbrewer)) {
		$place = floor($bb_row_scores['scorePlace']);
		if (($place == $bb_row_scores['scorePlace']) && ($place >= 1) && ($place <= 5))			$bestbrewer[$bb_row_scores['uid']]['Places'][$place-1] += 1;
		$bestbrewer[$bb_row_scores['uid']]['Scores'][] = $bb_row_scores['scoreEntry'];
//		$entry_info = array('Place'=>$bb_row_scores['scorePlace'], 'Score'=>$bb_row_scores['scoreEntry']);
//		$bestbrewer[$bb_row_scores['uid']]['Entries'][] = $entry_info;
//		$bestbrewer[$bb_row_scores['uid']]['Points'] += best_brewer_points2($bb_row_scores['scorePlace']);
	} 
	else {
		$bestbrewer[$bb_row_scores['uid']]['Name'] = $bb_row_scores['brewerFirstName']." ".$bb_row_scores['brewerLastName'];
		// I don't know why, but 'scorePlace' is set to float in the database, not integer, so I must be careful here.
		if ($bb_row_scores['brewCoBrewer'] != "") $bestbrewer[$bb_row_scores['uid']]['Name'] .= "<br>Co-Brewer: ".$bb_row_scores['brewCoBrewer'];
		$bestbrewer[$bb_row_scores['uid']]['ACervA'] = $bb_row_scores['brewerACervA'];
		$bestbrewer[$bb_row_scores['uid']]['Clube'] = $bb_row_scores['brewerClubs'];
		$bestbrewer[$bb_row_scores['uid']]['Places'] = array(0,0,0,0,0);
		$place = floor($bb_row_scores['scorePlace']);
		if (($place == $bb_row_scores['scorePlace']) && ($place >= 1) && ($place <= 5))			$bestbrewer[$bb_row_scores['uid']]['Places'][$place-1] = 1;
		
		$bestbrewer[$bb_row_scores['uid']]['Scores'] = array();
		$bestbrewer[$bb_row_scores['uid']]['Scores'][0] = $bb_row_scores['scoreEntry'];
//		$entry_info = array('Place'=>$bb_row_scores['scorePlace'], 'Score'=>$bb_row_scores['scoreEntry']);
//		$bestbrewer[$bb_row_scores['uid']]['Entries'][] = $entry_info;		
//		$bestbrewer[$bb_row_scores['uid']]['Points'] = best_brewer_points2($bb_row_scores['scorePlace']);
	}
	
} while ($bb_row_scores = mysql_fetch_assoc($bb_scores));


foreach (array_keys($bestbrewer) as $key) {
	$points = best_brewer_points($key,$bestbrewer[$key]['Places'],$bestbrewer[$key]['Scores']);
	$bestbrewer[$key]['Points'] = $points;
	$bb_sorter[$key] = $points;
}

arsort($bb_sorter);

$show_4th = FALSE;
$show_HM = FALSE;

$bb_count = 0;
$bb_position = 0;
$bb_previouspoints = 0;
$bb_max_position = 10;

foreach (array_keys($bb_sorter) as $key) {
	$bb_count += 1;
	$points = $bestbrewer[$key]['Points'];
	if ($points != $bb_previouspoints) { 
		$bb_position = $bb_count;
		$bb_previouspoints = $points;
	}
	if ($bb_position <= $bb_max_position) {
		if ($bestbrewer[$key]['Places'][3] > 0) $show_4th = TRUE;
		if ($bestbrewer[$key]['Places'][4] > 0) $show_HM = TRUE;
	}
	else break;
}


// --------------------------------------------------------------
// Display
// --------------------------------------------------------------

/*
echo "<pre>";
print_r($bestbrewer);
echo "</pre>";

echo "<pre>";
print_r($bb_sorter);
echo "</pre>";
*/
?>

<?php

$bb_name = "Panela de Ouro";

$header1_1 .= "<h2>".$bb_name." (".get_participant_count('received-entrant')." cervejeiros)</h2>";

$table_head1 .= "<tr>
			<th width=\"1%\" nowrap>Colocação</th>
			<th>Cervejeiro(a)(s)</th>";
$table_head1 .= "<th>Ouros</th>";
$table_head1 .= "<th>Pratas</th>";
$table_head1 .= "<th>Bronzes</th>";
if ($show_4th) $table_head1 .= "<th>".addOrdinalNumberSuffix(4)."</th>";
if ($show_HM) $table_head1 .= "<th>MH</th>";
$table_head1 .= "<th>Pontos</th>
			<th>ACervA</th>
			<th class=\"hidden-xs hidden-sm hidden-md\">Clube</th>
		</tr>";
 
$bb_count = 0;
$bb_position = 0;
$bb_previouspoints = 0;
 
foreach (array_keys($bb_sorter) as $key) {
	$bb_count += 1;
	$points = $bestbrewer[$key]['Points'];
	if ($points != $bb_previouspoints) { 
		$bb_position = $bb_count;
		$bb_previouspoints = $points;
		$bb_display_position = display_place($bb_position,3);
	}
	else $bb_display_position = "";
	if ($bb_position <= $bb_max_position) {
		$table_body1 .= "<tr>";
		$table_body1 .= "<td>".$bb_display_position."</td>";
		$table_body1 .= "<td>".$bestbrewer[$key]['Name']."</td>";
		$table_body1 .= "<td>".$bestbrewer[$key]['Places'][0]."</td>";
		$table_body1 .= "<td>".$bestbrewer[$key]['Places'][1]."</td>";
		$table_body1 .= "<td>".$bestbrewer[$key]['Places'][2]."</td>";
		if ($show_4th) $table_body1 .= "<td>".$bestbrewer[$key]['Places'][3]."</td>";
		if ($show_HM) $table_body1 .= "<td>".$bestbrewer[$key]['Places'][4]."</td>";
		if ((isset($_SESSION['loginUsername'])) && ($_SESSION['userLevel'] <= "1")) $table_body1 .= "<td>".$points."</td>";
		else $table_body1 .= "<td>".floor($points)."</td>";
		$table_body1 .= "<td>".$bestbrewer[$key]['ACervA']."</td>";
		$table_body1 .= "<td>".$bestbrewer[$key]['Clube']."</td>";
		$table_body1 .= "</tr>";
	}
	else break;
}

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
</div>


<!-- Public Page Rebuild completed 08.26.15 --> 

