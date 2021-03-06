<?php 
/*
 * Module:      process_prefs_add.inc.php
 * Description: This module does all the heavy lifting for adding information to the 
 *              "preferences" table.
 */

if (((isset($_SESSION['loginUsername'])) && ($_SESSION['userLevel'] <= 1)) || ($section == "setup")) {
	
	if ($_POST['prefsUSCLEx'] != "") $prefsUSCLEx = implode(",",$_POST['prefsUSCLEx']);
	else  $prefsUSCLEx = "";

	mysql_query("SET NAMES 'utf8'");
	
	if (NHC) {
		// Place NHC SQL calls below
		
		
	}
	
	else {

 
		if ($action == "add") {
			$insertSQL = sprintf("INSERT INTO $preferences_db_table (
			prefsTemp, 
			prefsWeight1, 
			prefsWeight2, 
			prefsLiquid1, 
			prefsLiquid2,
			
			prefsPaypal, 
			prefsPaypalAccount, 
			prefsCurrency, 
			prefsCash, 
			prefsCheck,
			
			prefsCheckPayee,
			prefsGoogle,
			prefsGoogleAccount,
			prefsTransFee,
			prefsSponsors,
			
			prefsSponsorLogos,
			prefsSponsorLogoSize,
			prefsCompLogoSize,
			prefsDisplayWinners,
			prefsWinnerDelay,
			
			prefsWinnerMethod,
			prefsDisplaySpecial,
			prefsEntryForm,
			prefsRecordLimit,
			prefsRecordPaging,

			prefsShowBestBrewer,
			prefsBestBrewerTitle,
			prefsFirstPlacePts,
			prefsSecondPlacePts,
			prefsThirdPlacePts,
			prefsFourthPlacePts,
			prefsHMPts,
			prefsTieBreakRule1,
			prefsTieBreakRule2,
			prefsTieBreakRule3,
			prefsTieBreakRule4,
			prefsTieBreakRule5,
			prefsTieBreakRule6,
						
			prefsRestrictedACervA,
			prefsACervAs,
			prefsShowACervA,
			
			prefsTheme,
			prefsDateFormat,
			prefsContact,
			prefsTimeZone,
			prefsEntryLimit,
			
			prefsTimeFormat,
			prefsUserEntryLimit,
			prefsUserSubCatLimit,
			prefsUSCLEx,
			prefsUSCLExLimit,
			
			prefsPayToPrint,
			prefsHideRecipe,
			prefsUseMods,
			prefsSEF,
			prefsSpecialCharLimit,
			
			prefsStyleSet,
			prefsAutoPurge,
			
			id
			
			) VALUES (
			%s, %s, %s, %s, %s, 
			%s, %s, %s, %s, %s, 
			%s, %s, %s, %s, %s,
			%s, %s, %s, %s, %s,
			%s, %s, %s, %s, %s,
			%s, %s, %s, %s, %s, 
			%s, %s, %s, %s, %s, 
			%s, %s, %s, %s, %s, 
			%s, %s, %s, %s, %s,
			%s, %s, %s, %s, %s,
			%s, %s, %s, %s, %s,
			%s, %s, %s, %s)",
								   GetSQLValueString($_POST['prefsTemp'], "text"),
								   GetSQLValueString($_POST['prefsWeight1'], "text"),
								   GetSQLValueString($_POST['prefsWeight2'], "text"),
								   GetSQLValueString($_POST['prefsLiquid1'], "text"),
								   GetSQLValueString($_POST['prefsLiquid2'], "text"),
								   
								   GetSQLValueString($_POST['prefsPaypal'], "text"),
								   GetSQLValueString($_POST['prefsPaypalAccount'], "text"),
								   GetSQLValueString($_POST['prefsCurrency'], "text"),
								   GetSQLValueString($_POST['prefsCash'], "text"),
								   GetSQLValueString($_POST['prefsCheck'], "text"),
								   
								   GetSQLValueString($_POST['prefsCheckPayee'], "text"),
								   GetSQLValueString($_POST['prefsGoogle'], "text"),
								   GetSQLValueString($_POST['prefsGoogleAccount'], "text"),
								   GetSQLValueString($_POST['prefsTransFee'], "text"),
								   GetSQLValueString($_POST['prefsSponsors'], "text"),
								   
								   GetSQLValueString($_POST['prefsSponsorLogos'], "text"),
								   GetSQLValueString($_POST['prefsSponsorLogoSize'], "int"),
								   GetSQLValueString($_POST['prefsCompLogoSize'], "int"),
								   GetSQLValueString($_POST['prefsDisplayWinners'], "text"),
								   GetSQLValueString($_POST['prefsWinnerDelay'], "text"),
								   
								   GetSQLValueString($_POST['prefsWinnerMethod'], "text"),
								   GetSQLValueString($_POST['prefsDisplaySpecial'], "text"),
								   GetSQLValueString($_POST['prefsEntryForm'], "text"),
								   GetSQLValueString($_POST['prefsRecordLimit'], "int"),
								   GetSQLValueString($_POST['prefsRecordPaging'], "int"),
								   
								   GetSQLValueString($_POST['prefsShowBestBrewer'], "int"),
								   GetSQLValueString($_POST['prefsBestBrewerTitle'], "text"),
								   GetSQLValueString($_POST['prefsFirstPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsSecondPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsThirdPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsFourthPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsHMPts'], "int"),
								   GetSQLValueString($_POST['prefsTieBreakRule1'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule2'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule3'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule4'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule5'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule6'], "text"),
								   GetSQLValueString($_POST['prefsRestrictedACervA'], "text"),
								   GetSQLValueString($_POST['prefsACervAs'], "text"),
								   GetSQLValueString($_POST['prefsShowACervA'], "int"),
								   
								   GetSQLValueString($_POST['prefsTheme'], "text"),
								   GetSQLValueString($_POST['prefsDateFormat'], "text"),
								   GetSQLValueString($_POST['prefsContact'], "text"),
								   GetSQLValueString($_POST['prefsTimeZone'], "text"),
								   GetSQLValueString($_POST['prefsEntryLimit'], "text"),
								   
								   GetSQLValueString($_POST['prefsTimeFormat'], "text"),
								   GetSQLValueString($_POST['prefsUserEntryLimit'], "int"),
								   GetSQLValueString($_POST['prefsUserSubCatLimit'], "int"),
								   GetSQLValueString($prefsUSCLEx, "text"),
								   GetSQLValueString($_POST['prefsUSCLExLimit'], "int"),
								   
								   GetSQLValueString($_POST['prefsPayToPrint'], "text"),
								   GetSQLValueString($_POST['prefsHideRecipe'], "text"),
								   GetSQLValueString($_POST['prefsUseMods'], "text"),
								   GetSQLValueString($_POST['prefsSEF'], "text"),
								   GetSQLValueString($_POST['prefsSpecialCharLimit'], "int"),
								   GetSQLValueString($_POST['prefsStyleSet'], "text"),
								   GetSQLValueString($_POST['prefsAutoPurge'], "text"),
								   GetSQLValueString($id, "int"));
								   
				//echo $insertSQL;
				mysql_select_db($database, $brewing);
				mysql_real_escape_string($insertSQL);
				$result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());
			
				$insertGoTo = "../setup.php?section=step4";
				$pattern = array('\'', '"');
				$insertGoTo = str_replace($pattern, "", $insertGoTo); 
				header(sprintf("Location: %s", stripslashes($insertGoTo)));
		}
		
		if ($action == "edit") {
			
			// Empty the prefs session variable
			// Will trigger the session to reset the variables in common.db.php upon reload after redirect
			session_start();
			unset($_SESSION['prefs'.$prefix_session]);
			
			
			$updateSQL = sprintf("UPDATE $preferences_db_table SET 
			prefsTemp=%s, 
			prefsWeight1=%s, 
			prefsWeight2=%s, 
			prefsLiquid1=%s, 
			prefsLiquid2=%s, 
			
			prefsPaypal=%s, 
			prefsPaypalAccount=%s, 
			prefsCurrency=%s, 
			prefsCash=%s, 
			prefsCheck=%s, 
			
			prefsCheckPayee=%s, 
			prefsGoogle=%s, 
			prefsGoogleAccount=%s,  
			prefsTransFee=%s, 
			prefsSponsors=%s, 
			
			prefsSponsorLogos=%s, 
			prefsSponsorLogoSize=%s, 
			prefsCompLogoSize=%s, 
			prefsDisplayWinners=%s, 
			prefsWinnerDelay=%s,
			
			prefsWinnerMethod=%s,
			prefsDisplaySpecial=%s, 
			prefsEntryForm=%s,
			prefsRecordLimit=%s,
			prefsRecordPaging=%s,
	
			prefsShowBestBrewer=%s,
			prefsBestBrewerTitle=%s,
			prefsFirstPlacePts=%s,
			prefsSecondPlacePts=%s,
			prefsThirdPlacePts=%s,
			prefsFourthPlacePts=%s,
			prefsHMPts=%s,
			prefsTieBreakRule1=%s,
			prefsTieBreakRule2=%s,
			prefsTieBreakRule3=%s,
			prefsTieBreakRule4=%s,
			prefsTieBreakRule5=%s,
			prefsTieBreakRule6=%s,
			
			prefsRestrictedACervA=%s,
			prefsACervAs=%s,
			prefsShowACervA=%s,
			
			prefsTheme=%s,
			prefsDateFormat=%s,
			prefsContact=%s,
			prefsTimeZone=%s,
			prefsEntryLimit=%s,
			
			prefsTimeFormat=%s,
			prefsUserEntryLimit=%s,
			prefsUserSubCatLimit=%s,
			prefsUSCLEx=%s,
			prefsUSCLExLimit=%s,
			
			prefsPayToPrint=%s,
			prefsHideRecipe=%s,
			prefsUseMods=%s,
			prefsSEF=%s,
			prefsSpecialCharLimit=%s,
			
			prefsStyleSet=%s,
			prefsAutoPurge=%s
			
			WHERE id=%s",
								   GetSQLValueString($_POST['prefsTemp'], "text"),
								   GetSQLValueString($_POST['prefsWeight1'], "text"),
								   GetSQLValueString($_POST['prefsWeight2'], "text"),
								   GetSQLValueString($_POST['prefsLiquid1'], "text"),
								   GetSQLValueString($_POST['prefsLiquid2'], "text"),
								   
								   GetSQLValueString($_POST['prefsPaypal'], "text"),
								   GetSQLValueString($_POST['prefsPaypalAccount'], "text"),
								   GetSQLValueString($_POST['prefsCurrency'], "text"),
								   GetSQLValueString($_POST['prefsCash'], "text"),
								   GetSQLValueString($_POST['prefsCheck'], "text"),
								   
								   GetSQLValueString($_POST['prefsCheckPayee'], "text"),
								   GetSQLValueString($_POST['prefsGoogle'], "text"),
								   GetSQLValueString($_POST['prefsGoogleAccount'], "text"),
								   GetSQLValueString($_POST['prefsTransFee'], "text"),
								   GetSQLValueString($_POST['prefsSponsors'], "text"),
								   
								   GetSQLValueString($_POST['prefsSponsorLogos'], "text"),
								   GetSQLValueString($_POST['prefsSponsorLogoSize'], "int"),
								   GetSQLValueString($_POST['prefsCompLogoSize'], "int"),
								   GetSQLValueString($_POST['prefsDisplayWinners'], "text"),
								   GetSQLValueString($_POST['prefsWinnerDelay'], "text"),
								   
								   GetSQLValueString($_POST['prefsWinnerMethod'], "text"),
								   GetSQLValueString($_POST['prefsDisplaySpecial'], "text"),
								   GetSQLValueString($_POST['prefsEntryForm'], "text"),
								   GetSQLValueString($_POST['prefsRecordLimit'], "int"),
								   GetSQLValueString($_POST['prefsRecordPaging'], "int"),

								   GetSQLValueString($_POST['prefsShowBestBrewer'], "int"),
								   GetSQLValueString($_POST['prefsBestBrewerTitle'], "text"),
								   GetSQLValueString($_POST['prefsFirstPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsSecondPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsThirdPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsFourthPlacePts'], "int"),
								   GetSQLValueString($_POST['prefsHMPts'], "int"),
								   GetSQLValueString($_POST['prefsTieBreakRule1'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule2'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule3'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule4'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule5'], "text"),
								   GetSQLValueString($_POST['prefsTieBreakRule6'], "text"),
								   GetSQLValueString($_POST['prefsRestrictedACervA'], "text"),
								   GetSQLValueString($_POST['prefsACervAs'], "text"),
								   GetSQLValueString($_POST['prefsShowACervA'], "int"),								   
								   GetSQLValueString($_POST['prefsTheme'], "text"),
								   GetSQLValueString($_POST['prefsDateFormat'], "text"),
								   GetSQLValueString($_POST['prefsContact'], "text"),
								   GetSQLValueString($_POST['prefsTimeZone'], "text"),
								   GetSQLValueString($_POST['prefsEntryLimit'], "text"),
								   
								   GetSQLValueString($_POST['prefsTimeFormat'], "text"),
								   GetSQLValueString($_POST['prefsUserEntryLimit'], "int"),
								   GetSQLValueString($_POST['prefsUserSubCatLimit'], "int"),
								   GetSQLValueString($prefsUSCLEx, "text"),
								   GetSQLValueString($_POST['prefsUSCLExLimit'], "int"),
								   
								   GetSQLValueString($_POST['prefsPayToPrint'], "text"),
								   GetSQLValueString($_POST['prefsHideRecipe'], "text"),
								   GetSQLValueString($_POST['prefsUseMods'], "text"),
								   GetSQLValueString($_POST['prefsSEF'], "text"),
								   GetSQLValueString($_POST['prefsSpecialCharLimit'], "int"),
								   
								   GetSQLValueString($_POST['prefsStyleSet'], "text"),
								   GetSQLValueString($_POST['prefsAutoPurge'], "text"),
								   
								   GetSQLValueString($id, "int"));
								   
				mysql_select_db($database, $brewing);
				mysql_real_escape_string($updateSQL);
				$result1 = mysql_query($updateSQL, $brewing) or die(mysql_error());
				$pattern = array('\'', '"');
				$updateGoTo = str_replace($pattern, "", $updateGoTo); 
				header(sprintf("Location: %s", stripslashes($updateGoTo)));
		}
		
	} // end else NHC

} else echo "<p>Not available.</p>";
?>