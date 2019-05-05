<?php include_once "phs_usersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_artwork_exhibtion_grid)) $cpy_artwork_exhibtion_grid = new ccpy_artwork_exhibtion_grid();

// Page init
$cpy_artwork_exhibtion_grid->Page_Init();

// Page main
$cpy_artwork_exhibtion_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_artwork_exhibtion_grid->Page_Render();
?>
<?php if ($cpy_artwork_exhibtion->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcpy_artwork_exhibtiongrid = new ew_Form("fcpy_artwork_exhibtiongrid", "grid");
fcpy_artwork_exhibtiongrid.FormKeyCountName = '<?php echo $cpy_artwork_exhibtion_grid->FormKeyCountName ?>';

// Validate form
fcpy_artwork_exhibtiongrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_art_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_artwork_exhibtion->art_id->FldCaption(), $cpy_artwork_exhibtion->art_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_exhib_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_artwork_exhibtion->exhib_order->FldCaption(), $cpy_artwork_exhibtion->exhib_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_exhib_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_artwork_exhibtion->exhib_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_exhib_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_artwork_exhibtion->exhib_id->FldCaption(), $cpy_artwork_exhibtion->exhib_id->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcpy_artwork_exhibtiongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "art_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "exhib_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "exhib_id", false)) return false;
	return true;
}

