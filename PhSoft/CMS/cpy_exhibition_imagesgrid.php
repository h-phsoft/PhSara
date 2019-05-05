<?php include_once "phs_usersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_exhibition_images_grid)) $cpy_exhibition_images_grid = new ccpy_exhibition_images_grid();

// Page init
$cpy_exhibition_images_grid->Page_Init();

// Page main
$cpy_exhibition_images_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_exhibition_images_grid->Page_Render();
?>
<?php if ($cpy_exhibition_images->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcpy_exhibition_imagesgrid = new ew_Form("fcpy_exhibition_imagesgrid", "grid");
fcpy_exhibition_imagesgrid.FormKeyCountName = '<?php echo $cpy_exhibition_images_grid->FormKeyCountName ?>';

// Validate form
fcpy_exhibition_imagesgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_exhib_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition_images->exhib_id->FldCaption(), $cpy_exhibition_images->exhib_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_exhib_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition_images->exhib_order->FldCaption(), $cpy_exhibition_images->exhib_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_exhib_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition_images->exhib_order->FldErrMsg()) ?>");
			felm = this.GetElements("x" + infix + "_exhib_image");
			elm = this.GetElements("fn_x" + infix + "_exhib_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition_images->exhib_image->FldCaption(), $cpy_exhibition_images->exhib_image->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcpy_exhibition_imagesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "exhib_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "exhib_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "exhib_image", false)) return false;
	return true;
}

