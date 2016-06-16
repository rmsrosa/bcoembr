<?php 
if ($section != "step7") include(DB.'judging_locations.db.php'); 
include(DB.'styles.db.php'); 
?>
<?php if ($section != "step7") { ?>
<p class="lead"><?php echo $_SESSION['contestName']; if ($action == "add") echo ": Add a Custom Style Category"; elseif ($action == "edit") echo ": Edit a Custom Style Category" ; elseif (($action == "default") && ($filter == "judging") && ($bid != "default")) echo ": Style Categories Judged at ".$row_judging['judgingLocName']; else echo " Accepted Style Categories"; ?></p>
<?php if (($filter == "default") && ($action == "default")) { ?><p class="lead"><span class="small">Check or uncheck the styles <?php if (($action == "default") && ($filter == "judging") && ($bid != "default")) { echo "that will be judged at ".$row_judging['judgingLocName']." on "; echo getTimeZoneDateTime($_SESSION['prefsTimeZone'], $row_judging['judgingDate'], $_SESSION['prefsDateFormat'],  $_SESSION['prefsTimeFormat'], "long", "date-time"); } else echo "your competition will accept (any custom styles are at the top of the list)"; ?>.</span></p><?php } ?>
<div class="bcoem-admin-element hidden-print">
	<?php if ($action != "default") { ?>
	<!-- Postion 1: View All Button -->
	<div class="btn-group" role="group" aria-label="all-styles">
        <a class="btn btn-default" href="<?php echo $base_url; ?>index.php?section=admin&amp;go=styles"><span class="fa fa-arrow-circle-left"></span> All Styles</a>
    </div><!-- ./button group -->
	<?php } ?>
	<?php if ($action == "default") { ?>
	<!-- Position 2: Add Dropdown Button Group -->
	<div class="btn-group" role="group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="fa fa-plus-circle"></span> Add...  
		<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li class="small"><a href="<?php echo $base_url; ?>index.php?section=admin&amp;go=styles&amp;action=add">A Custom Style Category</a></li>
			<li class="small"><a href="<?php echo $base_url; ?>index.php?section=admin&amp;go=style_types&amp;action=add">Add a Style Type</a><li>
		</ul>
	</div>
	<?php } ?>
</div>
<?php } if ((($action == "default") && ($filter == "default")) || ($section == "step7") || (($action == "default") && ($filter == "judging") && ($bid != "default"))) { 
?>
<script language="javascript" type="text/javascript">
//Custom JavaScript Functions by Shawn Olson
//Copyright 2006-2008
//http://www.shawnolson.net
function checkUncheckAll(theElement) {
     var theForm = theElement.form, z = 0;
	 for(z=0; z<theForm.length;z++){
      if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall'){
	  theForm[z].checked = theElement.checked;
	  }
     }
    }
	</script>
	<script type="text/javascript" language="javascript">
	 $(document).ready(function() {
		$('#sortable').dataTable( {
			"bPaginate" : true,
			"sPaginationType" : "full_numbers",
			"bLengthChange" : true,
			"iDisplayLength" : <?php echo $limit; ?>,
			"sDom": 'rtp',
			"bStateSave" : false,
			"aaSorting": [[2,'asc']],
			"aoColumns": [
				{ "asSorting": [  ] },
				null,
				null,
				null,
				{ "asSorting": [  ] },
				<?php if ($section != "step7") { ?>
				{ "asSorting": [  ] }
				<?php } ?>
				]
			} );
		} );
