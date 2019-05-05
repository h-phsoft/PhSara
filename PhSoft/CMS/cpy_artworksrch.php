<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_artworkinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_artwork_search = NULL; // Initialize page object first

class ccpy_artwork_search extends ccpy_artwork {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_artwork';

	// Page object name
	var $PageObjName = 'cpy_artwork_search';

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

		// Table object (cpy_artwork)
		if (!isset($GLOBALS["cpy_artwork"]) || get_class($GLOBALS["cpy_artwork"]) == "ccpy_artwork") {
			$GLOBALS["cpy_artwork"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_artwork"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_artwork', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_artworklist.php"));
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
		$this->art_year->SetVisibility();
		$this->type_id->SetVisibility();
		$this->art_title1->SetVisibility();
		$this->art_title2->SetVisibility();
		$this->art_size->SetVisibility();
		$this->art_image->SetVisibility();

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
		global $EW_EXPORT, $cpy_artwork;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_artwork);
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
					if ($pageName == "cpy_artworkview.php")
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
						$sSrchStr = "cpy_artworklist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->art_year); // art_year
		$this->BuildSearchUrl($sSrchUrl, $this->type_id); // type_id
		$this->BuildSearchUrl($sSrchUrl, $this->art_title1); // art_title1
		$this->BuildSearchUrl($sSrchUrl, $this->art_title2); // art_title2
		$this->BuildSearchUrl($sSrchUrl, $this->art_size); // art_size
		$this->BuildSearchUrl($sSrchUrl, $this->art_image); // art_image
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
		// art_year

		$this->art_year->AdvancedSearch->SearchValue = $objForm->GetValue("x_art_year");
		$this->art_year->AdvancedSearch->SearchOperator = $objForm->GetValue("z_art_year");

		// type_id
		$this->type_id->AdvancedSearch->SearchValue = $objForm->GetValue("x_type_id");
		$this->type_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_type_id");

		// art_title1
		$this->art_title1->AdvancedSearch->SearchValue = $objForm->GetValue("x_art_title1");
		$this->art_title1->AdvancedSearch->SearchOperator = $objForm->GetValue("z_art_title1");

		// art_title2
		$this->art_title2->AdvancedSearch->SearchValue = $objForm->GetValue("x_art_title2");
		$this->art_title2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_art_title2");

		// art_size
		$this->art_size->AdvancedSearch->SearchValue = $objForm->GetValue("x_art_size");
		$this->art_size->AdvancedSearch->SearchOperator = $objForm->GetValue("z_art_size");

		// art_image
		$this->art_image->AdvancedSearch->SearchValue = $objForm->GetValue("x_art_image");
		$this->art_image->AdvancedSearch->SearchOperator = $objForm->GetValue("z_art_image");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// art_id
		// art_year
		// type_id
		// art_title1
		// art_title2
		// art_size
		// art_image

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// art_year
		$this->art_year->ViewValue = $this->art_year->CurrentValue;
		$this->art_year->ViewCustomAttributes = "";

		// type_id
		if (strval($this->type_id->CurrentValue) <> "") {
			$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_arttype`";
		$sWhereWrk = "";
		$this->type_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

		// art_title1
		$this->art_title1->ViewValue = $this->art_title1->CurrentValue;
		$this->art_title1->ViewCustomAttributes = "";

		// art_title2
		$this->art_title2->ViewValue = $this->art_title2->CurrentValue;
		$this->art_title2->ViewCustomAttributes = "";

		// art_size
		$this->art_size->ViewValue = $this->art_size->CurrentValue;
		$this->art_size->ViewCustomAttributes = "";

		// art_image
		$this->art_image->UploadPath = '../../assets/img/small/';
		if (!ew_Empty($this->art_image->Upload->DbValue)) {
			$this->art_image->ImageWidth = 100;
			$this->art_image->ImageHeight = 0;
			$this->art_image->ImageAlt = $this->art_image->FldAlt();
			$this->art_image->ViewValue = $this->art_image->Upload->DbValue;
		} else {
			$this->art_image->ViewValue = "";
		}
		$this->art_image->ViewCustomAttributes = "";

			// art_year
			$this->art_year->LinkCustomAttributes = "";
			$this->art_year->HrefValue = "";
			$this->art_year->TooltipValue = "";

			// type_id
			$this->type_id->LinkCustomAttributes = "";
			$this->type_id->HrefValue = "";
			$this->type_id->TooltipValue = "";

			// art_title1
			$this->art_title1->LinkCustomAttributes = "";
			$this->art_title1->HrefValue = "";
			$this->art_title1->TooltipValue = "";

			// art_title2
			$this->art_title2->LinkCustomAttributes = "";
			$this->art_title2->HrefValue = "";
			$this->art_title2->TooltipValue = "";

			// art_size
			$this->art_size->LinkCustomAttributes = "";
			$this->art_size->HrefValue = "";
			$this->art_size->TooltipValue = "";

			// art_image
			$this->art_image->LinkCustomAttributes = "";
			$this->art_image->UploadPath = '../../assets/img/small/';
			if (!ew_Empty($this->art_image->Upload->DbValue)) {
				$this->art_image->HrefValue = ew_GetFileUploadUrl($this->art_image, $this->art_image->Upload->DbValue); // Add prefix/suffix
				$this->art_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->art_image->HrefValue = ew_FullUrl($this->art_image->HrefValue, "href");
			} else {
				$this->art_image->HrefValue = "";
			}
			$this->art_image->HrefValue2 = $this->art_image->UploadPath . $this->art_image->Upload->DbValue;
			$this->art_image->TooltipValue = "";
			if ($this->art_image->UseColorbox) {
				if (ew_Empty($this->art_image->TooltipValue))
					$this->art_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->art_image->LinkAttrs["data-rel"] = "cpy_artwork_x_art_image";
				ew_AppendClass($this->art_image->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// art_year
			$this->art_year->EditAttrs["class"] = "form-control";
			$this->art_year->EditCustomAttributes = "";
			$this->art_year->EditValue = ew_HtmlEncode($this->art_year->AdvancedSearch->SearchValue);
			$this->art_year->PlaceHolder = ew_RemoveHtml($this->art_year->FldCaption());

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `type_id`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_arttype`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->type_id->EditValue = $arwrk;

			// art_title1
			$this->art_title1->EditAttrs["class"] = "form-control";
			$this->art_title1->EditCustomAttributes = "";
			$this->art_title1->EditValue = ew_HtmlEncode($this->art_title1->AdvancedSearch->SearchValue);
			$this->art_title1->PlaceHolder = ew_RemoveHtml($this->art_title1->FldCaption());

			// art_title2
			$this->art_title2->EditAttrs["class"] = "form-control";
			$this->art_title2->EditCustomAttributes = "";
			$this->art_title2->EditValue = ew_HtmlEncode($this->art_title2->AdvancedSearch->SearchValue);
			$this->art_title2->PlaceHolder = ew_RemoveHtml($this->art_title2->FldCaption());

			// art_size
			$this->art_size->EditAttrs["class"] = "form-control";
			$this->art_size->EditCustomAttributes = "";
			$this->art_size->EditValue = ew_HtmlEncode($this->art_size->AdvancedSearch->SearchValue);
			$this->art_size->PlaceHolder = ew_RemoveHtml($this->art_size->FldCaption());

			// art_image
			$this->art_image->EditAttrs["class"] = "form-control";
			$this->art_image->EditCustomAttributes = "";
			$this->art_image->EditValue = ew_HtmlEncode($this->art_image->AdvancedSearch->SearchValue);
			$this->art_image->PlaceHolder = ew_RemoveHtml($this->art_image->FldCaption());
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
		if (!ew_CheckInteger($this->art_year->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->art_year->FldErrMsg());
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
		$this->art_year->AdvancedSearch->Load();
		$this->type_id->AdvancedSearch->Load();
		$this->art_title1->AdvancedSearch->Load();
		$this->art_title2->AdvancedSearch->Load();
		$this->art_size->AdvancedSearch->Load();
		$this->art_image->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_artworklist.php"), "", $this->TableVar, TRUE);
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
			$sSqlWrk = "SELECT `type_id` AS `LinkFld`, `type_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_arttype`";
			$sWhereWrk = "";
			$this->type_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`type_id` IN ({filter_value})', "t0" => "16", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->type_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($cpy_artwork_search)) $cpy_artwork_search = new ccpy_artwork_search();

// Page init
$cpy_artwork_search->Page_Init();

// Page main
$cpy_artwork_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_artwork_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($cpy_artwork_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fcpy_artworksearch = new ew_Form("fcpy_artworksearch", "search");
<?php } else { ?>
var CurrentForm = fcpy_artworksearch = new ew_Form("fcpy_artworksearch", "search");
<?php } ?>

// Form_CustomValidate event
fcpy_artworksearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_artworksearch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_artworksearch.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_arttype"};
fcpy_artworksearch.Lists["x_type_id"].Data = "<?php echo $cpy_artwork_search->type_id->LookupFilterQuery(FALSE, "search") ?>";

// Form object for search
// Validate function for search

fcpy_artworksearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_art_year");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_artwork->art_year->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_artwork_search->ShowPageHeader(); ?>
<?php
$cpy_artwork_search->ShowMessage();
?>
<form name="fcpy_artworksearch" id="fcpy_artworksearch" class="<?php echo $cpy_artwork_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_artwork_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_artwork_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_artwork">
<input type="hidden" name="a_search" id="a_search" value="S">
<input type="hidden" name="modal" value="<?php echo intval($cpy_artwork_search->IsModal) ?>">
<div class="ewSearchDiv"><!-- page* -->
<?php if ($cpy_artwork->art_year->Visible) { // art_year ?>
	<div id="r_art_year" class="form-group">
		<label for="x_art_year" class="<?php echo $cpy_artwork_search->LeftColumnClass ?>"><span id="elh_cpy_artwork_art_year"><?php echo $cpy_artwork->art_year->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_art_year" id="z_art_year" value="="></p>
		</label>
		<div class="<?php echo $cpy_artwork_search->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_year->CellAttributes() ?>>
			<span id="el_cpy_artwork_art_year">
<input type="text" data-table="cpy_artwork" data-field="x_art_year" name="x_art_year" id="x_art_year" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_year->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork->art_year->EditValue ?>"<?php echo $cpy_artwork->art_year->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label for="x_type_id" class="<?php echo $cpy_artwork_search->LeftColumnClass ?>"><span id="elh_cpy_artwork_type_id"><?php echo $cpy_artwork->type_id->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_type_id" id="z_type_id" value="="></p>
		</label>
		<div class="<?php echo $cpy_artwork_search->RightColumnClass ?>"><div<?php echo $cpy_artwork->type_id->CellAttributes() ?>>
			<span id="el_cpy_artwork_type_id">
<select data-table="cpy_artwork" data-field="x_type_id" data-value-separator="<?php echo $cpy_artwork->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_artwork->type_id->EditAttributes() ?>>
<?php echo $cpy_artwork->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_title1->Visible) { // art_title1 ?>
	<div id="r_art_title1" class="form-group">
		<label for="x_art_title1" class="<?php echo $cpy_artwork_search->LeftColumnClass ?>"><span id="elh_cpy_artwork_art_title1"><?php echo $cpy_artwork->art_title1->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_art_title1" id="z_art_title1" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_artwork_search->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_title1->CellAttributes() ?>>
			<span id="el_cpy_artwork_art_title1">
<input type="text" data-table="cpy_artwork" data-field="x_art_title1" name="x_art_title1" id="x_art_title1" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_title1->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork->art_title1->EditValue ?>"<?php echo $cpy_artwork->art_title1->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_title2->Visible) { // art_title2 ?>
	<div id="r_art_title2" class="form-group">
		<label for="x_art_title2" class="<?php echo $cpy_artwork_search->LeftColumnClass ?>"><span id="elh_cpy_artwork_art_title2"><?php echo $cpy_artwork->art_title2->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_art_title2" id="z_art_title2" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_artwork_search->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_title2->CellAttributes() ?>>
			<span id="el_cpy_artwork_art_title2">
<input type="text" data-table="cpy_artwork" data-field="x_art_title2" name="x_art_title2" id="x_art_title2" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_title2->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork->art_title2->EditValue ?>"<?php echo $cpy_artwork->art_title2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_size->Visible) { // art_size ?>
	<div id="r_art_size" class="form-group">
		<label for="x_art_size" class="<?php echo $cpy_artwork_search->LeftColumnClass ?>"><span id="elh_cpy_artwork_art_size"><?php echo $cpy_artwork->art_size->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_art_size" id="z_art_size" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_artwork_search->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_size->CellAttributes() ?>>
			<span id="el_cpy_artwork_art_size">
<input type="text" data-table="cpy_artwork" data-field="x_art_size" name="x_art_size" id="x_art_size" size="35" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_size->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork->art_size->EditValue ?>"<?php echo $cpy_artwork->art_size->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_image->Visible) { // art_image ?>
	<div id="r_art_image" class="form-group">
		<label class="<?php echo $cpy_artwork_search->LeftColumnClass ?>"><span id="elh_cpy_artwork_art_image"><?php echo $cpy_artwork->art_image->FldCaption() ?></span>
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_art_image" id="z_art_image" value="LIKE"></p>
		</label>
		<div class="<?php echo $cpy_artwork_search->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_image->CellAttributes() ?>>
			<span id="el_cpy_artwork_art_image">
<input type="text" data-table="cpy_artwork" data-field="x_art_image" name="x_art_image" id="x_art_image" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_image->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork->art_image->EditValue ?>"<?php echo $cpy_artwork->art_image->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_artwork_search->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_artwork_search->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_artworksearch.Init();
</script>
<?php
$cpy_artwork_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_artwork_search->Page_Terminate();
?>
