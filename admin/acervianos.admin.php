<?php include(DB.'acervianos.db.php'); ?>
<p class="lead"><?php echo $_SESSION['contestName']; if ($action == "add") echo ": Add an Acerviano"; elseif ($action == "edit") echo ": Edit an Acerviano"; elseif ($action == "bulkadd") echo ": Bulk Add Acervianos"; elseif ($action == "bulkdelete") echo ": Bulk Delete Acervianos"; else echo ": Acervianos"; ?></p>

<!-- Button Element Container -->
<div class="bcoem-admin-element hidden-print">
	<?php if (($action == "add") || ($action == "edit") || ($action == "bulkadd") || ($action == "bulkdelete")) { ?>
	<!-- Position 1: View All Button -->
	<div class="btn-group" role="group" aria-label="...">
		<a class="btn btn-default" href="<?php echo $base_url; ?>index.php?section=admin&amp;go=acervianos"><span class="fa fa-eye"></span> View All Acervianos</a>
    </div><!-- ./button group -->
	<?php } else { ?>
	<!-- Position 1: View All Button -->
	<div class="btn-group" role="group" aria-label="...">
		<a class="btn btn-default" href="<?php echo $base_url; ?>index.php?section=admin&amp;go=acervianos&amp;action=add"><span class="fa fa-plus-circle"></span> Add an Acerviano</a>
    </div><!-- ./button group -->
	<div class="btn-group" role="group" aria-label="...">
		<a class="btn btn-default" href="<?php echo $base_url; ?>index.php?section=admin&amp;go=acervianos&amp;action=bulkadd"><span class="fa fa-plus-circle"></span> Bulk Add Acervianos</a>
    </div><!-- ./button group -->
	<div class="btn-group" role="group" aria-label="...">
		<a class="btn btn-default" href="<?php echo $base_url; ?>index.php?section=admin&amp;go=acervianos&amp;action=bulkdelete"><span class="fa fa-minus-circle"></span> Bulk Delete Acervianos</a>
    </div><!-- ./button group -->
	<?php } ?>
</div>

<?php if (get_acervianos_count() > 0) { ?>
<?php if ($action == "default") { ?>
<script type="text/javascript" language="javascript">
	 $(document).ready(function() {
		$('#sortable').dataTable( {
			"bPaginate" : true,
			"sPaginationType" : "full_numbers",
			"bLengthChange" : true,
			"iDisplayLength" : <?php echo round($_SESSION['prefsRecordPaging']); ?>,
			"sDom": 'fprtp',
			"bStateSave" : false,
			"aaSorting": [[0,'asc']],
			"bProcessing" : true,
			"aoColumns": [
				null,
				null,
				null,
				null,
				null,
				{ "asSorting": [  ] },
				]
			} );
		} );
</script>
<table class="table table-responsive table-striped table-bordered dataTable" id="sortable">
<thead>
 <tr>
  <th>ACervA</th>
  <th>Nome</th>
  <th>CPF</th>
  <th>Telefone</th>
  <th>E-mail</th>
  <th>Ações</th>
 </tr>
</thead>
<tbody>
 <?php do { ?>
 <tr>
  <td><?php echo $row_acerviano['acervianoACervA']; ?></td>
  <td><?php echo $row_acerviano['acervianoFirstName'].", ".$row_acerviano['acervianoLastName'] ; ?></td>
  <td><?php echo $row_acerviano['acervianoCPF']; ?></td>
  <td><?php echo $row_acerviano['acervianoPhone']; ?></td>
  <td><?php echo $row_acerviano['acervianoEmail']; ?></td>
  <td>
  <a href="<?php echo $base_url; ?>index.php?section=admin&amp;go=<?php echo $go; ?>&amp;action=edit&amp;id=<?php echo $row_acerviano['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit <?php echo $row_acerviano['acervianoFirstName']." ".$row_acerviano['acervianoLastName']." (".$row_acerviano['acervianoCPF'].")" ; ?>&rsquo;s information"><span class="fa fa-pencil"></span></a> <a href="<?php echo $base_url; ?>includes/process.inc.php?section=admin&amp;go=<?php echo $go; ?>&amp;dbTable=<?php echo $acervianos_db_table; ?>&amp;action=delete&amp;id=<?php echo $row_acerviano['id']; ?>" data-confirm="Are you sure you want to delete <?php echo $row_acerviano['acervianoFirstName']." ".$row_acerviano['acervianoLastName']." (".$row_acerviano['acervianoCPF'].")"; ?> from the list of Acervianos? This cannot be undone."><span class="fa fa-trash-o"></span></a>  
  </td>
 </tr>
  <?php } while($row_acerviano = mysql_fetch_assoc($acerviano)) ?>
</tbody>
</table>
<?php } } else { ?>
<p>There are no acervianos in the database.</p>
<?php } ?>