</script>  
<form name="form1" method="post" action="<?php echo $base_url; ?>includes/process.inc.php?section=<?php if ($section == "step7") echo "setup"; else echo $section; ?>&amp;action=update&amp;dbTable=<?php echo $styles_db_table; ?>&amp;filter=<?php echo $filter; if ($bid != "default") echo "&amp;bid=".$bid; ?>">
<table class="table table-responsive table-striped table-bordered" id="sortable">
<thead>
 <tr>
  <th><input type="checkbox" name="checkall" onclick="checkUncheckAll(this);"/></th>
  <th>Category Name</th>
  <th title="Category Number and Subcategory Letter">#</th>
  <th>Style Type</th>
  <th>Requirements</th>
  <?php if ($section != "step7") { ?>
  <th class="hidden-print">Actions</th>
  <?php } ?>
 </tr>
 </thead>
 <tbody>
 <?php do { 
	if ($row_styles['id'] != "") {
	?>
 <tr>
  <input type="hidden" name="id[]" value="<?php echo $row_styles['id']; ?>" />
  <?php if ($bid == "default") { ?>
  <td width="1%" nowrap><input name="brewStyleActive<?php echo $row_styles['id']; ?>" type="checkbox" value="Y" <?php if ($row_styles['brewStyleActive'] == "Y") echo "CHECKED"; ?>></td>
  <?php } if ($bid != "default") { ?>
  <td width="1%" nowrap><input name="brewStyleJudgingLoc<?php echo $row_styles['id']; ?>" type="checkbox" value="<?php echo $bid; ?>" <?php if ($row_styles['brewStyleJudgingLoc'] == $bid) echo "CHECKED"; ?>></td>
  <?php } ?>
  <td><?php echo $row_styles['brewStyle']; ?></td>
  <td><?php if ($row_styles['brewStyleOwn'] != "bcoe") echo "* "; if (preg_match("/^[[:digit:]]+$/",$style[0])) echo sprintf('%02d',$row_styles['brewStyleGroup']).$row_styles['brewStyleNum']; else echo $row_styles['brewStyleGroup'].$row_styles['brewStyleNum']; if ($row_styles['brewStyleOwn'] != "bcoe") echo " - Custom Style"; ?></td>
  <td><?php if (style_type($row_styles['brewStyleType'],"1","") <= "3") $style_own = "bcoe"; else $style_own = "custom"; echo style_type($row_styles['brewStyleType'],"2",$style_own); ?></td>
  <td><?php if ($row_styles['brewStyleReqSpec'] == 1)  echo "<span class=\"fa fa-check-circle text-orange\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Special ingredients required for ".$row_styles['brewStyle']."\"></span> "; ?>
  <?php if ($row_styles['brewStyleStrength'] == 1) echo "<span class=\"fa fa-check-circle text-purple\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Strength required for ".$row_styles['brewStyle']."\"></span> "; ?>
  <?php if ($row_styles['brewStyleCarb'] == 1)  echo "<span class=\"fa fa-check-circle text-teal\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Carbonation required for ".$row_styles['brewStyle']."\"></span> "; ?>
  <?php if ($row_styles['brewStyleSweet'] == 1)  echo "<span class=\"fa fa-check-circle text-gold\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Sweetness required for ".$row_styles['brewStyle']."\"></span>"; ?></td>
  <?php if ($section != "step7") { ?>
  <td class="hidden-print">
  <?php if ($row_styles['brewStyleOwn'] != "bcoe") { ?>
	<a href="<?php echo $base_url; ?>index.php?section=admin&amp;go=<?php echo $go; ?>&amp;action=edit&amp;id=<?php echo $row_styles['id']; ?>&amp;view=<?php echo $row_styles['brewStyleType']; ?>" data-toggle="tooltip" data-placement="top" title="Edit <?php echo $row_styles['brewStyle']; ?>"><span class="fa fa-pencil"></span></a> <a href="<?php echo $base_url; ?>includes/process.inc.php?section=admin&amp;go=<?php echo $go; ?>&amp;dbTable=<?php echo $styles_db_table; ?>&amp;action=delete&amp;id=<?php echo $row_styles['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete <?php echo $row_styles['brewStyle']; ?>" data-confirm="Are you sure you want to delete <?php echo $row_styles['brewStyle']; ?>? This cannot be undone."><span class="fa fa-trash-o"></span></a> 
  <?php } else { ?>
  <span class="fa fa-pencil text-muted"></span> <span class="fa fa-trash-o text-muted"></span> <?php } if ($row_styles['brewStyleLink'] !="") echo "<a href=\"".$row_styles['brewStyleLink']."\" target=\"_blank\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Link to BJCP ".$row_styles['brewStyle']." sub-style on bjcp.org\"><span class=\"fa fa-link\"></span></a>"; ?>
	<?php } ?>
  </td>
	<?php } ?>
 </tr>
<?php  } while($row_styles = mysql_fetch_assoc($styles)) ?>
 </tbody>
 </table>
 <div class="bcoem-admin-element hidden-print">
	<input type="submit" name="Submit" id="helpUpdateStyles" class="btn btn-primary" aria-describedby="helpBlock" value="<?php if (($filter == "judging") && ($bid != "default")) echo "Update ".$row_judging['judgingLocName']; else echo "Update Accepted Style Categories"; ?>" />
    <span id="helpBlock" class="help-block">Click "<?php if (($filter == "judging") && ($bid != "default")) echo "Update ".$row_judging['judgingLocName']; else echo "Update Accepted Style Categories"; ?> <em>before</em> paging through records.</span>
</div>
<input type="hidden" name="relocate" value="<?php echo relocate($_SERVER['HTTP_REFERER'],"default",$msg,$id); ?>">
</form>
<?php } ?>

