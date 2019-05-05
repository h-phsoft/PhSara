<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_exhibitioninfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_exhibition_search = NULL; // Initialize page object first

class ccpy_exhibition_search extends ccpy_exhibition {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_exhibition';

	// Page object name
	var $PageObjName = 'cpy_exhibition_search';

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

		// Table object (cpy_exhibition)
		if (!isset($GLOBALS["cpy_exhibition"]) || get_class($GLOBALS["cpy_exhibition"]) == "ccpy_exhibition") {
			$GLOBALS["cpy_exhibition"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_exhibition"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_exhibition', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_exhibitionlist.php"));
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
		$this->type_id->SetVisibility();
		$this->kind_id->SetVisibility();
		$this->exhib_year->SetVisibility();
		$this->exhib_title1->SetVisibility();
		$this->exhib_title2->SetVisibility();
		$this->exhib_date->SetVisibility();
		$this->exhib_from->SetVisibility();
		$this->exhib_to->SetVisibility();
		$this->exhib_web->SetVisibility();
		$this->exhib_intro->SetVisibility();
		$this->exhib_info->SetVisibility();
		$this->exhib_text->SetVisibility();
		$this->exhib_image->SetVisibility();

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
		global $EW_EXPORT, $cpy_exhibition;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_exhibition);
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
					if ($pageName == "cpy_exhibitionview.php")
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
						$sSrchStr = "cpy_exhibitionlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->type_id); // type_id
		$this->BuildSearchUrl($sSrchUrl, $this->kind_id); // kind_id
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_year); // exhib_year
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_title1); // exhib_title1
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_title2); // exhib_title2
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_date); // exhib_date
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_from); // exhib_from
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_to); // exhib_to
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_web); // exhib_web
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_intro); // exhib_intro
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_info); // exhib_info
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_text); // exhib_text
		$this->BuildSearchUrl($sSrchUrl, $this->exhib_image); // exhib_image
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
		// type_id

		$this->type_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_type_id");
		$this->type_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_type_id");

		// kind_id
		$this->kind_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_kind_id");
		$this->kind_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_kind_id");

		// exhib_year
		$this->exhib_year->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_year");
		$this->exhib_year->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_year");

		// exhib_title1
		$this->exhib_title1->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_title1");
		$this->exhib_title1->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_title1");

		// exhib_title2
		$this->exhib_title2->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_title2");
		$this->exhib_title2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_title2");

		// exhib_date
		$this->exhib_date->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_date");
		$this->exhib_date->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_date");

		// exhib_from
		$this->exhib_from->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_from");
		$this->exhib_from->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_from");

		// exhib_to
		$this->exhib_to->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_to");
		$this->exhib_to->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_to");

		// exhib_web
		$this->exhib_web->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_web");
		$this->exhib_web->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_web");

		// exhib_intro
		$this->exhib_intro->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_intro");
		$this->exhib_intro->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_intro");

		// exhib_info
		$this->exhib_info->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_info");
		$this->exhib_info->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_info");

		// exhib_text
		$this->exhib_text->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_text");
		$this->exhib_text->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_text");

		// exhib_image
		$this->exhib_image->AdvancedSearch->SearchValue = $objForm->GetValue("x_exhib_image");
		$this->exhib_image->AdvancedSearch->SearchOperator = $objForm->GetValue("z_exhib_image");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// exhib_id
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_exhibtype`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `type_order`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->type_id->EditValue = $arwrk;

			// kind_id
			$this->kind_id->EditAttrs["class"] = "form-control";
			$this->kind_id->EditCustomAttributes = "";
			if (trim(strval($this->kind_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kind_id`" . ew_SearchString("=", $this->kind_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kind_id`, `kind_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_exhibkind`";
			$sWhereWrk = "";
			$this->kind_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kind_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `kind_order`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kind_id->EditValue = $arwrk;

			// exhib_year
			$this->exhib_year->EditAttrs["class"] = "form-control";
			$this->exhib_year->EditCustomAttributes = "";
			$this->exhib_year->EditValue = ew_HtmlEncode($this->exhib_year->AdvancedSearch->SearchValue);
			$this->exhib_year->PlaceHolder = ew_RemoveHtml($this->exhib_year->FldCaption());

			// exhib_title1
			$this->exhib_title1->EditAttrs["class"] = "form-control";
			$this->exhib_title1->EditCustomAttributes = "";
			$this->exhib_title1->EditValue = ew_HtmlEncode($this->exhib_title1->AdvancedSearch->SearchValue);
			$this->exhib_title1->PlaceHolder = ew_RemoveHtml($this->exhib_title1->FldCaption());

			// exhib_title2
			$this->exhib_title2->EditAttrs["class"] = "form-control";
			$this->exhib_title2->EditCustomAttributes = "";
			$this->exhib_title2->EditValue = ew_HtmlEncode($this->exhib_title2->AdvancedSearch->SearchValue);
			$this->exhib_title2->PlaceHolder = ew_RemoveHtml($this->exhib_title2->FldCaption());

			// exhib_date
			$this->exhib_date->EditAttrs["class"] = "form-control";
			$this->exhib_date->EditCustomAttributes = "";
			$this->exhib_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->exhib_date->AdvancedSearch->SearchValue, 0), 8));
			$this->exhib_date->PlaceHolder = ew_RemoveHtml($this->exhib_date->FldCaption());

			// exhib_from
			$this->exhib_from->EditAttrs["class"] = "form-control";
			$this->exhib_from->EditCustomAttributes = "";
			$this->exhib_from->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->exhib_from->AdvancedSearch->SearchValue, 0), 8));
			$this->exhib_from->PlaceHolder = ew_RemoveHtml($this->exhib_from->FldCaption());

			// exhib_to
			$this->exhib_to->EditAttrs["class"] = "form-control";
			$this->exhib_to->EditCustomAttributes = "";
			$this->exhib_to->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->exhib_to->AdvancedSearch->SearchValue, 0), 8));
			$this->exhib_to->PlaceHolder = ew_RemoveHtml($this->exhib_to->FldCaption());

			// exhib_web
			$this->exhib_web->EditAttrs["class"] = "form-control";
			$this->exhib_web->EditCustomAttributes = "";
			$this->exhib_web->EditValue = ew_HtmlEncode($this->exhib_web->AdvancedSearch->SearchValue);
			$this->exhib_web->PlaceHolder = ew_RemoveHtml($this->exhib_web->FldCaption());

			// exhib_intro
			$this->exhib_intro->EditAttrs["class"] = "form-control";
			$this->exhib_intro->EditCustomAttributes = "";
			$this->exhib_intro->EditValue = ew_HtmlEncode($this->exhib_intro->AdvancedSearch->SearchValue);
			$this->exhib_intro->PlaceHolder = ew_RemoveHtml($this->exhib_intro->FldCaption());

			// exhib_info
			$this->exhib_info->EditAttrs["class"] = "form-control";
			$this->exhib_info->EditCustomAttributes = "";
			$this->exhib_info->EditValue = ew_HtmlEncode($this->exhib_info->AdvancedSearch->SearchValue);
			$this->exhib_info->PlaceHolder = ew_RemoveHtml($this->exhib_info->FldCaption());

			// exhib_text
			$this->exhib_text->EditAttrs["class"] = "form-control";
			$this->exhib_text->EditCustomAttributes = "";
			$this->exhib_text->EditValue = ew_HtmlEncode($this->exhib_text->AdvancedSearch->SearchValue);
			$this->exhib_text->PlaceHolder = ew_RemoveHtml($this->exhib_text->FldCaption());

			// exhib_image
			$this->exhib_image->EditAttrs["class"] = "form-control";
			$this->exhib_image->EditCustomAttributes = "";
			$this->exhib_image->EditValue = ew_HtmlEncode($this->exhib_image->AdvancedSearch->SearchValue);
			$this->exhib_image->PlaceHolder = ew_RemoveHtml($this->exhib_image->FldCaption());
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
		if (!ew_CheckInteger($this->exhib_year->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->exhib_year->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->exhib_date->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->exhib_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->exhib_from->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->exhib_from->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->exhib_to->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->exhib_to->FldErrMsg());
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
		$this->type_id->AdvancedSearch->Load();
		$this->kind_id->AdvancedSearch->Load();
		$this->exhib_year->AdvancedSearch->Load();
		$this->exhib_title1->AdvancedSearch->Load();
		$this->exhib_title2->AdvancedSearch->Load();
		$this->exhib_date->AdvancedSearch->Load();
		$this->exhib_from->AdvancedSearch->Load();
		$this->exhib_to->AdvancedSearch->Load();
		$this->exhib_web->AdvancedSearch->Load();
		$this->exhib_intro->AdvancedSearch->Load();
		$this->exhib_info->AdvancedSearch->Load();
		$this->exhib_text->AdvancedSearch->Load();
		$this->exhib_image->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_exhibitionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_type_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `type_id` AS `LinkFld`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibtype`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`type_id` IN ({filter_value})', "t0" => "16", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `type_order`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kind_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kind_id` AS `LinkFld`, `kind_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibkind`";
			$sWhereWrk = "";
			$this->kind_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kind_id` IN ({filter_value})', "t0" => "16", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kind_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `kind_order`";
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
if (!isset($cpy_exhibition_search)) $cpy_exhibition_search = new ccpy_exhibition_search();

// Page init
$cpy_exhibition_search->Page_Init();

// Page main
$cpy_exhibition_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_exhibition_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($cpy_exhibition_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fcpy_exhibitionsearch = new ew_Form("fcpy_exhibitionsearch", "search");
<?php } else { ?>
var CurrentForm = fcpy_exhibitionsearch = new ew_Form("fcpy_exhibitionsearch", "search");
<?php } ?>

// Form_CustomValidate event
fcpy_exhibitionsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_exhibitionsearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_exhibitionsearch.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibtype"};
fcpy_exhibitionsearch.Lists["x_type_id"].Data = "<?php echo $cpy_exhibition_search->type_id->LookupFilterQuery(FALSE, "search") ?>";
fcpy_exhibitionsearch.Lists["x_kind_id"] = {"LinkField":"x_kind_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kind_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibkind"};
fcpy_exhibitionsearch.Lists["x_kind_id"].Data = "<?php echo $cpy_exhibition_search->kind_id->LookupFilterQuery(FALSE, "search") ?>";

// Form object for search
// Validate function for search

fcpy_exhibitionsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_exhib_year");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_year->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_exhib_date");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_date->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_exhib_from");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_from->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_exhib_to");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_to->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_exhibition_search->ShowPageHeader(); ?>
<?php
$cpy_exhibition_search->ShowMessage();
?>
<form name="fcpy_exhibitionsearch" id="fcpy_exhibitionsearch" class="<?php echo $cpy_exhibition_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_exhibition_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_exhibition_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_exhibition">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($cpy_exhibition_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($cpy_exhibition->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label for="x_type_id" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_type_id"><?php echo $cpy_exhibition->type_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_type_id" id="z_type_id" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->type_id->CellAttributes() ?>>
			<span id="el_cpy_exhibition_type_id">
<select data-table="cpy_exhibition" data-field="x_type_id" data-value-separator="<?php echo $cpy_exhibition->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_exhibition->type_id->EditAttributes() ?>>
<?php echo $cpy_exhibition->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->kind_id->Visible) { // kind_id ?>
	<div id="r_kind_id" class="form-group">
		<label for="x_kind_id" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_kind_id"><?php echo $cpy_exhibition->kind_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_kind_id" id="z_kind_id" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->kind_id->CellAttributes() ?>>
			<span id="el_cpy_exhibition_kind_id">
<select data-table="cpy_exhibition" data-field="x_kind_id" data-value-separator="<?php echo $cpy_exhibition->kind_id->DisplayValueSeparatorAttribute() ?>" id="x_kind_id" name="x_kind_id"<?php echo $cpy_exhibition->kind_id->EditAttributes() ?>>
<?php echo $cpy_exhibition->kind_id->SelectOptionListHtml("x_kind_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_year->Visible) { // exhib_year ?>
	<div id="r_exhib_year" class="form-group">
		<label for="x_exhib_year" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_year"><?php echo $cpy_exhibition->exhib_year->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_exhib_year" id="z_exhib_year" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_year->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_year">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_year" name="x_exhib_year" id="x_exhib_year" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_year->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_year->EditValue ?>"<?php echo $cpy_exhibition->exhib_year->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title1->Visible) { // exhib_title1 ?>
	<div id="r_exhib_title1" class="form-group">
		<label for="x_exhib_title1" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_title1"><?php echo $cpy_exhibition->exhib_title1->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_exhib_title1" id="z_exhib_title1" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_title1->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_title1">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_title1" name="x_exhib_title1" id="x_exhib_title1" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_title1->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_title1->EditValue ?>"<?php echo $cpy_exhibition->exhib_title1->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title2->Visible) { // exhib_title2 ?>
	<div id="r_exhib_title2" class="form-group">
		<label for="x_exhib_title2" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_title2"><?php echo $cpy_exhibition->exhib_title2->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_exhib_title2" id="z_exhib_title2" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_title2->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_title2">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_title2" name="x_exhib_title2" id="x_exhib_title2" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_title2->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_title2->EditValue ?>"<?php echo $cpy_exhibition->exhib_title2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_date->Visible) { // exhib_date ?>
	<div id="r_exhib_date" class="form-group">
		<label for="x_exhib_date" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_date"><?php echo $cpy_exhibition->exhib_date->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_exhib_date" id="z_exhib_date" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_date->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_date">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_date" name="x_exhib_date" id="x_exhib_date" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_date->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_date->EditValue ?>"<?php echo $cpy_exhibition->exhib_date->EditAttributes() ?>>
<?php if (!$cpy_exhibition->exhib_date->ReadOnly && !$cpy_exhibition->exhib_date->Disabled && !isset($cpy_exhibition->exhib_date->EditAttrs["readonly"]) && !isset($cpy_exhibition->exhib_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_exhibitionsearch", "x_exhib_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_from->Visible) { // exhib_from ?>
	<div id="r_exhib_from" class="form-group">
		<label for="x_exhib_from" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_from"><?php echo $cpy_exhibition->exhib_from->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_exhib_from" id="z_exhib_from" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_from->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_from">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_from" name="x_exhib_from" id="x_exhib_from" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_from->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_from->EditValue ?>"<?php echo $cpy_exhibition->exhib_from->EditAttributes() ?>>
<?php if (!$cpy_exhibition->exhib_from->ReadOnly && !$cpy_exhibition->exhib_from->Disabled && !isset($cpy_exhibition->exhib_from->EditAttrs["readonly"]) && !isset($cpy_exhibition->exhib_from->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_exhibitionsearch", "x_exhib_from", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_to->Visible) { // exhib_to ?>
	<div id="r_exhib_to" class="form-group">
		<label for="x_exhib_to" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_to"><?php echo $cpy_exhibition->exhib_to->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_exhib_to" id="z_exhib_to" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_to->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_to">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_to" name="x_exhib_to" id="x_exhib_to" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_to->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_to->EditValue ?>"<?php echo $cpy_exhibition->exhib_to->EditAttributes() ?>>
<?php if (!$cpy_exhibition->exhib_to->ReadOnly && !$cpy_exhibition->exhib_to->Disabled && !isset($cpy_exhibition->exhib_to->EditAttrs["readonly"]) && !isset($cpy_exhibition->exhib_to->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_exhibitionsearch", "x_exhib_to", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_web->Visible) { // exhib_web ?>
	<div id="r_exhib_web" class="form-group">
		<label for="x_exhib_web" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_web"><?php echo $cpy_exhibition->exhib_web->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_exhib_web" id="z_exhib_web" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_web->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_web">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_web" name="x_exhib_web" id="x_exhib_web" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_web->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_web->EditValue ?>"<?php echo $cpy_exhibition->exhib_web->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_intro->Visible) { // exhib_intro ?>
	<div id="r_exhib_intro" class="form-group">
		<label for="x_exhib_intro" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_intro"><?php echo $cpy_exhibition->exhib_intro->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_exhib_intro" id="z_exhib_intro" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_intro->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_intro">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_intro" name="x_exhib_intro" id="x_exhib_intro" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_intro->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_intro->EditValue ?>"<?php echo $cpy_exhibition->exhib_intro->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_info->Visible) { // exhib_info ?>
	<div id="r_exhib_info" class="form-group">
		<label for="x_exhib_info" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_info"><?php echo $cpy_exhibition->exhib_info->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_exhib_info" id="z_exhib_info" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_info->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_info">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_info" name="x_exhib_info" id="x_exhib_info" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_info->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_info->EditValue ?>"<?php echo $cpy_exhibition->exhib_info->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_text->Visible) { // exhib_text ?>
	<div id="r_exhib_text" class="form-group">
		<label for="x_exhib_text" class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_text"><?php echo $cpy_exhibition->exhib_text->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_exhib_text" id="z_exhib_text" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_text->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_text">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_text" name="x_exhib_text" id="x_exhib_text" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_text->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_text->EditValue ?>"<?php echo $cpy_exhibition->exhib_text->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_image->Visible) { // exhib_image ?>
	<div id="r_exhib_image" class="form-group">
		<label class="<?php echo $cpy_exhibition_search->LeftColumnClass ?>"><span id="elh_cpy_exhibition_exhib_image"><?php echo $cpy_exhibition->exhib_image->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_exhib_image" id="z_exhib_image" value="="></p>
		</label>
		<div class="<?php echo $cpy_exhibition_search->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_image->CellAttributes() ?>>
			<span id="el_cpy_exhibition_exhib_image">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_image" name="x_exhib_image" id="x_exhib_image" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_image->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_image->EditValue ?>"<?php echo $cpy_exhibition->exhib_image->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_exhibition_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_exhibition_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_exhibitionsearch.Init();
</script>
<?php
$cpy_exhibition_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_exhibition_search->Page_Terminate();
?>
