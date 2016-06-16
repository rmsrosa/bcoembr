<?php

/**
 * Module:      headers.inc.php
 * Description: This module defines all header text for the application based
 *              upon URL variables.
 * 
 */

if ($_SESSION['jPrefsQueued'] == "N") $assign_to = "Flights"; else $assign_to = "Tables";

$header_output = "";
$output = "";
$output_extend = "";

switch($section) {
	
	case "default":
	$header_output = $_SESSION['contestName'];
	if ($msg == "success") { 
		$output = "Setup was successful.";
		$output_extend = "<div class=\"alert alert-info hidden-print\"><span class=\"fa fa-info-circle\"></span> You are now logged in and ready to further customize your competition's site.</p>"; 
	}
	
	if ($msg == "chmod") { 
		$output = "<strong>Setup was successful.</strong> However, your config.php permissions file could not be changed.";
		$output_extend = "<div class='alert alert-warning hidden-print'><span class=\"fa fa-exclamation-triangle\"> It is highly recommended that you change the server permissions (chmod) on the config.php file to 555. To do this, you will need to access the file on your server.</div>"; 
		if (($setup_free_access == TRUE) && ($action != "print")) $output_extend .= "<div class='alert alert-warning hidden-print'><span class=\"fa fa-exclamation-triangle\"> Additionally, the &#36;setup_free_access variable in config.php is currently set to TRUE. For security reasons, the setting should returned to FALSE. You will need to edit config.php directly and re-upload to your server to do this.</div>"; 
	}
	
	if     ($msg == "1") $output = "<strong>Informação adicionada com sucesso.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Informação editada com sucesso.</strong>";
	elseif ($msg == "3") $output = "<strong>Houve um erro. </strong>Por favor, tente novamente.";
	elseif ($msg == "4") $output = "<strong>Você precisa ser administrador para acessar as funções de administração. </strong>";
	break;

	case "user":
	$header_output = "Alterar "; 
	if ($action == "username") $header_output .= "Email"; 
	if ($action == "password") $header_output .= "Senha";
	if     ($msg == "1") $output = "<strong>O endereço de email informado já está em uso.  Por favor, informe outro email.</strong>";
	elseif ($msg == "2") $output = "<strong>Houve um problema com a sua última ação. Tente novamente.</strong>";
	elseif ($msg == "3") $output = "<strong>Sua senha atual está incorreta.</strong> Tente novamente.";
	elseif ($msg == "4") $output = "<strong>Por favor, informe um endereço de email.</strong>";
	else $output = "";
	break;
	
	case "register":
	$header_output = $_SESSION['contestName']." - Registro";
	if     ($msg == "1") $output = "<strong>Houve um problema com a sua última tentativa de login.</strong> Tente novamente.";
	elseif ($msg == "2") { $output = "<strong>Sinto muito, o nome de usuário que você informou já está em uso.</strong>"; $output_extend = "<p>Talvez você já tenha se registrado? Caso positivo, <a href=\"index.php?section=login\">faça o login aqui</a>.</p>"; }
	elseif ($msg == "3") $output = "<strong>O nome de usuário informado não é um endereço de email válido.</strong> Por favor, informe um endereço de email válido.";
	elseif ($msg == "4") $output = "<strong>Os caracteres informados no CAPTCHA não estão corretos.</strong> Tente novamente.";
	elseif ($msg == "5") $output = "<strong>Os endereços de email informados não coincidem.</strong> Confira e tente novamente.";
	elseif ($msg == "6") $output = "<strong>The AHA number you entered is already in the system.</strong> Please check the number and try again.";
	else $output = "";
	break;

	case "pay":
	$header_output = $_SESSION['contestName']." - Pagar Taxa de Inscrição";
	if     ($msg == "1") $output = "<strong>Informação adicionada com sucesso.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Informação editada com sucesso.</strong>";
	elseif ($msg == "3") $output = "<strong>Houve um erro. </strong>Por favor, tente novamente.";
	elseif ($msg == "10") $output = "<strong>O seu pagamento online foi recebido.</strong> Por favor, imprima o recibo e não se esqueça de anexá-lo a uma das suas amostras como prova de pagamento."; 
	elseif ($msg == "11") $output = "<strong>O seu pagamento online foi cancelado.</strong>";
	elseif ($msg == "12") $output = "<strong>O código foi verificado.</strong>";
	elseif ($msg == "13") $output = "<strong>Sinto muito, o código informado não está correto.</strong>";
	else $output = "";
	break;
	
	case "login":
	if ($action == "forgot") $header_output = $_SESSION['contestName']." - Alterar Senha"; 
	elseif ($action == "logout") $header_output = $_SESSION['contestName']." - Logged Out"; 
	else $header_output = $_SESSION['contestName']." - Log In";
	if ($msg == "0") $output = "<strong>You must log in and have admin privileges to access the ".$_SESSION['contestName']." administration functions.</strong> "; 
	elseif     ($msg == "1") { $output = "<strong>Houve um problema com o seu login.</strong> Por favor verifique se seu email e senha estão corretos."; $output_extend = ""; }
	elseif ($msg == "2") { $output = "<strong>Sua senha foi alterada para ".$go."</strong>."; $output_extend = "<p>Você pode acessar sua conta utilizando essa senha.</p>"; }
	elseif ($msg == "3") $output = "<strong>Você saiu do sistema. </strong> Para retornar, faça login novamente."; 
	elseif ($msg == "4") $output = "<strong>Sua resposta à pergunta de segurança não confere com os nossos registros. </strong> Por favor, tente novamente."; 
	elseif ($msg == "5") $output = "<strong>As informações sobre a sua pergunta de segurança foram enviadas para o email associado à sua conta.</strong>"; 
	else $output = ""; 
	break;
	
	case "entry":
	if     ($msg == "1") $output = "<strong>Informação adicionada com sucesso.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Informação editada com sucesso.</strong>";
	elseif ($msg == "3") $output = "<strong>Houve um erro.</strong> Por favor, tente novamente.";
	else $output = "";
	$header_output = $_SESSION['contestName']." - Informações";
	break;
	
	case "sponsors":
	if     ($msg == "1") $output = "<strong>Informação adicionada com sucesso.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Informação editada com sucesso.</strong>";
	elseif ($msg == "3") $output = "<strong>Houve um erro.</strong> Por favor, tente novamente.";
	else $output = "";
	$header_output = $_SESSION['contestName']." - Patrocinadores";
	break;
	
	case "rules":
	if     ($msg == "1") $output = "<strong>Info added successfully.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Info edited successfully.</strong>";
	elseif ($msg == "3") $output = "<strong>There was an error.</strong> Please try again.";
	else $output = "";
	$header_output = $_SESSION['contestName']." - Regras Gerais";
	break;
	
	case "volunteers":
	if     ($msg == "1") $output = "<strong>Informação adicionada com sucesso.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Informação editada com sucesso.</strong>";
	elseif ($msg == "3") $output = "<strong>Houve um erro.</strong> Por favor, tente novamente.";
	else $output = "";
	$header_output = $_SESSION['contestName']." - Voluntários";
	break;	
	
	case "past_winners":
	if     ($msg == "1") $output = "<strong>Info added successfully.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Info edited successfully.</strong>";
	elseif ($msg == "3") $output = "<strong>There was an error.</strong> Please try again.";
	else $output = "";
	$header_output = $_SESSION['contestName']." - Past Winners";
	break;
	
	case "contact":
	$header_output = $_SESSION['contestName']." - Contato";
	if ($msg == "1") {
	
	if (NHC) {
	// Place NHC SQL calls below
	
	
	}
	// end if (NHC)
	
	else {
	
		mysql_select_db($database, $brewing);
		$query_contact = sprintf("SELECT contactFirstName,contactLastName,contactPosition FROM $contacts_db_table WHERE id='%s'", $id);
		mysql_query("SET NAMES 'utf8'");
		$contact = mysql_query($query_contact, $brewing) or die(mysql_error());
		$row_contact = mysql_fetch_assoc($contact);
		
	}
	
	
	$output = "<strong>Sua mensagem foi enviada para ".$row_contact['contactFirstName']." ".$row_contact['contactLastName'].", ".$row_contact['contactPosition'].".</strong>";
	}
	elseif ($msg == "2") $output = "<strong>Os caracteres digitados no CAPTCHA abaixo não estão corretos.</strong> Por favor, tente novamente.";
	else $output = "";
	break;
	
	case "brew":
	if ($action == "add") $header_output = "Adicionar uma Amostra"; 
	else $header_output = "Editar uma Amostra.";
		if ($_SESSION['prefsStyleSet'] == "BJCP2008") {
			switch ($msg) {
				case "1-6-D":  $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify if wheat or rye is used.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-16-E": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the beer being cloned, the new style being produced, or the special ingredients and/or process being used. Additional background information on the style and/or beer may be provided to judges to assist in the judging, including style parameters or detailed descriptions of the beer. Beers fitting other Belgian categories should not be entered in this category.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-17-F": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the type of fruit(s) used in making the lambic.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-20-A": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the underlying beer style AND the fruit(s) used. The types of fruits MUST be specified. If the beer is based upon a classic style (e.g., Blonde Ale), then the specific style MUST be specified. Note that fruit-based lambics should be entered in the Fruit Lambic category (17F), while other fruit-based Belgian specialties should be entered in the Belgian Specialty Ale category (16E). Beer with chile peppers should be entered in the Spice/Herb/Vegetable Beer category (21A).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break; 
				case "1-21-A": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the underlying beer style as well as the type of spices, herbs, or vegetables used. If the beer is based on a classic style (e.g, Blonde Ale), the specific classic style MUST be specified. This category may also be used for chile pepper, coffee-, chocolate-, or nut-based beers (including combinations of these items). Note that many spice-based Belgian specialties may be entered in Category 16E. Beers that only have additional fermentables (honey, maple syrup, molasses, sugars, treacle, etc.) should be entered in the Specialty Beer category (23A).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-21-B": $output = "You MAY elect to specify the underlying beer style as well as the special ingredients used. The base style, spices, or other ingredients need not be identified. However, the beer MUST include spices and MAY include other fermentables (sugars, honey, maple syrup, etc.) or fruit. Whenever spices, herbs or additional fermentables are declared, each should be noticeable and distinctive in its own way (although not necessarily individually identifiable; balanced with the other ingredients is still critical). English-style Winter Warmers (some of which may be labeled Christmas Ales) are generally not spiced, and should be entered as Old Ales. Belgian-style Christmas ales should be entered as Belgian Specialty Ales (16E).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-22-B": $output = "<strong>See the area(s) highlighted in RED below.</strong> If this beer is based upon a classic style, you MUST specify it. Classic styles do not have to be cited (e.g., &ldquo;porter&rdquo; or &ldquo;brown ale&rdquo; is acceptable). The type of wood or other sources of smoke MUST be specified IF a &ldquo;varietal&rdquo; character is noticable. Entries that have a classic style cited will be judged on how well that style is represented, and how well it is balanced with the smoke character. Entries with a specific type or types of smoke cited will be judged on how well that type of smoke is recognizable and marries with the base style. Specific classic styles or smoke types do not have to be specified.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-22-C": $output = "<strong>See the area(s) highlighted in RED below.</strong> If this beer is based upon a classic style, you MUST specify it. Classic styles do not have to be cited (e.g., &ldquo;porter&rdquo; or &ldquo;brown ale&rdquo; is acceptable). The type of wood or other sources of smoke MUST be specified IF a &ldquo;varietal&rdquo; character is noticable. You should specify any unusual ingredients in either the base style or the wood if those characteristics are noticeable. Specialty or experimental base beer styles may be specified, as long as the other specialty ingredients are identified. This category should NOT be used for base styles where barrel-aging is a fundamental requirement for the style (e.g., Flanders Red, Lambic, etc.).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-23-A": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the &ldquo;Experimental Nature&rdquo; of the beer (e.g., type of special ingredients used, process utilized, or historical style being brewed), or why the beer doesn't fit an established style. For historical styles or unusual ingredients/techniques that may not be known to all beer judges, you should provide descriptions of the styles, ingredients and/or techniques as an aid to the judges.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-24-A":
				case "1-24-B":
				case "1-24-C": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still; petillant or lightly carbonated; sparkling or highly carbonated). You MUST specify strength level (hydromel or light mead; standard mead; sack or strong mead). You MUST specify sweetness level (dry; semi-sweet; sweet). You MAY specify honey varieties (use the Special Ingredients and/or Classic Style field). <br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-25-A": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still; petillant or lightly carbonated; sparkling or highly carbonated). You MUST specify strength level (hydromel or light mead; standard mead; sack or strong mead). You MUST specify sweetness level (dry; semi-sweet; sweet). You MAY specify honey varieties (use the Special Ingredients and/or Classic Style field). You MAY specify varieties of apples used (if specified, a varietal character will be expected - use the Special Ingredients and/or Classic Style field).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-25-B": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still; petillant or lightly carbonated; sparkling or highly carbonated). You MUST specify strength level (hydromel or light mead; standard mead; sack or strong mead). You MUST specify sweetness level (dry; semi-sweet; sweet). You MAY specify honey varieties  (use the Special Ingredients and/or Classic Style field). You MAY specify varieties of grapes used (if specified, a varietal character will be expected - use the Special Ingredients and/or Classic Style field).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-25-C": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the fruit(s) used. You MUST specify carbonation level (still; petillant or lightly carbonated; sparkling or highly carbonated). You MUST specify strength level (hydromel or light mead; standard mead; sack or strong mead). You MUST specify sweetness level (dry; semi-sweet; sweet). You MAY specify honey varieties (use the Special Ingredients and/or Classic Style field).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-26-A": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the spice(s) used. You MUST specify carbonation level (still; petillant or lightly carbonated; sparkling or highly carbonated). You MUST specify strength level (hydromel or light mead; standard mead; sack or strong mead). You MUST specify sweetness level (dry; semi-sweet; sweet). You MAY specify honey varieties (use the Special Ingredients and/or Classic Style field).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-26-B": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level, strength, and sweetness. You MAY specify honey varieties. You MAY specify the base style or beer or types of malt used (use the Special Ingredients and/or Classic Style field). Products with a relatively low proportion of honey should be entered in the Specialty Beer category (23A) as a Honey Beer<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-26-C": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify the special nature of the mead, whether it is a combination of existing styles, an experimental mead, a historical mead, or some other creation. Any special ingredients that impart an identifiable character MAY be declared. You MUST specify carbonation level (still; petillant or lightly carbonated; sparkling or highly carbonated). You MUST specify strength level (hydromel or light mead; standard mead; sack or strong mead). You MUST specify sweetness level (dry; semi-sweet; sweet).  You MAY specify honey varieties.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-27-A":
				case "1-27-B":
				case "1-27-C": 
				case "1-27-D": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still, petillant, or sparkling) AND sweetness (dry, medium, sweet). You MAY specify variety of apple for a single varietal cider; if specified, varietal character will be expected (use the Special Ingredients and/or Classic Style field).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-27-E": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still, petillant, or sparkling) AND sweetness (dry, medium, sweet). Variety of pear(s) used MUST be stated.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-28-A": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still, petillant, or sparkling) AND sweetness (dry, medium, sweet). You MUST specify if the cider was barrel-fermented or aged.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-28-B": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still, petillant, or sparkling) AND sweetness (dry, medium, sweet). You MUST specify what fruit(s) and/or fruit juice(s) were added.<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-28-C": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify carbonation level (still, petillant, or sparkling) AND sweetness (dry, medium, sweet).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "1-28-D": $output = "<strong>See the area(s) highlighted in RED below.</strong> You MUST specify all major ingredients and adjuncts. You MUST specify carbonation level (still, petillant, or sparkling) AND sweetness (dry, medium, sweet).<br /> If you do not specify the required items above, your entry cannot be confirmed. "; break;
				case "2": $output = "<strong>Dados adicionados com sucesso.</strong><br />"; break;
				case "3": $output = "<strong>Houve um erro.</strong> Por favor, tente novamente.<br />"; break;
				case "4": $output = "<strong>This competition utilizes custom entry categories.</strong> All custom entry categories require that you specify the special ingredients, classic style, or special procedures of the entry.<br>If you DO NOT specify these items, your entry cannot be confirmed. Unconfirmed entries may be deleted from the system without warning.<br />"; break;
				default: $output = "<strong>This entry has not yet been confirmed.</strong> Please review the information as listed and correct any errors. "; break;
			}
		}
	
	else {
		switch ($msg) {
				case "2": $output = "<strong>Dados adicionados com sucesso.</strong><br />"; break;
				case "3": $output = "<strong>Houve um erro.</strong> Por favor, tente novamente.<br />"; break;
				case "4": $output = "<strong>Essa competição permite categorias com amostras customizadas. </strong> Todas as amostras customizadas precisam que ingredientes especiais, estilos clássicos ou procedimentos especiais sejam informados. <br>Se você NÃO especificar esses itens, o cadastro dessa amostra não será confirmado. Amostras com cadastro não confirmado serão apagadas do sistema sem aviso prévio. <br />"; break;
				default: $output = "<strong>Mais informações são necessárias para que o cadastro dessa amostra seja aceito e confirmado. </strong> Observe a(s) área(s) marcadas em VERMELHO abaixo."; break;
		}
	}
	
	if ((strstr($msg,"1-")) && ($_SESSION['prefsAutoPurge'] == 1)) $output .= "O cadastro de amostras não confirmadas pode ser apagado do sistema sem aviso prévio.";
	break;
	
	case "brewer":
		if     ($msg == "1") $output = "<strong>Dados adicionados com sucesso.</strong>"; 
		elseif ($msg == "2") $output = "<strong>Dados alterados com sucesso.</strong>";
		elseif ($msg == "3") $output = "<strong>Houve um erro.</strong> Por favor, tente novamente.";
		else $output = "";
		if ($action == "add") $header_output = "Step 2: Informação da Conta"; 
		elseif ($go == "admin")  $header_output = "Editar Conta";
		else  $header_output = "Editar Conta";
		
	break;
	
	case "judge":
		$header_output = "Judge Info"; 
		if ($msg == "1") $output = "<strong>Info added successfully.</strong>"; 
		elseif ($msg == "2") $output = "<strong>Info edited successfully.</strong>";
		elseif ($msg == "3") $output = "<strong>There was an error.</strong> Please try again.";
		else $output = "";
	break;

	case "list":
	$header_output = "Minha Conta";
	if ($msg == "1") $output = "<strong>Dados adicionados com sucesso.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Dados alterados com sucesso.</strong>"; 
	elseif ($msg == "3") $output = "<strong>Seu endereço de email foi atualizado.</strong>"; 
	elseif ($msg == "4") $output = "<strong>Sua senha foi atualizada.</strong>"; 
	elseif ($msg == "5") $output = "<strong>Dados apagados com sucesso.</strong>"; 
	elseif ($msg == "6") $output = "<strong>Você deve verificar os dados de todas as suas amostras cadastradas usando BeerXML.</strong>"; 
	elseif ($msg == "7") $output = "<strong>Você se inscreveu como Juiz ou Auxiliar.</strong> Obrigado.";
	elseif ($msg == "8") $output = "<strong>Você alcançou o limite de amostras por inscrição.</strong> Essa amostra não será incluída. ";
	elseif ($msg == "9") $output = "<strong>Você alcançou o limite de amostras por sub-category.</strong> Essa amostra não será incluída.";
	elseif ($msg == "10") $output = "<strong>Só é permitido o cadastro de amostras de sócios das ACervAs. A checagem é via CPF; confira o CPF informado. Caso você seja associado em dia de alguma ACervA e o sistema não está permitindo o cadastro das suas amostras, entre em contato com a Organização do Concurso, informando de qual ACervA você é membro, para verificarmos se a sua ACervA nos enviou o seu CPF na lista de sócios.  </strong>";	
	else $output = "";
	break;
	
	case "step0":
	$header_output = "Set Up: Install DB Tables and Data";
	$sidebar_status_0 = "text-danger";
	$sidebar_status_1 = "text-muted";
	$sidebar_status_2 = "text-muted";
	$sidebar_status_3 = "text-muted";
	$sidebar_status_4 = "text-muted";
	$sidebar_status_5 = "text-muted";
	$sidebar_status_6 = "text-muted";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-refresh";
	$sidebar_status_icon_1 = "fa fa-clock-o";
	$sidebar_status_icon_2 = "fa fa-clock-o";
	$sidebar_status_icon_3 = "fa fa-clock-o";
	$sidebar_status_icon_4 = "fa fa-clock-o";
	$sidebar_status_icon_5 = "fa fa-clock-o";
	$sidebar_status_icon_6 = "fa fa-clock-o";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	
	break;

	case "step1":
	$header_output = "Set Up: Create Admin User";
	if ($msg == "1") $output = "<strong>Please provide an email address.</strong>";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-danger";
	$sidebar_status_2 = "text-muted";
	$sidebar_status_3 = "text-muted";
	$sidebar_status_4 = "text-muted";
	$sidebar_status_5 = "text-muted";
	$sidebar_status_6 = "text-muted";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-refresh";
	$sidebar_status_icon_2 = "fa fa-clock-o";
	$sidebar_status_icon_3 = "fa fa-clock-o";
	$sidebar_status_icon_4 = "fa fa-clock-o";
	$sidebar_status_icon_5 = "fa fa-clock-o";
	$sidebar_status_icon_6 = "fa fa-clock-o";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;
	
	case "step2":
	$header_output = "Set Up: Add Admin User Info";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-danger";
	$sidebar_status_3 = "text-muted";
	$sidebar_status_4 = "text-muted";
	$sidebar_status_5 = "text-muted";
	$sidebar_status_6 = "text-muted";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-refresh";
	$sidebar_status_icon_3 = "fa fa-clock-o";
	$sidebar_status_icon_4 = "fa fa-clock-o";
	$sidebar_status_icon_5 = "fa fa-clock-o";
	$sidebar_status_icon_6 = "fa fa-clock-o";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;
	
	case "step3":
	$header_output = "Set Up: Set Website Preferences";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-success";
	$sidebar_status_3 = "text-danger";
	$sidebar_status_4 = "text-muted";
	$sidebar_status_5 = "text-muted";
	$sidebar_status_6 = "text-muted";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-check";
	$sidebar_status_icon_3 = "fa fa-refresh";
	$sidebar_status_icon_4 = "fa fa-clock-o";
	$sidebar_status_icon_5 = "fa fa-clock-o";
	$sidebar_status_icon_6 = "fa fa-clock-o";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;
	
	case "step4":
	$header_output = "Set Up: Add Competition Info";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-success";
	$sidebar_status_3 = "text-success";
	$sidebar_status_4 = "text-danger";
	$sidebar_status_5 = "text-muted";
	$sidebar_status_6 = "text-muted";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-check";
	$sidebar_status_icon_3 = "fa fa-check";
	$sidebar_status_icon_4 = "fa fa-refresh";
	$sidebar_status_icon_5 = "fa fa-clock-o";
	$sidebar_status_icon_6 = "fa fa-clock-o";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;
	
	case "step5":
	$header_output = "Set Up: Add Judging Locations";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-success";
	$sidebar_status_3 = "text-success";
	$sidebar_status_4 = "text-success";
	$sidebar_status_5 = "text-danger";
	$sidebar_status_6 = "text-muted";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-check";
	$sidebar_status_icon_3 = "fa fa-check";
	$sidebar_status_icon_4 = "fa fa-check";
	$sidebar_status_icon_5 = "fa fa-refresh";
	$sidebar_status_icon_6 = "fa fa-clock-o";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;

	case "step6":
	$header_output = "Set Up: Add Drop-Off Locations";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-success";
	$sidebar_status_3 = "text-success";
	$sidebar_status_4 = "text-success";
	$sidebar_status_5 = "text-success";
	$sidebar_status_6 = "text-danger";
	$sidebar_status_7 = "text-muted";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-check";
	$sidebar_status_icon_3 = "fa fa-check";
	$sidebar_status_icon_4 = "fa fa-check";
	$sidebar_status_icon_5 = "fa fa-check";
	$sidebar_status_icon_6 = "fa fa-refresh";
	$sidebar_status_icon_7 = "fa fa-clock-o";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;
	
	case "step7":
	$header_output = "Set Up: Designate Accepted Styles";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-success";
	$sidebar_status_3 = "text-success";
	$sidebar_status_4 = "text-success";
	$sidebar_status_5 = "text-success";
	$sidebar_status_6 = "text-success";
	$sidebar_status_7 = "text-danger";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-check";
	$sidebar_status_icon_3 = "fa fa-check";
	$sidebar_status_icon_4 = "fa fa-check";
	$sidebar_status_icon_5 = "fa fa-check";
	$sidebar_status_icon_6 = "fa fa-check";
	$sidebar_status_icon_7 = "fa fa-refresh";
	$sidebar_status_icon_8 = "fa fa-clock-o";
	break;
	
	case "step8":
	$header_output = "Set Up: Set Judging Preferences";
	$sidebar_status_0 = "text-success";
	$sidebar_status_1 = "text-success";
	$sidebar_status_2 = "text-success";
	$sidebar_status_3 = "text-success";
	$sidebar_status_4 = "text-success";
	$sidebar_status_5 = "text-success";
	$sidebar_status_6 = "text-success";
	$sidebar_status_7 = "text-success";
	$sidebar_status_8 = "text-muted";
	$sidebar_status_icon_0 = "fa fa-check";
	$sidebar_status_icon_1 = "fa fa-check";
	$sidebar_status_icon_2 = "fa fa-check";
	$sidebar_status_icon_3 = "fa fa-check";
	$sidebar_status_icon_4 = "fa fa-check";
	$sidebar_status_icon_5 = "fa fa-check";
	$sidebar_status_icon_6 = "fa fa-check";
	$sidebar_status_icon_7 = "fa fa-check";
	$sidebar_status_icon_8 = "fa fa-refresh";
	break;

	case "beerxml":
	include(DB.'styles.db.php');
	$header_output = "Import an Entry Using BeerXML";
	if ($msg == "default") { 
	if ($totalRows_styles < 98) $output_extend = "<div class=\"alert alert-info hidden-print\"><span class=\"fa fa-info-circle\"></span> <strong>Our competition accepts ".$totalRows_styles." of the 98 BJCP sub-styles.</strong> To make sure each of your entries are entered into one of the accepted categories, you should verify each entry.</div>"; else $output_extend = ""; 
	}
	if ($msg == "1") $output = "<strong>Your entry has been recorded.</strong>";
	if ($msg == "2") $output = "<strong>Your entry has been confirmed.</strong>";
	break;

	case "admin":
	if ($action != "print") $header_output = "Administration"; 
	else $header_output = $_SESSION['contestName'];
	
		switch($go) {
			
			case "default": 
			$header_output .= " Dashboard";
			break;
		
			case "judging":
			$header_output .= ": Judging";
			break;
			
			case "stewards":
			$header_output .= ": Stewarding";
			break;
			
			case "participants":
			$header_output .= ": Participants";
			break;
			
			case "entrant":
			$header_output .= ": Participants";
			break;
			
			case "judge":
			$header_output .= ": Participants";
			break;
			
			case "entries":
			$header_output .= ": Entries";
			break;
			
			case "contest_info":
			$header_output .= ": Competition Info"; 
			break;
						
			case "preferences":
			$header_output .= ": Website Preferences";
			break;
			
			case "judging_preferences":
			$header_output .= ": Competition Organization Preferences";
			break;
			
			case "archive":
			$header_output .= ": Archives";
			break;
			
			case "styles":
			$header_output .= ": Styles";
			break;
			
			case "dropoff":
			$header_output .= ": Drop-Off Locations";
			break;
			
			case "contacts":
			$header_output .= ": Contacts";
			break;
			
			case "judging_tables":
			$header_output .= ": Tables";
			break;
			
			case "judging_flights":
			$header_output .= ": ".$assign_to;
			break;
			
			case "judging_scores":
			$header_output .= ": Scoring";
			break;
			
			case "judging_scores_bos":
			$header_output .= ": Best of Show";
			break;
			
			case "style_types":
			$header_output .= ": Style Types";
			break;
			
			case "special_best":
			$header_output .= ": Custom Categories";
			break;
			
			case "special_best_data":
			$header_output .= ": Custom Category Entries";
			break;
			
			case "sponsors":
			$header_output .= ": Sponsors";
			break;
			
			case "count_by_style":
			$header_output .= ": Entry Count by Style";
			break;
			
			case "count_by_substyle":
			$header_output .= ": Entry Count by Sub-Style";
			break;
			
			case "mods":
			$header_output .= ": Custom Modules";
			break;
			
			case "checkin":
			$header_output .= ": Entry Check-In";
			break;
			
			case "make_admin":
			$header_output .= ": Change User Level";
			break;
			
			case "register":
			$header_output .= ": Register a Participant";
			break;
			
			case "upload":
			$header_output .= ": Upload Logo Images";
			break;
		}
	
	if     ($msg == "1") $output = "<strong>Info added successfully.</strong>"; 
	elseif ($msg == "2") $output = "<strong>Info edited successfully.</strong>";
	elseif ($msg == "3") $output = "<strong>There was an error.</strong> Please try again.";
	elseif ($msg == "4") $output = "<strong>All received entries have been checked and those not assigned to tables have been assigned.</strong>"; 
	elseif ($msg == "5") $output = "<strong>Info deleted successfully.</strong>";
	elseif ($msg == "6") $output = "<strong>The suffix you entered is already in use, please enter a different one.</strong>"; 
	elseif ($msg == "7") { 
		if (HOSTED) $output = "<strong>The specified competition data has been cleared.</strong>"; 
		else $output = "<strong>Archives created successfully.</strong> Click the archive name to view. ";
		$output_extend = "<div class=\"alert alert-info hidden-print\"><span class=\"fa fa-info-circle\"></span> <strong>Remember to update your <a class='alert-link' href='".$base_url."/index.php?section=admin&amp;go=contest_info'>Competition Information</a> and your <a class='alert-link' href='".$base_url."/index.php?section=admin&amp;go=contest_info'>Judging Dates</a> if you are starting a new competition.</strong></div>";
	
	}
	elseif ($msg == "8") $output = "<strong>Archive \"".$filter."\" deleted.</strong>"; 
	elseif ($msg == "9") $output = "<strong>The records have been updated.</strong>";
	elseif ($msg == "10") $output = "<strong>The username you have entered is already in use.</strong>";
	elseif ($msg == "11") { 
		$output = "Add another drop-off location?"; 
		$output_extend = "<p><a href='"; 
		if ($section == "step4") $output_extend .= "setup.php?section=step4"; else $output_extend .= "index.php?section=admin&amp;go=dropoff"; 
		$output_extend .="'>Yes</a>&nbsp;&nbsp;&nbsp;<a href='"; if ($section == "step4")
		$output_extend .= "setup.php?section=step5"; else $output_extend .= "index.php?section=admin'>No</a>"; 
		}
	elseif ($msg == "12") { 
		$output = "Add another judging location, date, or time?"; 
		$output_extend = "<p><a href='"; 
		if ($section == "step3") $output_extend .= "setup.php?section=step3"; else $output_extend .= "index.php?section=admin&amp;go=judging"; 
		$output_extend .="'>Yes</a>&nbsp;&nbsp;&nbsp;<a href='"; 
		if ($section == "step3") $output_extend .= "setup.php?section=step4"; else $output_extend .= "index.php?section=admin'>No</a>"; 
		}
	elseif ($msg == "13") $output = "<strong>The table that was just defined does not have any associated styles.</strong>";
	elseif ($msg == "15") $output = "<strong>One or more pieces of required data are missing - outlined in red below.</strong> Please check your data and enter again.";
	elseif ($msg == "18") $output = "<strong>The email addresses you entered do not match.</strong> Please check and try again.";
	elseif ($msg == "19") $output = "<strong>The AHA number you entered is already in the system.</strong> Please check the number and try again.";
	elseif ($msg == "20") $output = "<strong>All entries have been marked as paid.</strong>";
	elseif ($msg == "21") $output = "<strong>All entries have been marked as received.</strong>";
	elseif ($msg == "22") $output = "<strong>All unconfirmed entries are now marked as confirmed.</strong>";
	elseif ($msg == "23") $output = "<strong>All participant assignments have been cleared.</strong>";
	elseif ($msg == "24") $output = "<strong>A judging number you entered wasn't found in the database.</strong> Please check and re-enter.";
	elseif ($msg == "25") $output = "<strong>All entry styles have been converted from BJCP 2008 to BJCP 2015.</strong>";
	elseif ($msg == "26") $output = "<strong>Data has been deleted from the database.</strong>";
	elseif ($msg == "28") $output = "<strong>The judge/steward has been added successfully.</strong> Remember to assign the user as a judge or steward before assigning to tables.";
	elseif ($msg == "29") $output = "<strong>The image has been uploaded successfully.</strong> Check the list to verify.";
	elseif ($msg == "30") $output = "<strong>The file that was attempted to be uploaded is not an image file.</strong> Please try again.";
	elseif ($msg == "31") $output = "<strong>The file has been deleted.</strong>";
	elseif ($msg == "755") $output = "<strong>Change permission of user_images folder to 755 has failed.</strong>  You will need to change the folder&rsquo;s permission manually.  Consult your FTP program or ISP&rsquo;s documentation for chmod (folder permissions).";
	else $output = "";
	break;
}

if ($msg == "14") $output = "<strong>Judging Numbers have been regenerated using the method you specified.</strong>";
if ($msg == "16") { $output = "<strong>Your installation has been set up successfully!</strong>"; $output_extend = "<div class=\"alert alert-warning\"><span class=\"fa fa-exclamation-triangle\"></span> <strong>FOR SECURITY REASONS you should immediately set the &#36;setup_free_access variable in config.php to FALSE.</strong> Otherwise, your installation and server are vulerable to security breaches.</div><div class=\"alert alert-info\"><span class=\"fa fa-info-circle\"></span> <strong>Log in now to access the Admin Dashboard</strong>.</div>"; }
if ($msg == "17") $output = "<strong>Your installation has been updated successfully!</strong>";
if ($msg == "27") $output = "<strong>The email addresses do not match. Please enter again.</strong>";
if ($msg == "99") $output = "<strong>Please log in to access your account.</strong>";
?>