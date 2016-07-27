<?php 
/**
 * Module:      scoresheets.output.php 
 * Description: This module copies the pdf of the scoresheets of a given entry from a directory in which the pdfs are protected from direct access from the web (setup by the .htaccess in root) to a directory which is write-enabled. The name of the file in the temporary directory is appended by a randomly generated sequence of numbers, to prevent unwelcomed users to guess the name of the file and access it. The random number is generated and handed down from the brewers_entries.sec.php script.
 * 
 */

require ('../paths.php');
require (CONFIG.'bootstrap.php');
if (isset($_SESSION['loginUsername'])) {

	if (($brewer_info['brewerEmail'] != $_SESSION['loginUsername']) && ($row_logged_in_user['userLevel'] > 1)) { 
	  	echo "<html><head><title>Error</title></head><body>";
  		echo "<p>You do not have sufficient access priveliges to view this page.</p>";
	  	echo "</body></html>";
  		exit();
	}
   
//	$readablejudgingnumber = $_GET['judgnum'];
//	$filename = $readablejudgingnumber.".pdf";
//	$scoresheetsfile = SCORESHEETS."pdfs/".$filename;
	$scoresheetsfilename = $_GET['scoresheetsfilename'];
	$scoresheetsfile = SCORESHEETS."pdfs/".$scoresheetsfilename;
	$randomfilename = $_GET['randomfilename'];
	$scoresheetsrandomfilerelative = "scoresheets/temp/".$randomfilename;
	$scoresheetsrandomfile = SCORESHEETS."temp/".$randomfilename;
			
	if (copy($scoresheetsfile, $scoresheetsrandomfile)) {
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $scoresheetsfilename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($scoresheetsrandomfile));
		header('Accept-Ranges: bytes');
   		ob_clean();
	    flush();
    	readfile($scoresheetsrandomfile);			
	}
	else {
  		echo "<html><head><title>Error</title></head><body>";
	  	echo "<p>The pdf of your scoresheets could not be properly generated for your viewing. Please, contact the organizers of the competition.</p>";
  		echo "</body></html>";
	  	exit();
	}
//	exit();
} // end if logged in
?>