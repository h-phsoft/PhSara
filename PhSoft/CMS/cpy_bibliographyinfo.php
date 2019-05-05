<?php

// Global variable for table object
$cpy_bibliography = NULL;

//
// Table class for cpy_bibliography
//
class ccpy_bibliography extends cTable {
	var $bibl_id;
	var $bibl_order;
	var $bibl_title1;
	var $bibl_title2;
	var $bibl_image;
	var $bibl_text;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cpy_bibliography';
		$this->TableName = 'cpy_bibliography';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`cpy_bibliography`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// bibl_id
		$this->bibl_id = new cField('cpy_bibliography', 'cpy_bibliography', 'x_bibl_id', 'bibl_id', '`bibl_id`', '`bibl_id`', 3, -1, FALSE, '`bibl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->bibl_id->Sortable = FALSE; // Allow sort
		$this->bibl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bibl_id'] = &$this->bibl_id;

		// bibl_order
		$this->bibl_order = new cField('cpy_bibliography', 'cpy_bibliography', 'x_bibl_order', 'bibl_order', '`bibl_order`', '`bibl_order`', 3, -1, FALSE, '`bibl_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bibl_order->Sortable = TRUE; // Allow sort
		$this->bibl_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bibl_order'] = &$this->bibl_order;

		// bibl_title1
		$this->bibl_title1 = new cField('cpy_bibliography', 'cpy_bibliography', 'x_bibl_title1', 'bibl_title1', '`bibl_title1`', '`bibl_title1`', 201, -1, FALSE, '`bibl_title1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->bibl_title1->Sortable = TRUE; // Allow sort
		$this->fields['bibl_title1'] = &$this->bibl_title1;

		// bibl_title2
		$this->bibl_title2 = new cField('cpy_bibliography', 'cpy_bibliography', 'x_bibl_title2', 'bibl_title2', '`bibl_title2`', '`bibl_title2`', 201, -1, FALSE, '`bibl_title2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->bibl_title2->Sortable = TRUE; // Allow sort
		$this->fields['bibl_title2'] = &$this->bibl_title2;

		// bibl_image
		$this->bibl_image = new cField('cpy_bibliography', 'cpy_bibliography', 'x_bibl_image', 'bibl_image', '`bibl_image`', '`bibl_image`', 201, -1, TRUE, '`bibl_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->bibl_image->Sortable = TRUE; // Allow sort
		$this->fields['bibl_image'] = &$this->bibl_image;

		// bibl_text
		$this->bibl_text = new cField('cpy_bibliography', 'cpy_bibliography', 'x_bibl_text', 'bibl_text', '`bibl_text`', '`bibl_text`', 201, -1, FALSE, '`bibl_text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->bibl_text->Sortable = TRUE; // Allow sort
		$this->fields['bibl_text'] = &$this->bibl_text;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $this->LeftColumnClass);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cpy_bibliography`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`bibl_order` ASC,`bibl_id` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$sSql = $this->ListSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->bibl_id->setDbValue($conn->Insert_ID());
			$rs['bibl_id'] = $this->bibl_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('bibl_id', $rs))
				ew_AddFilter($where, ew_QuotedName('bibl_id', $this->DBID) . '=' . ew_QuotedValue($rs['bibl_id'], $this->bibl_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`bibl_id` = @bibl_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->bibl_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->bibl_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@bibl_id@", ew_AdjustSql($this->bibl_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "cpy_bibliographylist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "cpy_bibliographyview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "cpy_bibliographyedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "cpy_bibliographyadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "cpy_bibliographylist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_bibliographyview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_bibliographyview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "cpy_bibliographyadd.php?" . $this->UrlParm($parm);
		else
			$url = "cpy_bibliographyadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("cpy_bibliographyedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("cpy_bibliographyadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cpy_bibliographydelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "bibl_id:" . ew_VarToJson($this->bibl_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->bibl_id->CurrentValue)) {
			$sUrl .= "bibl_id=" . urlencode($this->bibl_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["bibl_id"]))
				$arKeys[] = $_POST["bibl_id"];
			elseif (isset($_GET["bibl_id"]))
				$arKeys[] = $_GET["bibl_id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->bibl_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->bibl_id->setDbValue($rs->fields('bibl_id'));
		$this->bibl_order->setDbValue($rs->fields('bibl_order'));
		$this->bibl_title1->setDbValue($rs->fields('bibl_title1'));
		$this->bibl_title2->setDbValue($rs->fields('bibl_title2'));
		$this->bibl_image->Upload->DbValue = $rs->fields('bibl_image');
		$this->bibl_text->setDbValue($rs->fields('bibl_text'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// bibl_id

		$this->bibl_id->CellCssStyle = "white-space: nowrap;";

		// bibl_order
		// bibl_title1
		// bibl_title2
		// bibl_image
		// bibl_text
		// bibl_id

		$this->bibl_id->ViewValue = $this->bibl_id->CurrentValue;
		$this->bibl_id->ViewCustomAttributes = "";

		// bibl_order
		$this->bibl_order->ViewValue = $this->bibl_order->CurrentValue;
		$this->bibl_order->ViewCustomAttributes = "";

		// bibl_title1
		$this->bibl_title1->ViewValue = $this->bibl_title1->CurrentValue;
		$this->bibl_title1->ViewCustomAttributes = "";

		// bibl_title2
		$this->bibl_title2->ViewValue = $this->bibl_title2->CurrentValue;
		$this->bibl_title2->ViewCustomAttributes = "";

		// bibl_image
		if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
			$this->bibl_image->ImageWidth = 100;
			$this->bibl_image->ImageHeight = 0;
			$this->bibl_image->ImageAlt = $this->bibl_image->FldAlt();
			$this->bibl_image->ViewValue = $this->bibl_image->Upload->DbValue;
		} else {
			$this->bibl_image->ViewValue = "";
		}
		$this->bibl_image->ViewCustomAttributes = "";

		// bibl_text
		$this->bibl_text->ViewValue = $this->bibl_text->CurrentValue;
		$this->bibl_text->ViewCustomAttributes = "";

		// bibl_id
		$this->bibl_id->LinkCustomAttributes = "";
		$this->bibl_id->HrefValue = "";
		$this->bibl_id->TooltipValue = "";

		// bibl_order
		$this->bibl_order->LinkCustomAttributes = "";
		$this->bibl_order->HrefValue = "";
		$this->bibl_order->TooltipValue = "";

		// bibl_title1
		$this->bibl_title1->LinkCustomAttributes = "";
		$this->bibl_title1->HrefValue = "";
		$this->bibl_title1->TooltipValue = "";

		// bibl_title2
		$this->bibl_title2->LinkCustomAttributes = "";
		$this->bibl_title2->HrefValue = "";
		$this->bibl_title2->TooltipValue = "";

		// bibl_image
		$this->bibl_image->LinkCustomAttributes = "";
		if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
			$this->bibl_image->HrefValue = ew_GetFileUploadUrl($this->bibl_image, $this->bibl_image->Upload->DbValue); // Add prefix/suffix
			$this->bibl_image->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->bibl_image->HrefValue = ew_FullUrl($this->bibl_image->HrefValue, "href");
		} else {
			$this->bibl_image->HrefValue = "";
		}
		$this->bibl_image->HrefValue2 = $this->bibl_image->UploadPath . $this->bibl_image->Upload->DbValue;
		$this->bibl_image->TooltipValue = "";
		if ($this->bibl_image->UseColorbox) {
			if (ew_Empty($this->bibl_image->TooltipValue))
				$this->bibl_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->bibl_image->LinkAttrs["data-rel"] = "cpy_bibliography_x_bibl_image";
			ew_AppendClass($this->bibl_image->LinkAttrs["class"], "ewLightbox");
		}

		// bibl_text
		$this->bibl_text->LinkCustomAttributes = "";
		$this->bibl_text->HrefValue = "";
		$this->bibl_text->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// bibl_id
		$this->bibl_id->EditAttrs["class"] = "form-control";
		$this->bibl_id->EditCustomAttributes = "";
		$this->bibl_id->EditValue = $this->bibl_id->CurrentValue;
		$this->bibl_id->ViewCustomAttributes = "";

		// bibl_order
		$this->bibl_order->EditAttrs["class"] = "form-control";
		$this->bibl_order->EditCustomAttributes = "";
		$this->bibl_order->EditValue = $this->bibl_order->CurrentValue;
		$this->bibl_order->PlaceHolder = ew_RemoveHtml($this->bibl_order->FldCaption());

		// bibl_title1
		$this->bibl_title1->EditAttrs["class"] = "form-control";
		$this->bibl_title1->EditCustomAttributes = "";
		$this->bibl_title1->EditValue = $this->bibl_title1->CurrentValue;
		$this->bibl_title1->PlaceHolder = ew_RemoveHtml($this->bibl_title1->FldCaption());

		// bibl_title2
		$this->bibl_title2->EditAttrs["class"] = "form-control";
		$this->bibl_title2->EditCustomAttributes = "";
		$this->bibl_title2->EditValue = $this->bibl_title2->CurrentValue;
		$this->bibl_title2->PlaceHolder = ew_RemoveHtml($this->bibl_title2->FldCaption());

		// bibl_image
		$this->bibl_image->EditAttrs["class"] = "form-control";
		$this->bibl_image->EditCustomAttributes = "";
		if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
			$this->bibl_image->ImageWidth = 100;
			$this->bibl_image->ImageHeight = 0;
			$this->bibl_image->ImageAlt = $this->bibl_image->FldAlt();
			$this->bibl_image->EditValue = $this->bibl_image->Upload->DbValue;
		} else {
			$this->bibl_image->EditValue = "";
		}
		if (!ew_Empty($this->bibl_image->CurrentValue))
			$this->bibl_image->Upload->FileName = $this->bibl_image->CurrentValue;

		// bibl_text
		$this->bibl_text->EditAttrs["class"] = "form-control";
		$this->bibl_text->EditCustomAttributes = "";
		$this->bibl_text->EditValue = $this->bibl_text->CurrentValue;
		$this->bibl_text->PlaceHolder = ew_RemoveHtml($this->bibl_text->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->bibl_order->Exportable) $Doc->ExportCaption($this->bibl_order);
					if ($this->bibl_title1->Exportable) $Doc->ExportCaption($this->bibl_title1);
					if ($this->bibl_title2->Exportable) $Doc->ExportCaption($this->bibl_title2);
					if ($this->bibl_image->Exportable) $Doc->ExportCaption($this->bibl_image);
					if ($this->bibl_text->Exportable) $Doc->ExportCaption($this->bibl_text);
				} else {
					if ($this->bibl_order->Exportable) $Doc->ExportCaption($this->bibl_order);
					if ($this->bibl_title1->Exportable) $Doc->ExportCaption($this->bibl_title1);
					if ($this->bibl_title2->Exportable) $Doc->ExportCaption($this->bibl_title2);
					if ($this->bibl_image->Exportable) $Doc->ExportCaption($this->bibl_image);
					if ($this->bibl_text->Exportable) $Doc->ExportCaption($this->bibl_text);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->bibl_order->Exportable) $Doc->ExportField($this->bibl_order);
						if ($this->bibl_title1->Exportable) $Doc->ExportField($this->bibl_title1);
						if ($this->bibl_title2->Exportable) $Doc->ExportField($this->bibl_title2);
						if ($this->bibl_image->Exportable) $Doc->ExportField($this->bibl_image);
						if ($this->bibl_text->Exportable) $Doc->ExportField($this->bibl_text);
					} else {
						if ($this->bibl_order->Exportable) $Doc->ExportField($this->bibl_order);
						if ($this->bibl_title1->Exportable) $Doc->ExportField($this->bibl_title1);
						if ($this->bibl_title2->Exportable) $Doc->ExportField($this->bibl_title2);
						if ($this->bibl_image->Exportable) $Doc->ExportField($this->bibl_image);
						if ($this->bibl_text->Exportable) $Doc->ExportField($this->bibl_text);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
