<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_artworkinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "cpy_artwork_exhibtiongridcls.php" ?>
<?php include_once "cpy_artwork_subjectgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_artwork_add = NULL; // Initialize page object first

class ccpy_artwork_add extends ccpy_artwork {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_artwork';

	// Page object name
	var $PageObjName = 'cpy_artwork_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'cpy_artwork_exhibtion'
			if (@$_POST["grid"] == "fcpy_artwork_exhibtiongrid") {
				if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid;
				$GLOBALS["cpy_artwork_exhibtion_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'cpy_artwork_subject'
			if (@$_POST["grid"] == "fcpy_artwork_subjectgrid") {
				if (!isset($GLOBALS["cpy_artwork_subject_grid"])) $GLOBALS["cpy_artwork_subject_grid"] = new ccpy_artwork_subject_grid;
				$GLOBALS["cpy_artwork_subject_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["art_id"] != "") {
				$this->art_id->setQueryStringValue($_GET["art_id"]);
				$this->setKey("art_id", $this->art_id->CurrentValue); // Set up key
			} else {
				$this->setKey("art_id", ""); // Clear key
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

		// Set up detail parameters
		$this->SetupDetailParms();

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
					$this->Page_Terminate("cpy_artworklist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_artworklist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_artworkview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->art_image->Upload->Index = $objForm->Index;
		$this->art_image->Upload->UploadFile();
		$this->art_image->CurrentValue = $this->art_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->art_id->CurrentValue = NULL;
		$this->art_id->OldValue = $this->art_id->CurrentValue;
		$this->art_year->CurrentValue = NULL;
		$this->art_year->OldValue = $this->art_year->CurrentValue;
		$this->type_id->CurrentValue = NULL;
		$this->type_id->OldValue = $this->type_id->CurrentValue;
		$this->art_title1->CurrentValue = NULL;
		$this->art_title1->OldValue = $this->art_title1->CurrentValue;
		$this->art_title2->CurrentValue = NULL;
		$this->art_title2->OldValue = $this->art_title2->CurrentValue;
		$this->art_size->CurrentValue = NULL;
		$this->art_size->OldValue = $this->art_size->CurrentValue;
		$this->art_image->Upload->DbValue = NULL;
		$this->art_image->OldValue = $this->art_image->Upload->DbValue;
		$this->art_image->CurrentValue = NULL; // Clear file related field
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->art_year->FldIsDetailKey) {
			$this->art_year->setFormValue($objForm->GetValue("x_art_year"));
		}
		if (!$this->type_id->FldIsDetailKey) {
			$this->type_id->setFormValue($objForm->GetValue("x_type_id"));
		}
		if (!$this->art_title1->FldIsDetailKey) {
			$this->art_title1->setFormValue($objForm->GetValue("x_art_title1"));
		}
		if (!$this->art_title2->FldIsDetailKey) {
			$this->art_title2->setFormValue($objForm->GetValue("x_art_title2"));
		}
		if (!$this->art_size->FldIsDetailKey) {
			$this->art_size->setFormValue($objForm->GetValue("x_art_size"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->art_year->CurrentValue = $this->art_year->FormValue;
		$this->type_id->CurrentValue = $this->type_id->FormValue;
		$this->art_title1->CurrentValue = $this->art_title1->FormValue;
		$this->art_title2->CurrentValue = $this->art_title2->FormValue;
		$this->art_size->CurrentValue = $this->art_size->FormValue;
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
		$this->art_id->setDbValue($row['art_id']);
		$this->art_year->setDbValue($row['art_year']);
		$this->type_id->setDbValue($row['type_id']);
		$this->art_title1->setDbValue($row['art_title1']);
		$this->art_title2->setDbValue($row['art_title2']);
		$this->art_size->setDbValue($row['art_size']);
		$this->art_image->Upload->DbValue = $row['art_image'];
		$this->art_image->CurrentValue = $this->art_image->Upload->DbValue;
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['art_id'] = $this->art_id->CurrentValue;
		$row['art_year'] = $this->art_year->CurrentValue;
		$row['type_id'] = $this->type_id->CurrentValue;
		$row['art_title1'] = $this->art_title1->CurrentValue;
		$row['art_title2'] = $this->art_title2->CurrentValue;
		$row['art_size'] = $this->art_size->CurrentValue;
		$row['art_image'] = $this->art_image->Upload->DbValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->art_id->DbValue = $row['art_id'];
		$this->art_year->DbValue = $row['art_year'];
		$this->type_id->DbValue = $row['type_id'];
		$this->art_title1->DbValue = $row['art_title1'];
		$this->art_title2->DbValue = $row['art_title2'];
		$this->art_size->DbValue = $row['art_size'];
		$this->art_image->Upload->DbValue = $row['art_image'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("art_id")) <> "")
			$this->art_id->CurrentValue = $this->getKey("art_id"); // art_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// art_year
			$this->art_year->EditAttrs["class"] = "form-control";
			$this->art_year->EditCustomAttributes = "";
			$this->art_year->EditValue = ew_HtmlEncode($this->art_year->CurrentValue);
			$this->art_year->PlaceHolder = ew_RemoveHtml($this->art_year->FldCaption());

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			$this->art_title1->EditValue = ew_HtmlEncode($this->art_title1->CurrentValue);
			$this->art_title1->PlaceHolder = ew_RemoveHtml($this->art_title1->FldCaption());

			// art_title2
			$this->art_title2->EditAttrs["class"] = "form-control";
			$this->art_title2->EditCustomAttributes = "";
			$this->art_title2->EditValue = ew_HtmlEncode($this->art_title2->CurrentValue);
			$this->art_title2->PlaceHolder = ew_RemoveHtml($this->art_title2->FldCaption());

			// art_size
			$this->art_size->EditAttrs["class"] = "form-control";
			$this->art_size->EditCustomAttributes = "";
			$this->art_size->EditValue = ew_HtmlEncode($this->art_size->CurrentValue);
			$this->art_size->PlaceHolder = ew_RemoveHtml($this->art_size->FldCaption());

			// art_image
			$this->art_image->EditAttrs["class"] = "form-control";
			$this->art_image->EditCustomAttributes = "";
			$this->art_image->UploadPath = '../../assets/img/small/';
			if (!ew_Empty($this->art_image->Upload->DbValue)) {
				$this->art_image->ImageWidth = 100;
				$this->art_image->ImageHeight = 0;
				$this->art_image->ImageAlt = $this->art_image->FldAlt();
				$this->art_image->EditValue = $this->art_image->Upload->DbValue;
			} else {
				$this->art_image->EditValue = "";
			}
			if (!ew_Empty($this->art_image->CurrentValue))
				$this->art_image->Upload->FileName = $this->art_image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->art_image);

			// Add refer script
			// art_year

			$this->art_year->LinkCustomAttributes = "";
			$this->art_year->HrefValue = "";

			// type_id
			$this->type_id->LinkCustomAttributes = "";
			$this->type_id->HrefValue = "";

			// art_title1
			$this->art_title1->LinkCustomAttributes = "";
			$this->art_title1->HrefValue = "";

			// art_title2
			$this->art_title2->LinkCustomAttributes = "";
			$this->art_title2->HrefValue = "";

			// art_size
			$this->art_size->LinkCustomAttributes = "";
			$this->art_size->HrefValue = "";

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
		if (!ew_CheckInteger($this->art_year->FormValue)) {
			ew_AddMessage($gsFormError, $this->art_year->FldErrMsg());
		}
		if (!$this->type_id->FldIsDetailKey && !is_null($this->type_id->FormValue) && $this->type_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->type_id->FldCaption(), $this->type_id->ReqErrMsg));
		}
		if (!$this->art_title1->FldIsDetailKey && !is_null($this->art_title1->FormValue) && $this->art_title1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->art_title1->FldCaption(), $this->art_title1->ReqErrMsg));
		}
		if ($this->art_image->Upload->FileName == "" && !$this->art_image->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->art_image->FldCaption(), $this->art_image->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cpy_artwork_exhibtion", $DetailTblVar) && $GLOBALS["cpy_artwork_exhibtion"]->DetailAdd) {
			if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid(); // get detail page object
			$GLOBALS["cpy_artwork_exhibtion_grid"]->ValidateGridForm();
		}
		if (in_array("cpy_artwork_subject", $DetailTblVar) && $GLOBALS["cpy_artwork_subject"]->DetailAdd) {
			if (!isset($GLOBALS["cpy_artwork_subject_grid"])) $GLOBALS["cpy_artwork_subject_grid"] = new ccpy_artwork_subject_grid(); // get detail page object
			$GLOBALS["cpy_artwork_subject_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
			$this->art_image->OldUploadPath = '../../assets/img/small/';
			$this->art_image->UploadPath = $this->art_image->OldUploadPath;
		}
		$rsnew = array();

		// art_year
		$this->art_year->SetDbValueDef($rsnew, $this->art_year->CurrentValue, NULL, FALSE);

		// type_id
		$this->type_id->SetDbValueDef($rsnew, $this->type_id->CurrentValue, 0, FALSE);

		// art_title1
		$this->art_title1->SetDbValueDef($rsnew, $this->art_title1->CurrentValue, "", FALSE);

		// art_title2
		$this->art_title2->SetDbValueDef($rsnew, $this->art_title2->CurrentValue, NULL, FALSE);

		// art_size
		$this->art_size->SetDbValueDef($rsnew, $this->art_size->CurrentValue, NULL, FALSE);

		// art_image
		if ($this->art_image->Visible && !$this->art_image->Upload->KeepFile) {
			$this->art_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->art_image->Upload->FileName == "") {
				$rsnew['art_image'] = NULL;
			} else {
				$rsnew['art_image'] = $this->art_image->Upload->FileName;
			}
		}
		if ($this->art_image->Visible && !$this->art_image->Upload->KeepFile) {
			$this->art_image->UploadPath = '../../assets/img/small/';
			if (!ew_Empty($this->art_image->Upload->Value)) {
				$rsnew['art_image'] = ew_UploadFileNameEx($this->art_image->PhysicalUploadPath(), $rsnew['art_image']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->art_image->Visible && !$this->art_image->Upload->KeepFile) {
					if (!ew_Empty($this->art_image->Upload->Value)) {
						if (!$this->art_image->Upload->SaveToFile($rsnew['art_image'], TRUE)) {
							$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
							return FALSE;
						}
					}
				}
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("cpy_artwork_exhibtion", $DetailTblVar) && $GLOBALS["cpy_artwork_exhibtion"]->DetailAdd) {
				$GLOBALS["cpy_artwork_exhibtion"]->art_id->setSessionValue($this->art_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_artwork_exhibtion"); // Load user level of detail table
				$AddRow = $GLOBALS["cpy_artwork_exhibtion_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["cpy_artwork_exhibtion"]->art_id->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("cpy_artwork_subject", $DetailTblVar) && $GLOBALS["cpy_artwork_subject"]->DetailAdd) {
				$GLOBALS["cpy_artwork_subject"]->art_id->setSessionValue($this->art_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["cpy_artwork_subject_grid"])) $GLOBALS["cpy_artwork_subject_grid"] = new ccpy_artwork_subject_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_artwork_subject"); // Load user level of detail table
				$AddRow = $GLOBALS["cpy_artwork_subject_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["cpy_artwork_subject"]->art_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// art_image
		ew_CleanUploadTempPath($this->art_image, $this->art_image->Upload->Index);
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("cpy_artwork_exhibtion", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"]))
					$GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid;
				if ($GLOBALS["cpy_artwork_exhibtion_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cpy_artwork_exhibtion_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cpy_artwork_exhibtion_grid"]->CurrentMode = "add";
					$GLOBALS["cpy_artwork_exhibtion_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cpy_artwork_exhibtion_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_artwork_exhibtion_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_artwork_exhibtion_grid"]->art_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_artwork_exhibtion_grid"]->art_id->CurrentValue = $this->art_id->CurrentValue;
					$GLOBALS["cpy_artwork_exhibtion_grid"]->art_id->setSessionValue($GLOBALS["cpy_artwork_exhibtion_grid"]->art_id->CurrentValue);
				}
			}
			if (in_array("cpy_artwork_subject", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_artwork_subject_grid"]))
					$GLOBALS["cpy_artwork_subject_grid"] = new ccpy_artwork_subject_grid;
				if ($GLOBALS["cpy_artwork_subject_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cpy_artwork_subject_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cpy_artwork_subject_grid"]->CurrentMode = "add";
					$GLOBALS["cpy_artwork_subject_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cpy_artwork_subject_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_artwork_subject_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_artwork_subject_grid"]->art_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_artwork_subject_grid"]->art_id->CurrentValue = $this->art_id->CurrentValue;
					$GLOBALS["cpy_artwork_subject_grid"]->art_id->setSessionValue($GLOBALS["cpy_artwork_subject_grid"]->art_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_artworklist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($cpy_artwork_add)) $cpy_artwork_add = new ccpy_artwork_add();

// Page init
$cpy_artwork_add->Page_Init();

// Page main
$cpy_artwork_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_artwork_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_artworkadd = new ew_Form("fcpy_artworkadd", "add");

// Validate form
fcpy_artworkadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_art_year");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_artwork->art_year->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_type_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_artwork->type_id->FldCaption(), $cpy_artwork->type_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_art_title1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_artwork->art_title1->FldCaption(), $cpy_artwork->art_title1->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_art_image");
			elm = this.GetElements("fn_x" + infix + "_art_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_artwork->art_image->FldCaption(), $cpy_artwork->art_image->ReqErrMsg)) ?>");

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
fcpy_artworkadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_artworkadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_artworkadd.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_arttype"};
fcpy_artworkadd.Lists["x_type_id"].Data = "<?php echo $cpy_artwork_add->type_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_artwork_add->ShowPageHeader(); ?>
<?php
$cpy_artwork_add->ShowMessage();
?>
<form name="fcpy_artworkadd" id="fcpy_artworkadd" class="<?php echo $cpy_artwork_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_artwork_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_artwork_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_artwork">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_artwork_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_artwork->art_year->Visible) { // art_year ?>
	<div id="r_art_year" class="form-group">
		<label id="elh_cpy_artwork_art_year" for="x_art_year" class="<?php echo $cpy_artwork_add->LeftColumnClass ?>"><?php echo $cpy_artwork->art_year->FldCaption() ?></label>
		<div class="<?php echo $cpy_artwork_add->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_year->CellAttributes() ?>>
<span id="el_cpy_artwork_art_year">
<input type="text" data-table="cpy_artwork" data-field="x_art_year" name="x_art_year" id="x_art_year" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_year->getPlaceHolder()) ?>" value="<?php echo $cpy_artwork->art_year->EditValue ?>"<?php echo $cpy_artwork->art_year->EditAttributes() ?>>
</span>
<?php echo $cpy_artwork->art_year->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label id="elh_cpy_artwork_type_id" for="x_type_id" class="<?php echo $cpy_artwork_add->LeftColumnClass ?>"><?php echo $cpy_artwork->type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_artwork_add->RightColumnClass ?>"><div<?php echo $cpy_artwork->type_id->CellAttributes() ?>>
<span id="el_cpy_artwork_type_id">
<select data-table="cpy_artwork" data-field="x_type_id" data-value-separator="<?php echo $cpy_artwork->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_artwork->type_id->EditAttributes() ?>>
<?php echo $cpy_artwork->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
<?php echo $cpy_artwork->type_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_title1->Visible) { // art_title1 ?>
	<div id="r_art_title1" class="form-group">
		<label id="elh_cpy_artwork_art_title1" for="x_art_title1" class="<?php echo $cpy_artwork_add->LeftColumnClass ?>"><?php echo $cpy_artwork->art_title1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_artwork_add->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_title1->CellAttributes() ?>>
<span id="el_cpy_artwork_art_title1">
<textarea data-table="cpy_artwork" data-field="x_art_title1" name="x_art_title1" id="x_art_title1" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_title1->getPlaceHolder()) ?>"<?php echo $cpy_artwork->art_title1->EditAttributes() ?>><?php echo $cpy_artwork->art_title1->EditValue ?></textarea>
</span>
<?php echo $cpy_artwork->art_title1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_title2->Visible) { // art_title2 ?>
	<div id="r_art_title2" class="form-group">
		<label id="elh_cpy_artwork_art_title2" for="x_art_title2" class="<?php echo $cpy_artwork_add->LeftColumnClass ?>"><?php echo $cpy_artwork->art_title2->FldCaption() ?></label>
		<div class="<?php echo $cpy_artwork_add->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_title2->CellAttributes() ?>>
<span id="el_cpy_artwork_art_title2">
<textarea data-table="cpy_artwork" data-field="x_art_title2" name="x_art_title2" id="x_art_title2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_title2->getPlaceHolder()) ?>"<?php echo $cpy_artwork->art_title2->EditAttributes() ?>><?php echo $cpy_artwork->art_title2->EditValue ?></textarea>
</span>
<?php echo $cpy_artwork->art_title2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_size->Visible) { // art_size ?>
	<div id="r_art_size" class="form-group">
		<label id="elh_cpy_artwork_art_size" for="x_art_size" class="<?php echo $cpy_artwork_add->LeftColumnClass ?>"><?php echo $cpy_artwork->art_size->FldCaption() ?></label>
		<div class="<?php echo $cpy_artwork_add->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_size->CellAttributes() ?>>
<span id="el_cpy_artwork_art_size">
<textarea data-table="cpy_artwork" data-field="x_art_size" name="x_art_size" id="x_art_size" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_artwork->art_size->getPlaceHolder()) ?>"<?php echo $cpy_artwork->art_size->EditAttributes() ?>><?php echo $cpy_artwork->art_size->EditValue ?></textarea>
</span>
<?php echo $cpy_artwork->art_size->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_artwork->art_image->Visible) { // art_image ?>
	<div id="r_art_image" class="form-group">
		<label id="elh_cpy_artwork_art_image" class="<?php echo $cpy_artwork_add->LeftColumnClass ?>"><?php echo $cpy_artwork->art_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_artwork_add->RightColumnClass ?>"><div<?php echo $cpy_artwork->art_image->CellAttributes() ?>>
<span id="el_cpy_artwork_art_image">
<div id="fd_x_art_image">
<span title="<?php echo $cpy_artwork->art_image->FldTitle() ? $cpy_artwork->art_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_artwork->art_image->ReadOnly || $cpy_artwork->art_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_artwork" data-field="x_art_image" name="x_art_image" id="x_art_image"<?php echo $cpy_artwork->art_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_art_image" id= "fn_x_art_image" value="<?php echo $cpy_artwork->art_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_art_image" id= "fa_x_art_image" value="0">
<input type="hidden" name="fs_x_art_image" id= "fs_x_art_image" value="1000">
<input type="hidden" name="fx_x_art_image" id= "fx_x_art_image" value="<?php echo $cpy_artwork->art_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_art_image" id= "fm_x_art_image" value="<?php echo $cpy_artwork->art_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_art_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_artwork->art_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("cpy_artwork_exhibtion", explode(",", $cpy_artwork->getCurrentDetailTable())) && $cpy_artwork_exhibtion->DetailAdd) {
?>
<?php if ($cpy_artwork->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_artwork_exhibtion", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_artwork_exhibtiongrid.php" ?>
<?php } ?>
<?php
	if (in_array("cpy_artwork_subject", explode(",", $cpy_artwork->getCurrentDetailTable())) && $cpy_artwork_subject->DetailAdd) {
?>
<?php if ($cpy_artwork->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_artwork_subject", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_artwork_subjectgrid.php" ?>
<?php } ?>
<?php if (!$cpy_artwork_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_artwork_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_artwork_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_artworkadd.Init();
</script>
<?php
$cpy_artwork_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_artwork_add->Page_Terminate();
?>