<?php if (($action == "add") || ($action == "edit")) {
$style_type_2 = style_type($row_styles['brewStyleType'],"1","bcoe");
?>

<script type='text/javascript'>//<![CDATA[ 
$(document).ready(function(){
	$("#mead-cider").hide("fast");
	$("#mead").hide("fast");
	
	<?php if (($action == "edit") && ($view == "2")) { ?>
	
	$("#mead-cider").show("slow");
	$("#mead").hide("slow");
	
	<?php } ?>
	
	<?php if (($action == "edit") && ($view == "3")) { ?>
	
	$("#mead-cider").show("slow");
	$("#mead").show("slow");
	
	<?php } ?>
	
	$("#brewStyleType").change(function() {
		$("#mead-cider").hide("fast");
		$("#mead").hide("fast");
		
        if ( 
			$("#brewStyleType").val() == "1"){
			$("#mead-cider").hide("fast");
			$("#mead").hide("fast");
		}
		
		else if ( 
			$("#brewStyleType").val() == "2"){
			$("#mead").hide("slow");
			$("#mead-cider").show("slow");
			
		}
		
		else if ( 
			$("#brewStyleType").val() == "3"){
			$("#mead").show("slow");
			$("#mead-cider").show("slow");
			
		}
		
		else{
			$("#mead").hide("fast");
			$("#mead-cider").hide("fast");
			
		}	
	}
	);
});//]]>  

</script>
<form data-toggle="validator" role="form" class="form-horizontal" method="post" action="<?php echo $base_url; ?>includes/process.inc.php?section=<?php echo $section; ?>&amp;action=<?php echo $action; ?>&amp;dbTable=<?php echo $styles_db_table; ?>&amp;go=<?php echo $go; if ($action == "edit") echo "&amp;id=".$id; ?>" id="form1" name="form1" onSubmit="return CheckRequiredFields()">

<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="brewStyle" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Name</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
			<input class="form-control" id="brewStyle" name="brewStyle" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyle']; ?>" placeholder="" data-error="The custom style category's name is required" autofocus required>
			<span class="input-group-addon" id="brewStyle-addon2"><span class="fa fa-star"></span></span>
		</div>
        <div class="help-block with-errors"></div>
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group REQUIRED Select -->
	<label for="brewStyleType" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Style Type</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 has-warning">
	<!-- Input Here -->
	<select class="selectpicker" data-width="auto"  name="brewStyleType" id="brewStyleType" onclick="craateUserJsObject.ShowMeadCider();" data-size="10" data-width="auto">
        <?php do { ?>
        <option value="<?php echo $row_style_type['id']; ?>" <?php if (($action == "edit") && ($row_styles['brewStyleType'] == $row_style_type['id'])) echo "SELECTED"; ?>><?php echo $row_style_type['styleTypeName']; ?></option>
    	<?php } while ($row_style_type = mysql_fetch_assoc($style_type)); ?>
	</select>
	<span id="helpBlock" class="help-block"><a class="btn btn-sm btn-primary" href="<?php echo $base_url; ?>index.php?section=admin&amp;go=style_types&amp;action=add"><span class="fa fa-plus-circle"></span> Add a Style Type</a>
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group Radio INLINE -->
	<label for="brewStyleReqSpec" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Require Special Ingredients</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group">
			<!-- Input Here -->
			<label class="radio-inline">
				<input type="radio" name="brewStyleReqSpec" value="1" id="brewStyleReqSpec_0" <?php if ($row_styles['brewStyleReqSpec'] == 1) echo "CHECKED"; ?> />Yes
			</label>
			<label class="radio-inline">
				<input type="radio" name="brewStyleReqSpec" value="0" id="brewStyleReqSpec_1" <?php if (($action == "add") ||  ($row_styles['brewStyleReqSpec'] == 0)) echo "CHECKED"; ?> />No
			</label>
		</div>
	</div>
</div><!-- ./Form Group -->

<div id="mead-cider">
	<div class="form-group"><!-- Form Group Radio INLINE -->
		<label for="brewStyleCarb" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Require Carbonation</label>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
			<div class="input-group">
				<!-- Input Here -->
				<label class="radio-inline">
					<input type="radio" name="brewStyleCarb" value="1" id="brewStyleCarb_0" <?php if ($row_styles['brewStyleCarb'] == 1) echo "CHECKED"; ?> />Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="brewStyleCarb" value="0" id="brewStyleCarb_1" <?php if (($action == "add") || (($action == "edit") && ($row_styles['brewStyleCarb'] == 0))) echo "CHECKED"; ?> />No
				</label>
			</div>
		</div>
	</div><!-- ./Form Group -->
	
	<div class="form-group"><!-- Form Group Radio INLINE -->
		<label for="brewStyleSweet" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Require Sweetness</label>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
			<div class="input-group">
				<!-- Input Here -->
				<label class="radio-inline">
					<input type="radio" name="brewStyleSweet" value="1" id="brewStyleSweet_0" <?php if ($row_styles['brewStyleSweet'] == 1) echo "CHECKED"; ?> />Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="brewStyleSweet" value="0" id="brewStyleSweet_1" <?php if (($action == "add") || (($action == "edit") && ($row_styles['brewStyleSweet'] == 0))) echo "CHECKED"; ?> />No
				</label>
			</div>
		</div>
	</div><!-- ./Form Group -->
	
</div>

<div id="mead">
	<div class="form-group"><!-- Form Group Radio INLINE -->
		<label for="brewStyleStrength" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Require Strength</label>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
			<div class="input-group">
				<!-- Input Here -->
				<label class="radio-inline">
					<input type="radio" name="brewStyleStrength" value="1" id="brewStyleStrength_0" <?php if ($row_styles['brewStyleStrength'] == 1) echo "CHECKED"; ?> />Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="brewStyleStrength" value="0" id="brewStyleStrength_1" <?php if (($action == "add") || (($action == "edit") && ($row_styles['brewStyleStrength'] == 0))) echo "CHECKED"; ?> />No
				</label>
			</div>
		</div>
	</div><!-- ./Form Group -->
</div>

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleOG" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">OG Minimum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleOG" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleOG']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleOGMax" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">OG Maximum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleOGMax" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleOGMax']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleFG" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">FG Minimum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleFG" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleFG']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleFGMax" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">FG Maximum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleFGMax" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleFGMax']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleABV" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">ABV Minimum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleABV" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleABV']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleABVMax" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">ABV Maximum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleABVMax" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleABVMax']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleIBU" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">IBU Minimum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleIBU" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleIBU']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleIBUMax" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">IBU Maximum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleIBUMax" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleIBUMax']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleSRM" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Color Minimum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleSRM" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleSRM']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="brewStyleSRMMax" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Color Maximum</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" name="brewStyleSRMMax" type="text" value="<?php if ($action == "edit") echo $row_styles['brewStyleSRMMax']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group NOT-REQUIRED Text Area -->
	<label for="brewStyleInfo" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Description</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<textarea class="form-control" name="brewStyleInfo" rows="6"><?php if ($action == "edit") echo $row_styles['brewStyleInfo']; ?></textarea>
	 </div>