<?php if (($action == "add") || ($action == "edit")) { ?>
<form data-toggle="validator" role="form" class="form-horizontal" method="post" action="<?php echo $base_url; ?>includes/process.inc.php?action=<?php echo $action; ?>&amp;dbTable=<?php echo $acervianos_db_table; ?><?php if ($action == "edit") echo "&amp;id=".$id; ?>" name="form1">

<div class="bcoem-admin-element hidden-print">
<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="acervianoACervA" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">ACervA</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
		    <select class="selectpicker" name="acervianoACervA" id="acervianoACervA" data-live-search="true" data-size="10" data-width="auto" data-error="The regional ACervA is required" required>
    			<?php foreach ($acervas as $acerva) {  ?>
		        <option value="<?php echo $acerva; ?>" <?php if (($action == "edit") && ($row_acerviano['acervianoACervA'] == $acerva)) echo "selected"; ?>><?php echo $acerva; ?></option>
        		<?php } ?>
		    </select>
		</div>
        <div class="help-block with-errors"></div>
	</div>
</div><!-- ./Form Group -->
<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="acervianoFirstName" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Nome</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" id="acervianoFirstName" name="acervianoFirstName" type="text" value="<?php if ($action == "edit") echo $row_acerviano['acervianoFirstName']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->
<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="acervianoLastName" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Sobrenome</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" id="acervianoLastName" name="acervianoLastName" type="text" value="<?php if ($action == "edit") echo $row_acerviano['acervianoLastName']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->
<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="acervianoCPF" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">CPF</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
			<input class="form-control" id="acervianoCPF" name="acervianoCPF" type="text" value="<?php if ($action == "edit") echo $row_acerviano['acervianoCPF']; ?>" placeholder="" data-error="The Acerviano's CPF is required" required>
			<span class="input-group-addon" id="acervianoCPF-addon2"><span class="fa fa-star"></span></span>
		</div>
        <div class="help-block with-errors"></div>
	</div>
</div><!-- ./Form Group -->
<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="acervianoPhone" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Telefone</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" id="acervianoPhone" name="acervianoPhone" type="text" value="<?php if ($action == "edit") echo $row_acerviano['acervianoPhone']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->
<div class="form-group"><!-- Form Group NOT REQUIRED Text Input -->
	<label for="acervianoACervA" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Email</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<!-- Input Here -->
		<input class="form-control" id="acervianoEmail" name="acervianoEmail" type="text" value="<?php if ($action == "edit") echo $row_acerviano['acervianoEmail']; ?>" placeholder="">
	</div>
</div><!-- ./Form Group -->
<input type="hidden" name="relocate" value="<?php echo relocate($_SERVER['HTTP_REFERER'],"default",$msg,$id); ?>">
</div>
<div class="bcoem-admin-element hidden-print">
	<div class="form-group">
		<div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-4">
			<input type="submit" name="Submit" id="updateAcerviano" class="btn btn-primary" value="<?php if ($action == "add") echo "Add"; else echo "Edit"; ?> Acerviano" />
		</div>
	</div>
</div>
</form>
<?php } ?>

