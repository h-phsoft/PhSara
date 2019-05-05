<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "phs_menuinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$phs_menu_delete = NULL; // Initialize page object first

class cphs_menu_delete extends cphs_menu {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'phs_menu';

	// Page object name
	var $PageObjName = 'phs_menu_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (phs_menu)
		if (!isset($GLOBALS["phs_menu"]) || get_class($GLOBALS["phs_menu"]) == "cphs_menu") {
			$GLOBALS["phs_menu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["phs_menu"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'phs_menu', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (phs_users)
		if (!isset($UserTable)) {
			$UserTable = new cphs_users();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("phs_menulist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->menu_id->SetVisibility();
		$this->menu_pid->SetVisibility();
		$this->page_id->SetVisibility();
		$this->status_id->SetVisibility();
		$this->menu_order->SetVisibility();
		$this->menu_name->SetVisibility();
		$this->menu_icon->SetVisibility();
		$this->menu_href->SetVisibility();
		$this->menu_target->SetVisibility();
		$this->menu_page->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $phs_menu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($phs_menu);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("phs_menulist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in phs_menu class, phs_menuinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("phs_menulist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->menu_id->setDbValue($row['menu_id']);
		$this->menu_pid->setDbValue($row['menu_pid']);
		$this->page_id->setDbValue($row['page_id']);
		$this->status_id->setDbValue($row['status_id']);
		$this->menu_order->setDbValue($row['menu_order']);
		$this->menu_name->setDbValue($row['menu_name']);
		$this->menu_icon->setDbValue($row['menu_icon']);
		$this->menu_href->setDbValue($row['menu_href']);
		$this->menu_target->setDbValue($row['menu_target']);
		$this->menu_page->setDbValue($row['menu_page']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['menu_id'] = NULL;
		$row['menu_pid'] = NULL;
		$row['page_id'] = NULL;
		$row['status_id'] = NULL;
		$row['menu_order'] = NULL;
		$row['menu_name'] = NULL;
		$row['menu_icon'] = NULL;
		$row['menu_href'] = NULL;
		$row['menu_target'] = NULL;
		$row['menu_page'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->menu_id->DbValue = $row['menu_id'];
		$this->menu_pid->DbValue = $row['menu_pid'];
		$this->page_id->DbValue = $row['page_id'];
		$this->status_id->DbValue = $row['status_id'];
		$this->menu_order->DbValue = $row['menu_order'];
		$this->menu_name->DbValue = $row['menu_name'];
		$this->menu_icon->DbValue = $row['menu_icon'];
		$this->menu_href->DbValue = $row['menu_href'];
		$this->menu_target->DbValue = $row['menu_target'];
		$this->menu_page->DbValue = $row['menu_page'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// menu_id
		// menu_pid
		// page_id
		// status_id
		// menu_order
		// menu_name
		// menu_icon
		// menu_href
		// menu_target
		// menu_page

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// menu_id
		$this->menu_id->ViewValue = $this->menu_id->CurrentValue;
		$this->menu_id->ViewCustomAttributes = "";

		// menu_pid
		if (strval($this->menu_pid->CurrentValue) <> "") {
			$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_pid->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `menu_id`, `menu_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_menu`";
		$sWhereWrk = "";
		$this->menu_pid->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->menu_pid, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->menu_pid->ViewValue = $this->menu_pid->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->menu_pid->ViewValue = $this->menu_pid->CurrentValue;
			}
		} else {
			$this->menu_pid->ViewValue = NULL;
		}
		$this->menu_pid->ViewCustomAttributes = "";

		// page_id
		if (strval($this->page_id->CurrentValue) <> "") {
			$sFilterWrk = "`page_id`" . ew_SearchString("=", $this->page_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `page_id`, `page_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_page`";
		$sWhereWrk = "";
		$this->page_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->page_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->page_id->ViewValue = $this->page_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->page_id->ViewValue = $this->page_id->CurrentValue;
			}
		} else {
			$this->page_id->ViewValue = NULL;
		}
		$this->page_id->ViewCustomAttributes = "";

		// status_id
		if (strval($this->status_id->CurrentValue) <> "") {
			$sFilterWrk = "`status_id`" . ew_SearchString("=", $this->status_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `status_id`, `status_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_status`";
		$sWhereWrk = "";
		$this->status_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->status_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->status_id->ViewValue = $this->status_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->status_id->ViewValue = $this->status_id->CurrentValue;
			}
		} else {
			$this->status_id->ViewValue = NULL;
		}
		$this->status_id->ViewCustomAttributes = "";

		// menu_order
		$this->menu_order->ViewValue = $this->menu_order->CurrentValue;
		$this->menu_order->ViewCustomAttributes = "";

		// menu_name
		$this->menu_name->ViewValue = $this->menu_name->CurrentValue;
		$this->menu_name->ViewCustomAttributes = "";

		// menu_icon
		$this->menu_icon->ViewValue = $this->menu_icon->CurrentValue;
		$this->menu_icon->ViewCustomAttributes = "";

		// menu_href
		$this->menu_href->ViewValue = $this->menu_href->CurrentValue;
		$this->menu_href->ViewCustomAttributes = "";

		// menu_target
		$this->menu_target->ViewValue = $this->menu_target->CurrentValue;
		$this->menu_target->ViewCustomAttributes = "";

		// menu_page
		$this->menu_page->ViewValue = $this->menu_page->CurrentValue;
		$this->menu_page->ViewCustomAttributes = "";

			// menu_id
			$this->menu_id->LinkCustomAttributes = "";
			$this->menu_id->HrefValue = "";
			$this->menu_id->TooltipValue = "";

			// menu_pid
			$this->menu_pid->LinkCustomAttributes = "";
			$this->menu_pid->HrefValue = "";
			$this->menu_pid->TooltipValue = "";

			// page_id
			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";
			$this->page_id->TooltipValue = "";

			// status_id
			$this->status_id->LinkCustomAttributes = "";
			$this->status_id->HrefValue = "";
			$this->status_id->TooltipValue = "";

			// menu_order
			$this->menu_order->LinkCustomAttributes = "";
			$this->menu_order->HrefValue = "";
			$this->menu_order->TooltipValue = "";

			// menu_name
			$this->menu_name->LinkCustomAttributes = "";
			$this->menu_name->HrefValue = "";
			$this->menu_name->TooltipValue = "";

			// menu_icon
			$this->menu_icon->LinkCustomAttributes = "";
			$this->menu_icon->HrefValue = "";
			$this->menu_icon->TooltipValue = "";

			// menu_href
			$this->menu_href->LinkCustomAttributes = "";
			$this->menu_href->HrefValue = "";
			$this->menu_href->TooltipValue = "";

			// menu_target
			$this->menu_target->LinkCustomAttributes = "";
			$this->menu_target->HrefValue = "";
			$this->menu_target->TooltipValue = "";

			// menu_page
			$this->menu_page->LinkCustomAttributes = "";
			$this->menu_page->HrefValue = "";
			$this->menu_page->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['menu_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("phs_menulist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($phs_menu_delete)) $phs_menu_delete = new cphs_menu_delete();

// Page init
$phs_menu_delete->Page_Init();

// Page main
$phs_menu_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$phs_menu_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fphs_menudelete = new ew_Form("fphs_menudelete", "delete");

// Form_CustomValidate event
fphs_menudelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fphs_menudelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fphs_menudelete.Lists["x_menu_pid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_menu"};
fphs_menudelete.Lists["x_menu_pid"].Data = "<?php echo $phs_menu_delete->menu_pid->LookupFilterQuery(FALSE, "delete") ?>";
fphs_menudelete.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fphs_menudelete.Lists["x_page_id"].Data = "<?php echo $phs_menu_delete->page_id->LookupFilterQuery(FALSE, "delete") ?>";
fphs_menudelete.Lists["x_status_id"] = {"LinkField":"x_status_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_status_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_status"};
fphs_menudelete.Lists["x_status_id"].Data = "<?php echo $phs_menu_delete->status_id->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $phs_menu_delete->ShowPageHeader(); ?>
<?php
$phs_menu_delete->ShowMessage();
?>
<form name="fphs_menudelete" id="fphs_menudelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($phs_menu_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $phs_menu_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="phs_menu">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($phs_menu_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($phs_menu->menu_id->Visible) { // menu_id ?>
		<th class="<?php echo $phs_menu->menu_id->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_id" class="phs_menu_menu_id"><?php echo $phs_menu->menu_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_pid->Visible) { // menu_pid ?>
		<th class="<?php echo $phs_menu->menu_pid->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_pid" class="phs_menu_menu_pid"><?php echo $phs_menu->menu_pid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->page_id->Visible) { // page_id ?>
		<th class="<?php echo $phs_menu->page_id->HeaderCellClass() ?>"><span id="elh_phs_menu_page_id" class="phs_menu_page_id"><?php echo $phs_menu->page_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->status_id->Visible) { // status_id ?>
		<th class="<?php echo $phs_menu->status_id->HeaderCellClass() ?>"><span id="elh_phs_menu_status_id" class="phs_menu_status_id"><?php echo $phs_menu->status_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_order->Visible) { // menu_order ?>
		<th class="<?php echo $phs_menu->menu_order->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_order" class="phs_menu_menu_order"><?php echo $phs_menu->menu_order->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_name->Visible) { // menu_name ?>
		<th class="<?php echo $phs_menu->menu_name->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_name" class="phs_menu_menu_name"><?php echo $phs_menu->menu_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_icon->Visible) { // menu_icon ?>
		<th class="<?php echo $phs_menu->menu_icon->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_icon" class="phs_menu_menu_icon"><?php echo $phs_menu->menu_icon->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_href->Visible) { // menu_href ?>
		<th class="<?php echo $phs_menu->menu_href->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_href" class="phs_menu_menu_href"><?php echo $phs_menu->menu_href->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_target->Visible) { // menu_target ?>
		<th class="<?php echo $phs_menu->menu_target->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_target" class="phs_menu_menu_target"><?php echo $phs_menu->menu_target->FldCaption() ?></span></th>
<?php } ?>
<?php if ($phs_menu->menu_page->Visible) { // menu_page ?>
		<th class="<?php echo $phs_menu->menu_page->HeaderCellClass() ?>"><span id="elh_phs_menu_menu_page" class="phs_menu_menu_page"><?php echo $phs_menu->menu_page->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$phs_menu_delete->RecCnt = 0;
$i = 0;
while (!$phs_menu_delete->Recordset->EOF) {
	$phs_menu_delete->RecCnt++;
	$phs_menu_delete->RowCnt++;

	// Set row properties
	$phs_menu->ResetAttrs();
	$phs_menu->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$phs_menu_delete->LoadRowValues($phs_menu_delete->Recordset);

	// Render row
	$phs_menu_delete->RenderRow();
?>
	<tr<?php echo $phs_menu->RowAttributes() ?>>
<?php if ($phs_menu->menu_id->Visible) { // menu_id ?>
		<td<?php echo $phs_menu->menu_id->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_id" class="phs_menu_menu_id">
<span<?php echo $phs_menu->menu_id->ViewAttributes() ?>>
<?php echo $phs_menu->menu_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_pid->Visible) { // menu_pid ?>
		<td<?php echo $phs_menu->menu_pid->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_pid" class="phs_menu_menu_pid">
<span<?php echo $phs_menu->menu_pid->ViewAttributes() ?>>
<?php echo $phs_menu->menu_pid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->page_id->Visible) { // page_id ?>
		<td<?php echo $phs_menu->page_id->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_page_id" class="phs_menu_page_id">
<span<?php echo $phs_menu->page_id->ViewAttributes() ?>>
<?php echo $phs_menu->page_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->status_id->Visible) { // status_id ?>
		<td<?php echo $phs_menu->status_id->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_status_id" class="phs_menu_status_id">
<span<?php echo $phs_menu->status_id->ViewAttributes() ?>>
<?php echo $phs_menu->status_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_order->Visible) { // menu_order ?>
		<td<?php echo $phs_menu->menu_order->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_order" class="phs_menu_menu_order">
<span<?php echo $phs_menu->menu_order->ViewAttributes() ?>>
<?php echo $phs_menu->menu_order->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_name->Visible) { // menu_name ?>
		<td<?php echo $phs_menu->menu_name->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_name" class="phs_menu_menu_name">
<span<?php echo $phs_menu->menu_name->ViewAttributes() ?>>
<?php echo $phs_menu->menu_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_icon->Visible) { // menu_icon ?>
		<td<?php echo $phs_menu->menu_icon->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_icon" class="phs_menu_menu_icon">
<span<?php echo $phs_menu->menu_icon->ViewAttributes() ?>>
<?php echo $phs_menu->menu_icon->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_href->Visible) { // menu_href ?>
		<td<?php echo $phs_menu->menu_href->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_href" class="phs_menu_menu_href">
<span<?php echo $phs_menu->menu_href->ViewAttributes() ?>>
<?php echo $phs_menu->menu_href->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_target->Visible) { // menu_target ?>
		<td<?php echo $phs_menu->menu_target->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_target" class="phs_menu_menu_target">
<span<?php echo $phs_menu->menu_target->ViewAttributes() ?>>
<?php echo $phs_menu->menu_target->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($phs_menu->menu_page->Visible) { // menu_page ?>
		<td<?php echo $phs_menu->menu_page->CellAttributes() ?>>
<span id="el<?php echo $phs_menu_delete->RowCnt ?>_phs_menu_menu_page" class="phs_menu_menu_page">
<span<?php echo $phs_menu->menu_page->ViewAttributes() ?>>
<?php echo $phs_menu->menu_page->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$phs_menu_delete->Recordset->MoveNext();
}
$phs_menu_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $phs_menu_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fphs_menudelete.Init();
</script>
<?php
$phs_menu_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$phs_menu_delete->Page_Terminate();
?>
