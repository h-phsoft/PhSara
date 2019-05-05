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

$phs_menu_search = NULL; // Initialize page object first

class cphs_menu_search extends cphs_menu {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'phs_menu';

	// Page object name
	var $PageObjName = 'phs_menu_search';

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
			define("EW_PAGE_ID", 'search', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanSearch()) {
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
		// Create form object

		$objForm = new cFormObj();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "phs_menuview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
				}
				echo ew_ArrayToJson(array($row));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "phs_menulist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->menu_id); // menu_id
		$this->BuildSearchUrl($sSrchUrl, $this->menu_pid); // menu_pid
		$this->BuildSearchUrl($sSrchUrl, $this->page_id); // page_id
		$this->BuildSearchUrl($sSrchUrl, $this->status_id); // status_id
		$this->BuildSearchUrl($sSrchUrl, $this->menu_order); // menu_order
		$this->BuildSearchUrl($sSrchUrl, $this->menu_name); // menu_name
		$this->BuildSearchUrl($sSrchUrl, $this->menu_icon); // menu_icon
		$this->BuildSearchUrl($sSrchUrl, $this->menu_href); // menu_href
		$this->BuildSearchUrl($sSrchUrl, $this->menu_target); // menu_target
		$this->BuildSearchUrl($sSrchUrl, $this->menu_page); // menu_page
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = $Fld->FldParm();
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = $FldVal;
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = $FldVal2;
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// menu_id

		$this->menu_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_id");
		$this->menu_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_id");

		// menu_pid
		$this->menu_pid->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_pid");
		$this->menu_pid->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_pid");

		// page_id
		$this->page_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_page_id");
		$this->page_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_page_id");

		// status_id
		$this->status_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_status_id");
		$this->status_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_status_id");

		// menu_order
		$this->menu_order->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_order");
		$this->menu_order->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_order");

		// menu_name
		$this->menu_name->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_name");
		$this->menu_name->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_name");

		// menu_icon
		$this->menu_icon->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_icon");
		$this->menu_icon->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_icon");

		// menu_href
		$this->menu_href->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_href");
		$this->menu_href->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_href");

		// menu_target
		$this->menu_target->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_target");
		$this->menu_target->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_target");

		// menu_page
		$this->menu_page->AdvancedSearch->SearchValue = $objForm->GetValue("x_menu_page");
		$this->menu_page->AdvancedSearch->SearchOperator = $objForm->GetValue("z_menu_page");
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// menu_id
			$this->menu_id->EditAttrs["class"] = "form-control";
			$this->menu_id->EditCustomAttributes = "";
			$this->menu_id->EditValue = ew_HtmlEncode($this->menu_id->AdvancedSearch->SearchValue);
			$this->menu_id->PlaceHolder = ew_RemoveHtml($this->menu_id->FldCaption());

