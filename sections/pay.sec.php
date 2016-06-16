<?php
/**
 * Module:      pay.sec.php 
 * Description: This module dispays payment information based upon the competition-
                specific payment preferences. 
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

	$bid = $_SESSION['user_id'];
	include (DB.'entries.db.php');
	
	$total_entry_fees = total_fees($_SESSION['contestEntryFee'], $_SESSION['contestEntryFee2'], $_SESSION['contestEntryFeeDiscount'], $_SESSION['contestEntryFeeDiscountNum'], $_SESSION['contestEntryCap'], $_SESSION['contestEntryFeePasswordNum'], $bid, $filter);
	$total_paid_entry_fees = total_fees_paid($_SESSION['contestEntryFee'], $_SESSION['contestEntryFee2'], $_SESSION['contestEntryFeeDiscount'], $_SESSION['contestEntryFeeDiscountNum'], $_SESSION['contestEntryCap'], $_SESSION['contestEntryFeePasswordNum'], $bid, $filter);
	$total_to_pay = $total_entry_fees - $total_paid_entry_fees; 
	$total_not_paid = total_not_paid_brewer($_SESSION['user_id']);
	$unconfirmed = array_sum(entries_unconfirmed($_SESSION['user_id']));
	
	$warning1 = "";
	$warning2 = "";
	$warning3 = "";
	$primary_page_info = "";
	$header1_1 = "";
	$page_info1 = "";
	$header1_2 = "";
	$page_info2 = "";
	$header1_3 = "";
	$page_info3 = "";
	$header2_4 = "";
	$page_info4 = "";
	$header2_5 = "";
	$page_info5 = "";
	$page_info6 = "";
	$header1_7 = "";
	$page_info7 = "";
	$return_entries = "";
	
	// Build top of page info: total entry fees, list of unpaid entries, etc.
	
	$primary_page_info .= sprintf("<p class=\"lead\">%s, o pagamento deve ser feito via PayPal.</p>",$_SESSION['brewerFirstName']);
	$primary_page_info .= "<p class=\"lead\"><small>";
	$primary_page_info .= sprintf("<span class=\"fa fa-money text-success\"></span> A taxa é de <strong class=\"text-success\">%s</strong> por amostra.",$currency_symbol.number_format($_SESSION['contestEntryFee'],2,',',''));
	if ($_SESSION['contestEntryFeeDiscount'] == "Y") $primary_page_info .= sprintf(" %s por amostra após a %s amostra. ",$currency_symbol.number_format($_SESSION['contestEntryFee2'], 2),addOrdinalNumberSuffix($_SESSION['contestEntryFeeDiscountNum'])); 
	if ($_SESSION['contestEntryCap'] != "") $primary_page_info .= sprintf(" %s por amostras ilimitadas. ",$currency_symbol.number_format($_SESSION['contestEntryCap'], 2));
	$primary_page_info .= "</small></p>";
	if ($row_brewer['brewerDiscount'] == "Y") {
		$primary_page_info .= sprintf("<p class=\"lead\"><small><span class=\"fa fa-star-o text-primary\"></span> A taxa, após o desconto, é de <strong class=\"text-success\">%s</strong> por amostra.</small></p>",$currency_symbol.number_format($_SESSION['contestEntryFeePasswordNum'], 2));
	}
	$primary_page_info .= sprintf("<p class=\"lead\"><small><span class=\"fa fa-exclamation-triangle text-danger\"></span>  O seu total de taxa de inscrição é de <strong class=\"text-success\">%s</strong>. Você já pagou <strong class=\"text-success\">%s</strong>. Ainda falta pagar <strong class=\"text-danger\">%s</strong>.</small></p>",$currency_symbol.number_format($total_entry_fees,2,',',''),$currency_symbol.number_format($total_paid_entry_fees,2,',',''),$currency_symbol.number_format($total_to_pay,2,',',''));
	
	if ($total_not_paid == 0) $primary_page_info .= sprintf("<p class=\"lead\"><small><span class=\"fa fa-thumbs-o-up text-danger\"></span> %s</p>","Todas as amostras foram pagas. Obrigado!</small></p>");
	
	
	else {
		$primary_page_info .= "<p class=\"lead\"><small>";
		$primary_page_info .= sprintf("<span class=\"fa fa-exclamation-triangle text-danger\"></span>  No momento você tem <strong class=\"text-danger\">%s  ",readable_number($total_not_paid));
		if ($total_not_paid == "1") $primary_page_info .= "amostra confirmada não paga</strong>:"; else $primary_page_info .= "amostras confirmadas não pagas</strong>:";
		$primary_page_info .= "</small></p>";
		$primary_page_info .= "<ol>";
			do { 
				if ($row_log_confirmed['brewPaid'] != "1") {
					$entry_no = sprintf("%04s",$row_log_confirmed['id']);
					$primary_page_info .= sprintf("<li>Amostra #%s: %s (Categoria %s)</li>",$entry_no,$row_log_confirmed['brewName'],$row_log_confirmed['brewCategory'].$row_log_confirmed['brewSubCategory']);
					$entries .= sprintf("%04s",$row_log_confirmed['id']).", ";
					$return_entries .= $row_log_confirmed['id']."-";
				}
			} while ($row_log_confirmed = mysql_fetch_assoc($log_confirmed)); 
		$primary_page_info .= "</ol>";
	}
	
	$return = $base_url."index.php?section=pay&msg=10&view=".$return_entries;
	$entries = "";
	
	if (($total_to_pay > 0) && ($view == "default")) {
		
		// Cash Payment
		if ($_SESSION['prefsCash'] == "Y") { 
			$header1_1 .= "<h2>Cash</h2>";
			$page_info1 .= "<p>Attach cash payment for the entire entry amount in a <em>sealed envelope</em> to one of  your bottles.</p>";
			$page_info1 .= "<p>Your returned score sheets will serve as your entry receipt.</p>";
		}
	
		
		if ($_SESSION['prefsCheck'] == "Y") {
			// Check Payment
			$header1_2 .= "<h2>Checks</h2>";
			$page_info2 .= sprintf("<p>Attach a check for the entire entry amount to one of your bottles. Checks should be made out to <em>%s</em>.</p>",$_SESSION['prefsCheckPayee']);
			$page_info2 .= "<p>Your check carbon or cashed check is your entry receipt.</p>";
		}
	
		if ($_SESSION['prefsPaypal'] == "Y")  { 
					
//			if ($_SESSION['prefsTransFee'] == "Y") $payment_amount = $total_to_pay + number_format((($total_to_pay * .03) + .30), 2, '.', ''); 
//			if ($_SESSION['prefsTransFee'] == "Y") $payment_amount = number_format($total_to_pay * 1.03 + .30, 2, ',', ''); 
			if ($_SESSION['prefsTransFee'] == "Y") $payment_amount = number_format($total_to_pay * 1.05 + .60,2);
			else $payment_amount = number_format($total_to_pay, 2);
			$fee = number_format((($total_to_pay * .05) + .60), 2); 
		
			// Online
			$header1_3 .= "<h2>Pague Online</h2>";
			$page_info3 .= "<p>O email de confirmação será o seu recibo. Inclua uma cópia do email de confirmação junto com as amostras.</p>";
		
			// PayPal
			$header2_4 .= "<h3>PayPal <span class=\"fa fa-cc-paypal\"></span> <span class=\"fa fa-cc-visa\"></span> <span class=\"fa fa-cc-mastercard\"></span> <span class=\"fa fa-cc-discover\"></span> <span class=\"fa fa-cc-amex\"></span></h3>";
			$page_info4 .= "<p>Clique no botão &ldquo;Pay with PayPal&rdquo; abaixo para pagar online.";
			if ($_SESSION['prefsTransFee'] == "Y") $page_info4 .= sprintf(" Observe que uma taxa de transação de <strong class=\"text-danger\">%s</strong> será adicionada ao seu pagamento, totalizando <strong class=\"text-danger\">%s</strong>.</p>",$currency_symbol.number_format($fee,2,',',''),$currency_symbol.number_format($payment_amount,2,',',''));
			//$page_info4 .= "<div class=\"alert alert-warning\"><span class=\"fa fa-exclamation-triangle\"> <strong>IMPORTANTE! Clique no linke &quot;Retorne para ...&quot; na página de confirmação de pagamento do PayPal.</strong> Isso irá garantir que a sua amostra será marcada como &quot;paga&quot; no <em>nosso sistema</em>. Caso isso não seja feito, entre imediatamente em contato com a organização do concurso, caso contráio a inclusão da sua amostra corre o risco de ser cancelada. </div>";
			$page_info4 .= "<form role=\"form\" id=\"formfield\"  name=\"PayPal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" name=\"form1\">";
			$page_info4 .= "<input type=\"hidden\" name=\"action\" value=\"add_form\" />";
			$page_info4 .= "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">";
			$page_info4 .= sprintf("<input type=\"hidden\" name=\"business\" value=\"%s\">",$_SESSION['prefsPaypalAccount']);
			$page_info4 .= sprintf("<input type=\"hidden\" name=\"item_name\" value=\"%s, %s - %s Payment\">",$_SESSION['brewerLastName'],$_SESSION['brewerFirstName'],$_SESSION['contestName']);
			$page_info4 .= sprintf("<input type=\"hidden\" name=\"amount\" value=\"%s\">",$payment_amount);
			$page_info4 .= sprintf("<input type=\"hidden\" name=\"currency_code\" value=\"%s\">",$currency_code);
			$page_info4 .= "<input type=\"hidden\" name=\"button_subtype\" value=\"services\">";
			$page_info4 .= "<input type=\"hidden\" name=\"no_note\" value=\"0\">";
			$page_info4 .= "<input type=\"hidden\" name=\"cn\" value=\"Add special instructions\">";
			$page_info4 .= "<input type=\"hidden\" name=\"no_shipping\" value=\"1\">";
			$page_info4 .= "<input type=\"hidden\" name=\"rm\" value=\"1\">";
			$page_info4 .= sprintf("<input type=\"hidden\" name=\"return\" value=\"%s\">",rtrim($return, '-'));
			$page_info4 .= sprintf("<input type=\"hidden\" name=\"cancel_return\" value=\"%s\">",$base_url."index.php?section=pay&msg=11");
			$page_info4 .= "<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted\">";
			$page_info4 .= "<button type=\"button\" type=\"submit\" name=\"Submit\" id=\"submitBtn\" data-toggle=\"modal\" data-target=\"#confirm-submit\" class=\"btn btn-primary\" /><span class=\"fa fa-paypal\"><span> Pay with PayPal</button>";
			$page_info4 .= "</form>";
			$page_info4 .= "<!-- Form submit confirmation modal -->";
			$page_info4 .= "<!-- Refer to bcoem_custom.js for configuration -->";
			$page_info4 .= "<div class=\"modal fade\" id=\"confirm-submit\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">";
			$page_info4 .= "<div class=\"modal-dialog\">";
			$page_info4 .= "<div class=\"modal-content\">";
			$page_info4 .= "<div class=\"modal-header\">";
			$page_info4 .= "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$page_info4 .= "<h4 class=\"modal-title\">NÃO Se Esqueça de Clicar em &ldquo;Clique aqui para voltar para...&rdquo; Após Enviar o Pagamento</h4>";
			$page_info4 .= "</div>";
			$page_info4 .= "<div class=\"modal-body\"><p><strong class=\"text-danger\">IMPORTANTE!</strong> Para garantir que a sua amostra apareça como tendo sido <strong>paga</strong> no <strong>nosso sistema</strong>, não esqueça de clicar no link &ldquo;Clique aqui para voltar para ...&rdquo; na página de confirmação de pagamento do PayPal <strong>após</strong> você ter enviado o seu pagamento.</p><p>Além disso, não se esqueça de imprimir o recibo do seu pagamento e de incluir uma cópia do recibo junto com as suas amostras.</p>";
			$page_info4 .= "</div>";
			$page_info4 .= "<div class=\"modal-footer\">";
			$page_info4 .= "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Cancelar</button>";
			$page_info4 .= "<a href=\"#\" id=\"submit\" class=\"btn btn-success success\">Eu estou ciente</a>";
			$page_info4 .= "</div>";
			$page_info4 .= "</div>";
			$page_info4 .= "</div>";
			$page_info4 .= "</div>";
	
			/*
			if ($_SESSION['prefsGoogle'] == "Y") {
				// Google Wallet
				$header2_5 .= "<h2>Google Wallet</h2>";
				$page_info5 .= "<p>Click the &quot;Buy Now&quot; button below to pay online using Google Wallet.";
				if ($_SESSION['prefsTransFee'] == "Y") $page_info5 .= sprintf(" Please note that a transaction fee of %s will be added into your total.</p>",$currency_symbol.$fee);
				$page_info5 .= "<div class='error'>To make sure your Google Wallet payment is marked &quot;paid&quot; on <em>this site</em>, please click the &quot;Return to...&quot; link on Google Wallet's confirmation screen after you have sent your payment.</div>";
				$page_info5 .= sprintf("<form action='https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/%s' id='BB_BuyButtonForm' method='post' name='BB_BuyButtonForm' target='_top'>",$_SESSION['prefsGoogleAccount']);
				$page_info5 .= sprintf("<input name='item_name_1' type='hidden' value='%s, %s - %s Payment'>",$_SESSION['brewerLastName'],$_SESSION['brewerFirstName'],$_SESSION['contestName']);
				$page_info5 .= sprintf("<input name='checkout-flow-support.merchant-checkout-flow-support.continue-shopping-url' type='hidden' value='%s' />",rtrim($return, '-'));
				$page_info5 .= sprintf("<input name='item_description_1' type='hidden' value='Entry #: %s'/>",rtrim($entries,', '));
				$page_info5 .= "<input name='item_quantity_1' type='hidden' value='1'/>";
				$page_info5 .= sprintf("<input name='item_price_1' type='hidden' value='%s'/>",$payment_amount);
				$page_info5 .= sprintf("<input name='item_currency_1' type='hidden' value='%s'/>",$currency_code);
				$page_info5 .= "<input name='_charset_' type='hidden' value='utf-8'/>";
				$page_info5 .= sprintf("<input src='https://checkout.google.com/buttons/buy.gif?merchant_id=%s&amp;w=117&amp;h=48&amp;style=white&amp;variant=text&amp;loc=en_US' type='image' class='paypal' alt='Pay your competition entry fees with Google Wallet' title='Pay your compeition entry fees with Google Wallet'/>",$_SESSION['prefsGoogleAccount']);
				$page_info5 .= "</form>";
	
			}
			*/
			
		} // end if (($_SESSION['prefsPaypal'] == "Y") || ($_SESSION['prefsGoogle'] == "Y"))
		
	}
	
	if (($row_brewer['brewerDiscount'] != "Y") && ($row_contest_info['contestEntryFeePassword'] != "") && ((($total_entry_fees > 0) && ($total_entry_fees != $total_paid_entry_fees)))) {
		$header1_7 .= "<h2>Discounted Entry Fee</h2>";
		$page_info7 .= "<p>Enter the code supplied by the competition organizers for a discounted entry fee.</p>";
		$page_info7 .= "<form class=\"form-inline\" action=\"".$base_url."includes/process.inc.php?action=check_discount&amp;dbTable=".$brewer_db_table."&amp;id=".$row_brewer['uid']."\" method=\"POST\" name=\"form1\" id=\"form1\">";
		$page_info7 .= "
		<div class=\"form-group\"><!-- Form Group NOT REQUIRED Text Input -->
            	<label for=\"brewerDiscount\" class=\"sr-only\">Discount Code</label>
                    <!-- Input Here -->
                    <input class=\"form-control\" name=\"brewerDiscount\" type=\"text\" value=\"\" placeholder=\"Enter Discount Code\" autofocus>
            </div><!-- ./Form Group -->
		";
		$page_info7 .= sprintf("<input type=\"submit\" class=\"btn btn-primary\" value=\"%s\">","Verify");
		$page_info7 .= "</form>";
	}
	
	if (($total_entry_fees > 0) && ($total_entry_fees == $total_paid_entry_fees)) $page_info6 .= "<span class=\"fa fa-thumbs-o-up\"></span> Todas as amostras foram pagas. Obrigado!</p>";
	if ($total_entry_fees == 0) $page_info6 .= "<p>Você ainda não incluiu nenhuma amostra em sua inscrição.</p>";
	
	if (($_SESSION['prefsPayToPrint'] == "Y") && ($unconfirmed > 0)) $warning1 .= "<div class=\"alert alert-danger\"><span class=\"fa fa-exclamation-circle\"></span> <strong>Você não pode pagar pelas amostras porque uma ou mais de suas amostras não estão confirmadas.</strong> Clique em &ldquo;Minha Conta&rdquo; acima para revisar as suas amostras não confirmadas.</div>"; 
	
		
	// --------------------------------------------------------------
	// Display
	// --------------------------------------------------------------
	
	
	
	if ($total_entry_fees > 0) { 
		
		if (($_SESSION['prefsPayToPrint'] == "N") && (($totalRows_log - $totalRows_log_confirmed) > 0)) $warning2 .= "<div class=\"alert alert-warning\"><span class=\"fa fa-exclamation-triangle\"> <strong>Você possui amostras não confirmadas que  <em>não</em> estão incluídas na taxa total abaixo.</strong> Por favor, clique em <a class=\"alert-link\" href=\"".build_public_url("list","default","default","default",$sef,$base_url)."#entries\">sua lista de amostras</a> para confirmar todas as suas amostras. Amostras não confirmadas podem ser apagadas do sistema sem mais avisos.</div>";
		
		echo $warning1;
		echo $warning2;
		echo $primary_page_info;
		echo $header1_7;
		echo $page_info7;
		echo $header1_1;
		echo $page_info1;
		echo $header1_2;
		echo $page_info2;
		echo $header1_3;
		echo $page_info3;
		echo $header2_4;
		echo $page_info4;
		//echo $header2_5;
		//echo $page_info5;
		
	} // end if ($total_entry_fees > 0)
	
	else echo $page_info6;
	
?>
