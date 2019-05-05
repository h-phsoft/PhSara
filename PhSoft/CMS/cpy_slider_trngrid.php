<?php include_once "phs_usersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_slider_trn_grid)) $cpy_slider_trn_grid = new ccpy_slider_trn_grid();

// Page init
$cpy_slider_trn_grid->Page_Init();

// Page main
$cpy_slider_trn_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_slider_trn_grid->Page_Render();
?>
<?php if ($cpy_slider_trn->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcpy_slider_trngrid = new ew_Form("fcpy_slider_trngrid", "grid");
fcpy_slider_trngrid.FormKeyCountName = '<?php echo $cpy_slider_trn_grid->FormKeyCountName ?>';

// Validate form
fcpy_slider_trngrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_slid_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_slider_trn->slid_id->FldCaption(), $cpy_slider_trn->slid_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_slid_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_slider_trn->slid_order->FldCaption(), $cpy_slider_trn->slid_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_slid_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_slider_trn->slid_order->FldErrMsg()) ?>");
			felm = this.GetElements("x" + infix + "_slid_image");
			elm = this.GetElements("fn_x" + infix + "_slid_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_slider_trn->slid_image->FldCaption(), $cpy_slider_trn->slid_image->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcpy_slider_trngrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "slid_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "slid_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "slid_image", false)) return false;
	return true;
}