<?php if ($action == "bulkadd") { ?>
<form data-toggle="validator" role="form" class="form-horizontal" method="post" action="<?php echo $base_url; ?>includes/process.inc.php?action=<?php echo $action; ?>&amp;dbTable=<?php echo $acervianos_db_table; ?>" name="form2">

<div class="bcoem-admin-element hidden-print">
<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="acervianosACervA" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">ACervA</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
		    <select class="selectpicker" name="acervianosACervA" id="acervianosACervA" data-live-search="true" data-size="10" data-width="auto" data-error="The regional ACervA is required" required>
    			<?php foreach ($acervas as $acerva) {  ?>
		        <option value="<?php echo $acerva; ?>"><?php echo $acerva; ?></option>
        		<?php } ?>
		    </select>
		</div>
        <div class="help-block with-errors"></div>
        <span id="helpBlock" class="help-block">Selecione a regional da ACervA associada à lista de CPFs a ser informada abaixo.</span>
	</div>
</div><!-- ./Form Group -->
        <div class="form-group"><!-- Form Group Radio STACKED -->
            <label for="FieldsforBulkAddAcervianos" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Campos a serem informados, nesta ordem</label>
            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12">
                <div class="input-group">
                    <!-- Input Here -->
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="checkacervianoFirstName" value="checkacervianoFirstName"> Nome
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="checkacervianoLastName" value="checkacervianoLastName"> Sobrenome
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="checkacervianoCPF" value="checkacervianoCPF" CHECKED DISABLED READONLY> CPF
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="checkacervianoPhone" value="checkacervianoPhone"> Telefone
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                             <input type="checkbox" name="checkacervianoEmail" value="checkacervianoEmail">Email
                        </label>
                    </div>
                </div>
                <span class="help-block">O Campo CPF é obrigatório. Acrescente os outros campos que deseja informar na janela abaixo (com a ordem dos campos devendo ser respeitada).</span>
            </div>
        </div><!-- ./Form Group -->

<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="acervianoslist" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Lista de Acervianos</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
	        <textarea id="acervianoslist" class="form-control" name="acervianoslist" cols="82" rows="15" aria-describedby="helpBlock">
			</textarea>
		</div>
        <div class="help-block with-errors"></div>
        <span id="helpBlock" class="help-block">A lista deve ser informada com os campos de cada Acerviano separados por vírgulas, na ordem dos campos selecionados acima, e com os dados de Acervianos diferentes em linhas separadas.</span>
	</div>
</div><!-- ./Form Group -->
<input type="hidden" name="relocate" value="<?php echo relocate($_SERVER['HTTP_REFERER'],"default",$msg,$id); ?>">
</div>
<div class="bcoem-admin-element hidden-print">
	<div class="form-group">
		<div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-4">
			<input type="submit" name="Submit" id="bulkaddAcervianos" class="btn btn-primary" value="Bulk Add Acervianos" />
		</div>
	</div>
</div>
</form>
<?php } ?>

<?php if ($action == "bulkdelete") { ?>
<form data-toggle="validator" role="form" class="form-horizontal" method="post" action="<?php echo $base_url; ?>includes/process.inc.php?action=<?php echo $action; ?>&amp;dbTable=<?php echo $acervianos_db_table; ?>" name="form3">

<div class="bcoem-admin-element hidden-print">
<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="acervianosACervA" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">ACervA</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
		    <select class="selectpicker" name="acervianosACervA" id="acervianosACervA" data-live-search="true" data-size="10" data-width="auto" data-error="The regional ACervA is required" required>
    			<?php foreach ($acervas as $acerva) {  ?>
		        <option value="<?php echo $acerva; ?>"><?php echo $acerva; ?></option>
        		<?php } ?>
		    </select>
		</div>
        <div class="help-block with-errors"></div>
		<span id="helpBlock" class="help-block">Selecione a regional da ACervA associada à lista de CPFs a ser informada abaixo.</span>
	</div>
</div><!-- ./Form Group -->
<div class="form-group"><!-- Form Group REQUIRED Text Input -->
	<label for="acervianosCPFs" class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label">Lista de Acervianos</label>
	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
		<div class="input-group has-warning">
			<!-- Input Here -->
	        <textarea id="acervianosCPFs" class="form-control" name="acervianosCPFs" cols="20" rows="15" aria-describedby="helpBlock">
			</textarea>
		</div>
        <div class="help-block with-errors"></div>
		<span id="helpBlock" class="help-block">A lista deve ser informada com cada CPF em uma linha separada.</span>
	</div>
</div><!-- ./Form Group -->
<input type="hidden" name="relocate" value="<?php echo relocate($_SERVER['HTTP_REFERER'],"default",$msg,$id); ?>">
</div>
<div class="bcoem-admin-element hidden-print">
	<div class="form-group">
		<div class="col-lg-offset-2 col-md-offset-3 col-sm-offset-4">
			<input type="submit" name="Submit" id="bulkdeleteAcervianos" class="btn btn-primary" value="Bulk Delete Acervianos" />
		</div>
	</div>
</div>
</form>
<?php } ?>