</div><!-- ./Form Group -->

<input type="hidden" name="brewStyleOld" value="<?php if ($action == "edit") echo $row_styles['brewStyle'];?>">
<input type="hidden" name="brewStyleGroup" value="<?php if ($action == "edit") echo $row_styles['brewStyleGroup'];?>">
<input type="hidden" name="brewStyleNum" value="<?php if ($action == "edit") echo $row_styles['brewStyleNum'];?>" >
<input type="hidden" name="brewStyleActive" value="<?php if ($action == "edit") echo $row_styles['brewStyleActive']; else echo "Y"; ?>">
<input type="hidden" name="brewStyleOwn" value="<?php if ($action == "edit") echo $row_styles['brewStyleOwn']; else echo "custom"; ?>">
<input type="hidden" name="relocate" value="<?php echo relocate($_SERVER['HTTP_REFERER'],"default",$msg,$id); ?>">

<div class="bcoem-admin-element hidden-print">
	<div class="form-group">
		<div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-4">
			<input type="submit" name="Submit" id="updateStyle" class="btn btn-primary" value="<?php if ($action == "add") echo "Add"; else echo "Edit"; ?> Custom Style Category" />
		</div>
	</div>
</div>
</form>
<?php } ?>
<?php if (($action == "default") && ($filter == "judging") && ($bid == "default")) { ?>
<table>
 <tr>
   <td class="dataLabel">Choose a judging location:</td>
   <td class="data">
   <select class="selectpicker" data-width="auto"  name="judge_loc" id="judge_loc" onchange="jumpMenu('self',this,0)" data-size="10" data-width="auto">
	<option value=""></option>
    <?php do { ?>
	<option value="index.php?section=admin&amp;go=styles&amp;filter=judging&amp;bid=<?php echo $row_judging['id']; ?>"><?php  echo $row_judging['judgingLocName']." ("; echo getTimeZoneDateTime($_SESSION['prefsTimeZone'], $row_judging['judgingDate'], $_SESSION['prefsDateFormat'],  $_SESSION['prefsTimeFormat'], "long", "date-time").")"; ?></option>
    <?php } while ($row_judging = mysql_fetch_assoc($judging)); ?>
  </select>
  </td>
</tr>
</table>
<?php } ?>

<?php if (($action == "default") && ($filter == "orphans") && ($bid == "default")) { ?>
<h3>Styles Without a Valid Style Type</h3>
<?php 
echo orphan_styles();
} ?>