			// menu_pid
			$this->menu_pid->EditAttrs["class"] = "form-control";
			$this->menu_pid->EditCustomAttributes = "";
			if (trim(strval($this->menu_pid->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_pid->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `menu_id`, `menu_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `phs_menu`";
			$sWhereWrk = "";
			$this->menu_pid->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->menu_pid, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->menu_pid->EditValue = $arwrk;

			// page_id
			$this->page_id->EditAttrs["class"] = "form-control";
			$this->page_id->EditCustomAttributes = "";
			if (trim(strval($this->page_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`page_id`" . ew_SearchString("=", $this->page_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `page_id`, `page_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_page`";
			$sWhereWrk = "";
			$this->page_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->page_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->page_id->EditValue = $arwrk;

			// status_id
			$this->status_id->EditAttrs["class"] = "form-control";
			$this->status_id->EditCustomAttributes = "";
			if (trim(strval($this->status_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`status_id`" . ew_SearchString("=", $this->status_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `status_id`, `status_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `phs_status`";
			$sWhereWrk = "";
			$this->status_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->status_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->status_id->EditValue = $arwrk;

			// menu_order
			$this->menu_order->EditAttrs["class"] = "form-control";
			$this->menu_order->EditCustomAttributes = "";
			$this->menu_order->EditValue = ew_HtmlEncode($this->menu_order->AdvancedSearch->SearchValue);
			$this->menu_order->PlaceHolder = ew_RemoveHtml($this->menu_order->FldCaption());

			// menu_name
			$this->menu_name->EditAttrs["class"] = "form-control";
			$this->menu_name->EditCustomAttributes = "";
			$this->menu_name->EditValue = ew_HtmlEncode($this->menu_name->AdvancedSearch->SearchValue);
			$this->menu_name->PlaceHolder = ew_RemoveHtml($this->menu_name->FldCaption());

			// menu_icon
			$this->menu_icon->EditAttrs["class"] = "form-control";
			$this->menu_icon->EditCustomAttributes = "";
			$this->menu_icon->EditValue = ew_HtmlEncode($this->menu_icon->AdvancedSearch->SearchValue);
			$this->menu_icon->PlaceHolder = ew_RemoveHtml($this->menu_icon->FldCaption());

			// menu_href
			$this->menu_href->EditAttrs["class"] = "form-control";
			$this->menu_href->EditCustomAttributes = "";
			$this->menu_href->EditValue = ew_HtmlEncode($this->menu_href->AdvancedSearch->SearchValue);
			$this->menu_href->PlaceHolder = ew_RemoveHtml($this->menu_href->FldCaption());

			// menu_target
			$this->menu_target->EditAttrs["class"] = "form-control";
			$this->menu_target->EditCustomAttributes = "";
			$this->menu_target->EditValue = ew_HtmlEncode($this->menu_target->AdvancedSearch->SearchValue);
			$this->menu_target->PlaceHolder = ew_RemoveHtml($this->menu_target->FldCaption());

			// menu_page
			$this->menu_page->EditAttrs["class"] = "form-control";
			$this->menu_page->EditCustomAttributes = "";
			$this->menu_page->EditValue = ew_HtmlEncode($this->menu_page->AdvancedSearch->SearchValue);
			$this->menu_page->PlaceHolder = ew_RemoveHtml($this->menu_page->FldCaption());
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($this->menu_id->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->menu_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->menu_order->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->menu_order->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->menu_id->AdvancedSearch->Load();
		$this->menu_pid->AdvancedSearch->Load();
		$this->page_id->AdvancedSearch->Load();
		$this->status_id->AdvancedSearch->Load();
		$this->menu_order->AdvancedSearch->Load();
		$this->menu_name->AdvancedSearch->Load();
		$this->menu_icon->AdvancedSearch->Load();
		$this->menu_href->AdvancedSearch->Load();
		$this->menu_target->AdvancedSearch->Load();
		$this->menu_page->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("phs_menulist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_menu_pid":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `menu_id` AS `LinkFld`, `menu_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_menu`";
			$sWhereWrk = "";
			$this->menu_pid->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`menu_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->menu_pid, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_page_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `page_id` AS `LinkFld`, `page_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_page`";
			$sWhereWrk = "";
			$this->page_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`page_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->page_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_status_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `status_id` AS `LinkFld`, `status_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_status`";
			$sWhereWrk = "";
			$this->status_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`status_id` IN ({filter_value})', "t0" => "16", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->status_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($phs_menu_search)) $phs_menu_search = new cphs_menu_search();

// Page init
$phs_menu_search->Page_Init();

// Page main
$phs_menu_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$phs_menu_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($phs_menu_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fphs_menusearch = new ew_Form("fphs_menusearch", "search");
<?php } else { ?>
var CurrentForm = fphs_menusearch = new ew_Form("fphs_menusearch", "search");
<?php } ?>

// Form_CustomValidate event
fphs_menusearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fphs_menusearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fphs_menusearch.Lists["x_menu_pid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_menu"};
fphs_menusearch.Lists["x_menu_pid"].Data = "<?php echo $phs_menu_search->menu_pid->LookupFilterQuery(FALSE, "search") ?>";
fphs_menusearch.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fphs_menusearch.Lists["x_page_id"].Data = "<?php echo $phs_menu_search->page_id->LookupFilterQuery(FALSE, "search") ?>";
fphs_menusearch.Lists["x_status_id"] = {"LinkField":"x_status_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_status_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_status"};
fphs_menusearch.Lists["x_status_id"].Data = "<?php echo $phs_menu_search->status_id->LookupFilterQuery(FALSE, "search") ?>";

// Form object for search
// Validate function for search

fphs_menusearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_menu_id");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($phs_menu->menu_id->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_menu_order");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($phs_menu->menu_order->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $phs_menu_search->ShowPageHeader(); ?>
<?php
$phs_menu_search->ShowMessage();
?>
<form name="fphs_menusearch" id="fphs_menusearch" class="<?php echo $phs_menu_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($phs_menu_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $phs_menu_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="phs_menu">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($phs_menu_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($phs_menu->menu_id->Visible) { // menu_id ?>
	<div id="r_menu_id" class="form-group">
		<label for="x_menu_id" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_id"><?php echo $phs_menu->menu_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_menu_id" id="z_menu_id" value="="></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_id->CellAttributes() ?>>
			<span id="el_phs_menu_menu_id">
<input type="text" data-table="phs_menu" data-field="x_menu_id" name="x_menu_id" id="x_menu_id" size="30" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_id->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_id->EditValue ?>"<?php echo $phs_menu->menu_id->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_pid->Visible) { // menu_pid ?>
	<div id="r_menu_pid" class="form-group">
		<label for="x_menu_pid" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_pid"><?php echo $phs_menu->menu_pid->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_menu_pid" id="z_menu_pid" value="="></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_pid->CellAttributes() ?>>
			<span id="el_phs_menu_menu_pid">
<select data-table="phs_menu" data-field="x_menu_pid" data-value-separator="<?php echo $phs_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x_menu_pid" name="x_menu_pid"<?php echo $phs_menu->menu_pid->EditAttributes() ?>>
<?php echo $phs_menu->menu_pid->SelectOptionListHtml("x_menu_pid") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->page_id->Visible) { // page_id ?>
	<div id="r_page_id" class="form-group">
		<label for="x_page_id" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_page_id"><?php echo $phs_menu->page_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_page_id" id="z_page_id" value="="></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->page_id->CellAttributes() ?>>
			<span id="el_phs_menu_page_id">
<select data-table="phs_menu" data-field="x_page_id" data-value-separator="<?php echo $phs_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x_page_id" name="x_page_id"<?php echo $phs_menu->page_id->EditAttributes() ?>>
<?php echo $phs_menu->page_id->SelectOptionListHtml("x_page_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->status_id->Visible) { // status_id ?>
	<div id="r_status_id" class="form-group">
		<label for="x_status_id" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_status_id"><?php echo $phs_menu->status_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_status_id" id="z_status_id" value="="></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->status_id->CellAttributes() ?>>
			<span id="el_phs_menu_status_id">
<select data-table="phs_menu" data-field="x_status_id" data-value-separator="<?php echo $phs_menu->status_id->DisplayValueSeparatorAttribute() ?>" id="x_status_id" name="x_status_id"<?php echo $phs_menu->status_id->EditAttributes() ?>>
<?php echo $phs_menu->status_id->SelectOptionListHtml("x_status_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_order->Visible) { // menu_order ?>
	<div id="r_menu_order" class="form-group">
		<label for="x_menu_order" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_order"><?php echo $phs_menu->menu_order->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_menu_order" id="z_menu_order" value="="></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_order->CellAttributes() ?>>
			<span id="el_phs_menu_menu_order">
<input type="text" data-table="phs_menu" data-field="x_menu_order" name="x_menu_order" id="x_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_order->EditValue ?>"<?php echo $phs_menu->menu_order->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_name->Visible) { // menu_name ?>
	<div id="r_menu_name" class="form-group">
		<label for="x_menu_name" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_name"><?php echo $phs_menu->menu_name->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_menu_name" id="z_menu_name" value="LIKE"></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_name->CellAttributes() ?>>
			<span id="el_phs_menu_menu_name">
<input type="text" data-table="phs_menu" data-field="x_menu_name" name="x_menu_name" id="x_menu_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_name->EditValue ?>"<?php echo $phs_menu->menu_name->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_icon->Visible) { // menu_icon ?>
	<div id="r_menu_icon" class="form-group">
		<label for="x_menu_icon" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_icon"><?php echo $phs_menu->menu_icon->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_menu_icon" id="z_menu_icon" value="LIKE"></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_icon->CellAttributes() ?>>
			<span id="el_phs_menu_menu_icon">
<input type="text" data-table="phs_menu" data-field="x_menu_icon" name="x_menu_icon" id="x_menu_icon" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_icon->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_icon->EditValue ?>"<?php echo $phs_menu->menu_icon->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_href->Visible) { // menu_href ?>
	<div id="r_menu_href" class="form-group">
		<label for="x_menu_href" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_href"><?php echo $phs_menu->menu_href->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_menu_href" id="z_menu_href" value="LIKE"></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_href->CellAttributes() ?>>
			<span id="el_phs_menu_menu_href">
<input type="text" data-table="phs_menu" data-field="x_menu_href" name="x_menu_href" id="x_menu_href" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_href->EditValue ?>"<?php echo $phs_menu->menu_href->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_target->Visible) { // menu_target ?>
	<div id="r_menu_target" class="form-group">
		<label for="x_menu_target" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_target"><?php echo $phs_menu->menu_target->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_menu_target" id="z_menu_target" value="LIKE"></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_target->CellAttributes() ?>>
			<span id="el_phs_menu_menu_target">
<input type="text" data-table="phs_menu" data-field="x_menu_target" name="x_menu_target" id="x_menu_target" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_target->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_target->EditValue ?>"<?php echo $phs_menu->menu_target->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_page->Visible) { // menu_page ?>
	<div id="r_menu_page" class="form-group">
		<label for="x_menu_page" class="<?php echo $phs_menu_search->LeftColumnClass ?>"><span id="elh_phs_menu_menu_page"><?php echo $phs_menu->menu_page->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_menu_page" id="z_menu_page" value="LIKE"></p>
		</label>
		<div class="<?php echo $phs_menu_search->RightColumnClass ?>"><div<?php echo $phs_menu->menu_page->CellAttributes() ?>>
			<span id="el_phs_menu_menu_page">
<input type="text" data-table="phs_menu" data-field="x_menu_page" name="x_menu_page" id="x_menu_page" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_page->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_page->EditValue ?>"<?php echo $phs_menu->menu_page->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$phs_menu_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $phs_menu_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fphs_menusearch.Init();
</script>
<?php
$phs_menu_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$phs_menu_search->Page_Terminate();
?>
