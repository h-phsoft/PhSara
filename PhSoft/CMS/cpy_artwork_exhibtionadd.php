<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_artwork_exhibtioninfo.php" ?>
<?php include_once "cpy_artworkinfo.php" ?>
<?php include_once "cpy_exhibitioninfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_artwork_exhibtion_add = NULL; // Initialize page object first

class ccpy_artwork_exhibtion_add extends ccpy_artwork_exhibtion {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_artwork_exhibtion';

	// Page object name
	var $PageObjName = 'cpy_artwork_exhibtion_add';

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

		// Table object (cpy_artwork_exhibtion)
		if (!isset($GLOBALS["cpy_artwork_exhibtion"]) || get_class($GLOBALS["cpy_artwork_exhibtion"]) == "ccpy_artwork_exhibtion") {
			$GLOBALS["cpy_artwork_exhibtion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_artwork_exhibtion"];
		}

		// Table object (cpy_artwork)
		if (!isset($GLOBALS['cpy_artwork'])) $GLOBALS['cpy_artwork'] = new ccpy_artwork();

		// Table object (cpy_exhibition)
		if (!isset($GLOBALS['cpy_exhibition'])) $GLOBALS['cpy_exhibition'] = new ccpy_exhibition();

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_artwork_exhibtion', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("cpy_artwork_exhibtionlist.php"));
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
		$this->art_id->SetVisibility();
		$this->exhib_order->SetVisibility();
		$this->exhib_id->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $cpy_artwork_exhibtion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_artwork_exhibtion);
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
					if ($pageName == "cpy_artwork_exhibtionview.php")
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["artexh_id"] != "") {
				$this->artexh_id->setQueryStringValue($_GET["artexh_id"]);
				$this->setKey("artexh_id", $this->artexh_id->CurrentValue); // Set up key
			} else {
				$this->setKey("artexh_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cpy_artwork_exhibtionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_artwork_exhibtionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_artwork_exhibtionview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->artexh_id->CurrentValue = NULL;
		$this->artexh_id->OldValue = $this->artexh_id->CurrentValue;
		$this->art_id->CurrentValue = NULL;
		$this->art_id->OldValue = $this->art_id->CurrentValue;
		$this->exhib_order->CurrentValue = 0;
		$this->exhib_id->CurrentValue = NULL;
		$this->exhib_id->OldValue = $this->exhib_id->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->art_id->FldIsDetailKey) {
			$this->art_id->setFormValue($objForm->GetValue("x_art_id"));
		}
		if (!$this->exhib_order->FldIsDetailKey) {
			$this->exhib_order->setFormValue($objForm->GetValue("x_exhib_order"));
		}
		if (!$this->exhib_id->FldIsDetailKey) {
			$this->exhib_id->setFormValue($objForm->GetValue("x_exhib_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->art_id->CurrentValue = $this->art_id->FormValue;
		$this->exhib_order->CurrentValue = $this->exhib_order->FormValue;
		$this->exhib_id->CurrentValue = $this->exhib_id->FormValue;
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
		$this->artexh_id->setDbValue($row['artexh_id']);
		$this->art_id->setDbValue($row['art_id']);
		$this->exhib_order->setDbValue($row['exhib_order']);
		$this->exhib_id->setDbValue($row['exhib_id']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['artexh_id'] = $this->artexh_id->CurrentValue;
		$row['art_id'] = $this->art_id->CurrentValue;
		$row['exhib_order'] = $this->exhib_order->CurrentValue;
		$row['exhib_id'] = $this->exhib_id->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->artexh_id->DbValue = $row['artexh_id'];
		$this->art_id->DbValue = $row['art_id'];
		$this->exhib_order->DbValue = $row['exhib_order'];
		$this->exhib_id->DbValue = $row['exhib_id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("artexh_id")) <> "")
			$this->artexh_id->CurrentValue = $this->getKey("artexh_id"); // artexh_id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// artexh_id
		// art_id
		// exhib_order
		// exhib_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// art_id
		if (strval($this->art_id->CurrentValue) <> "") {
			$sFilterWrk = "`art_id`" . ew_SearchString("=", $this->art_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `art_id`, `art_title1` AS `DispFld`, `art_title2` AS `Disp2Fld`, `art_year` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_artwork`";
		$sWhereWrk = "";
		$this->art_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->art_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->art_id->ViewValue = $this->art_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->art_id->ViewValue = $this->art_id->CurrentValue;
			}
		} else {
			$this->art_id->ViewValue = NULL;
		}
		$this->art_id->ViewCustomAttributes = "";

		// exhib_order
		$this->exhib_order->ViewValue = $this->exhib_order->CurrentValue;
		$this->exhib_order->ViewCustomAttributes = "";

		// exhib_id
		if (strval($this->exhib_id->CurrentValue) <> "") {
			$sFilterWrk = "`exhib_id`" . ew_SearchString("=", $this->exhib_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `exhib_id`, `exhib_title1` AS `DispFld`, `exhib_title2` AS `Disp2Fld`, `exhib_year` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibition`";
		$sWhereWrk = "";
		$this->exhib_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->exhib_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->exhib_id->ViewValue = $this->exhib_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->exhib_id->ViewValue = $this->exhib_id->CurrentValue;
			}
		} else {
			$this->exhib_id->ViewValue = NULL;
		}
		$this->exhib_id->ViewCustomAttributes = "";

			// art_id
			$this->art_id->LinkCustomAttributes = "";
			$this->art_id->HrefValue = "";
			$this->art_id->TooltipValue = "";

			// exhib_order
			$this->exhib_order->LinkCustomAttributes = "";
			$this->exhib_order->HrefValue = "";
			$this->exhib_order->TooltipValue = "";

			// exhib_id
			$this->exhib_id->LinkCustomAttributes = "";
			$this->exhib_id->HrefValue = "";
			$this->exhib_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// art_id
			$this->art_id->EditAttrs["class"] = "form-control";
			$this->art_id->EditCustomAttributes = "";
			if ($this->art_id->getSessionValue() <> "") {
				$this->art_id->CurrentValue = $this->art_id->getSessionValue();
			if (strval($this->art_id->CurrentValue) <> "") {
				$sFilterWrk = "`art_id`" . ew_SearchString("=", $this->art_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `art_id`, `art_title1` AS `DispFld`, `art_title2` AS `Disp2Fld`, `art_year` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_artwork`";
			$sWhereWrk = "";
			$this->art_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->art_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = $rswrk->fields('Disp2Fld');
					$arwrk[3] = $rswrk->fields('Disp3Fld');
					$this->art_id->ViewValue = $this->art_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->art_id->ViewValue = $this->art_id->CurrentValue;
				}
			} else {
				$this->art_id->ViewValue = NULL;
			}
			$this->art_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->art_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`art_id`" . ew_SearchString("=", $this->art_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `art_id`, `art_title1` AS `DispFld`, `art_title2` AS `Disp2Fld`, `art_year` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_artwork`";
			$sWhereWrk = "";
			$this->art_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->art_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->art_id->EditValue = $arwrk;
			}

			// exhib_order
			$this->exhib_order->EditAttrs["class"] = "form-control";
			$this->exhib_order->EditCustomAttributes = "";
			$this->exhib_order->EditValue = ew_HtmlEncode($this->exhib_order->CurrentValue);
			$this->exhib_order->PlaceHolder = ew_RemoveHtml($this->exhib_order->FldCaption());

			// exhib_id
			$this->exhib_id->EditAttrs["class"] = "form-control";
			$this->exhib_id->EditCustomAttributes = "";
			if ($this->exhib_id->getSessionValue() <> "") {
				$this->exhib_id->CurrentValue = $this->exhib_id->getSessionValue();
			if (strval($this->exhib_id->CurrentValue) <> "") {
				$sFilterWrk = "`exhib_id`" . ew_SearchString("=", $this->exhib_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `exhib_id`, `exhib_title1` AS `DispFld`, `exhib_title2` AS `Disp2Fld`, `exhib_year` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibition`";
			$sWhereWrk = "";
			$this->exhib_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->exhib_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = $rswrk->fields('Disp2Fld');
					$arwrk[3] = $rswrk->fields('Disp3Fld');
					$this->exhib_id->ViewValue = $this->exhib_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->exhib_id->ViewValue = $this->exhib_id->CurrentValue;
				}
			} else {
				$this->exhib_id->ViewValue = NULL;
			}
			$this->exhib_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->exhib_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`exhib_id`" . ew_SearchString("=", $this->exhib_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `exhib_id`, `exhib_title1` AS `DispFld`, `exhib_title2` AS `Disp2Fld`, `exhib_year` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cpy_exhibition`";
			$sWhereWrk = "";
			$this->exhib_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->exhib_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->exhib_id->EditValue = $arwrk;
			}

			// Add refer script
			// art_id

			$this->art_id->LinkCustomAttributes = "";
			$this->art_id->HrefValue = "";

			// exhib_order
			$this->exhib_order->LinkCustomAttributes = "";
			$this->exhib_order->HrefValue = "";

			// exhib_id
			$this->exhib_id->LinkCustomAttributes = "";
			$this->exhib_id->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->art_id->FldIsDetailKey && !is_null($this->art_id->FormValue) && $this->art_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->art_id->FldCaption(), $this->art_id->ReqErrMsg));
		}
		if (!$this->exhib_order->FldIsDetailKey && !is_null($this->exhib_order->FormValue) && $this->exhib_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->exhib_order->FldCaption(), $this->exhib_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->exhib_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->exhib_order->FldErrMsg());
		}
		if (!$this->exhib_id->FldIsDetailKey && !is_null($this->exhib_id->FormValue) && $this->exhib_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->exhib_id->FldCaption(), $this->exhib_id->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// art_id
		$this->art_id->SetDbValueDef($rsnew, $this->art_id->CurrentValue, 0, FALSE);

		// exhib_order
		$this->exhib_order->SetDbValueDef($rsnew, $this->exhib_order->CurrentValue, 0, strval($this->exhib_order->CurrentValue) == "");

		// exhib_id
		$this->exhib_id->SetDbValueDef($rsnew, $this->exhib_id->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cpy_artwork") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_art_id"] <> "") {
					$GLOBALS["cpy_artwork"]->art_id->setQueryStringValue($_GET["fk_art_id"]);
					$this->art_id->setQueryStringValue($GLOBALS["cpy_artwork"]->art_id->QueryStringValue);
					$this->art_id->setSessionValue($this->art_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cpy_artwork"]->art_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "cpy_exhibition") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_exhib_id"] <> "") {
					$GLOBALS["cpy_exhibition"]->exhib_id->setQueryStringValue($_GET["fk_exhib_id"]);
					$this->exhib_id->setQueryStringValue($GLOBALS["cpy_exhibition"]->exhib_id->QueryStringValue);
					$this->exhib_id->setSessionValue($this->exhib_id->QueryStringValue);
					if (!is_numeric($GLOBALS["cpy_exhibition"]->exhib_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "cpy_artwork") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_art_id"] <> "") {
					$GLOBALS["cpy_artwork"]->art_id->setFormValue($_POST["fk_art_id"]);
					$this->art_id->setFormValue($GLOBALS["cpy_artwork"]->art_id->FormValue);
					$this->art_id->setSessionValue($this->art_id->FormValue);
					if (!is_numeric($GLOBALS["cpy_artwork"]->art_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "cpy_exhibition") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_exhib_id"] <> "") {
					$GLOBALS["cpy_exhibition"]->exhib_id->setFormValue($_POST["fk_exhib_id"]);
					$this->exhib_id->setFormValue($GLOBALS["cpy_exhibition"]->exhib_id->FormValue);
					$this->exhib_id->setSessionValue($this->exhib_id->FormValue);
					if (!is_numeric($GLOBALS["cpy_exhibition"]->exhib_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cpy_artwork") {
				if ($this->art_id->CurrentValue == "") $this->art_id->setSessionValue("");
			}
			if ($sMasterTblVar <> "cpy_exhibition") {
				if ($this->exhib_id->CurrentValue == "") $this->exhib_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_artwork_exhibtionlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_art_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `art_id` AS `LinkFld`, `art_title1` AS `DispFld`, `art_title2` AS `Disp2Fld`, `art_year` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_artwork`";
			$sWhereWrk = "";
			$this->art_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`art_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->art_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_exhib_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `exhib_id` AS `LinkFld`, `exhib_title1` AS `DispFld`, `exhib_title2` AS `Disp2Fld`, `exhib_year` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cpy_exhibition`";
			$sWhereWrk = "";
			$this->exhib_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`exhib_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->exhib_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($cpy_artwork_exhibtion_add)) $cpy_artwork_exhibtion_add = new ccpy_artwork_exhibtion_add();

// Page init
$cpy_artwork_exhibtion_add->Page_Init();

// Page main
$cpy_artwork_exhibtion_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_artwork_exhibtion_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_artwork_exhibtionadd = new ew_Form("fcpy_artwork_exhibtionadd", "add");

// Validate form
fcpy_artwork_exhibtionadd.Validate = function() {
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
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fcpy_artwork_exhibtionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_artwork_exhibtionadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_artwork_exhibtionadd.Lists["x_art_id"] = {"LinkField":"x_art_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_art_title1","x_art_title2","x_art_year",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_artwork"};
fcpy_artwork_exhibtionadd.Lists["x_art_id"].Data = "<?php echo $cpy_artwork_exhibtion_add->art_id->LookupFilterQuery(FALSE, "add") ?>";
fcpy_artwork_exhibtionadd.Lists["x_exhib_id"] = {"LinkField":"x_exhib_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_exhib_title1","x_exhib_title2","x_exhib_year",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibition"};
fcpy_artwork_exhibtionadd.Lists["x_exhib_id"].Data = "<?php echo $cpy_artwork_exhibtion_add->exhib_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_artwork_exhibtion_add->ShowPageHeader(); ?>
<?php
$cpy_artwork_exhibtion_add->ShowMessage();
?>
<form name="fcpy_artwork_exhibtionadd" id="fcpy_artwork_exhibtionadd" class="<?php echo $cpy_artwork_exhibtion_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_artwork_exhibtion_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_artwork_exhibtion_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_artwork_exhibtion">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_artwork_exhibtion_add->IsModal) ?>">
<?php if ($cpy_artwork_exhibtion->getCurrentMasterTable() == "cpy_artwork") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_artwork">
<input type="hidden" name="fk_art_id" value="<?php echo $cpy_artwork_exhibtion->art_id->getSessionValue() ?>">
<?php } ?>
<?php if ($cpy_artwork_exhibtion->getCurrentMasterTable() == "cpy_exhibition") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cpy_exhibition">
<input type="hidden" name="fk_exhib_id" value="<?php echo $cpy_artwork_exhibtion->exhib_id->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_artwork_exhibtion->art_id->Visible) { // art_id ?>
	<div id="r_art_id" class="form-group">
		<label id="elh_cpy_artwork_exhibtion_art_id" for="x_art_id" class="<?php echo $cpy_artwork_exhibtion_add->LeftColumnClass ?>"><?php echo $cpy_artwork_exhibtion->art_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_artwork_exhibtion_add->RightColumnClass ?>"><div<?php echo $cpy_artwork_exhibtion->art_id->CellAttributes() ?>>
<?php if ($cpy_artwork_exhibtion->art_id->getSessionValue() <> "") { ?>
<span id="el_cpy_artwork_exhibtion_art_id">
<span<?php echo $cpy_artwork_exhibtion->art_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->art_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_art_id" name="x_art_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->art_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cpy_artwork_exhibtion_art_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_art_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->art_id->DisplayValueSeparatorAttribute() ?>" id="x_art_id" name="x_art_id"<?php echo $cpy_artwork_exhibtion->art_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->art_id->SelectOptionListHtml("x_art_id") ?>
</select>
</span>
<?php } ?>
<?php echo $cpy_artwork_exhibtion->art_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->exhib_order->Visible) { // exhib_order ?>
	<div id="r_exhib_order" class="form-group">
		<label id="elh_cpy_artwork_exhibtion_exhib_order" for="x_exhib_order" class="<?php echo $cpy_artwork_exhibtion_add->LeftColumnClass ?>"><?php echo $cpy_artwork_exhibtion->exhib_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_artwork_exhibtion_add->RightColumnClass ?>"><div<?php echo $cpy_artwork_exhibtion->exhib_order->CellAttributes() ?>>
<span id="el_cpy_artwork_exhibtion_exhib_order">
<input type="text" data-table="cpy_artwork_exhibtion" data-field="x_exhib_order" name="x_exhib_order" id="x_exhib_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_order->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork_exhibtion->exhib_order->EditValue ?>"<?php echo $cpy_artwork_exhibtion->exhib_order->EditAttributes() ?>>
</span>
<?php echo $cpy_artwork_exhibtion->exhib_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork_exhibtion->exhib_id->Visible) { // exhib_id ?>
	<div id="r_exhib_id" class="form-group">
		<label id="elh_cpy_artwork_exhibtion_exhib_id" for="x_exhib_id" class="<?php echo $cpy_artwork_exhibtion_add->LeftColumnClass ?>"><?php echo $cpy_artwork_exhibtion->exhib_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_artwork_exhibtion_add->RightColumnClass ?>"><div<?php echo $cpy_artwork_exhibtion->exhib_id->CellAttributes() ?>>
<?php if ($cpy_artwork_exhibtion->exhib_id->getSessionValue() <> "") { ?>
<span id="el_cpy_artwork_exhibtion_exhib_id">
<span<?php echo $cpy_artwork_exhibtion->exhib_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cpy_artwork_exhibtion->exhib_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_exhib_id" name="x_exhib_id" value="<?php echo ew_HtmlEncode($cpy_artwork_exhibtion->exhib_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cpy_artwork_exhibtion_exhib_id">
<select data-table="cpy_artwork_exhibtion" data-field="x_exhib_id" data-value-separator="<?php echo $cpy_artwork_exhibtion->exhib_id->DisplayValueSeparatorAttribute() ?>" id="x_exhib_id" name="x_exhib_id"<?php echo $cpy_artwork_exhibtion->exhib_id->EditAttributes() ?>>
<?php echo $cpy_artwork_exhibtion->exhib_id->SelectOptionListHtml("x_exhib_id") ?>
</select>
</span>
<?php } ?>
<?php echo $cpy_artwork_exhibtion->exhib_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_artwork_exhibtion_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_artwork_exhibtion_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_artwork_exhibtion_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_artwork_exhibtionadd.Init();
</script>
<?php
$cpy_artwork_exhibtion_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_artwork_exhibtion_add->Page_Terminate();
?>
