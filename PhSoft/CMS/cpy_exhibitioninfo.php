<?php

// Global variable for table object
$cpy_exhibition = NULL;

//
// Table class for cpy_exhibition
//
class ccpy_exhibition extends cTable {
	var $exhib_id;
	var $type_id;
	var $kind_id;
	var $exhib_year;
	var $exhib_title1;
	var $exhib_title2;
	var $exhib_date;
	var $exhib_from;
	var $exhib_to;
	var $exhib_web;
	var $exhib_intro;
	var $exhib_info;
	var $exhib_text;
	var $exhib_image;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cpy_exhibition';
		$this->TableName = 'cpy_exhibition';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`cpy_exhibition`";
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

		// exhib_id
		$this->exhib_id = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_id', 'exhib_id', '`exhib_id`', '`exhib_id`', 3, -1, FALSE, '`exhib_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->exhib_id->Sortable = FALSE; // Allow sort
		$this->exhib_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['exhib_id'] = &$this->exhib_id;

		// type_id
		$this->type_id = new cField('cpy_exhibition', 'cpy_exhibition', 'x_type_id', 'type_id', '`type_id`', '`type_id`', 16, -1, FALSE, '`type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->type_id->Sortable = TRUE; // Allow sort
		$this->type_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->type_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['type_id'] = &$this->type_id;