// Form_CustomValidate event
fcpy_slider_trngrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_slider_trngrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_slider_trngrid.Lists["x_slid_id"] = {"LinkField":"x_slid_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_slid_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_slider_mst"};
fcpy_slider_trngrid.Lists["x_slid_id"].Data = "<?php echo $cpy_slider_trn_grid->slid_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($cpy_slider_trn->CurrentAction == "gridadd") {
	if ($cpy_slider_trn->CurrentMode == "copy") {
		$bSelectLimit = $cpy_slider_trn_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cpy_slider_trn_grid->TotalRecs = $cpy_slider_trn->ListRecordCount();
			$cpy_slider_trn_grid->Recordset = $cpy_slider_trn_grid->LoadRecordset($cpy_slider_trn_grid->StartRec-1, $cpy_slider_trn_grid->DisplayRecs);
		} else {
			if ($cpy_slider_trn_grid->Recordset = $cpy_slider_trn_grid->LoadRecordset())
				$cpy_slider_trn_grid->TotalRecs = $cpy_slider_trn_grid->Recordset->RecordCount();
		}
		$cpy_slider_trn_grid->StartRec = 1;
		$cpy_slider_trn_grid->DisplayRecs = $cpy_slider_trn_grid->TotalRecs;
	} else {
		$cpy_slider_trn->CurrentFilter = "0=1";
		$cpy_slider_trn_grid->StartRec = 1;
		$cpy_slider_trn_grid->DisplayRecs = $cpy_slider_trn->GridAddRowCount;
	}
	$cpy_slider_trn_grid->TotalRecs = $cpy_slider_trn_grid->DisplayRecs;
	$cpy_slider_trn_grid->StopRec = $cpy_slider_trn_grid->DisplayRecs;
} else {
	$bSelectLimit = $cpy_slider_trn_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_slider_trn_grid->TotalRecs <= 0)
			$cpy_slider_trn_grid->TotalRecs = $cpy_slider_trn->ListRecordCount();
	} else {
		if (!$cpy_slider_trn_grid->Recordset && ($cpy_slider_trn_grid->Recordset = $cpy_slider_trn_grid->LoadRecordset()))
			$cpy_slider_trn_grid->TotalRecs = $cpy_slider_trn_grid->Recordset->RecordCount();
	}
	$cpy_slider_trn_grid->StartRec = 1;
	$cpy_slider_trn_grid->DisplayRecs = $cpy_slider_trn_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cpy_slider_trn_grid->Recordset = $cpy_slider_trn_grid->LoadRecordset($cpy_slider_trn_grid->StartRec-1, $cpy_slider_trn_grid->DisplayRecs);

	// Set no record found message
	if ($cpy_slider_trn->CurrentAction == "" && $cpy_slider_trn_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_slider_trn_grid->setWarningMessage(ew_DeniedMsg());
		if ($cpy_slider_trn_grid->SearchWhere == "0=101")
			$cpy_slider_trn_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_slider_trn_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cpy_slider_trn_grid->RenderOtherOptions();
?>
<?php $cpy_slider_trn_grid->ShowPageHeader(); ?>
<?php
$cpy_slider_trn_grid->ShowMessage();
?>
<?php if ($cpy_slider_trn_grid->TotalRecs > 0 || $cpy_slider_trn->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_slider_trn_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_slider_trn">
<div id="fcpy_slider_trngrid" class="ewForm ewListForm form-inline">
<?php if ($cpy_slider_trn_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($cpy_slider_trn_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cpy_slider_trn" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_cpy_slider_trngrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_slider_trn_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_slider_trn_grid->RenderListOptions();

// Render list options (header, left)
$cpy_slider_trn_grid->ListOptions->Render("header", "left");
?>
<?php if ($cpy_slider_trn->slid_id->Visible) { // slid_id ?>
	<?php if ($cpy_slider_trn->SortUrl($cpy_slider_trn->slid_id) == "") { ?>
		<th data-name="slid_id" class="<?php echo $cpy_slider_trn->slid_id->HeaderCellClass() ?>"><div id="elh_cpy_slider_trn_slid_id" class="cpy_slider_trn_slid_id"><div class="ewTableHeaderCaption"><?php echo $cpy_slider_trn->slid_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="slid_id" class="<?php echo $cpy_slider_trn->slid_id->HeaderCellClass() ?>"><div><div id="elh_cpy_slider_trn_slid_id" class="cpy_slider_trn_slid_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_slider_trn->slid_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_slider_trn->slid_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_slider_trn->slid_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_slider_trn->slid_order->Visible) { // slid_order ?>
	<?php if ($cpy_slider_trn->SortUrl($cpy_slider_trn->slid_order) == "") { ?>
		<th data-name="slid_order" class="<?php echo $cpy_slider_trn->slid_order->HeaderCellClass() ?>"><div id="elh_cpy_slider_trn_slid_order" class="cpy_slider_trn_slid_order"><div class="ewTableHeaderCaption"><?php echo $cpy_slider_trn->slid_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="slid_order" class="<?php echo $cpy_slider_trn->slid_order->HeaderCellClass() ?>"><div><div id="elh_cpy_slider_trn_slid_order" class="cpy_slider_trn_slid_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_slider_trn->slid_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_slider_trn->slid_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_slider_trn->slid_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_slider_trn->slid_image->Visible) { // slid_image ?>
	<?php if ($cpy_slider_trn->SortUrl($cpy_slider_trn->slid_image) == "") { ?>
		<th data-name="slid_image" class="<?php echo $cpy_slider_trn->slid_image->HeaderCellClass() ?>"><div id="elh_cpy_slider_trn_slid_image" class="cpy_slider_trn_slid_image"><div class="ewTableHeaderCaption"><?php echo $cpy_slider_trn->slid_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="slid_image" class="<?php echo $cpy_slider_trn->slid_image->HeaderCellClass() ?>"><div><div id="elh_cpy_slider_trn_slid_image" class="cpy_slider_trn_slid_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_slider_trn->slid_image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_slider_trn->slid_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_slider_trn->slid_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_slider_trn_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cpy_slider_trn_grid->StartRec = 1;
$cpy_slider_trn_grid->StopRec = $cpy_slider_trn_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_slider_trn_grid->FormKeyCountName) && ($cpy_slider_trn->CurrentAction == "gridadd" || $cpy_slider_trn->CurrentAction == "gridedit" || $cpy_slider_trn->CurrentAction == "F")) {
		$cpy_slider_trn_grid->KeyCount = $objForm->GetValue($cpy_slider_trn_grid->FormKeyCountName);
		$cpy_slider_trn_grid->StopRec = $cpy_slider_trn_grid->StartRec + $cpy_slider_trn_grid->KeyCount - 1;
	}
}
$cpy_slider_trn_grid->RecCnt = $cpy_slider_trn_grid->StartRec - 1;
if ($cpy_slider_trn_grid->Recordset && !$cpy_slider_trn_grid->Recordset->EOF) {
	$cpy_slider_trn_grid->Recordset->MoveFirst();
	$bSelectLimit = $cpy_slider_trn_grid->UseSelectLimit;
	if (!$bSelectLimit && $cpy_slider_trn_grid->StartRec > 1)
		$cpy_slider_trn_grid->Recordset->Move($cpy_slider_trn_grid->StartRec - 1);
} elseif (!$cpy_slider_trn->AllowAddDeleteRow && $cpy_slider_trn_grid->StopRec == 0) {
	$cpy_slider_trn_grid->StopRec = $cpy_slider_trn->GridAddRowCount;
}

// Initialize aggregate
$cpy_slider_trn->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_slider_trn->ResetAttrs();
$cpy_slider_trn_grid->RenderRow();
if ($cpy_slider_trn->CurrentAction == "gridadd")
	$cpy_slider_trn_grid->RowIndex = 0;
if ($cpy_slider_trn->CurrentAction == "gridedit")
	$cpy_slider_trn_grid->RowIndex = 0;
while ($cpy_slider_trn_grid->RecCnt < $cpy_slider_trn_grid->StopRec) {
	$cpy_slider_trn_grid->RecCnt++;
	if (intval($cpy_slider_trn_grid->RecCnt) >= intval($cpy_slider_trn_grid->StartRec)) {
		$cpy_slider_trn_grid->RowCnt++;
		if ($cpy_slider_trn->CurrentAction == "gridadd" || $cpy_slider_trn->CurrentAction == "gridedit" || $cpy_slider_trn->CurrentAction == "F") {
			$cpy_slider_trn_grid->RowIndex++;
			$objForm->Index = $cpy_slider_trn_grid->RowIndex;
			if ($objForm->HasValue($cpy_slider_trn_grid->FormActionName))
				$cpy_slider_trn_grid->RowAction = strval($objForm->GetValue($cpy_slider_trn_grid->FormActionName));
			elseif ($cpy_slider_trn->CurrentAction == "gridadd")
				$cpy_slider_trn_grid->RowAction = "insert";
			else
				$cpy_slider_trn_grid->RowAction = "";
		}

		// Set up key count
		$cpy_slider_trn_grid->KeyCount = $cpy_slider_trn_grid->RowIndex;

		// Init row class and style
		$cpy_slider_trn->ResetAttrs();
		$cpy_slider_trn->CssClass = "";
		if ($cpy_slider_trn->CurrentAction == "gridadd") {
			if ($cpy_slider_trn->CurrentMode == "copy") {
				$cpy_slider_trn_grid->LoadRowValues($cpy_slider_trn_grid->Recordset); // Load row values
				$cpy_slider_trn_grid->SetRecordKey($cpy_slider_trn_grid->RowOldKey, $cpy_slider_trn_grid->Recordset); // Set old record key
			} else {
				$cpy_slider_trn_grid->LoadRowValues(); // Load default values
				$cpy_slider_trn_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cpy_slider_trn_grid->LoadRowValues($cpy_slider_trn_grid->Recordset); // Load row values
		}
		$cpy_slider_trn->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_slider_trn->CurrentAction == "gridadd") // Grid add
			$cpy_slider_trn->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cpy_slider_trn->CurrentAction == "gridadd" && $cpy_slider_trn->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cpy_slider_trn_grid->RestoreCurrentRowFormValues($cpy_slider_trn_grid->RowIndex); // Restore form values
		if ($cpy_slider_trn->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_slider_trn->EventCancelled) {
				$cpy_slider_trn_grid->RestoreCurrentRowFormValues($cpy_slider_trn_grid->RowIndex); // Restore form values
			}
			if ($cpy_slider_trn_grid->RowAction == "insert")
				$cpy_slider_trn->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_slider_trn->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_slider_trn->CurrentAction == "gridedit" && ($cpy_slider_trn->RowType == EW_ROWTYPE_EDIT || $cpy_slider_trn->RowType == EW_ROWTYPE_ADD) && $cpy_slider_trn->EventCancelled) // Update failed
			$cpy_slider_trn_grid->RestoreCurrentRowFormValues($cpy_slider_trn_grid->RowIndex); // Restore form values
		if ($cpy_slider_trn->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_slider_trn_grid->EditRowCnt++;
		if ($cpy_slider_trn->CurrentAction == "F") // Confirm row
			$cpy_slider_trn_grid->RestoreCurrentRowFormValues($cpy_slider_trn_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cpy_slider_trn->RowAttrs = array_merge($cpy_slider_trn->RowAttrs, array('data-rowindex'=>$cpy_slider_trn_grid->RowCnt, 'id'=>'r' . $cpy_slider_trn_grid->RowCnt . '_cpy_slider_trn', 'data-rowtype'=>$cpy_slider_trn->RowType));

		// Render row
		$cpy_slider_trn_grid->RenderRow();

		// Render list options
		$cpy_slider_trn_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_slider_trn_grid->RowAction <> "delete" && $cpy_slider_trn_grid->RowAction <> "insertdelete" && !($cpy_slider_trn_grid->RowAction == "insert" && $cpy_slider_trn->CurrentAction == "F" && $cpy_slider_trn_grid->EmptyRow())) {
?>
	<tr<?php echo $cpy_slider_trn->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_slider_trn_grid->ListOptions->Render("body", "left", $cpy_slider_trn_grid->RowCnt);
?>
	<?php if ($cpy_slider_trn->slid_id->Visible) { // slid_id ?>
		<td data-name="slid_id"<?php echo $cpy_slider_trn->slid_id->CellAttributes() ?>>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_slider_trn->slid_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<span<?php echo $cpy_slider_trn->slid_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_slider_trn->slid_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<select data-table="cpy_slider_trn" data-field="x_slid_id" data-value-separator="<?php echo $cpy_slider_trn->slid_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id"<?php echo $cpy_slider_trn->slid_id->EditAttributes() ?>>
<?php echo $cpy_slider_trn->slid_id->SelectOptionListHtml("x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_slider_trn->slid_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<span<?php echo $cpy_slider_trn->slid_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_slider_trn->slid_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<select data-table="cpy_slider_trn" data-field="x_slid_id" data-value-separator="<?php echo $cpy_slider_trn->slid_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id"<?php echo $cpy_slider_trn->slid_id->EditAttributes() ?>>
<?php echo $cpy_slider_trn->slid_id->SelectOptionListHtml("x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_id" class="cpy_slider_trn_slid_id">
<span<?php echo $cpy_slider_trn->slid_id->ViewAttributes() ?>>
<?php echo $cpy_slider_trn->slid_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_slider_trn->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->FormValue) ?>">
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="fcpy_slider_trngrid$x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="fcpy_slider_trngrid$x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->FormValue) ?>">
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="fcpy_slider_trngrid$o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="fcpy_slider_trngrid$o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_tslid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_tslid_id" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_tslid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->tslid_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_slider_trn" data-field="x_tslid_id" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_tslid_id" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_tslid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->tslid_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_EDIT || $cpy_slider_trn->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_tslid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_tslid_id" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_tslid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->tslid_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_slider_trn->slid_order->Visible) { // slid_order ?>
		<td data-name="slid_order"<?php echo $cpy_slider_trn->slid_order->CellAttributes() ?>>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_order" class="form-group cpy_slider_trn_slid_order">
<input type="text" data-table="cpy_slider_trn" data-field="x_slid_order" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->getPlaceHolder()) ?>" value="<?php echo $cpy_slider_trn->slid_order->EditValue ?>"<?php echo $cpy_slider_trn->slid_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_order" class="form-group cpy_slider_trn_slid_order">
<input type="text" data-table="cpy_slider_trn" data-field="x_slid_order" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->getPlaceHolder()) ?>" value="<?php echo $cpy_slider_trn->slid_order->EditValue ?>"<?php echo $cpy_slider_trn->slid_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_order" class="cpy_slider_trn_slid_order">
<span<?php echo $cpy_slider_trn->slid_order->ViewAttributes() ?>>
<?php echo $cpy_slider_trn->slid_order->ListViewValue() ?></span>
</span>
<?php if ($cpy_slider_trn->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->FormValue) ?>">
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="fcpy_slider_trngrid$x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="fcpy_slider_trngrid$x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->FormValue) ?>">
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="fcpy_slider_trngrid$o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="fcpy_slider_trngrid$o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_slider_trn->slid_image->Visible) { // slid_image ?>
		<td data-name="slid_image"<?php echo $cpy_slider_trn->slid_image->CellAttributes() ?>>
<?php if ($cpy_slider_trn_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_cpy_slider_trn_slid_image" class="form-group cpy_slider_trn_slid_image">
<div id="fd_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image">
<span title="<?php echo $cpy_slider_trn->slid_image->FldTitle() ? $cpy_slider_trn->slid_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_slider_trn->slid_image->ReadOnly || $cpy_slider_trn->slid_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_slider_trn" data-field="x_slid_image" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image"<?php echo $cpy_slider_trn->slid_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fn_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fs_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fx_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fm_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_image" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_image->OldValue) ?>">
<?php } elseif ($cpy_slider_trn->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_image" class="cpy_slider_trn_slid_image">
<span>
<?php echo ew_GetFileViewTag($cpy_slider_trn->slid_image, $cpy_slider_trn->slid_image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $cpy_slider_trn_grid->RowCnt ?>_cpy_slider_trn_slid_image" class="form-group cpy_slider_trn_slid_image">
<div id="fd_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image">
<span title="<?php echo $cpy_slider_trn->slid_image->FldTitle() ? $cpy_slider_trn->slid_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_slider_trn->slid_image->ReadOnly || $cpy_slider_trn->slid_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_slider_trn" data-field="x_slid_image" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image"<?php echo $cpy_slider_trn->slid_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fn_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fs_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fx_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fm_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_slider_trn_grid->ListOptions->Render("body", "right", $cpy_slider_trn_grid->RowCnt);
?>
	</tr>
<?php if ($cpy_slider_trn->RowType == EW_ROWTYPE_ADD || $cpy_slider_trn->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_slider_trngrid.UpdateOpts(<?php echo $cpy_slider_trn_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_slider_trn->CurrentAction <> "gridadd" || $cpy_slider_trn->CurrentMode == "copy")
		if (!$cpy_slider_trn_grid->Recordset->EOF) $cpy_slider_trn_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_slider_trn->CurrentMode == "add" || $cpy_slider_trn->CurrentMode == "copy" || $cpy_slider_trn->CurrentMode == "edit") {
		$cpy_slider_trn_grid->RowIndex = '$rowindex$';
		$cpy_slider_trn_grid->LoadRowValues();

		// Set row properties
		$cpy_slider_trn->ResetAttrs();
		$cpy_slider_trn->RowAttrs = array_merge($cpy_slider_trn->RowAttrs, array('data-rowindex'=>$cpy_slider_trn_grid->RowIndex, 'id'=>'r0_cpy_slider_trn', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_slider_trn->RowAttrs["class"], "ewTemplate");
		$cpy_slider_trn->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_slider_trn_grid->RenderRow();

		// Render list options
		$cpy_slider_trn_grid->RenderListOptions();
		$cpy_slider_trn_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_slider_trn->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_slider_trn_grid->ListOptions->Render("body", "left", $cpy_slider_trn_grid->RowIndex);
?>
	<?php if ($cpy_slider_trn->slid_id->Visible) { // slid_id ?>
		<td data-name="slid_id">
<?php if ($cpy_slider_trn->CurrentAction <> "F") { ?>
<?php if ($cpy_slider_trn->slid_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<span<?php echo $cpy_slider_trn->slid_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_slider_trn->slid_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<select data-table="cpy_slider_trn" data-field="x_slid_id" data-value-separator="<?php echo $cpy_slider_trn->slid_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id"<?php echo $cpy_slider_trn->slid_id->EditAttributes() ?>>
<?php echo $cpy_slider_trn->slid_id->SelectOptionListHtml("x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_slider_trn_slid_id" class="form-group cpy_slider_trn_slid_id">
<span<?php echo $cpy_slider_trn->slid_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_slider_trn->slid_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_id" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_slider_trn->slid_order->Visible) { // slid_order ?>
		<td data-name="slid_order">
<?php if ($cpy_slider_trn->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_slider_trn_slid_order" class="form-group cpy_slider_trn_slid_order">
<input type="text" data-table="cpy_slider_trn" data-field="x_slid_order" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->getPlaceHolder()) ?>" value="<?php echo $cpy_slider_trn->slid_order->EditValue ?>"<?php echo $cpy_slider_trn->slid_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_slider_trn_slid_order" class="form-group cpy_slider_trn_slid_order">
<span<?php echo $cpy_slider_trn->slid_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_slider_trn->slid_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_order" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_order" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_slider_trn->slid_image->Visible) { // slid_image ?>
		<td data-name="slid_image">
<span id="el$rowindex$_cpy_slider_trn_slid_image" class="form-group cpy_slider_trn_slid_image">
<div id="fd_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image">
<span title="<?php echo $cpy_slider_trn->slid_image->FldTitle() ? $cpy_slider_trn->slid_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_slider_trn->slid_image->ReadOnly || $cpy_slider_trn->slid_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_slider_trn" data-field="x_slid_image" name="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id="x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image"<?php echo $cpy_slider_trn->slid_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fn_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fa_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fs_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fx_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id= "fm_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo $cpy_slider_trn->slid_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_slider_trn" data-field="x_slid_image" name="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" id="o<?php echo $cpy_slider_trn_grid->RowIndex ?>_slid_image" value="<?php echo ew_HtmlEncode($cpy_slider_trn->slid_image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_slider_trn_grid->ListOptions->Render("body", "right", $cpy_slider_trn_grid->RowCnt);
?>
<script type="text/javascript">
fcpy_slider_trngrid.UpdateOpts(<?php echo $cpy_slider_trn_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cpy_slider_trn->CurrentMode == "add" || $cpy_slider_trn->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cpy_slider_trn_grid->FormKeyCountName ?>" id="<?php echo $cpy_slider_trn_grid->FormKeyCountName ?>" value="<?php echo $cpy_slider_trn_grid->KeyCount ?>">
<?php echo $cpy_slider_trn_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_slider_trn->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_slider_trn_grid->FormKeyCountName ?>" id="<?php echo $cpy_slider_trn_grid->FormKeyCountName ?>" value="<?php echo $cpy_slider_trn_grid->KeyCount ?>">
<?php echo $cpy_slider_trn_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_slider_trn->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcpy_slider_trngrid">
</div>
<?php

// Close recordset
if ($cpy_slider_trn_grid->Recordset)
	$cpy_slider_trn_grid->Recordset->Close();
?>
<?php if ($cpy_slider_trn_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($cpy_slider_trn_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cpy_slider_trn_grid->TotalRecs == 0 && $cpy_slider_trn->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_slider_trn_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cpy_slider_trn->Export == "") { ?>
<script type="text/javascript">
fcpy_slider_trngrid.Init();
</script>
<?php } ?>
<?php
$cpy_slider_trn_grid->Page_Terminate();
?>
