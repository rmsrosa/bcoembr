<?php
/**
 * Module:      user.sec.php 
 * Description: This module houses the functionality for users to add/update enter their
 *              user name and password information. 
 * 
 */

if ((($_SESSION['loginUsername'] == $_SESSION['user_name'])) || ($_SESSION['userLevel'] <= "1")) {

// Build Variables
$user_help_link = "";
$user_help_link_text = "";

if ($action == "username") { 
	$user_help_link .= "change_email_address.html";
	$user_help_link_text .= "Ajuda Mudança de Email";
}

if ($action == "password") {
	$user_help_link .= "change_password.html";
	$user_help_link_text .= "Ajuda Mudança de Senha";
}

if ($action == "username") {
	if ($filter == "admin")$current_email_msg = "You are changing ".$row_brewer['brewerFirstName']." ".$row_brewer['brewerLastName']."&rsquo;s Email Address (User Name)."; 
	else $current_email_msg = "O seu endereço de email atual é <small class=\"text-muted\">".$_SESSION['user_name']."</small>.";
}

?>
<?php if ($action == "username") { ?>

<script type="text/javascript">
function checkAvailability()
{
	jQuery.ajax({
		url: "<?php echo $base_url; ?>includes/ajax_functions.inc.php?action=username",
		data:'user_name='+$("#user_name").val(),
		type: "POST",
		success:function(data){
			$("#status").html(data);
		},
		error:function (){}
	});
}

function AjaxFunction(email)
{
	var httpxml;
		try
		{
		// Firefox, Opera 8.0+, Safari
		httpxml=new XMLHttpRequest();
		}
	catch (e)
		{
		// Internet Explorer
		try
		{
		httpxml=new ActiveXObject("Msxml2.XMLHTTP");
		}
	catch (e)
		{
		try
		{
		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e)
		{
		//alert("Your browser does not support AJAX!");
	return false;
	}
	}
}
function stateck()
{
if(httpxml.readyState==4)
{
document.getElementById("msg_email").innerHTML=httpxml.responseText;
}
}
var url="<?php echo $base_url; ?>includes/ajax_functions.inc.php?action=email";
url=url+"&email="+email;
url=url+"&sid="+Math.random();
httpxml.onreadystatechange=stateck;
httpxml.open("GET",url,true);
httpxml.send(null);
}
//-->
</script>

<?php } // end if ($action == "username") ?>
<p class="lead"><?php echo $current_email_msg; ?></p>
<form data-toggle="validator" role="form" class="form-horizontal"  action="<?php echo $base_url; ?>includes/process.inc.php?section=<?php echo $section; ?>&amp;go=<?php echo $action; ?>&amp;action=edit&amp;dbTable=<?php echo $users_db_table; ?>&amp;filter=<?php echo $filter; ?>&amp;id=<?php if ($filter == "admin") echo $row_brewer['uid']; else echo $_SESSION['user_id']; ?>" method="POST" name="form1" id="form1" onSubmit="return CheckRequiredFields()">
<input name="user_name_old" type="hidden" value="<?php if ($filter == "admin") echo $row_brewer['brewerEmail']; else echo $_SESSION['user_name']; ?>">
<input type="hidden" name="relocate" value="<?php echo relocate($_SERVER['HTTP_REFERER'],"default",$msg,$id); ?>">

<?php if ($action == "username") { ?>
	<div class="form-group"><!-- Form Group REQUIRED Text Input -->
        <label for="user_name" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 control-label">Novo Email</label>
        <div class="col-lg-10 col-md-6 col-sm-9 col-xs-12">
            <div class="input-group has-warning">
                <!-- Input Here -->
                <span class="input-group-addon" id="user_name-addon1"><span class="fa fa-envelope"></span></span>
                <input class="form-control" id="user_name" name="user_name" type="email" onBlur="checkAvailability()" onkeyup="twitter.updateUrl(this.value)" onchange="AjaxFunction(this.value);" placeholder="" data-error="O seu novo endereço de email é necessário e deve ter um formato válido." required>
                <span class="input-group-addon" id="user_name-addon2"><span class="fa fa-star"></span></span>
            </div>
            <div class="help-block with-errors"></div>
            <div id="msg_email"></div>
			<div id="status"></div>
        </div>
    </div><!-- ./Form Group -->

	<div class="form-group"><!-- Form Group Checkbox INLINE -->
        <label for="sure" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 control-label">Tem certeza?</label>
        <div class="col-lg-10 col-md-6 col-sm-9 col-xs-12">
            <div class="input-group">
                <!-- Input Here -->
                <label class="checkbox-inline">
                    <input type="checkbox" name="sure" value="Y" id="sure_0" required> Sim
                </label>
            </div>
            <div class="help-block with-errors"></div>
        </div>
    </div><!-- ./Form Group -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-lg-10 col-md-6 col-sm-9 col-xs-12">
			<!-- Input Here -->
			<button name="submit" type="submit" class="btn btn-primary" >Mudar Email</button>
		</div>
	</div><!-- Form Group -->
<?php } ?>
<?php if ($action == "password") { ?>
	<div class="form-group"><!-- Form Group REQUIRED Text Input -->
        <label for="passwordOld" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 control-label">Antiga Senha</label>
        <div class="col-lg-10 col-md-6 col-sm-9 col-xs-12">
            <div class="input-group has-warning">
                <!-- Input Here -->
                <span class="input-group-addon" id="passwordOld-addon1"><span class="fa fa-key"></span></span>
                <input class="form-control" name="passwordOld" type="password" placeholder="" id="passwordOld" required>
                <span class="input-group-addon" id="passwordOld-addon2"><span class="fa fa-star"></span></span>
            </div>
            <div class="help-block with-errors"></div>
        </div>
    </div><!-- ./Form Group -->

	<div class="form-group"><!-- Form Group REQUIRED Text Input -->
        <label for="password" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 control-label">Nova Senha</label>
        <div class="col-lg-10 col-md-6 col-sm-9 col-xs-12">
            <div class="input-group has-warning">
                <!-- Input Here -->
                <span class="input-group-addon" id="password-addon1"><span class="fa fa-key"></span></span>
                <input class="form-control" name="password" type="password" placeholder="" id="newPassword">
                <span class="input-group-addon" id="password-addon2"><span class="fa fa-star"></span></span>
            </div>
            <div class="help-block with-errors"></div>
        </div>
    </div><!-- ./Form Group -->

	<div class="form-group">
		<div class="col-sm-offset-2 col-lg-10 col-md-6 col-sm-9 col-xs-12">
			<!-- Input Here -->
			<button name="submit" type="submit" class="btn btn-primary" >Mude a Senha</button>
		</div>
	</div><!-- Form Group -->


<?php } ?>
</form>

<?php } // end if ((($_SESSION['loginUsername'] == $_SESSION['user_name'])) || ($_SESSION['userLevel'] <= "1")) - LINE 9
else echo "<div class='lead'>You can only edit your own user name and password.</div>"; ?>