		// kind_id
		$this->kind_id = new cField('cpy_exhibition', 'cpy_exhibition', 'x_kind_id', 'kind_id', '`kind_id`', '`kind_id`', 16, -1, FALSE, '`kind_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kind_id->Sortable = TRUE; // Allow sort
		$this->kind_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kind_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->kind_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kind_id'] = &$this->kind_id;

		// exhib_year
		$this->exhib_year = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_year', 'exhib_year', '`exhib_year`', '`exhib_year`', 3, -1, FALSE, '`exhib_year`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exhib_year->Sortable = TRUE; // Allow sort
		$this->exhib_year->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['exhib_year'] = &$this->exhib_year;

		// exhib_title1
		$this->exhib_title1 = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_title1', 'exhib_title1', '`exhib_title1`', '`exhib_title1`', 201, -1, FALSE, '`exhib_title1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->exhib_title1->Sortable = TRUE; // Allow sort
		$this->fields['exhib_title1'] = &$this->exhib_title1;

		// exhib_title2
		$this->exhib_title2 = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_title2', 'exhib_title2', '`exhib_title2`', '`exhib_title2`', 201, -1, FALSE, '`exhib_title2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->exhib_title2->Sortable = TRUE; // Allow sort
		$this->fields['exhib_title2'] = &$this->exhib_title2;

		// exhib_date
		$this->exhib_date = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_date', 'exhib_date', '`exhib_date`', ew_CastDateFieldForLike('`exhib_date`', 0, "DB"), 133, 0, FALSE, '`exhib_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exhib_date->Sortable = TRUE; // Allow sort
		$this->exhib_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['exhib_date'] = &$this->exhib_date;

		// exhib_from
		$this->exhib_from = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_from', 'exhib_from', '`exhib_from`', ew_CastDateFieldForLike('`exhib_from`', 0, "DB"), 133, 0, FALSE, '`exhib_from`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exhib_from->Sortable = TRUE; // Allow sort
		$this->exhib_from->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['exhib_from'] = &$this->exhib_from;

		// exhib_to
		$this->exhib_to = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_to', 'exhib_to', '`exhib_to`', ew_CastDateFieldForLike('`exhib_to`', 0, "DB"), 133, 0, FALSE, '`exhib_to`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exhib_to->Sortable = TRUE; // Allow sort
		$this->exhib_to->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['exhib_to'] = &$this->exhib_to;

		// exhib_web
		$this->exhib_web = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_web', 'exhib_web', '`exhib_web`', '`exhib_web`', 200, -1, FALSE, '`exhib_web`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->exhib_web->Sortable = TRUE; // Allow sort
		$this->fields['exhib_web'] = &$this->exhib_web;

		// exhib_intro
		$this->exhib_intro = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_intro', 'exhib_intro', '`exhib_intro`', '`exhib_intro`', 201, -1, FALSE, '`exhib_intro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->exhib_intro->Sortable = TRUE; // Allow sort
		$this->fields['exhib_intro'] = &$this->exhib_intro;

		// exhib_info
		$this->exhib_info = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_info', 'exhib_info', '`exhib_info`', '`exhib_info`', 201, -1, FALSE, '`exhib_info`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->exhib_info->Sortable = TRUE; // Allow sort
		$this->fields['exhib_info'] = &$this->exhib_info;

		// exhib_text
		$this->exhib_text = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_text', 'exhib_text', '`exhib_text`', '`exhib_text`', 201, -1, FALSE, '`exhib_text`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->exhib_text->Sortable = TRUE; // Allow sort
		$this->fields['exhib_text'] = &$this->exhib_text;

		// exhib_image
		$this->exhib_image = new cField('cpy_exhibition', 'cpy_exhibition', 'x_exhib_image', 'exhib_image', '`exhib_image`', '`exhib_image`', 201, -1, TRUE, '`exhib_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->exhib_image->Sortable = TRUE; // Allow sort
		$this->exhib_image->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['exhib_image'] = &$this->exhib_image;
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "cpy_exhibition_images") {
			$sDetailUrl = $GLOBALS["cpy_exhibition_images"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_exhib_id=" . urlencode($this->exhib_id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "cpy_exhibition_video") {
			$sDetailUrl = $GLOBALS["cpy_exhibition_video"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_exhib_id=" . urlencode($this->exhib_id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "cpy_artwork_exhibtion") {
			$sDetailUrl = $GLOBALS["cpy_artwork_exhibtion"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_exhib_id=" . urlencode($this->exhib_id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "cpy_exhibitionlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`cpy_exhibition`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`exhib_year` DESC,`type_id` ASC,`kind_id` ASC,`exhib_from` DESC,`exhib_to` ASC";
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
			$this->exhib_id->setDbValue($conn->Insert_ID());
			$rs['exhib_id'] = $this->exhib_id->DbValue;
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
			if (array_key_exists('exhib_id', $rs))
				ew_AddFilter($where, ew_QuotedName('exhib_id', $this->DBID) . '=' . ew_QuotedValue($rs['exhib_id'], $this->exhib_id->FldDataType, $this->DBID));
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
		return "`exhib_id` = @exhib_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->exhib_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->exhib_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@exhib_id@", ew_AdjustSql($this->exhib_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "cpy_exhibitionlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "cpy_exhibitionview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "cpy_exhibitionedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "cpy_exhibitionadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "cpy_exhibitionlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_exhibitionview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_exhibitionview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "cpy_exhibitionadd.php?" . $this->UrlParm($parm);
		else
			$url = "cpy_exhibitionadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_exhibitionedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_exhibitionedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cpy_exhibitionadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cpy_exhibitionadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cpy_exhibitiondelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "exhib_id:" . ew_VarToJson($this->exhib_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->exhib_id->CurrentValue)) {
			$sUrl .= "exhib_id=" . urlencode($this->exhib_id->CurrentValue);
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
			if ($isPost && isset($_POST["exhib_id"]))
				$arKeys[] = $_POST["exhib_id"];
			elseif (isset($_GET["exhib_id"]))
				$arKeys[] = $_GET["exhib_id"];
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
			$this->exhib_id->CurrentValue = $key;
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
		$this->exhib_id->setDbValue($rs->fields('exhib_id'));
		$this->type_id->setDbValue($rs->fields('type_id'));
		$this->kind_id->setDbValue($rs->fields('kind_id'));
		$this->exhib_year->setDbValue($rs->fields('exhib_year'));
		$this->exhib_title1->setDbValue($rs->fields('exhib_title1'));
		$this->exhib_title2->setDbValue($rs->fields('exhib_title2'));
		$this->exhib_date->setDbValue($rs->fields('exhib_date'));
		$this->exhib_from->setDbValue($rs->fields('exhib_from'));
		$this->exhib_to->setDbValue($rs->fields('exhib_to'));
		$this->exhib_web->setDbValue($rs->fields('exhib_web'));
		$this->exhib_intro->setDbValue($rs->fields('exhib_intro'));
		$this->exhib_info->setDbValue($rs->fields('exhib_info'));
		$this->exhib_text->setDbValue($rs->fields('exhib_text'));
		$this->exhib_image->Upload->DbValue = $rs->fields('exhib_image');
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// exhib_id

		$this->exhib_id->CellCssStyle = "white-space: nowrap;";

		// type_id
		// kind_id
		// exhib_year
		// exhib_title1
		// exhib_title2
		// exhib_date
		// exhib_from
		// exhib_to
		// exhib_web
		// exhib_intro
		// exhib_info
		// exhib_text
		// exhib_image
		// exhib_id

		$this->exhib_id->ViewValue = $this->exhib_id->CurrentValue;
		$this->exhib_id->ViewCustomAttributes = "";

		// type_id
		if (strval($this->type_id->CurrentValue) <> "") {
			$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibtype`";
		$sWhereWrk = "";
		$this->type_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `type_order`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->type_id->ViewValue = $this->type_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->type_id->ViewValue = $this->type_id->CurrentValue;
			}
		} else {
			$this->type_id->ViewValue = NULL;
		}
		$this->type_id->ViewCustomAttributes = "";

		// kind_id
		if (strval($this->kind_id->CurrentValue) <> "") {
			$sFilterWrk = "`kind_id`" . ew_SearchString("=", $this->kind_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kind_id`, `kind_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibkind`";
		$sWhereWrk = "";
		$this->kind_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kind_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `kind_order`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kind_id->ViewValue = $this->kind_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kind_id->ViewValue = $this->kind_id->CurrentValue;
			}
		} else {
			$this->kind_id->ViewValue = NULL;
		}
		$this->kind_id->ViewCustomAttributes = "";

		// exhib_year
		$this->exhib_year->ViewValue = $this->exhib_year->CurrentValue;
		$this->exhib_year->ViewCustomAttributes = "";

		// exhib_title1
		$this->exhib_title1->ViewValue = $this->exhib_title1->CurrentValue;
		$this->exhib_title1->ViewCustomAttributes = "";

		// exhib_title2
		$this->exhib_title2->ViewValue = $this->exhib_title2->CurrentValue;
		$this->exhib_title2->ViewCustomAttributes = "";

		// exhib_date
		$this->exhib_date->ViewValue = $this->exhib_date->CurrentValue;
		$this->exhib_date->ViewValue = ew_FormatDateTime($this->exhib_date->ViewValue, 0);
		$this->exhib_date->ViewCustomAttributes = "";

		// exhib_from
		$this->exhib_from->ViewValue = $this->exhib_from->CurrentValue;
		$this->exhib_from->ViewValue = ew_FormatDateTime($this->exhib_from->ViewValue, 0);
		$this->exhib_from->ViewCustomAttributes = "";

		// exhib_to
		$this->exhib_to->ViewValue = $this->exhib_to->CurrentValue;
		$this->exhib_to->ViewValue = ew_FormatDateTime($this->exhib_to->ViewValue, 0);
		$this->exhib_to->ViewCustomAttributes = "";

		// exhib_web
		$this->exhib_web->ViewValue = $this->exhib_web->CurrentValue;
		$this->exhib_web->ViewCustomAttributes = "";

		// exhib_intro
		$this->exhib_intro->ViewValue = $this->exhib_intro->CurrentValue;
		$this->exhib_intro->ViewCustomAttributes = "";

		// exhib_info
		$this->exhib_info->ViewValue = $this->exhib_info->CurrentValue;
		$this->exhib_info->ViewCustomAttributes = "";

		// exhib_text
		$this->exhib_text->ViewValue = $this->exhib_text->CurrentValue;
		$this->exhib_text->ViewCustomAttributes = "";

		// exhib_image
		$this->exhib_image->UploadPath = '../../assets/img/uploads/';
		if (!ew_Empty($this->exhib_image->Upload->DbValue)) {
			$this->exhib_image->ImageWidth = 100;
			$this->exhib_image->ImageHeight = 0;
			$this->exhib_image->ImageAlt = $this->exhib_image->FldAlt();
			$this->exhib_image->ViewValue = $this->exhib_image->Upload->DbValue;
		} else {
			$this->exhib_image->ViewValue = "";
		}
		$this->exhib_image->ViewCustomAttributes = "";

		// exhib_id
		$this->exhib_id->LinkCustomAttributes = "";
		$this->exhib_id->HrefValue = "";
		$this->exhib_id->TooltipValue = "";

		// type_id
		$this->type_id->LinkCustomAttributes = "";
		$this->type_id->HrefValue = "";
		$this->type_id->TooltipValue = "";

		// kind_id
		$this->kind_id->LinkCustomAttributes = "";
		$this->kind_id->HrefValue = "";
		$this->kind_id->TooltipValue = "";

		// exhib_year
		$this->exhib_year->LinkCustomAttributes = "";
		$this->exhib_year->HrefValue = "";
		$this->exhib_year->TooltipValue = "";

		// exhib_title1
		$this->exhib_title1->LinkCustomAttributes = "";
		$this->exhib_title1->HrefValue = "";
		$this->exhib_title1->TooltipValue = "";

		// exhib_title2
		$this->exhib_title2->LinkCustomAttributes = "";
		$this->exhib_title2->HrefValue = "";
		$this->exhib_title2->TooltipValue = "";

		// exhib_date
		$this->exhib_date->LinkCustomAttributes = "";
		$this->exhib_date->HrefValue = "";
		$this->exhib_date->TooltipValue = "";

		// exhib_from
		$this->exhib_from->LinkCustomAttributes = "";
		$this->exhib_from->HrefValue = "";
		$this->exhib_from->TooltipValue = "";

		// exhib_to
		$this->exhib_to->LinkCustomAttributes = "";
		$this->exhib_to->HrefValue = "";
		$this->exhib_to->TooltipValue = "";

		// exhib_web
		$this->exhib_web->LinkCustomAttributes = "";
		$this->exhib_web->HrefValue = "";
		$this->exhib_web->TooltipValue = "";

		// exhib_intro
		$this->exhib_intro->LinkCustomAttributes = "";
		$this->exhib_intro->HrefValue = "";
		$this->exhib_intro->TooltipValue = "";

		// exhib_info
		$this->exhib_info->LinkCustomAttributes = "";
		$this->exhib_info->HrefValue = "";
		$this->exhib_info->TooltipValue = "";

		// exhib_text
		$this->exhib_text->LinkCustomAttributes = "";
		$this->exhib_text->HrefValue = "";
		$this->exhib_text->TooltipValue = "";

		// exhib_image
		$this->exhib_image->LinkCustomAttributes = "";
		$this->exhib_image->UploadPath = '../../assets/img/uploads/';
		if (!ew_Empty($this->exhib_image->Upload->DbValue)) {
			$this->exhib_image->HrefValue = ew_GetFileUploadUrl($this->exhib_image, $this->exhib_image->Upload->DbValue); // Add prefix/suffix
			$this->exhib_image->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->exhib_image->HrefValue = ew_FullUrl($this->exhib_image->HrefValue, "href");
		} else {
			$this->exhib_image->HrefValue = "";
		}
		$this->exhib_image->HrefValue2 = $this->exhib_image->UploadPath . $this->exhib_image->Upload->DbValue;
		$this->exhib_image->TooltipValue = "";
		if ($this->exhib_image->UseColorbox) {
			if (ew_Empty($this->exhib_image->TooltipValue))
				$this->exhib_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->exhib_image->LinkAttrs["data-rel"] = "cpy_exhibition_x_exhib_image";
			ew_AppendClass($this->exhib_image->LinkAttrs["class"], "ewLightbox");
		}

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

		// exhib_id
		$this->exhib_id->EditAttrs["class"] = "form-control";
		$this->exhib_id->EditCustomAttributes = "";
		$this->exhib_id->EditValue = $this->exhib_id->CurrentValue;
		$this->exhib_id->ViewCustomAttributes = "";

		// type_id
		$this->type_id->EditAttrs["class"] = "form-control";
		$this->type_id->EditCustomAttributes = "";

		// kind_id
		$this->kind_id->EditAttrs["class"] = "form-control";
		$this->kind_id->EditCustomAttributes = "";

		// exhib_year
		$this->exhib_year->EditAttrs["class"] = "form-control";
		$this->exhib_year->EditCustomAttributes = "";
		$this->exhib_year->EditValue = $this->exhib_year->CurrentValue;
		$this->exhib_year->PlaceHolder = ew_RemoveHtml($this->exhib_year->FldCaption());

		// exhib_title1
		$this->exhib_title1->EditAttrs["class"] = "form-control";
		$this->exhib_title1->EditCustomAttributes = "";
		$this->exhib_title1->EditValue = $this->exhib_title1->CurrentValue;
		$this->exhib_title1->PlaceHolder = ew_RemoveHtml($this->exhib_title1->FldCaption());

		// exhib_title2
		$this->exhib_title2->EditAttrs["class"] = "form-control";
		$this->exhib_title2->EditCustomAttributes = "";
		$this->exhib_title2->EditValue = $this->exhib_title2->CurrentValue;
		$this->exhib_title2->PlaceHolder = ew_RemoveHtml($this->exhib_title2->FldCaption());

		// exhib_date
		$this->exhib_date->EditAttrs["class"] = "form-control";
		$this->exhib_date->EditCustomAttributes = "";
		$this->exhib_date->EditValue = ew_FormatDateTime($this->exhib_date->CurrentValue, 8);
		$this->exhib_date->PlaceHolder = ew_RemoveHtml($this->exhib_date->FldCaption());

		// exhib_from
		$this->exhib_from->EditAttrs["class"] = "form-control";
		$this->exhib_from->EditCustomAttributes = "";
		$this->exhib_from->EditValue = ew_FormatDateTime($this->exhib_from->CurrentValue, 8);
		$this->exhib_from->PlaceHolder = ew_RemoveHtml($this->exhib_from->FldCaption());

		// exhib_to
		$this->exhib_to->EditAttrs["class"] = "form-control";
		$this->exhib_to->EditCustomAttributes = "";
		$this->exhib_to->EditValue = ew_FormatDateTime($this->exhib_to->CurrentValue, 8);
		$this->exhib_to->PlaceHolder = ew_RemoveHtml($this->exhib_to->FldCaption());

		// exhib_web
		$this->exhib_web->EditAttrs["class"] = "form-control";
		$this->exhib_web->EditCustomAttributes = "";
		$this->exhib_web->EditValue = $this->exhib_web->CurrentValue;
		$this->exhib_web->PlaceHolder = ew_RemoveHtml($this->exhib_web->FldCaption());

		// exhib_intro
		$this->exhib_intro->EditAttrs["class"] = "form-control";
		$this->exhib_intro->EditCustomAttributes = "";
		$this->exhib_intro->EditValue = $this->exhib_intro->CurrentValue;
		$this->exhib_intro->PlaceHolder = ew_RemoveHtml($this->exhib_intro->FldCaption());

		// exhib_info
		$this->exhib_info->EditAttrs["class"] = "form-control";
		$this->exhib_info->EditCustomAttributes = "";
		$this->exhib_info->EditValue = $this->exhib_info->CurrentValue;
		$this->exhib_info->PlaceHolder = ew_RemoveHtml($this->exhib_info->FldCaption());

		// exhib_text
		$this->exhib_text->EditAttrs["class"] = "form-control";
		$this->exhib_text->EditCustomAttributes = "";
		$this->exhib_text->EditValue = $this->exhib_text->CurrentValue;
		$this->exhib_text->PlaceHolder = ew_RemoveHtml($this->exhib_text->FldCaption());

		// exhib_image
		$this->exhib_image->EditAttrs["class"] = "form-control";
		$this->exhib_image->EditCustomAttributes = "";
		$this->exhib_image->UploadPath = '../../assets/img/uploads/';
		if (!ew_Empty($this->exhib_image->Upload->DbValue)) {
			$this->exhib_image->ImageWidth = 100;
			$this->exhib_image->ImageHeight = 0;
			$this->exhib_image->ImageAlt = $this->exhib_image->FldAlt();
			$this->exhib_image->EditValue = $this->exhib_image->Upload->DbValue;
		} else {
			$this->exhib_image->EditValue = "";
		}
		if (!ew_Empty($this->exhib_image->CurrentValue))
			$this->exhib_image->Upload->FileName = $this->exhib_image->CurrentValue;

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
					if ($this->type_id->Exportable) $Doc->ExportCaption($this->type_id);
					if ($this->kind_id->Exportable) $Doc->ExportCaption($this->kind_id);
					if ($this->exhib_year->Exportable) $Doc->ExportCaption($this->exhib_year);
					if ($this->exhib_title1->Exportable) $Doc->ExportCaption($this->exhib_title1);
					if ($this->exhib_title2->Exportable) $Doc->ExportCaption($this->exhib_title2);
					if ($this->exhib_date->Exportable) $Doc->ExportCaption($this->exhib_date);
					if ($this->exhib_from->Exportable) $Doc->ExportCaption($this->exhib_from);
					if ($this->exhib_to->Exportable) $Doc->ExportCaption($this->exhib_to);
					if ($this->exhib_web->Exportable) $Doc->ExportCaption($this->exhib_web);
					if ($this->exhib_intro->Exportable) $Doc->ExportCaption($this->exhib_intro);
					if ($this->exhib_info->Exportable) $Doc->ExportCaption($this->exhib_info);
					if ($this->exhib_text->Exportable) $Doc->ExportCaption($this->exhib_text);
					if ($this->exhib_image->Exportable) $Doc->ExportCaption($this->exhib_image);
				} else {
					if ($this->type_id->Exportable) $Doc->ExportCaption($this->type_id);
					if ($this->kind_id->Exportable) $Doc->ExportCaption($this->kind_id);
					if ($this->exhib_year->Exportable) $Doc->ExportCaption($this->exhib_year);
					if ($this->exhib_title1->Exportable) $Doc->ExportCaption($this->exhib_title1);
					if ($this->exhib_title2->Exportable) $Doc->ExportCaption($this->exhib_title2);
					if ($this->exhib_date->Exportable) $Doc->ExportCaption($this->exhib_date);
					if ($this->exhib_from->Exportable) $Doc->ExportCaption($this->exhib_from);
					if ($this->exhib_to->Exportable) $Doc->ExportCaption($this->exhib_to);
					if ($this->exhib_web->Exportable) $Doc->ExportCaption($this->exhib_web);
					if ($this->exhib_intro->Exportable) $Doc->ExportCaption($this->exhib_intro);
					if ($this->exhib_info->Exportable) $Doc->ExportCaption($this->exhib_info);
					if ($this->exhib_text->Exportable) $Doc->ExportCaption($this->exhib_text);
					if ($this->exhib_image->Exportable) $Doc->ExportCaption($this->exhib_image);
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
						if ($this->type_id->Exportable) $Doc->ExportField($this->type_id);
						if ($this->kind_id->Exportable) $Doc->ExportField($this->kind_id);
						if ($this->exhib_year->Exportable) $Doc->ExportField($this->exhib_year);
						if ($this->exhib_title1->Exportable) $Doc->ExportField($this->exhib_title1);
						if ($this->exhib_title2->Exportable) $Doc->ExportField($this->exhib_title2);
						if ($this->exhib_date->Exportable) $Doc->ExportField($this->exhib_date);
						if ($this->exhib_from->Exportable) $Doc->ExportField($this->exhib_from);
						if ($this->exhib_to->Exportable) $Doc->ExportField($this->exhib_to);
						if ($this->exhib_web->Exportable) $Doc->ExportField($this->exhib_web);
						if ($this->exhib_intro->Exportable) $Doc->ExportField($this->exhib_intro);
						if ($this->exhib_info->Exportable) $Doc->ExportField($this->exhib_info);
						if ($this->exhib_text->Exportable) $Doc->ExportField($this->exhib_text);
						if ($this->exhib_image->Exportable) $Doc->ExportField($this->exhib_image);
					} else {
						if ($this->type_id->Exportable) $Doc->ExportField($this->type_id);
						if ($this->kind_id->Exportable) $Doc->ExportField($this->kind_id);
						if ($this->exhib_year->Exportable) $Doc->ExportField($this->exhib_year);
						if ($this->exhib_title1->Exportable) $Doc->ExportField($this->exhib_title1);
						if ($this->exhib_title2->Exportable) $Doc->ExportField($this->exhib_title2);
						if ($this->exhib_date->Exportable) $Doc->ExportField($this->exhib_date);
						if ($this->exhib_from->Exportable) $Doc->ExportField($this->exhib_from);
						if ($this->exhib_to->Exportable) $Doc->ExportField($this->exhib_to);
						if ($this->exhib_web->Exportable) $Doc->ExportField($this->exhib_web);
						if ($this->exhib_intro->Exportable) $Doc->ExportField($this->exhib_intro);
						if ($this->exhib_info->Exportable) $Doc->ExportField($this->exhib_info);
						if ($this->exhib_text->Exportable) $Doc->ExportField($this->exhib_text);
						if ($this->exhib_image->Exportable) $Doc->ExportField($this->exhib_image);
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