// Form_CustomValidate event
fcpy_artwork_exhibtiongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_artwork_exhibtiongrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_artwork_exhibtiongrid.Lists["x_art_id"] = {"LinkField":"x_art_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_art_title1","x_art_title2","x_art_year",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_artwork"};
fcpy_artwork_exhibtiongrid.Lists["x_art_id"].Data = "<?php echo $cpy_artwork_exhibtion_grid->art_id->LookupFilterQuery(FALSE, "grid") ?>";
fcpy_artwork_exhibtiongrid.Lists["x_exhib_id"] = {"LinkField":"x_exhib_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_exhib_title1","x_exhib_title2","x_exhib_year",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibition"};
fcpy_artwork_exhibtiongrid.Lists["x_exhib_id"].Data = "<?php echo $cpy_artwork_exhibtion_grid->exhib_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($cpy_artwork_exhibtion->CurrentAction == "gridadd") {
	if ($cpy_artwork_exhibtion->CurrentMode == "copy") {
		$bSelectLimit = $cpy_artwork_exhibtion_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cpy_artwork_exhibtion_grid->TotalRecs = $cpy_artwork_exhibtion->ListRecordCount();
			$cpy_artwork_exhibtion_grid->Recordset = $cpy_artwork_exhibtion_grid->LoadRecordset($cpy_artwork_exhibtion_grid->StartRec-1, $cpy_artwork_exhibtion_grid->DisplayRecs);
		} else {
			if ($cpy_artwork_exhibtion_grid->Recordset = $cpy_artwork_exhibtion_grid->LoadRecordset())
				$cpy_artwork_exhibtion_grid->TotalRecs = $cpy_artwork_exhibtion_grid->Recordset->RecordCount();
		}
		$cpy_artwork_exhibtion_grid->StartRec = 1;
		$cpy_artwork_exhibtion_grid->DisplayRecs = $cpy_artwork_exhibtion_grid->TotalRecs;
	} else {
		$cpy_artwork_exhibtion->CurrentFilter = "0=1";
		$cpy_artwork_exhibtion_grid->StartRec = 1;
		$cpy_artwork_exhibtion_grid->DisplayRecs = $cpy_artwork_exhibtion->GridAddRowCount;
	}
	$cpy_artwork_exhibtion_grid->TotalRecs = $cpy_artwork_exhibtion_grid->DisplayRecs;
	$cpy_artwork_exhibtion_grid->StopRec = $cpy_artwork_exhibtion_grid->DisplayRecs;
} else {
	$bSelectLimit = $cpy_artwork_exhibtion_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_artwork_exhibtion_grid->TotalRecs <= 0)
			$cpy_artwork_exhibtion_grid->TotalRecs = $cpy_artwork_exhibtion->ListRecordCount();
	} else {
		if (!$cpy_artwork_exhibtion_grid->Recordset && ($cpy_artwork_exhibtion_grid->Recordset = $cpy_artwork_exhibtion_grid->LoadRecordset()))
			$cpy_artwork_exhibtion_grid->TotalRecs = $cpy_artwork_exhibtion_grid->Recordset->RecordCount();
	}
	$cpy_artwork_exhibtion_grid->StartRec = 1;
	$cpy_artwork_exhibtion_grid->DisplayRecs = $cpy_artwork_exhibtion_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cpy_artwork_exhibtion_grid->Recordset = $cpy_artwork_exhibtion_grid->LoadRecordset($cpy_artwork_exhibtion_grid->StartRec-1, $cpy_artwork_exhibtion_grid->DisplayRecs);

	// Set no record found message
	if ($cpy_artwork_exhibtion->CurrentAction == "" && $cpy_artwork_exhibtion_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_artwork_exhibtion_grid->setWarningMessage(ew_DeniedMsg());
		if ($cpy_artwork_exhibtion_grid->SearchWhere == "0=101")
			$cpy_artwork_exhibtion_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_artwork_exhibtion_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cpy_artwork_exhibtion_grid->RenderOtherOptions();
?>
<?php $cpy_artwork_exhibtion_grid->ShowPageHeader(); ?>
<?php
$cpy_artwork_exhibtion_grid->ShowMessage();
?>
<?php if ($cpy_artwork_exhibtion_grid->TotalRecs > 0 || $cpy_artwork_exhibtion->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_artwork_exhibtion_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_artwork_exhibtion">
<div id="fcpy_artwork_exhibtiongrid" class="ewForm ewListForm form-inline">
<?php if ($cpy_artwork_exhibtion_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($cpy_artwork_exhibtion_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cpy_artwork_exhibtion" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_cpy_artwork_exhibtiongrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_artwork_exhibtion_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_artwork_exhibtion_grid->RenderListOptions();

// Render list options (header, left)
$cpy_artwork_exhibtion_grid->ListOptions->Render("header", "left");
?>
<?php if ($cpy_artwork_exhibtion->art_id->Visible) { // art_id ?>
	<?php if ($cpy_artwork_exhibtion->SortUrl($cpy_artwork_exhibtion->art_id) == "") { ?>
		<th data-name="art_id" class="<?php echo $cpy_artwork_exhibtion->art_id->HeaderCellClass() ?>"><div id="elh_cpy_artwork_exhibtion_art_id" class="cpy_artwork_exhibtion_art_id"><div class="ewTableHeaderCaption"><?php echo $cpy_artwork_exhibtion->art_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="art_id" class="<?php echo $cpy_artwork_exhibtion->art_id->HeaderCellClass() ?>"><div><div id="elh_cpy_artwork_exhibtion_art_id" class="cpy_artwork_exhibtion_art_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_artwork_exhibtion->art_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_artwork_exhibtion->art_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_artwork_exhibtion->art_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->exhib_order->Visible) { // exhib_order ?>
	<?php if ($cpy_artwork_exhibtion->SortUrl($cpy_artwork_exhibtion->exhib_order) == "") { ?>
		<th data-name="exhib_order" class="<?php echo $cpy_artwork_exhibtion->exhib_order->HeaderCellClass() ?>"><div id="elh_cpy_artwork_exhibtion_exhib_order" class="cpy_artwork_exhibtion_exhib_order"><div class="ewTableHeaderCaption"><?php echo $cpy_artwork_exhibtion->exhib_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exhib_order" class="<?php echo $cpy_artwork_exhibtion->exhib_order->HeaderCellClass() ?>"><div><div id="elh_cpy_artwork_exhibtion_exhib_order" class="cpy_artwork_exhibtion_exhib_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_artwork_exhibtion->exhib_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_artwork_exhibtion->exhib_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_artwork_exhibtion->exhib_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->exhib_id->Visible) { // exhib_id ?>
	<?php if ($cpy_artwork_exhibtion->SortUrl($cpy_artwork_exhibtion->exhib_id) == "") { ?>
		<th data-name="exhib_id" class="<?php echo $cpy_artwork_exhibtion->exhib_id->HeaderCellClass() ?>"><div id="elh_cpy_artwork_exhibtion_exhib_id" class="cpy_artwork_exhibtion_exhib_id"><div class="ewTableHeaderCaption"><?php echo $cpy_artwork_exhibtion->exhib_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exhib_id" class="<?php echo $cpy_artwork_exhibtion->exhib_id->HeaderCellClass() ?>"><div><div id="elh_cpy_artwork_exhibtion_exhib_id" class="cpy_artwork_exhibtion_exhib_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_artwork_exhibtion->exhib_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_artwork_exhibtion->exhib_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_artwork_exhibtion->exhib_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_artwork_exhibtion_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cpy_artwork_exhibtion_grid->StartRec = 1;
$cpy_artwork_exhibtion_grid->StopRec = $cpy_artwork_exhibtion_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_artwork_exhibtion_grid->FormKeyCountName) && ($cpy_artwork_exhibtion->CurrentAction == "gridadd" || $cpy_artwork_exhibtion->CurrentAction == "gridedit" || $cpy_artwork_exhibtion->CurrentAction == "F")) {
		$cpy_artwork_exhibtion_grid->KeyCount = $objForm->GetValue($cpy_artwork_exhibtion_grid->FormKeyCountName);
		$cpy_artwork_exhibtion_grid->StopRec = $cpy_artwork_exhibtion_grid->StartRec + $cpy_artwork_exhibtion_grid->KeyCount - 1;
	}
}
$cpy_artwork_exhibtion_grid->RecCnt = $cpy_artwork_exhibtion_grid->StartRec - 1;
if ($cpy_artwork_exhibtion_grid->Recordset && !$cpy_artwork_exhibtion_grid->Recordset->EOF) {
	$cpy_artwork_exhibtion_grid->Recordset->MoveFirst();
	$bSelectLimit = $cpy_artwork_exhibtion_grid->UseSelectLimit;
	if (!$bSelectLimit && $cpy_artwork_exhibtion_grid->StartRec > 1)
		$cpy_artwork_exhibtion_grid->Recordset->Move($cpy_artwork_exhibtion_grid->StartRec - 1);
} elseif (!$cpy_artwork_exhibtion->AllowAddDeleteRow && $cpy_artwork_exhibtion_grid->StopRec == 0) {
	$cpy_artwork_exhibtion_grid->StopRec = $cpy_artwork_exhibtion->GridAddRowCount;
}

// Initialize aggregate
$cpy_artwork_exhibtion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_artwork_exhibtion->ResetAttrs();
$cpy_artwork_exhibtion_grid->RenderRow();
if ($cpy_artwork_exhibtion->CurrentAction == "gridadd")
	$cpy_artwork_exhibtion_grid->RowIndex = 0;
if ($cpy_artwork_exhibtion->CurrentAction == "gridedit")
	$cpy_artwork_exhibtion_grid->RowIndex = 0;
while ($cpy_artwork_exhibtion_grid->RecCnt < $cpy_artwork_exhibtion_grid->StopRec) {
	$cpy_artwork_exhibtion_grid->RecCnt++;
	if (intval($cpy_artwork_exhibtion_grid->RecCnt) >= intval($cpy_artwork_exhibtion_grid->StartRec)) {
		$cpy_artwork_exhibtion_grid->RowCnt++;
		if ($cpy_artwork_exhibtion->CurrentAction == "gridadd" || $cpy_artwork_exhibtion->CurrentAction == "gridedit" || $cpy_artwork_exhibtion->CurrentAction == "F") {
			$cpy_artwork_exhibtion_grid->RowIndex++;
			$objForm->Index = $cpy_artwork_exhibtion_grid->RowIndex;
			if ($objForm->HasValue($cpy_artwork_exhibtion_grid->FormActionName))
				$cpy_artwork_exhibtion_grid->RowAction = strval($objForm->GetValue($cpy_artwork_exhibtion_grid->FormActionName));
			elseif ($cpy_artwork_exhibtion->CurrentAction == "gridadd")
				$cpy_artwork_exhibtion_grid->RowAction = "insert";
			else
				$cpy_artwork_exhibtion_grid->RowAction = "";
		}

		// Set up key count
		$cpy_artwork_exhibtion_grid->KeyCount = $cpy_artwork_exhibtion_grid->RowIndex;

		// Init row class and style
		$cpy_artwork_exhibtion->ResetAttrs();
		$cpy_artwork_exhibtion->CssClass = "";
		if ($cpy_artwork_exhibtion->CurrentAction == "gridadd") {
			if ($cpy_artwork_exhibtion->CurrentMode == "copy") {
				$cpy_artwork_exhibtion_grid->LoadRowValues($cpy_artwork_exhibtion_grid->Recordset); // Load row values
				$cpy_artwork_exhibtion_grid->SetRecordKey($cpy_artwork_exhibtion_grid->RowOldKey, $cpy_artwork_exhibtion_grid->Recordset); // Set old record key
			} else {
				$cpy_artwork_exhibtion_grid->LoadRowValues(); // Load default values
				$cpy_artwork_exhibtion_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cpy_artwork_exhibtion_grid->LoadRowValues($cpy_artwork_exhibtion_grid->Recordset); // Load row values
		}
		$cpy_artwork_exhibtion->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_artwork_exhibtion->CurrentAction == "gridadd") // Grid add
			$cpy_artwork_exhibtion->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cpy_artwork_exhibtion->CurrentAction == "gridadd" && $cpy_artwork_exhibtion->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cpy_artwork_exhibtion_grid->RestoreCurrentRowFormValues($cpy_artwork_exhibtion_grid->RowIndex); // Restore form values
		if ($cpy_artwork_exhibtion->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_artwork_exhibtion->EventCancelled) {
				$cpy_artwork_exhibtion_grid->RestoreCurrentRowFormValues($cpy_artwork_exhibtion_grid->RowIndex); // Restore form values
			}
			if ($cpy_artwork_exhibtion_grid->RowAction == "insert")
				$cpy_artwork_exhibtion->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_artwork_exhibtion->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_artwork_exhibtion->CurrentAction == "gridedit" && ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT || $cpy_artwork_exhibtion->RowType == EW_ROWTYPE_ADD) && $cpy_artwork_exhibtion->EventCancelled) // Update failed
			$cpy_artwork_exhibtion_grid->RestoreCurrentRowFormValues($cpy_artwork_exhibtion_grid->RowIndex); // Restore form values
		if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_artwork_exhibtion_grid->EditRowCnt++;
		if ($cpy_artwork_exhibtion->CurrentAction == "F") // Confirm row
			$cpy_artwork_exhibtion_grid->RestoreCurrentRowFormValues($cpy_artwork_exhibtion_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cpy_artwork_exhibtion->RowAttrs = array_merge($cpy_artwork_exhibtion->RowAttrs, array('data-rowindex'=>$cpy_artwork_exhibtion_grid->RowCnt, 'id'=>'r' . $cpy_artwork_exhibtion_grid->RowCnt . '_cpy_artwork_exhibtion', 'data-rowtype'=>$cpy_artwork_exhibtion->RowType));

		// Render row
		$cpy_artwork_exhibtion_grid->RenderRow();

		// Render list options
		$cpy_artwork_exhibtion_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_artwork_exhibtion_grid->RowAction <> "delete" && $cpy_artwork_exhibtion_grid->RowAction <> "insertdelete" && !($cpy_artwork_exhibtion_grid->RowAction == "insert" && $cpy_artwork_exhibtion->CurrentAction == "F" && $cpy_artwork_exhibtion_grid->EmptyRow())) {
?>
	<tr<?php echo $cpy_artwork_exhibtion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_artwork_exhibtion_grid->ListOptions->Render("body", "left", $cpy_artwork_exhibtion_grid->RowCnt);
?>
	<?php if ($cpy_artwork_exhibtion->art_id->Visible) { // art_id ?>
		<td data-name="art_id"<?php echo $cpy_artwork_exhibtion->art_id->CellAttributes() ?>>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_artwork_exhibtion->art_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<span<?php echo $cpy_artwork_exhibtion->art_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->art_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_art_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->art_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id"<?php echo $cpy_artwork_exhibtion->art_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->art_id->SelectOptionListHtml("x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_artwork_exhibtion->art_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<span<?php echo $cpy_artwork_exhibtion->art_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->art_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_art_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->art_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id"<?php echo $cpy_artwork_exhibtion->art_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->art_id->SelectOptionListHtml("x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_art_id" class="cpy_artwork_exhibtion_art_id">
<span<?php echo $cpy_artwork_exhibtion->art_id->ViewAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->art_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_artwork_exhibtion->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->FormValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="fcpy_artwork_exhibtiongrid$x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="fcpy_artwork_exhibtiongrid$x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->FormValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="fcpy_artwork_exhibtiongrid$o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="fcpy_artwork_exhibtiongrid$o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_artexh_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_artexh_id" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_artexh_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->artexh_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_artexh_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_artexh_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_artexh_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->artexh_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT || $cpy_artwork_exhibtion->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_artexh_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_artexh_id" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_artexh_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->artexh_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_artwork_exhibtion->exhib_order->Visible) { // exhib_order ?>
		<td data-name="exhib_order"<?php echo $cpy_artwork_exhibtion->exhib_order->CellAttributes() ?>>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_order" class="form-group cpy_artwork_exhibtion_exhib_order">
<input type="text" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork_exhibtion->exhib_order->EditValue ?>"<?php echo $cpy_artwork_exhibtion->exhib_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_order" class="form-group cpy_artwork_exhibtion_exhib_order">
<input type="text" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork_exhibtion->exhib_order->EditValue ?>"<?php echo $cpy_artwork_exhibtion->exhib_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_order" class="cpy_artwork_exhibtion_exhib_order">
<span<?php echo $cpy_artwork_exhibtion->exhib_order->ViewAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->exhib_order->ListViewValue() ?></span>
</span>
<?php if ($cpy_artwork_exhibtion->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->FormValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="fcpy_artwork_exhibtiongrid$x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="fcpy_artwork_exhibtiongrid$x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->FormValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="fcpy_artwork_exhibtiongrid$o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="fcpy_artwork_exhibtiongrid$o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_artwork_exhibtion->exhib_id->Visible) { // exhib_id ?>
		<td data-name="exhib_id"<?php echo $cpy_artwork_exhibtion->exhib_id->CellAttributes() ?>>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_artwork_exhibtion->exhib_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<span<?php echo $cpy_artwork_exhibtion->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id"<?php echo $cpy_artwork_exhibtion->exhib_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->exhib_id->SelectOptionListHtml("x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_artwork_exhibtion->exhib_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<span<?php echo $cpy_artwork_exhibtion->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id"<?php echo $cpy_artwork_exhibtion->exhib_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->exhib_id->SelectOptionListHtml("x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_artwork_exhibtion_grid->RowCnt ?>_cpy_artwork_exhibtion_exhib_id" class="cpy_artwork_exhibtion_exhib_id">
<span<?php echo $cpy_artwork_exhibtion->exhib_id->ViewAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->exhib_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_artwork_exhibtion->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->FormValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="fcpy_artwork_exhibtiongrid$x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="fcpy_artwork_exhibtiongrid$x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->FormValue) ?>">
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="fcpy_artwork_exhibtiongrid$o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="fcpy_artwork_exhibtiongrid$o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_artwork_exhibtion_grid->ListOptions->Render("body", "right", $cpy_artwork_exhibtion_grid->RowCnt);
?>
	</tr>
<?php if ($cpy_artwork_exhibtion->RowType == EW_ROWTYPE_ADD || $cpy_artwork_exhibtion->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_artwork_exhibtiongrid.UpdateOpts(<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_artwork_exhibtion->CurrentAction <> "gridadd" || $cpy_artwork_exhibtion->CurrentMode == "copy")
		if (!$cpy_artwork_exhibtion_grid->Recordset->EOF) $cpy_artwork_exhibtion_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_artwork_exhibtion->CurrentMode == "add" || $cpy_artwork_exhibtion->CurrentMode == "copy" || $cpy_artwork_exhibtion->CurrentMode == "edit") {
		$cpy_artwork_exhibtion_grid->RowIndex = '$rowindex$';
		$cpy_artwork_exhibtion_grid->LoadRowValues();

		// Set row properties
		$cpy_artwork_exhibtion->ResetAttrs();
		$cpy_artwork_exhibtion->RowAttrs = array_merge($cpy_artwork_exhibtion->RowAttrs, array('data-rowindex'=>$cpy_artwork_exhibtion_grid->RowIndex, 'id'=>'r0_cpy_artwork_exhibtion', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_artwork_exhibtion->RowAttrs["class"], "ewTemplate");
		$cpy_artwork_exhibtion->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_artwork_exhibtion_grid->RenderRow();

		// Render list options
		$cpy_artwork_exhibtion_grid->RenderListOptions();
		$cpy_artwork_exhibtion_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_artwork_exhibtion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_artwork_exhibtion_grid->ListOptions->Render("body", "left", $cpy_artwork_exhibtion_grid->RowIndex);
?>
	<?php if ($cpy_artwork_exhibtion->art_id->Visible) { // art_id ?>
		<td data-name="art_id">
<?php if ($cpy_artwork_exhibtion->CurrentAction <> "F") { ?>
<?php if ($cpy_artwork_exhibtion->art_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<span<?php echo $cpy_artwork_exhibtion->art_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->art_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_art_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->art_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id"<?php echo $cpy_artwork_exhibtion->art_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->art_id->SelectOptionListHtml("x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_art_id" class="form-group cpy_artwork_exhibtion_art_id">
<span<?php echo $cpy_artwork_exhibtion->art_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->art_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_art_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_artwork_exhibtion->exhib_order->Visible) { // exhib_order ?>
		<td data-name="exhib_order">
<?php if ($cpy_artwork_exhibtion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_exhib_order" class="form-group cpy_artwork_exhibtion_exhib_order">
<input type="text" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork_exhibtion->exhib_order->EditValue ?>"<?php echo $cpy_artwork_exhibtion->exhib_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_exhib_order" class="form-group cpy_artwork_exhibtion_exhib_order">
<span<?php echo $cpy_artwork_exhibtion->exhib_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->exhib_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_artwork_exhibtion->exhib_id->Visible) { // exhib_id ?>
		<td data-name="exhib_id">
<?php if ($cpy_artwork_exhibtion->CurrentAction <> "F") { ?>
<?php if ($cpy_artwork_exhibtion->exhib_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<span<?php echo $cpy_artwork_exhibtion->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id"<?php echo $cpy_artwork_exhibtion->exhib_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->exhib_id->SelectOptionListHtml("x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_artwork_exhibtion_exhib_id" class="form-group cpy_artwork_exhibtion_exhib_id">
<span<?php echo $cpy_artwork_exhibtion->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="x<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" name="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" id="o<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_artwork_exhibtion_grid->ListOptions->Render("body", "right", $cpy_artwork_exhibtion_grid->RowCnt);
?>
<script type="text/javascript">
fcpy_artwork_exhibtiongrid.UpdateOpts(<?php echo $cpy_artwork_exhibtion_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cpy_artwork_exhibtion->CurrentMode == "add" || $cpy_artwork_exhibtion->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cpy_artwork_exhibtion_grid->FormKeyCountName ?>" id="<?php echo $cpy_artwork_exhibtion_grid->FormKeyCountName ?>" value="<?php echo $cpy_artwork_exhibtion_grid->KeyCount ?>">
<?php echo $cpy_artwork_exhibtion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_artwork_exhibtion_grid->FormKeyCountName ?>" id="<?php echo $cpy_artwork_exhibtion_grid->FormKeyCountName ?>" value="<?php echo $cpy_artwork_exhibtion_grid->KeyCount ?>">
<?php echo $cpy_artwork_exhibtion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcpy_artwork_exhibtiongrid">
</div>
<?php

// Close recordset
if ($cpy_artwork_exhibtion_grid->Recordset)
	$cpy_artwork_exhibtion_grid->Recordset->Close();
?>
<?php if ($cpy_artwork_exhibtion_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($cpy_artwork_exhibtion_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cpy_artwork_exhibtion_grid->TotalRecs == 0 && $cpy_artwork_exhibtion->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_artwork_exhibtion_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->Export == "") { ?>
<script type="text/javascript">
fcpy_artwork_exhibtiongrid.Init();
</script>
<?php } ?>
<?php
$cpy_artwork_exhibtion_grid->Page_Terminate();
?>
