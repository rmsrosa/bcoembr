<?php

$query_scores = sprintf("SELECT a.scorePlace, a.scoreEntry, b.brewCoBrewer, c.uid, c.brewerLastName, c.brewerFirstName, c.brewerACervA, c.brewerClubs FROM %s a, %s b, %s c WHERE a.eid = b.id AND c.uid = b.brewBrewerID AND a.scorePlace IS NOT NULL ", $judging_scores_db_table, $brewing_db_table, $brewer_db_table);

//if ((($action == "print") && ($view == "winners")) || ($action == "default") || ($section == "default")) $query_scores .= " AND a.scorePlace IS NOT NULL";

//$query_scores .= " ORDER BY a.scorePlace ASC";

mysql_query("SET NAMES 'utf8'");
$bb_scores = mysql_query($query_scores, $brewing) or die(mysql_error());
$bb_row_scores = mysql_fetch_assoc($bb_scores);
$bb_totalRows_scores = mysql_num_rows($bb_scores);

?>