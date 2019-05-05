<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_publicationinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_publication_search = NULL; // Initialize page object first

class ccpy_publication_search extends ccpy_publication {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_publication';

	// Page object name
	var $PageObjName = 'cpy_publication_search';

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

		// Table object (cpy_publication)
		if (!isset($GLOBALS["cpy_publication"]) || get_class($GLOBALS["cpy_publication"]) == "ccpy_publication") {
			$GLOBALS["cpy_publication"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_publication"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_publication', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_publicationlist.php"));
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
		$this->bibl_id->SetVisibility();
		$this->pub_order->SetVisibility();
		$this->pub_title1->SetVisibility();
		$this->pub_title2->SetVisibility();
		$this->pub_publisher->SetVisibility();
		$this->pub_dimensions->SetVisibility();
		$this->pub_editor->SetVisibility();
		$this->pub_image->SetVisibility();
		$this->pub_text->SetVisibility();

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
		global $EW_EXPORT, $cpy_publication;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_publication);
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
					if ($pageName == "cpy_publicationview.php")
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
						$sSrchStr = "cpy_publicationlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->bibl_id); // bibl_id
		$this->BuildSearchUrl($sSrchUrl, $this->pub_order); // pub_order
		$this->BuildSearchUrl($sSrchUrl, $this->pub_title1); // pub_title1
		$this->BuildSearchUrl($sSrchUrl, $this->pub_title2); // pub_title2
		$this->BuildSearchUrl($sSrchUrl, $this->pub_publisher); // pub_publisher
		$this->BuildSearchUrl($sSrchUrl, $this->pub_dimensions); // pub_dimensions
		$this->BuildSearchUrl($sSrchUrl, $this->pub_editor); // pub_editor
		$this->BuildSearchUrl($sSrchUrl, $this->pub_image); // pub_image
		$this->BuildSearchUrl($sSrchUrl, $this->pub_text); // pub_text
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
		// bibl_id

		$this->bibl_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_bibl_id");
		$this->bibl_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_bibl_id");

		// pub_order
		$this->pub_order->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_order");
		$this->pub_order->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_order");

		// pub_title1
		$this->pub_title1->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_title1");
		$this->pub_title1->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_title1");

		// pub_title2
		$this->pub_title2->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_title2");
		$this->pub_title2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_title2");

		// pub_publisher
		$this->pub_publisher->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_publisher");
		$this->pub_publisher->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_publisher");

		// pub_dimensions
		$this->pub_dimensions->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_dimensions");
		$this->pub_dimensions->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_dimensions");

		// pub_editor
		$this->pub_editor->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_editor");
		$this->pub_editor->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_editor");

		// pub_image
		$this->pub_image->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_image");
		$this->pub_image->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_image");

		// pub_text
		$this->pub_text->AdvancedSearch->SearchValue = $objForm->GetValue("x_pub_text");
		$this->pub_text->AdvancedSearch->SearchOperator = $objForm->GetValue("z_pub_text");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// pub_id
		// bibl_id
		// pub_order
		// pub_title1
		// pub_title2
		// pub_publisher
		// pub_dimensions
		// pub_editor
		// pub_image
		// pub_text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// bibl_id
		if (strval($this->bibl_id->CurrentValue) <> "") {
			$sFilterWrk = "`bibl_id`" . ew_SearchString("=", $this->bibl_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `bibl_id`, `bibl_title1` AS `DispFld`, `bibl_title2` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_bibliography`";
		$sWhereWrk = "";
		$this->bibl_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bibl_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->bibl_id->ViewValue = $this->bibl_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bibl_id->ViewValue = $this->bibl_id->CurrentValue;
			}
		} else {
			$this->bibl_id->ViewValue = NULL;
		}
		$this->bibl_id->ViewCustomAttributes = "";

		// pub_order
		$this->pub_order->ViewValue = $this->pub_order->CurrentValue;
		$this->pub_order->ViewCustomAttributes = "";

		// pub_title1
		$this->pub_title1->ViewValue = $this->pub_title1->CurrentValue;
		$this->pub_title1->ViewCustomAttributes = "";

		// pub_title2
		$this->pub_title2->ViewValue = $this->pub_title2->CurrentValue;
		$this->pub_title2->ViewCustomAttributes = "";

		// pub_publisher
		$this->pub_publisher->ViewValue = $this->pub_publisher->CurrentValue;
		$this->pub_publisher->ViewCustomAttributes = "";

		// pub_dimensions
		$this->pub_dimensions->ViewValue = $this->pub_dimensions->CurrentValue;
		$this->pub_dimensions->ViewCustomAttributes = "";

		// pub_editor
		$this->pub_editor->ViewValue = $this->pub_editor->CurrentValue;
		$this->pub_editor->ViewCustomAttributes = "";

		// pub_image
		if (!ew_Empty($this->pub_image->Upload->DbValue)) {
			$this->pub_image->ImageWidth = 100;
			$this->pub_image->ImageHeight = 0;
			$this->pub_image->ImageAlt = $this->pub_image->FldAlt();
			$this->pub_image->ViewValue = $this->pub_image->Upload->DbValue;
		} else {
			$this->pub_image->ViewValue = "";
		}
		$this->pub_image->ViewCustomAttributes = "";

		// pub_text
		$this->pub_text->ViewValue = $this->pub_text->CurrentValue;
		$this->pub_text->ViewCustomAttributes = "";

			// bibl_id
			$this->bibl_id->LinkCustomAttributes = "";
			$this->bibl_id->HrefValue = "";
			$this->bibl_id->TooltipValue = "";

			// pub_order
			$this->pub_order->LinkCustomAttributes = "";
			$this->pub_order->HrefValue = "";
			$this->pub_order->TooltipValue = "";

			// pub_title1
			$this->pub_title1->LinkCustomAttributes = "";
			$this->pub_title1->HrefValue = "";
			$this->pub_title1->TooltipValue = "";

			// pub_title2
			$this->pub_title2->LinkCustomAttributes = "";
			$this->pub_title2->HrefValue = "";
			$this->pub_title2->TooltipValue = "";

			// pub_publisher
			$this->pub_publisher->LinkCustomAttributes = "";
			$this->pub_publisher->HrefValue = "";
			$this->pub_publisher->TooltipValue = "";

			// pub_dimensions
			$this->pub_dimensions->LinkCustomAttributes = "";
			$this->pub_dimensions->HrefValue = "";
			$this->pub_dimensions->TooltipValue = "";

			// pub_editor
			$this->pub_editor->LinkCustomAttributes = "";
			$this->pub_editor->HrefValue = "";
			$this->pub_editor->TooltipValue = "";

			// pub_image
			$this->pub_image->LinkCustomAttributes = "";
			if (!ew_Empty($this->pub_image->Upload->DbValue)) {
				$this->pub_image->HrefValue = ew_GetFileUploadUrl($this->pub_image, $this->pub_image->Upload->DbValue); // Add prefix/suffix
				$this->pub_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->pub_image->HrefValue = ew_FullUrl($this->pub_image->HrefValue, "href");
			} else {
				$this->pub_image->HrefValue = "";
			}
			$this->pub_image->HrefValue2 = $this->pub_image->UploadPath . $this->pub_image->Upload->DbValue;
			$this->pub_image->TooltipValue = "";
			if ($this->pub_image->UseColorbox) {
				if (ew_Empty($this->pub_image->TooltipValue))
					$this->pub_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->pub_image->LinkAttrs["data-rel"] = "cpy_publication_x_pub_image";
				ew_AppendClass($this->pub_image->LinkAttrs["class"], "ewLightbox");
			}

			// pub_text
			$this->pub_text->LinkCustomAttributes = "";
			$this->pub_text->HrefValue = "";
			$this->pub_text->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// bibl_id
			$this->bibl_id->EditAttrs["class"] = "form-control";
			$this->bibl_id->EditCustomAttributes = "";
			if (trim(strval($this->bibl_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`bibl_id`" . ew_SearchString("=", $this->bibl_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `bibl_id`, `bibl_title1` AS `DispFld`, `bibl_title2` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_bibliography`";
			$sWhereWrk = "";
			$this->bibl_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->bibl_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->bibl_id->EditValue = $arwrk;

			// pub_order
			$this->pub_order->EditAttrs["class"] = "form-control";
			$this->pub_order->EditCustomAttributes = "";
			$this->pub_order->EditValue = ew_HtmlEncode($this->pub_order->AdvancedSearch->SearchValue);
			$this->pub_order->PlaceHolder = ew_RemoveHtml($this->pub_order->FldCaption());

			// pub_title1
			$this->pub_title1->EditAttrs["class"] = "form-control";
			$this->pub_title1->EditCustomAttributes = "";
			$this->pub_title1->EditValue = ew_HtmlEncode($this->pub_title1->AdvancedSearch->SearchValue);
			$this->pub_title1->PlaceHolder = ew_RemoveHtml($this->pub_title1->FldCaption());

			// pub_title2
			$this->pub_title2->EditAttrs["class"] = "form-control";
			$this->pub_title2->EditCustomAttributes = "";
			$this->pub_title2->EditValue = ew_HtmlEncode($this->pub_title2->AdvancedSearch->SearchValue);
			$this->pub_title2->PlaceHolder = ew_RemoveHtml($this->pub_title2->FldCaption());

			// pub_publisher
			$this->pub_publisher->EditAttrs["class"] = "form-control";
			$this->pub_publisher->EditCustomAttributes = "";
			$this->pub_publisher->EditValue = ew_HtmlEncode($this->pub_publisher->AdvancedSearch->SearchValue);
			$this->pub_publisher->PlaceHolder = ew_RemoveHtml($this->pub_publisher->FldCaption());

			// pub_dimensions
			$this->pub_dimensions->EditAttrs["class"] = "form-control";
			$this->pub_dimensions->EditCustomAttributes = "";
			$this->pub_dimensions->EditValue = ew_HtmlEncode($this->pub_dimensions->AdvancedSearch->SearchValue);
			$this->pub_dimensions->PlaceHolder = ew_RemoveHtml($this->pub_dimensions->FldCaption());

			// pub_editor
			$this->pub_editor->EditAttrs["class"] = "form-control";
			$this->pub_editor->EditCustomAttributes = "";
			$this->pub_editor->EditValue = ew_HtmlEncode($this->pub_editor->AdvancedSearch->SearchValue);
			$this->pub_editor->PlaceHolder = ew_RemoveHtml($this->pub_editor->FldCaption());

			// pub_image
			$this->pub_image->EditAttrs["class"] = "form-control";
			$this->pub_image->EditCustomAttributes = "";
			$this->pub_image->EditValue = ew_HtmlEncode($this->pub_image->AdvancedSearch->SearchValue);
			$this->pub_image->PlaceHolder = ew_RemoveHtml($this->pub_image->FldCaption());

			// pub_text
			$this->pub_text->EditAttrs["class"] = "form-control";
			$this->pub_text->EditCustomAttributes = "";
			$this->pub_text->EditValue = ew_HtmlEncode($this->pub_text->AdvancedSearch->SearchValue);
			$this->pub_text->PlaceHolder = ew_RemoveHtml($this->pub_text->FldCaption());
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
		if (!ew_CheckInteger($this->pub_order->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->pub_order->FldErrMsg());
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
		$this->bibl_id->AdvancedSearch->Load();
		$this->pub_order->AdvancedSearch->Load();
		$this->pub_title1->AdvancedSearch->Load();
		$this->pub_title2->AdvancedSearch->Load();
		$this->pub_publisher->AdvancedSearch->Load();
		$this->pub_dimensions->AdvancedSearch->Load();
		$this->pub_editor->AdvancedSearch->Load();
		$this->pub_image->AdvancedSearch->Load();
		$this->pub_text->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_publicationlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_bibl_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `bibl_id` AS `LinkFld`, `bibl_title1` AS `DispFld`, `bibl_title2` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_bibliography`";
			$sWhereWrk = "";
			$this->bibl_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`bibl_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->bibl_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($cpy_publication_search)) $cpy_publication_search = new ccpy_publication_search();

// Page init
$cpy_publication_search->Page_Init();

// Page main
$cpy_publication_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_publication_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($cpy_publication_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fcpy_publicationsearch = new ew_Form("fcpy_publicationsearch", "search");
<?php } else { ?>
var CurrentForm = fcpy_publicationsearch = new ew_Form("fcpy_publicationsearch", "search");
<?php } ?>

// Form_CustomValidate event
fcpy_publicationsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_publicationsearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_publicationsearch.Lists["x_bibl_id"] = {"LinkField":"x_bibl_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bibl_title1","x_bibl_title2","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_bibliography"};
fcpy_publicationsearch.Lists["x_bibl_id"].Data = "<?php echo $cpy_publication_search->bibl_id->LookupFilterQuery(FALSE, "search") ?>";

// Form object for search
// Validate function for search

fcpy_publicationsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_pub_order");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_publication->pub_order->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_publication_search->ShowPageHeader(); ?>
<?php
$cpy_publication_search->ShowMessage();
?>
<form name="fcpy_publicationsearch" id="fcpy_publicationsearch" class="<?php echo $cpy_publication_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_publication_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_publication_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_publication">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($cpy_publication_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($cpy_publication->bibl_id->Visible) { // bibl_id ?>
	<div id="r_bibl_id" class="form-group">
		<label for="x_bibl_id" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_bibl_id"><?php echo $cpy_publication->bibl_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_bibl_id" id="z_bibl_id" value="="></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->bibl_id->CellAttributes() ?>>
			<span id="el_cpy_publication_bibl_id">
<select data-table="cpy_publication" data-field="x_bibl_id" data-value-separator="<?php echo $cpy_publication->bibl_id->DisplayValueSeparatorAttribute() ?>" id="x_bibl_id" name="x_bibl_id"<?php echo $cpy_publication->bibl_id->EditAttributes() ?>>
<?php echo $cpy_publication->bibl_id->SelectOptionListHtml("x_bibl_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_order->Visible) { // pub_order ?>
	<div id="r_pub_order" class="form-group">
		<label for="x_pub_order" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_order"><?php echo $cpy_publication->pub_order->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_pub_order" id="z_pub_order" value="="></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_order->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_order">
<input type="text" data-table="cpy_publication" data-field="x_pub_order" name="x_pub_order" id="x_pub_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_order->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_order->EditValue ?>"<?php echo $cpy_publication->pub_order->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_title1->Visible) { // pub_title1 ?>
	<div id="r_pub_title1" class="form-group">
		<label for="x_pub_title1" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_title1"><?php echo $cpy_publication->pub_title1->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_title1" id="z_pub_title1" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_title1->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_title1">
<input type="text" data-table="cpy_publication" data-field="x_pub_title1" name="x_pub_title1" id="x_pub_title1" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_title1->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_title1->EditValue ?>"<?php echo $cpy_publication->pub_title1->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_title2->Visible) { // pub_title2 ?>
	<div id="r_pub_title2" class="form-group">
		<label for="x_pub_title2" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_title2"><?php echo $cpy_publication->pub_title2->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_title2" id="z_pub_title2" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_title2->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_title2">
<input type="text" data-table="cpy_publication" data-field="x_pub_title2" name="x_pub_title2" id="x_pub_title2" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_title2->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_title2->EditValue ?>"<?php echo $cpy_publication->pub_title2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_publisher->Visible) { // pub_publisher ?>
	<div id="r_pub_publisher" class="form-group">
		<label for="x_pub_publisher" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_publisher"><?php echo $cpy_publication->pub_publisher->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_publisher" id="z_pub_publisher" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_publisher->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_publisher">
<input type="text" data-table="cpy_publication" data-field="x_pub_publisher" name="x_pub_publisher" id="x_pub_publisher" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_publisher->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_publisher->EditValue ?>"<?php echo $cpy_publication->pub_publisher->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_dimensions->Visible) { // pub_dimensions ?>
	<div id="r_pub_dimensions" class="form-group">
		<label for="x_pub_dimensions" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_dimensions"><?php echo $cpy_publication->pub_dimensions->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_dimensions" id="z_pub_dimensions" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_dimensions->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_dimensions">
<input type="text" data-table="cpy_publication" data-field="x_pub_dimensions" name="x_pub_dimensions" id="x_pub_dimensions" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_dimensions->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_dimensions->EditValue ?>"<?php echo $cpy_publication->pub_dimensions->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_editor->Visible) { // pub_editor ?>
	<div id="r_pub_editor" class="form-group">
		<label for="x_pub_editor" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_editor"><?php echo $cpy_publication->pub_editor->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_editor" id="z_pub_editor" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_editor->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_editor">
<input type="text" data-table="cpy_publication" data-field="x_pub_editor" name="x_pub_editor" id="x_pub_editor" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_editor->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_editor->EditValue ?>"<?php echo $cpy_publication->pub_editor->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_image->Visible) { // pub_image ?>
	<div id="r_pub_image" class="form-group">
		<label class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_image"><?php echo $cpy_publication->pub_image->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_image" id="z_pub_image" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_image->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_image">
<input type="text" data-table="cpy_publication" data-field="x_pub_image" name="x_pub_image" id="x_pub_image" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_image->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_image->EditValue ?>"<?php echo $cpy_publication->pub_image->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_text->Visible) { // pub_text ?>
	<div id="r_pub_text" class="form-group">
		<label for="x_pub_text" class="<?php echo $cpy_publication_search->LeftColumnClass ?>"><span id="elh_cpy_publication_pub_text"><?php echo $cpy_publication->pub_text->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_pub_text" id="z_pub_text" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_publication_search->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_text->CellAttributes() ?>>
			<span id="el_cpy_publication_pub_text">
<input type="text" data-table="cpy_publication" data-field="x_pub_text" name="x_pub_text" id="x_pub_text" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_text->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_text->EditValue ?>"<?php echo $cpy_publication->pub_text->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_publication_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_publication_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_publicationsearch.Init();
</script>
<?php
$cpy_publication_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_publication_search->Page_Terminate();
?>
