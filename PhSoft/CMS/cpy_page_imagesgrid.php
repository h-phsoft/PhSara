<?php include_once "phs_usersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_page_images_grid)) $cpy_page_images_grid = new ccpy_page_images_grid();

// Page init
$cpy_page_images_grid->Page_Init();

// Page main
$cpy_page_images_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_page_images_grid->Page_Render();
?>
<?php if ($cpy_page_images->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcpy_page_imagesgrid = new ew_Form("fcpy_page_imagesgrid", "grid");
fcpy_page_imagesgrid.FormKeyCountName = '<?php echo $cpy_page_images_grid->FormKeyCountName ?>';

// Validate form
fcpy_page_imagesgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_page_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_images->page_id->FldCaption(), $cpy_page_images->page_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_images->page_order->FldCaption(), $cpy_page_images->page_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_page_images->page_order->FldErrMsg()) ?>");
			felm = this.GetElements("x" + infix + "_page_image");
			elm = this.GetElements("fn_x" + infix + "_page_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_page_images->page_image->FldCaption(), $cpy_page_images->page_image->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcpy_page_imagesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "page_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "page_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "page_image", false)) return false;
	return true;
}

// Form_CustomValidate event
fcpy_page_imagesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_page_imagesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_page_imagesgrid.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fcpy_page_imagesgrid.Lists["x_page_id"].Data = "<?php echo $cpy_page_images_grid->page_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($cpy_page_images->CurrentAction == "gridadd") {
	if ($cpy_page_images->CurrentMode == "copy") {
		$bSelectLimit = $cpy_page_images_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cpy_page_images_grid->TotalRecs = $cpy_page_images->ListRecordCount();
			$cpy_page_images_grid->Recordset = $cpy_page_images_grid->LoadRecordset($cpy_page_images_grid->StartRec-1, $cpy_page_images_grid->DisplayRecs);
		} else {
			if ($cpy_page_images_grid->Recordset = $cpy_page_images_grid->LoadRecordset())
				$cpy_page_images_grid->TotalRecs = $cpy_page_images_grid->Recordset->RecordCount();
		}
		$cpy_page_images_grid->StartRec = 1;
		$cpy_page_images_grid->DisplayRecs = $cpy_page_images_grid->TotalRecs;
	} else {
		$cpy_page_images->CurrentFilter = "0=1";
		$cpy_page_images_grid->StartRec = 1;
		$cpy_page_images_grid->DisplayRecs = $cpy_page_images->GridAddRowCount;
	}
	$cpy_page_images_grid->TotalRecs = $cpy_page_images_grid->DisplayRecs;
	$cpy_page_images_grid->StopRec = $cpy_page_images_grid->DisplayRecs;
} else {
	$bSelectLimit = $cpy_page_images_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cpy_page_images_grid->TotalRecs <= 0)
			$cpy_page_images_grid->TotalRecs = $cpy_page_images->ListRecordCount();
	} else {
		if (!$cpy_page_images_grid->Recordset && ($cpy_page_images_grid->Recordset = $cpy_page_images_grid->LoadRecordset()))
			$cpy_page_images_grid->TotalRecs = $cpy_page_images_grid->Recordset->RecordCount();
	}
	$cpy_page_images_grid->StartRec = 1;
	$cpy_page_images_grid->DisplayRecs = $cpy_page_images_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cpy_page_images_grid->Recordset = $cpy_page_images_grid->LoadRecordset($cpy_page_images_grid->StartRec-1, $cpy_page_images_grid->DisplayRecs);

	// Set no record found message
	if ($cpy_page_images->CurrentAction == "" && $cpy_page_images_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$cpy_page_images_grid->setWarningMessage(ew_DeniedMsg());
		if ($cpy_page_images_grid->SearchWhere == "0=101")
			$cpy_page_images_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cpy_page_images_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cpy_page_images_grid->RenderOtherOptions();
?>
<?php $cpy_page_images_grid->ShowPageHeader(); ?>
<?php
$cpy_page_images_grid->ShowMessage();
?>
<?php if ($cpy_page_images_grid->TotalRecs > 0 || $cpy_page_images->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($cpy_page_images_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> cpy_page_images">
<div id="fcpy_page_imagesgrid" class="ewForm ewListForm form-inline">
<?php if ($cpy_page_images_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($cpy_page_images_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cpy_page_images" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_cpy_page_imagesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$cpy_page_images_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cpy_page_images_grid->RenderListOptions();

// Render list options (header, left)
$cpy_page_images_grid->ListOptions->Render("header", "left");
?>
<?php if ($cpy_page_images->page_id->Visible) { // page_id ?>
	<?php if ($cpy_page_images->SortUrl($cpy_page_images->page_id) == "") { ?>
		<th data-name="page_id" class="<?php echo $cpy_page_images->page_id->HeaderCellClass() ?>"><div id="elh_cpy_page_images_page_id" class="cpy_page_images_page_id"><div class="ewTableHeaderCaption"><?php echo $cpy_page_images->page_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_id" class="<?php echo $cpy_page_images->page_id->HeaderCellClass() ?>"><div><div id="elh_cpy_page_images_page_id" class="cpy_page_images_page_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_images->page_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_images->page_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_images->page_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_images->page_order->Visible) { // page_order ?>
	<?php if ($cpy_page_images->SortUrl($cpy_page_images->page_order) == "") { ?>
		<th data-name="page_order" class="<?php echo $cpy_page_images->page_order->HeaderCellClass() ?>"><div id="elh_cpy_page_images_page_order" class="cpy_page_images_page_order"><div class="ewTableHeaderCaption"><?php echo $cpy_page_images->page_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_order" class="<?php echo $cpy_page_images->page_order->HeaderCellClass() ?>"><div><div id="elh_cpy_page_images_page_order" class="cpy_page_images_page_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_images->page_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_images->page_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_images->page_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cpy_page_images->page_image->Visible) { // page_image ?>
	<?php if ($cpy_page_images->SortUrl($cpy_page_images->page_image) == "") { ?>
		<th data-name="page_image" class="<?php echo $cpy_page_images->page_image->HeaderCellClass() ?>"><div id="elh_cpy_page_images_page_image" class="cpy_page_images_page_image"><div class="ewTableHeaderCaption"><?php echo $cpy_page_images->page_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="page_image" class="<?php echo $cpy_page_images->page_image->HeaderCellClass() ?>"><div><div id="elh_cpy_page_images_page_image" class="cpy_page_images_page_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cpy_page_images->page_image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cpy_page_images->page_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cpy_page_images->page_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cpy_page_images_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cpy_page_images_grid->StartRec = 1;
$cpy_page_images_grid->StopRec = $cpy_page_images_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cpy_page_images_grid->FormKeyCountName) && ($cpy_page_images->CurrentAction == "gridadd" || $cpy_page_images->CurrentAction == "gridedit" || $cpy_page_images->CurrentAction == "F")) {
		$cpy_page_images_grid->KeyCount = $objForm->GetValue($cpy_page_images_grid->FormKeyCountName);
		$cpy_page_images_grid->StopRec = $cpy_page_images_grid->StartRec + $cpy_page_images_grid->KeyCount - 1;
	}
}
$cpy_page_images_grid->RecCnt = $cpy_page_images_grid->StartRec - 1;
if ($cpy_page_images_grid->Recordset && !$cpy_page_images_grid->Recordset->EOF) {
	$cpy_page_images_grid->Recordset->MoveFirst();
	$bSelectLimit = $cpy_page_images_grid->UseSelectLimit;
	if (!$bSelectLimit && $cpy_page_images_grid->StartRec > 1)
		$cpy_page_images_grid->Recordset->Move($cpy_page_images_grid->StartRec - 1);
} elseif (!$cpy_page_images->AllowAddDeleteRow && $cpy_page_images_grid->StopRec == 0) {
	$cpy_page_images_grid->StopRec = $cpy_page_images->GridAddRowCount;
}

// Initialize aggregate
$cpy_page_images->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cpy_page_images->ResetAttrs();
$cpy_page_images_grid->RenderRow();
if ($cpy_page_images->CurrentAction == "gridadd")
	$cpy_page_images_grid->RowIndex = 0;
if ($cpy_page_images->CurrentAction == "gridedit")
	$cpy_page_images_grid->RowIndex = 0;
while ($cpy_page_images_grid->RecCnt < $cpy_page_images_grid->StopRec) {
	$cpy_page_images_grid->RecCnt++;
	if (intval($cpy_page_images_grid->RecCnt) >= intval($cpy_page_images_grid->StartRec)) {
		$cpy_page_images_grid->RowCnt++;
		if ($cpy_page_images->CurrentAction == "gridadd" || $cpy_page_images->CurrentAction == "gridedit" || $cpy_page_images->CurrentAction == "F") {
			$cpy_page_images_grid->RowIndex++;
			$objForm->Index = $cpy_page_images_grid->RowIndex;
			if ($objForm->HasValue($cpy_page_images_grid->FormActionName))
				$cpy_page_images_grid->RowAction = strval($objForm->GetValue($cpy_page_images_grid->FormActionName));
			elseif ($cpy_page_images->CurrentAction == "gridadd")
				$cpy_page_images_grid->RowAction = "insert";
			else
				$cpy_page_images_grid->RowAction = "";
		}

		// Set up key count
		$cpy_page_images_grid->KeyCount = $cpy_page_images_grid->RowIndex;

		// Init row class and style
		$cpy_page_images->ResetAttrs();
		$cpy_page_images->CssClass = "";
		if ($cpy_page_images->CurrentAction == "gridadd") {
			if ($cpy_page_images->CurrentMode == "copy") {
				$cpy_page_images_grid->LoadRowValues($cpy_page_images_grid->Recordset); // Load row values
				$cpy_page_images_grid->SetRecordKey($cpy_page_images_grid->RowOldKey, $cpy_page_images_grid->Recordset); // Set old record key
			} else {
				$cpy_page_images_grid->LoadRowValues(); // Load default values
				$cpy_page_images_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cpy_page_images_grid->LoadRowValues($cpy_page_images_grid->Recordset); // Load row values
		}
		$cpy_page_images->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cpy_page_images->CurrentAction == "gridadd") // Grid add
			$cpy_page_images->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cpy_page_images->CurrentAction == "gridadd" && $cpy_page_images->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cpy_page_images_grid->RestoreCurrentRowFormValues($cpy_page_images_grid->RowIndex); // Restore form values
		if ($cpy_page_images->CurrentAction == "gridedit") { // Grid edit
			if ($cpy_page_images->EventCancelled) {
				$cpy_page_images_grid->RestoreCurrentRowFormValues($cpy_page_images_grid->RowIndex); // Restore form values
			}
			if ($cpy_page_images_grid->RowAction == "insert")
				$cpy_page_images->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cpy_page_images->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cpy_page_images->CurrentAction == "gridedit" && ($cpy_page_images->RowType == EW_ROWTYPE_EDIT || $cpy_page_images->RowType == EW_ROWTYPE_ADD) && $cpy_page_images->EventCancelled) // Update failed
			$cpy_page_images_grid->RestoreCurrentRowFormValues($cpy_page_images_grid->RowIndex); // Restore form values
		if ($cpy_page_images->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cpy_page_images_grid->EditRowCnt++;
		if ($cpy_page_images->CurrentAction == "F") // Confirm row
			$cpy_page_images_grid->RestoreCurrentRowFormValues($cpy_page_images_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cpy_page_images->RowAttrs = array_merge($cpy_page_images->RowAttrs, array('data-rowindex'=>$cpy_page_images_grid->RowCnt, 'id'=>'r' . $cpy_page_images_grid->RowCnt . '_cpy_page_images', 'data-rowtype'=>$cpy_page_images->RowType));

		// Render row
		$cpy_page_images_grid->RenderRow();

		// Render list options
		$cpy_page_images_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cpy_page_images_grid->RowAction <> "delete" && $cpy_page_images_grid->RowAction <> "insertdelete" && !($cpy_page_images_grid->RowAction == "insert" && $cpy_page_images->CurrentAction == "F" && $cpy_page_images_grid->EmptyRow())) {
?>
	<tr<?php echo $cpy_page_images->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_images_grid->ListOptions->Render("body", "left", $cpy_page_images_grid->RowCnt);
?>
	<?php if ($cpy_page_images->page_id->Visible) { // page_id ?>
		<td data-name="page_id"<?php echo $cpy_page_images->page_id->CellAttributes() ?>>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cpy_page_images->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<span<?php echo $cpy_page_images->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_images->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<select data-table="cpy_page_images" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_images->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id"<?php echo $cpy_page_images->page_id->EditAttributes() ?>>
<?php echo $cpy_page_images->page_id->SelectOptionListHtml("x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cpy_page_images->page_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<span<?php echo $cpy_page_images->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_images->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<select data-table="cpy_page_images" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_images->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id"<?php echo $cpy_page_images->page_id->EditAttributes() ?>>
<?php echo $cpy_page_images->page_id->SelectOptionListHtml("x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_id" class="cpy_page_images_page_id">
<span<?php echo $cpy_page_images->page_id->ViewAttributes() ?>>
<?php echo $cpy_page_images->page_id->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_images->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->FormValue) ?>">
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="fcpy_page_imagesgrid$x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="fcpy_page_imagesgrid$x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->FormValue) ?>">
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="fcpy_page_imagesgrid$o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="fcpy_page_imagesgrid$o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_ipage_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_ipage_id" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_ipage_id" value="<?php echo ew_HtmlEncode($cpy_page_images->ipage_id->CurrentValue) ?>">
<input type="hidden" data-table="cpy_page_images" data-field="x_ipage_id" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_ipage_id" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_ipage_id" value="<?php echo ew_HtmlEncode($cpy_page_images->ipage_id->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_EDIT || $cpy_page_images->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_ipage_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_ipage_id" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_ipage_id" value="<?php echo ew_HtmlEncode($cpy_page_images->ipage_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cpy_page_images->page_order->Visible) { // page_order ?>
		<td data-name="page_order"<?php echo $cpy_page_images->page_order->CellAttributes() ?>>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_order" class="form-group cpy_page_images_page_order">
<input type="text" data-table="cpy_page_images" data-field="x_page_order" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_images->page_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_images->page_order->EditValue ?>"<?php echo $cpy_page_images->page_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->OldValue) ?>">
<?php } ?>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_order" class="form-group cpy_page_images_page_order">
<input type="text" data-table="cpy_page_images" data-field="x_page_order" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_images->page_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_images->page_order->EditValue ?>"<?php echo $cpy_page_images->page_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_order" class="cpy_page_images_page_order">
<span<?php echo $cpy_page_images->page_order->ViewAttributes() ?>>
<?php echo $cpy_page_images->page_order->ListViewValue() ?></span>
</span>
<?php if ($cpy_page_images->CurrentAction <> "F") { ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->FormValue) ?>">
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="fcpy_page_imagesgrid$x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="fcpy_page_imagesgrid$x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->FormValue) ?>">
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="fcpy_page_imagesgrid$o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="fcpy_page_imagesgrid$o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cpy_page_images->page_image->Visible) { // page_image ?>
		<td data-name="page_image"<?php echo $cpy_page_images->page_image->CellAttributes() ?>>
<?php if ($cpy_page_images_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_cpy_page_images_page_image" class="form-group cpy_page_images_page_image">
<div id="fd_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image">
<span title="<?php echo $cpy_page_images->page_image->FldTitle() ? $cpy_page_images->page_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_page_images->page_image->ReadOnly || $cpy_page_images->page_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_page_images" data-field="x_page_image" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image"<?php echo $cpy_page_images->page_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fn_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fs_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fx_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fm_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_image" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo ew_HtmlEncode($cpy_page_images->page_image->OldValue) ?>">
<?php } elseif ($cpy_page_images->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_image" class="cpy_page_images_page_image">
<span>
<?php echo ew_GetFileViewTag($cpy_page_images->page_image, $cpy_page_images->page_image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $cpy_page_images_grid->RowCnt ?>_cpy_page_images_page_image" class="form-group cpy_page_images_page_image">
<div id="fd_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image">
<span title="<?php echo $cpy_page_images->page_image->FldTitle() ? $cpy_page_images->page_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_page_images->page_image->ReadOnly || $cpy_page_images->page_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_page_images" data-field="x_page_image" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image"<?php echo $cpy_page_images->page_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fn_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fs_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fx_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fm_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_images_grid->ListOptions->Render("body", "right", $cpy_page_images_grid->RowCnt);
?>
	</tr>
<?php if ($cpy_page_images->RowType == EW_ROWTYPE_ADD || $cpy_page_images->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcpy_page_imagesgrid.UpdateOpts(<?php echo $cpy_page_images_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cpy_page_images->CurrentAction <> "gridadd" || $cpy_page_images->CurrentMode == "copy")
		if (!$cpy_page_images_grid->Recordset->EOF) $cpy_page_images_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cpy_page_images->CurrentMode == "add" || $cpy_page_images->CurrentMode == "copy" || $cpy_page_images->CurrentMode == "edit") {
		$cpy_page_images_grid->RowIndex = '$rowindex$';
		$cpy_page_images_grid->LoadRowValues();

		// Set row properties
		$cpy_page_images->ResetAttrs();
		$cpy_page_images->RowAttrs = array_merge($cpy_page_images->RowAttrs, array('data-rowindex'=>$cpy_page_images_grid->RowIndex, 'id'=>'r0_cpy_page_images', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cpy_page_images->RowAttrs["class"], "ewTemplate");
		$cpy_page_images->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cpy_page_images_grid->RenderRow();

		// Render list options
		$cpy_page_images_grid->RenderListOptions();
		$cpy_page_images_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cpy_page_images->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cpy_page_images_grid->ListOptions->Render("body", "left", $cpy_page_images_grid->RowIndex);
?>
	<?php if ($cpy_page_images->page_id->Visible) { // page_id ?>
		<td data-name="page_id">
<?php if ($cpy_page_images->CurrentAction <> "F") { ?>
<?php if ($cpy_page_images->page_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<span<?php echo $cpy_page_images->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_images->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<select data-table="cpy_page_images" data-field="x_page_id" data-value-separator="<?php echo $cpy_page_images->page_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id"<?php echo $cpy_page_images->page_id->EditAttributes() ?>>
<?php echo $cpy_page_images->page_id->SelectOptionListHtml("x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_images_page_id" class="form-group cpy_page_images_page_id">
<span<?php echo $cpy_page_images->page_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_images->page_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_id" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_id" value="<?php echo ew_HtmlEncode($cpy_page_images->page_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_images->page_order->Visible) { // page_order ?>
		<td data-name="page_order">
<?php if ($cpy_page_images->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cpy_page_images_page_order" class="form-group cpy_page_images_page_order">
<input type="text" data-table="cpy_page_images" data-field="x_page_order" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_page_images->page_order->getPlaceHolder()) ?>" value="<?php echo $cpy_page_images->page_order->EditValue ?>"<?php echo $cpy_page_images->page_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cpy_page_images_page_order" class="form-group cpy_page_images_page_order">
<span<?php echo $cpy_page_images->page_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_page_images->page_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_order" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_order" value="<?php echo ew_HtmlEncode($cpy_page_images->page_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cpy_page_images->page_image->Visible) { // page_image ?>
		<td data-name="page_image">
<span id="el$rowindex$_cpy_page_images_page_image" class="form-group cpy_page_images_page_image">
<div id="fd_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image">
<span title="<?php echo $cpy_page_images->page_image->FldTitle() ? $cpy_page_images->page_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_page_images->page_image->ReadOnly || $cpy_page_images->page_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_page_images" data-field="x_page_image" name="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id="x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image"<?php echo $cpy_page_images->page_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fn_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fa_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="0">
<input type="hidden" name="fs_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fs_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="200">
<input type="hidden" name="fx_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fx_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id= "fm_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo $cpy_page_images->page_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="cpy_page_images" data-field="x_page_image" name="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" id="o<?php echo $cpy_page_images_grid->RowIndex ?>_page_image" value="<?php echo ew_HtmlEncode($cpy_page_images->page_image->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cpy_page_images_grid->ListOptions->Render("body", "right", $cpy_page_images_grid->RowCnt);
?>
<script type="text/javascript">
fcpy_page_imagesgrid.UpdateOpts(<?php echo $cpy_page_images_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cpy_page_images->CurrentMode == "add" || $cpy_page_images->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cpy_page_images_grid->FormKeyCountName ?>" id="<?php echo $cpy_page_images_grid->FormKeyCountName ?>" value="<?php echo $cpy_page_images_grid->KeyCount ?>">
<?php echo $cpy_page_images_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_page_images->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cpy_page_images_grid->FormKeyCountName ?>" id="<?php echo $cpy_page_images_grid->FormKeyCountName ?>" value="<?php echo $cpy_page_images_grid->KeyCount ?>">
<?php echo $cpy_page_images_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cpy_page_images->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcpy_page_imagesgrid">
</div>
<?php

// Close recordset
if ($cpy_page_images_grid->Recordset)
	$cpy_page_images_grid->Recordset->Close();
?>
<?php if ($cpy_page_images_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($cpy_page_images_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cpy_page_images_grid->TotalRecs == 0 && $cpy_page_images->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cpy_page_images_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cpy_page_images->Export == "") { ?>
<script type="text/javascript">
fcpy_page_imagesgrid.Init();
</script>
<?php } ?>
<?php
$cpy_page_images_grid->Page_Terminate();
?>