// Form_CustomValidate event
fcpy_exhibition_imagesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_exhibition_imagesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_exhibition_imagesgrid.Lists["x_exhib_id"] = {"LinkField":"x_exhib_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_exhib_title1","x_exhib_title2","x_exhib_year",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibition"};
fcpy_exhibition_imagesgrid.Lists["x_exhib_id"].Data = "<?php echo $cpy_exhibition_images_grid->exhib_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($cpy_exhibition_images->CurrentAction == "gridadd") {
	if ($cpy_exhibition_images->CurrentMode == "copy") {
		$bSelectLimit = $cpy_exhibition_images_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cpy_exhibition_images_grid->TotalRecs = $cpy_exhibition_images->ListRecordCount();
			$cpy_exhibition_images_grid->Recordset = $cpy_exhibition_images_grid->LoadRecordset($cpy_exhibition_images_grid->StartRec-1, $cpy_exhibition_images_grid->DisplayRecs);
		} else {
			if ($cpy_exhibition_images_grid->Recordset = $cpy_exhibition_images_grid->LoadRecordset())
				$cpy_exhibition_images_grid->TotalRecs = $cpy_exhibition_images_grid->Recordset->RecordCount();
		}
		$cpy_exhibition_images_grid->StartRec = 1;
		$cpy_exhibition_images_grid->DisplayRecs = $cpy_exhibition_images_grid->TotalRecs;
	} else {
		$cpy_exhibition_images->CurrentFilter = "0=1";
		$cpy_exhibition_images_grid->StartRec = 1;
		$cpy_exhibition_images_grid->DisplayRecs = $cpy_exhibition_images->GridAddRowCount;
	}
	$cpy_exhibition_images_grid->TotalRecs = $cpy_exhibition_images_grid->DisplayRecs;
	$cpy_exhibition_images_grid->StopRec = $cpy_exhibition_images_grid->DisplayRecs;
} else {
	$bSelectLimit = $cpy_exhibition_images_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_exhibition_images_grid->TotalRecs <= 0)
			$cpy_exhibition_images_grid->TotalRecs = $cpy_exhibition_images->ListRecordCount();
	} else {
		if (!$cpy_exhibition_images_grid->Recordset && ($cpy_exhibition_images_grid->Recordset = $cpy_exhibition_images_grid->LoadRecordset()))
			$cpy_exhibition_images_grid->TotalRecs = $cpy_exhibition_images_grid->Recordset->RecordCount();
	}
	$cpy_exhibition_images_grid->StartRec = 1;
	$cpy_exhibition_images_grid->DisplayRecs = $cpy_exhibition_images_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cpy_exhibition_images_grid->Recordset = $cpy_exhibition_images_grid->LoadRecordset($cpy_exhibition_images_grid->StartRec-1, $cpy_exhibition_images_grid->DisplayRecs);

	// Set no record found message
	if ($cpy_exhibition_images->CurrentAction == "" && $cpy_exhibition_images_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_exhibition_images_grid->setWarningMessage(ew_DeniedMsg());
		if ($cpy_exhibition_images_grid->SearchWhere == "0=101")
			$cpy_exhibition_images_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_exhibition_images_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cpy_exhibition_images_grid->RenderOtherOptions();
?>
<?php $cpy_exhibition_images_grid->ShowPageHeader(); ?>
<?php
$cpy_exhibition_images_grid->ShowMessage();
?>
<?php if ($cpy_exhibition_images_grid->TotalRecs > 0 || $cpy_exhibition_images->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_exhibition_images_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_exhibition_images">
<div id="fcpy_exhibition_imagesgrid" class="ewForm ewListForm form-inline">
<?php if ($cpy_exhibition_images_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($cpy_exhibition_images_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cpy_exhibition_images" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_cpy_exhibition_imagesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_exhibition_images_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_exhibition_images_grid->RenderListOptions();

// Render list options (header, left)
$cpy_exhibition_images_grid->ListOptions->Render("header", "left");
?>
<?php if ($cpy_exhibition_images->exhib_id->Visible) { // exhib_id ?>
	<?php if ($cpy_exhibition_images->SortUrl($cpy_exhibition_images->exhib_id) == "") { ?>
		<th data-name="exhib_id" class="<?php echo $cpy_exhibition_images->exhib_id->HeaderCellClass() ?>"><div id="elh_cpy_exhibition_images_exhib_id" class="cpy_exhibition_images_exhib_id"><div class="ewTableHeaderCaption"><?php echo $cpy_exhibition_images->exhib_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exhib_id" class="<?php echo $cpy_exhibition_images->exhib_id->HeaderCellClass() ?>"><div><div id="elh_cpy_exhibition_images_exhib_id" class="cpy_exhibition_images_exhib_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_exhibition_images->exhib_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_exhibition_images->exhib_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_exhibition_images->exhib_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_exhibition_images->exhib_order->Visible) { // exhib_order ?>
	<?php if ($cpy_exhibition_images->SortUrl($cpy_exhibition_images->exhib_order) == "") { ?>
		<th data-name="exhib_order" class="<?php echo $cpy_exhibition_images->exhib_order->HeaderCellClass() ?>"><div id="elh_cpy_exhibition_images_exhib_order" class="cpy_exhibition_images_exhib_order"><div class="ewTableHeaderCaption"><?php echo $cpy_exhibition_images->exhib_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exhib_order" class="<?php echo $cpy_exhibition_images->exhib_order->HeaderCellClass() ?>"><div><div id="elh_cpy_exhibition_images_exhib_order" class="cpy_exhibition_images_exhib_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_exhibition_images->exhib_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_exhibition_images->exhib_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_exhibition_images->exhib_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_exhibition_images->exhib_image->Visible) { // exhib_image ?>
	<?php if ($cpy_exhibition_images->SortUrl($cpy_exhibition_images->exhib_image) == "") { ?>
		<th data-name="exhib_image" class="<?php echo $cpy_exhibition_images->exhib_image->HeaderCellClass() ?>"><div id="elh_cpy_exhibition_images_exhib_image" class="cpy_exhibition_images_exhib_image"><div class="ewTableHeaderCaption"><?php echo $cpy_exhibition_images->exhib_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="exhib_image" class="<?php echo $cpy_exhibition_images->exhib_image->HeaderCellClass() ?>"><div><div id="elh_cpy_exhibition_images_exhib_image" class="cpy_exhibition_images_exhib_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_exhibition_images->exhib_image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_exhibition_images->exhib_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_exhibition_images->exhib_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_exhibition_images_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cpy_exhibition_images_grid->StartRec = 1;
$cpy_exhibition_images_grid->StopRec = $cpy_exhibition_images_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_exhibition_images_grid->FormKeyCountName) && ($cpy_exhibition_images->CurrentAction == "gridadd" || $cpy_exhibition_images->CurrentAction == "gridedit" || $cpy_exhibition_images->CurrentAction == "F")) {
		$cpy_exhibition_images_grid->KeyCount = $objForm->GetValue($cpy_exhibition_images_grid->FormKeyCountName);
		$cpy_exhibition_images_grid->StopRec = $cpy_exhibition_images_grid->StartRec + $cpy_exhibition_images_grid->KeyCount - 1;
	}
}
$cpy_exhibition_images_grid->RecCnt = $cpy_exhibition_images_grid->StartRec - 1;
if ($cpy_exhibition_images_grid->Recordset && !$cpy_exhibition_images_grid->Recordset->EOF) {
	$cpy_exhibition_images_grid->Recordset->MoveFirst();
	$bSelectLimit = $cpy_exhibition_images_grid->UseSelectLimit;
	if (!$bSelectLimit && $cpy_exhibition_images_grid->StartRec > 1)
		$cpy_exhibition_images_grid->Recordset->Move($cpy_exhibition_images_grid->StartRec - 1);
} elseif (!$cpy_exhibition_images->AllowAddDeleteRow && $cpy_exhibition_images_grid->StopRec == 0) {
	$cpy_exhibition_images_grid->StopRec = $cpy_exhibition_images->GridAddRowCount;
}

// Initialize aggregate
$cpy_exhibition_images->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_exhibition_images->ResetAttrs();
$cpy_exhibition_images_grid->RenderRow();
if ($cpy_exhibition_images->CurrentAction == "gridadd")
	$cpy_exhibition_images_grid->RowIndex = 0;
if ($cpy_exhibition_images->CurrentAction == "gridedit")
	$cpy_exhibition_images_grid->RowIndex = 0;
while ($cpy_exhibition_images_grid->RecCnt < $cpy_exhibition_images_grid->StopRec) {
	$cpy_exhibition_images_grid->RecCnt++;
	if (intval($cpy_exhibition_images_grid->RecCnt) >= intval($cpy_exhibition_images_grid->StartRec)) {
		$cpy_exhibition_images_grid->RowCnt++;
		if ($cpy_exhibition_images->CurrentAction == "gridadd" || $cpy_exhibition_images->CurrentAction == "gridedit" || $cpy_exhibition_images->CurrentAction == "F") {
			$cpy_exhibition_images_grid->RowIndex++;
			$objForm->Index = $cpy_exhibition_images_grid->RowIndex;
			if ($objForm->HasValue($cpy_exhibition_images_grid->FormActionName))
				$cpy_exhibition_images_grid->RowAction = strval($objForm->GetValue($cpy_exhibition_images_grid->FormActionName));
			elseif ($cpy_exhibition_images->CurrentAction == "gridadd")
				$cpy_exhibition_images_grid->RowAction = "insert";
			else
				$cpy_exhibition_images_grid->RowAction = "";
		}

		// Set up key count
		$cpy_exhibition_images_grid->KeyCount = $cpy_exhibition_images_grid->RowIndex;

		// Init row class and style
		$cpy_exhibition_images->ResetAttrs();
		$cpy_exhibition_images->CssClass = "";
		if ($cpy_exhibition_images->CurrentAction == "gridadd") {
			if ($cpy_exhibition_images->CurrentMode == "copy") {
				$cpy_exhibition_images_grid->LoadRowValues($cpy_exhibition_images_grid->Recordset); // Load row values
				$cpy_exhibition_images_grid->SetRecordKey($cpy_exhibition_images_grid->RowOldKey, $cpy_exhibition_images_grid->Recordset); // Set old record key
			} else {
				$cpy_exhibition_images_grid->LoadRowValues(); // Load default values
				$cpy_exhibition_images_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cpy_exhibition_images_grid->LoadRowValues($cpy_exhibition_images_grid->Recordset); // Load row values
		}
		$cpy_exhibition_images->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_exhibition_images->CurrentAction == "gridadd") // Grid add
			$cpy_exhibition_images->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cpy_exhibition_images->CurrentAction == "gridadd" && $cpy_exhibition_images->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cpy_exhibition_images_grid->RestoreCurrentRowFormValues($cpy_exhibition_images_grid->RowIndex); // Restore form values
		if ($cpy_exhibition_images->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_exhibition_images->EventCancelled) {
				$cpy_exhibition_images_grid->RestoreCurrentRowFormValues($cpy_exhibition_images_grid->RowIndex); // Restore form values
			}
			if ($cpy_exhibition_images_grid->RowAction == "insert")
				$cpy_exhibition_images->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_exhibition_images->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_exhibition_images->CurrentAction == "gridedit" && ($cpy_exhibition_images->RowType == EW_ROWTYPE_EDIT || $cpy_exhibition_images->RowType == EW_ROWTYPE_ADD) && $cpy_exhibition_images->EventCancelled) // Update failed
			$cpy_exhibition_images_grid->RestoreCurrentRowFormValues($cpy_exhibition_images_grid->RowIndex); // Restore form values
		if ($cpy_exhibition_images->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_exhibition_images_grid->EditRowCnt++;
		if ($cpy_exhibition_images->CurrentAction == "F") // Confirm row
			$cpy_exhibition_images_grid->RestoreCurrentRowFormValues($cpy_exhibition_images_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cpy_exhibition_images->RowAttrs = array_merge($cpy_exhibition_images->RowAttrs, array('data-rowindex'=>$cpy_exhibition_images_grid->RowCnt, 'id'=>'r' . $cpy_exhibition_images_grid->RowCnt . '_cpy_exhibition_images', 'data-rowtype'=>$cpy_exhibition_images->RowType));

		// Render row
		$cpy_exhibition_images_grid->RenderRow();

		// Render list options
		$cpy_exhibition_images_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_exhibition_images_grid->RowAction <> "delete" && $cpy_exhibition_images_grid->RowAction <> "insertdelete" && !($cpy_exhibition_images_grid->RowAction == "insert" && $cpy_exhibition_images->CurrentAction == "F" && $cpy_exhibition_images_grid->EmptyRow())) {
?>
	<tr<?php echo $cpy_exhibition_images->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_exhibition_images_grid->ListOptions->Render("body", "left", $cpy_exhibition_images_grid->RowCnt);
?>
	<?php if ($cpy_exhibition_images->exhib_id->Visible) { // exhib_id ?>
		<td data-name="exhib_id"<?php echo $cpy_exhibition_images->exhib_id->CellAttributes() ?>>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_exhibition_images->exhib_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<span<?php echo $cpy_exhibition_images->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_exhibition_images->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<select data-table="cpy_exhibition_images" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_exhibition_images->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id"<?php echo $cpy_exhibition_images->exhib_id->EditAttributes() ?>>
<?php echo $cpy_exhibition_images->exhib_id->SelectOptionListHtml("x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_exhibition_images->exhib_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<span<?php echo $cpy_exhibition_images->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_exhibition_images->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<select data-table="cpy_exhibition_images" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_exhibition_images->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id"<?php echo $cpy_exhibition_images->exhib_id->EditAttributes() ?>>
<?php echo $cpy_exhibition_images->exhib_id->SelectOptionListHtml("x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_id" class="cpy_exhibition_images_exhib_id">
<span<?php echo $cpy_exhibition_images->exhib_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition_images->exhib_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_exhibition_images->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->FormValue) ?>">
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="fcpy_exhibition_imagesgrid$x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="fcpy_exhibition_imagesgrid$x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->FormValue) ?>">
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="fcpy_exhibition_imagesgrid$o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="fcpy_exhibition_imagesgrid$o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_iexhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_iexhib_id" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_iexhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->iexhib_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_iexhib_id" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_iexhib_id" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_iexhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->iexhib_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_EDIT || $cpy_exhibition_images->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_iexhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_iexhib_id" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_iexhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->iexhib_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_exhibition_images->exhib_order->Visible) { // exhib_order ?>
		<td data-name="exhib_order"<?php echo $cpy_exhibition_images->exhib_order->CellAttributes() ?>>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_order" class="form-group cpy_exhibition_images_exhib_order">
<input type="text" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition_images->exhib_order->EditValue ?>"<?php echo $cpy_exhibition_images->exhib_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_order" class="form-group cpy_exhibition_images_exhib_order">
<input type="text" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition_images->exhib_order->EditValue ?>"<?php echo $cpy_exhibition_images->exhib_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_order" class="cpy_exhibition_images_exhib_order">
<span<?php echo $cpy_exhibition_images->exhib_order->ViewAttributes() ?>>
<?php echo $cpy_exhibition_images->exhib_order->ListViewValue() ?></span>
</span>
<?php if ($cpy_exhibition_images->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->FormValue) ?>">
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="fcpy_exhibition_imagesgrid$x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="fcpy_exhibition_imagesgrid$x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->FormValue) ?>">
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="fcpy_exhibition_imagesgrid$o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="fcpy_exhibition_imagesgrid$o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_exhibition_images->exhib_image->Visible) { // exhib_image ?>
		<td data-name="exhib_image"<?php echo $cpy_exhibition_images->exhib_image->CellAttributes() ?>>
<?php if ($cpy_exhibition_images_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_cpy_exhibition_images_exhib_image" class="form-group cpy_exhibition_images_exhib_image">
<div id="fd_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image">
<span title="<?php echo $cpy_exhibition_images->exhib_image->FldTitle() ? $cpy_exhibition_images->exhib_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_exhibition_images->exhib_image->ReadOnly || $cpy_exhibition_images->exhib_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_exhibition_images" data-field="x_exhib_image" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image"<?php echo $cpy_exhibition_images->exhib_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fn_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fs_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="100">
<input type="hidden" name="fx_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fx_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fm_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_image" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_image->OldValue) ?>">
<?php } elseif ($cpy_exhibition_images->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_image" class="cpy_exhibition_images_exhib_image">
<span>
<?php echo ew_GetFileViewTag($cpy_exhibition_images->exhib_image, $cpy_exhibition_images->exhib_image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $cpy_exhibition_images_grid->RowCnt ?>_cpy_exhibition_images_exhib_image" class="form-group cpy_exhibition_images_exhib_image">
<div id="fd_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image">
<span title="<?php echo $cpy_exhibition_images->exhib_image->FldTitle() ? $cpy_exhibition_images->exhib_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_exhibition_images->exhib_image->ReadOnly || $cpy_exhibition_images->exhib_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_exhibition_images" data-field="x_exhib_image" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image"<?php echo $cpy_exhibition_images->exhib_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fn_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fs_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="100">
<input type="hidden" name="fx_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fx_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fm_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_exhibition_images_grid->ListOptions->Render("body", "right", $cpy_exhibition_images_grid->RowCnt);
?>
	</tr>
<?php if ($cpy_exhibition_images->RowType == EW_ROWTYPE_ADD || $cpy_exhibition_images->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_exhibition_imagesgrid.UpdateOpts(<?php echo $cpy_exhibition_images_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_exhibition_images->CurrentAction <> "gridadd" || $cpy_exhibition_images->CurrentMode == "copy")
		if (!$cpy_exhibition_images_grid->Recordset->EOF) $cpy_exhibition_images_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_exhibition_images->CurrentMode == "add" || $cpy_exhibition_images->CurrentMode == "copy" || $cpy_exhibition_images->CurrentMode == "edit") {
		$cpy_exhibition_images_grid->RowIndex = '$rowindex$';
		$cpy_exhibition_images_grid->LoadRowValues();

		// Set row properties
		$cpy_exhibition_images->ResetAttrs();
		$cpy_exhibition_images->RowAttrs = array_merge($cpy_exhibition_images->RowAttrs, array('data-rowindex'=>$cpy_exhibition_images_grid->RowIndex, 'id'=>'r0_cpy_exhibition_images', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_exhibition_images->RowAttrs["class"], "ewTemplate");
		$cpy_exhibition_images->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_exhibition_images_grid->RenderRow();

		// Render list options
		$cpy_exhibition_images_grid->RenderListOptions();
		$cpy_exhibition_images_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_exhibition_images->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_exhibition_images_grid->ListOptions->Render("body", "left", $cpy_exhibition_images_grid->RowIndex);
?>
	<?php if ($cpy_exhibition_images->exhib_id->Visible) { // exhib_id ?>
		<td data-name="exhib_id">
<?php if ($cpy_exhibition_images->CurrentAction <> "F") { ?>
<?php if ($cpy_exhibition_images->exhib_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<span<?php echo $cpy_exhibition_images->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_exhibition_images->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<select data-table="cpy_exhibition_images" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_exhibition_images->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id"<?php echo $cpy_exhibition_images->exhib_id->EditAttributes() ?>>
<?php echo $cpy_exhibition_images->exhib_id->SelectOptionListHtml("x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_exhibition_images_exhib_id" class="form-group cpy_exhibition_images_exhib_id">
<span<?php echo $cpy_exhibition_images->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_exhibition_images->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_id" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_id" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_exhibition_images->exhib_order->Visible) { // exhib_order ?>
		<td data-name="exhib_order">
<?php if ($cpy_exhibition_images->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_exhibition_images_exhib_order" class="form-group cpy_exhibition_images_exhib_order">
<input type="text" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition_images->exhib_order->EditValue ?>"<?php echo $cpy_exhibition_images->exhib_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_exhibition_images_exhib_order" class="form-group cpy_exhibition_images_exhib_order">
<span<?php echo $cpy_exhibition_images->exhib_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_exhibition_images->exhib_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_order" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_order" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_exhibition_images->exhib_image->Visible) { // exhib_image ?>
		<td data-name="exhib_image">
<span id="el$rowindex$_cpy_exhibition_images_exhib_image" class="form-group cpy_exhibition_images_exhib_image">
<div id="fd_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image">
<span title="<?php echo $cpy_exhibition_images->exhib_image->FldTitle() ? $cpy_exhibition_images->exhib_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_exhibition_images->exhib_image->ReadOnly || $cpy_exhibition_images->exhib_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_exhibition_images" data-field="x_exhib_image" name="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id="x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image"<?php echo $cpy_exhibition_images->exhib_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fn_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fa_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fs_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="100">
<input type="hidden" name="fx_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fx_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id= "fm_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo $cpy_exhibition_images->exhib_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_exhibition_images" data-field="x_exhib_image" name="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" id="o<?php echo $cpy_exhibition_images_grid->RowIndex ?>_exhib_image" value="<?php echo ew_HtmlEncode($cpy_exhibition_images->exhib_image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_exhibition_images_grid->ListOptions->Render("body", "right", $cpy_exhibition_images_grid->RowCnt);
?>
<script type="text/javascript">
fcpy_exhibition_imagesgrid.UpdateOpts(<?php echo $cpy_exhibition_images_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cpy_exhibition_images->CurrentMode == "add" || $cpy_exhibition_images->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cpy_exhibition_images_grid->FormKeyCountName ?>" id="<?php echo $cpy_exhibition_images_grid->FormKeyCountName ?>" value="<?php echo $cpy_exhibition_images_grid->KeyCount ?>">
<?php echo $cpy_exhibition_images_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_exhibition_images->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_exhibition_images_grid->FormKeyCountName ?>" id="<?php echo $cpy_exhibition_images_grid->FormKeyCountName ?>" value="<?php echo $cpy_exhibition_images_grid->KeyCount ?>">
<?php echo $cpy_exhibition_images_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_exhibition_images->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcpy_exhibition_imagesgrid">
</div>
<?php

// Close recordset
if ($cpy_exhibition_images_grid->Recordset)
	$cpy_exhibition_images_grid->Recordset->Close();
?>
<?php if ($cpy_exhibition_images_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($cpy_exhibition_images_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cpy_exhibition_images_grid->TotalRecs == 0 && $cpy_exhibition_images->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_exhibition_images_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cpy_exhibition_images->Export == "") { ?>
<script type="text/javascript">
fcpy_exhibition_imagesgrid.Init();
</script>
<?php } ?>
<?php
$cpy_exhibition_images_grid->Page_Terminate();
?>
