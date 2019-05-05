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

$cpy_publication_add = NULL; // Initialize page object first

class ccpy_publication_add extends ccpy_publication {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_publication';

	// Page object name
	var $PageObjName = 'cpy_publication_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
			if (@$_GET["pub_id"] != "") {
				$this->pub_id->setQueryStringValue($_GET["pub_id"]);
				$this->setKey("pub_id", $this->pub_id->CurrentValue); // Set up key
			} else {
				$this->setKey("pub_id", ""); // Clear key
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
					$this->Page_Terminate("cpy_publicationlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_publicationlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_publicationview.php")
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
		$this->pub_image->Upload->Index = $objForm->Index;
		$this->pub_image->Upload->UploadFile();
		$this->pub_image->CurrentValue = $this->pub_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->pub_id->CurrentValue = NULL;
		$this->pub_id->OldValue = $this->pub_id->CurrentValue;
		$this->bibl_id->CurrentValue = NULL;
		$this->bibl_id->OldValue = $this->bibl_id->CurrentValue;
		$this->pub_order->CurrentValue = 0;
		$this->pub_title1->CurrentValue = NULL;
		$this->pub_title1->OldValue = $this->pub_title1->CurrentValue;
		$this->pub_title2->CurrentValue = NULL;
		$this->pub_title2->OldValue = $this->pub_title2->CurrentValue;
		$this->pub_publisher->CurrentValue = NULL;
		$this->pub_publisher->OldValue = $this->pub_publisher->CurrentValue;
		$this->pub_dimensions->CurrentValue = NULL;
		$this->pub_dimensions->OldValue = $this->pub_dimensions->CurrentValue;
		$this->pub_editor->CurrentValue = NULL;
		$this->pub_editor->OldValue = $this->pub_editor->CurrentValue;
		$this->pub_image->Upload->DbValue = NULL;
		$this->pub_image->OldValue = $this->pub_image->Upload->DbValue;
		$this->pub_image->CurrentValue = NULL; // Clear file related field
		$this->pub_text->CurrentValue = NULL;
		$this->pub_text->OldValue = $this->pub_text->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->bibl_id->FldIsDetailKey) {
			$this->bibl_id->setFormValue($objForm->GetValue("x_bibl_id"));
		}
		if (!$this->pub_order->FldIsDetailKey) {
			$this->pub_order->setFormValue($objForm->GetValue("x_pub_order"));
		}
		if (!$this->pub_title1->FldIsDetailKey) {
			$this->pub_title1->setFormValue($objForm->GetValue("x_pub_title1"));
		}
		if (!$this->pub_title2->FldIsDetailKey) {
			$this->pub_title2->setFormValue($objForm->GetValue("x_pub_title2"));
		}
		if (!$this->pub_publisher->FldIsDetailKey) {
			$this->pub_publisher->setFormValue($objForm->GetValue("x_pub_publisher"));
		}
		if (!$this->pub_dimensions->FldIsDetailKey) {
			$this->pub_dimensions->setFormValue($objForm->GetValue("x_pub_dimensions"));
		}
		if (!$this->pub_editor->FldIsDetailKey) {
			$this->pub_editor->setFormValue($objForm->GetValue("x_pub_editor"));
		}
		if (!$this->pub_text->FldIsDetailKey) {
			$this->pub_text->setFormValue($objForm->GetValue("x_pub_text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->bibl_id->CurrentValue = $this->bibl_id->FormValue;
		$this->pub_order->CurrentValue = $this->pub_order->FormValue;
		$this->pub_title1->CurrentValue = $this->pub_title1->FormValue;
		$this->pub_title2->CurrentValue = $this->pub_title2->FormValue;
		$this->pub_publisher->CurrentValue = $this->pub_publisher->FormValue;
		$this->pub_dimensions->CurrentValue = $this->pub_dimensions->FormValue;
		$this->pub_editor->CurrentValue = $this->pub_editor->FormValue;
		$this->pub_text->CurrentValue = $this->pub_text->FormValue;
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
		$this->pub_id->setDbValue($row['pub_id']);
		$this->bibl_id->setDbValue($row['bibl_id']);
		$this->pub_order->setDbValue($row['pub_order']);
		$this->pub_title1->setDbValue($row['pub_title1']);
		$this->pub_title2->setDbValue($row['pub_title2']);
		$this->pub_publisher->setDbValue($row['pub_publisher']);
		$this->pub_dimensions->setDbValue($row['pub_dimensions']);
		$this->pub_editor->setDbValue($row['pub_editor']);
		$this->pub_image->Upload->DbValue = $row['pub_image'];
		$this->pub_image->CurrentValue = $this->pub_image->Upload->DbValue;
		$this->pub_text->setDbValue($row['pub_text']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['pub_id'] = $this->pub_id->CurrentValue;
		$row['bibl_id'] = $this->bibl_id->CurrentValue;
		$row['pub_order'] = $this->pub_order->CurrentValue;
		$row['pub_title1'] = $this->pub_title1->CurrentValue;
		$row['pub_title2'] = $this->pub_title2->CurrentValue;
		$row['pub_publisher'] = $this->pub_publisher->CurrentValue;
		$row['pub_dimensions'] = $this->pub_dimensions->CurrentValue;
		$row['pub_editor'] = $this->pub_editor->CurrentValue;
		$row['pub_image'] = $this->pub_image->Upload->DbValue;
		$row['pub_text'] = $this->pub_text->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->pub_id->DbValue = $row['pub_id'];
		$this->bibl_id->DbValue = $row['bibl_id'];
		$this->pub_order->DbValue = $row['pub_order'];
		$this->pub_title1->DbValue = $row['pub_title1'];
		$this->pub_title2->DbValue = $row['pub_title2'];
		$this->pub_publisher->DbValue = $row['pub_publisher'];
		$this->pub_dimensions->DbValue = $row['pub_dimensions'];
		$this->pub_editor->DbValue = $row['pub_editor'];
		$this->pub_image->Upload->DbValue = $row['pub_image'];
		$this->pub_text->DbValue = $row['pub_text'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("pub_id")) <> "")
			$this->pub_id->CurrentValue = $this->getKey("pub_id"); // pub_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// bibl_id
			$this->bibl_id->EditAttrs["class"] = "form-control";
			$this->bibl_id->EditCustomAttributes = "";
			if (trim(strval($this->bibl_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`bibl_id`" . ew_SearchString("=", $this->bibl_id->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			$this->pub_order->EditValue = ew_HtmlEncode($this->pub_order->CurrentValue);
			$this->pub_order->PlaceHolder = ew_RemoveHtml($this->pub_order->FldCaption());

			// pub_title1
			$this->pub_title1->EditAttrs["class"] = "form-control";
			$this->pub_title1->EditCustomAttributes = "";
			$this->pub_title1->EditValue = ew_HtmlEncode($this->pub_title1->CurrentValue);
			$this->pub_title1->PlaceHolder = ew_RemoveHtml($this->pub_title1->FldCaption());

			// pub_title2
			$this->pub_title2->EditAttrs["class"] = "form-control";
			$this->pub_title2->EditCustomAttributes = "";
			$this->pub_title2->EditValue = ew_HtmlEncode($this->pub_title2->CurrentValue);
			$this->pub_title2->PlaceHolder = ew_RemoveHtml($this->pub_title2->FldCaption());

			// pub_publisher
			$this->pub_publisher->EditAttrs["class"] = "form-control";
			$this->pub_publisher->EditCustomAttributes = "";
			$this->pub_publisher->EditValue = ew_HtmlEncode($this->pub_publisher->CurrentValue);
			$this->pub_publisher->PlaceHolder = ew_RemoveHtml($this->pub_publisher->FldCaption());

			// pub_dimensions
			$this->pub_dimensions->EditAttrs["class"] = "form-control";
			$this->pub_dimensions->EditCustomAttributes = "";
			$this->pub_dimensions->EditValue = ew_HtmlEncode($this->pub_dimensions->CurrentValue);
			$this->pub_dimensions->PlaceHolder = ew_RemoveHtml($this->pub_dimensions->FldCaption());

			// pub_editor
			$this->pub_editor->EditAttrs["class"] = "form-control";
			$this->pub_editor->EditCustomAttributes = "";
			$this->pub_editor->EditValue = ew_HtmlEncode($this->pub_editor->CurrentValue);
			$this->pub_editor->PlaceHolder = ew_RemoveHtml($this->pub_editor->FldCaption());

			// pub_image
			$this->pub_image->EditAttrs["class"] = "form-control";
			$this->pub_image->EditCustomAttributes = "";
			if (!ew_Empty($this->pub_image->Upload->DbValue)) {
				$this->pub_image->ImageWidth = 100;
				$this->pub_image->ImageHeight = 0;
				$this->pub_image->ImageAlt = $this->pub_image->FldAlt();
				$this->pub_image->EditValue = $this->pub_image->Upload->DbValue;
			} else {
				$this->pub_image->EditValue = "";
			}
			if (!ew_Empty($this->pub_image->CurrentValue))
				$this->pub_image->Upload->FileName = $this->pub_image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->pub_image);

			// pub_text
			$this->pub_text->EditAttrs["class"] = "form-control";
			$this->pub_text->EditCustomAttributes = "";
			$this->pub_text->EditValue = ew_HtmlEncode($this->pub_text->CurrentValue);
			$this->pub_text->PlaceHolder = ew_RemoveHtml($this->pub_text->FldCaption());

			// Add refer script
			// bibl_id

			$this->bibl_id->LinkCustomAttributes = "";
			$this->bibl_id->HrefValue = "";

			// pub_order
			$this->pub_order->LinkCustomAttributes = "";
			$this->pub_order->HrefValue = "";

			// pub_title1
			$this->pub_title1->LinkCustomAttributes = "";
			$this->pub_title1->HrefValue = "";

			// pub_title2
			$this->pub_title2->LinkCustomAttributes = "";
			$this->pub_title2->HrefValue = "";

			// pub_publisher
			$this->pub_publisher->LinkCustomAttributes = "";
			$this->pub_publisher->HrefValue = "";

			// pub_dimensions
			$this->pub_dimensions->LinkCustomAttributes = "";
			$this->pub_dimensions->HrefValue = "";

			// pub_editor
			$this->pub_editor->LinkCustomAttributes = "";
			$this->pub_editor->HrefValue = "";

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

			// pub_text
			$this->pub_text->LinkCustomAttributes = "";
			$this->pub_text->HrefValue = "";
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
		if (!$this->bibl_id->FldIsDetailKey && !is_null($this->bibl_id->FormValue) && $this->bibl_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bibl_id->FldCaption(), $this->bibl_id->ReqErrMsg));
		}
		if (!$this->pub_order->FldIsDetailKey && !is_null($this->pub_order->FormValue) && $this->pub_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pub_order->FldCaption(), $this->pub_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->pub_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->pub_order->FldErrMsg());
		}
		if (!$this->pub_title1->FldIsDetailKey && !is_null($this->pub_title1->FormValue) && $this->pub_title1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pub_title1->FldCaption(), $this->pub_title1->ReqErrMsg));
		}
		if ($this->pub_image->Upload->FileName == "" && !$this->pub_image->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pub_image->FldCaption(), $this->pub_image->ReqErrMsg));
		}
		if (!$this->pub_text->FldIsDetailKey && !is_null($this->pub_text->FormValue) && $this->pub_text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pub_text->FldCaption(), $this->pub_text->ReqErrMsg));
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

		// bibl_id
		$this->bibl_id->SetDbValueDef($rsnew, $this->bibl_id->CurrentValue, 0, FALSE);

		// pub_order
		$this->pub_order->SetDbValueDef($rsnew, $this->pub_order->CurrentValue, 0, strval($this->pub_order->CurrentValue) == "");

		// pub_title1
		$this->pub_title1->SetDbValueDef($rsnew, $this->pub_title1->CurrentValue, "", FALSE);

		// pub_title2
		$this->pub_title2->SetDbValueDef($rsnew, $this->pub_title2->CurrentValue, NULL, FALSE);

		// pub_publisher
		$this->pub_publisher->SetDbValueDef($rsnew, $this->pub_publisher->CurrentValue, NULL, FALSE);

		// pub_dimensions
		$this->pub_dimensions->SetDbValueDef($rsnew, $this->pub_dimensions->CurrentValue, NULL, FALSE);

		// pub_editor
		$this->pub_editor->SetDbValueDef($rsnew, $this->pub_editor->CurrentValue, NULL, FALSE);

		// pub_image
		if ($this->pub_image->Visible && !$this->pub_image->Upload->KeepFile) {
			$this->pub_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->pub_image->Upload->FileName == "") {
				$rsnew['pub_image'] = NULL;
			} else {
				$rsnew['pub_image'] = $this->pub_image->Upload->FileName;
			}
		}

		// pub_text
		$this->pub_text->SetDbValueDef($rsnew, $this->pub_text->CurrentValue, "", FALSE);
		if ($this->pub_image->Visible && !$this->pub_image->Upload->KeepFile) {
			if (!ew_Empty($this->pub_image->Upload->Value)) {
				$rsnew['pub_image'] = ew_UploadFileNameEx($this->pub_image->PhysicalUploadPath(), $rsnew['pub_image']); // Get new file name
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
				if ($this->pub_image->Visible && !$this->pub_image->Upload->KeepFile) {
					if (!ew_Empty($this->pub_image->Upload->Value)) {
						if (!$this->pub_image->Upload->SaveToFile($rsnew['pub_image'], TRUE)) {
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
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// pub_image
		ew_CleanUploadTempPath($this->pub_image, $this->pub_image->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_publicationlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($cpy_publication_add)) $cpy_publication_add = new ccpy_publication_add();

// Page init
$cpy_publication_add->Page_Init();

// Page main
$cpy_publication_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_publication_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_publicationadd = new ew_Form("fcpy_publicationadd", "add");

// Validate form
fcpy_publicationadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_bibl_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_publication->bibl_id->FldCaption(), $cpy_publication->bibl_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pub_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_publication->pub_order->FldCaption(), $cpy_publication->pub_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pub_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_publication->pub_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pub_title1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_publication->pub_title1->FldCaption(), $cpy_publication->pub_title1->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_pub_image");
			elm = this.GetElements("fn_x" + infix + "_pub_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_publication->pub_image->FldCaption(), $cpy_publication->pub_image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pub_text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_publication->pub_text->FldCaption(), $cpy_publication->pub_text->ReqErrMsg)) ?>");

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
fcpy_publicationadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_publicationadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_publicationadd.Lists["x_bibl_id"] = {"LinkField":"x_bibl_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bibl_title1","x_bibl_title2","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_bibliography"};
fcpy_publicationadd.Lists["x_bibl_id"].Data = "<?php echo $cpy_publication_add->bibl_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_publication_add->ShowPageHeader(); ?>
<?php
$cpy_publication_add->ShowMessage();
?>
<form name="fcpy_publicationadd" id="fcpy_publicationadd" class="<?php echo $cpy_publication_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_publication_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_publication_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_publication">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_publication_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_publication->bibl_id->Visible) { // bibl_id ?>
	<div id="r_bibl_id" class="form-group">
		<label id="elh_cpy_publication_bibl_id" for="x_bibl_id" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->bibl_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->bibl_id->CellAttributes() ?>>
<span id="el_cpy_publication_bibl_id">
<select data-table="cpy_publication" data-field="x_bibl_id" data-value-separator="<?php echo $cpy_publication->bibl_id->DisplayValueSeparatorAttribute() ?>" id="x_bibl_id" name="x_bibl_id"<?php echo $cpy_publication->bibl_id->EditAttributes() ?>>
<?php echo $cpy_publication->bibl_id->SelectOptionListHtml("x_bibl_id") ?>
</select>
</span>
<?php echo $cpy_publication->bibl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_order->Visible) { // pub_order ?>
	<div id="r_pub_order" class="form-group">
		<label id="elh_cpy_publication_pub_order" for="x_pub_order" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_order->CellAttributes() ?>>
<span id="el_cpy_publication_pub_order">
<input type="text" data-table="cpy_publication" data-field="x_pub_order" name="x_pub_order" id="x_pub_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_order->getPlaceHolder()) ?>" value="<?php echo $cpy_publication->pub_order->EditValue ?>"<?php echo $cpy_publication->pub_order->EditAttributes() ?>>
</span>
<?php echo $cpy_publication->pub_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_title1->Visible) { // pub_title1 ?>
	<div id="r_pub_title1" class="form-group">
		<label id="elh_cpy_publication_pub_title1" for="x_pub_title1" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_title1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_title1->CellAttributes() ?>>
<span id="el_cpy_publication_pub_title1">
<textarea data-table="cpy_publication" data-field="x_pub_title1" name="x_pub_title1" id="x_pub_title1" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_title1->getPlaceHolder()) ?>"<?php echo $cpy_publication->pub_title1->EditAttributes() ?>><?php echo $cpy_publication->pub_title1->EditValue ?></textarea>
</span>
<?php echo $cpy_publication->pub_title1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_title2->Visible) { // pub_title2 ?>
	<div id="r_pub_title2" class="form-group">
		<label id="elh_cpy_publication_pub_title2" for="x_pub_title2" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_title2->FldCaption() ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_title2->CellAttributes() ?>>
<span id="el_cpy_publication_pub_title2">
<textarea data-table="cpy_publication" data-field="x_pub_title2" name="x_pub_title2" id="x_pub_title2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_title2->getPlaceHolder()) ?>"<?php echo $cpy_publication->pub_title2->EditAttributes() ?>><?php echo $cpy_publication->pub_title2->EditValue ?></textarea>
</span>
<?php echo $cpy_publication->pub_title2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_publisher->Visible) { // pub_publisher ?>
	<div id="r_pub_publisher" class="form-group">
		<label id="elh_cpy_publication_pub_publisher" for="x_pub_publisher" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_publisher->FldCaption() ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_publisher->CellAttributes() ?>>
<span id="el_cpy_publication_pub_publisher">
<textarea data-table="cpy_publication" data-field="x_pub_publisher" name="x_pub_publisher" id="x_pub_publisher" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_publisher->getPlaceHolder()) ?>"<?php echo $cpy_publication->pub_publisher->EditAttributes() ?>><?php echo $cpy_publication->pub_publisher->EditValue ?></textarea>
</span>
<?php echo $cpy_publication->pub_publisher->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_dimensions->Visible) { // pub_dimensions ?>
	<div id="r_pub_dimensions" class="form-group">
		<label id="elh_cpy_publication_pub_dimensions" for="x_pub_dimensions" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_dimensions->FldCaption() ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_dimensions->CellAttributes() ?>>
<span id="el_cpy_publication_pub_dimensions">
<textarea data-table="cpy_publication" data-field="x_pub_dimensions" name="x_pub_dimensions" id="x_pub_dimensions" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_dimensions->getPlaceHolder()) ?>"<?php echo $cpy_publication->pub_dimensions->EditAttributes() ?>><?php echo $cpy_publication->pub_dimensions->EditValue ?></textarea>
</span>
<?php echo $cpy_publication->pub_dimensions->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_editor->Visible) { // pub_editor ?>
	<div id="r_pub_editor" class="form-group">
		<label id="elh_cpy_publication_pub_editor" for="x_pub_editor" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_editor->FldCaption() ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_editor->CellAttributes() ?>>
<span id="el_cpy_publication_pub_editor">
<textarea data-table="cpy_publication" data-field="x_pub_editor" name="x_pub_editor" id="x_pub_editor" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_editor->getPlaceHolder()) ?>"<?php echo $cpy_publication->pub_editor->EditAttributes() ?>><?php echo $cpy_publication->pub_editor->EditValue ?></textarea>
</span>
<?php echo $cpy_publication->pub_editor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_image->Visible) { // pub_image ?>
	<div id="r_pub_image" class="form-group">
		<label id="elh_cpy_publication_pub_image" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_image->CellAttributes() ?>>
<span id="el_cpy_publication_pub_image">
<div id="fd_x_pub_image">
<span title="<?php echo $cpy_publication->pub_image->FldTitle() ? $cpy_publication->pub_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_publication->pub_image->ReadOnly || $cpy_publication->pub_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_publication" data-field="x_pub_image" name="x_pub_image" id="x_pub_image"<?php echo $cpy_publication->pub_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_pub_image" id= "fn_x_pub_image" value="<?php echo $cpy_publication->pub_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_pub_image" id= "fa_x_pub_image" value="0">
<input type="hidden" name="fs_x_pub_image" id= "fs_x_pub_image" value="1000">
<input type="hidden" name="fx_x_pub_image" id= "fx_x_pub_image" value="<?php echo $cpy_publication->pub_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_pub_image" id= "fm_x_pub_image" value="<?php echo $cpy_publication->pub_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_pub_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_publication->pub_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_publication->pub_text->Visible) { // pub_text ?>
	<div id="r_pub_text" class="form-group">
		<label id="elh_cpy_publication_pub_text" for="x_pub_text" class="<?php echo $cpy_publication_add->LeftColumnClass ?>"><?php echo $cpy_publication->pub_text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_publication_add->RightColumnClass ?>"><div<?php echo $cpy_publication->pub_text->CellAttributes() ?>>
<span id="el_cpy_publication_pub_text">
<textarea data-table="cpy_publication" data-field="x_pub_text" name="x_pub_text" id="x_pub_text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_publication->pub_text->getPlaceHolder()) ?>"<?php echo $cpy_publication->pub_text->EditAttributes() ?>><?php echo $cpy_publication->pub_text->EditValue ?></textarea>
</span>
<?php echo $cpy_publication->pub_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_publication_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_publication_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_publication_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_publicationadd.Init();
</script>
<?php
$cpy_publication_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_publication_add->Page_Terminate();
?>
