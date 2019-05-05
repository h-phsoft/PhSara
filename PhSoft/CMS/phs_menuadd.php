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

$phs_menu_add = NULL; // Initialize page object first

class cphs_menu_add extends cphs_menu {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'phs_menu';

	// Page object name
	var $PageObjName = 'phs_menu_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
			if (@$_GET["menu_id"] != "") {
				$this->menu_id->setQueryStringValue($_GET["menu_id"]);
				$this->setKey("menu_id", $this->menu_id->CurrentValue); // Set up key
			} else {
				$this->setKey("menu_id", ""); // Clear key
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
					$this->Page_Terminate("phs_menulist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "phs_menulist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "phs_menuview.php")
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
		$this->menu_id->CurrentValue = NULL;
		$this->menu_id->OldValue = $this->menu_id->CurrentValue;
		$this->menu_pid->CurrentValue = NULL;
		$this->menu_pid->OldValue = $this->menu_pid->CurrentValue;
		$this->page_id->CurrentValue = 0;
		$this->status_id->CurrentValue = 1;
		$this->menu_order->CurrentValue = 0;
		$this->menu_name->CurrentValue = NULL;
		$this->menu_name->OldValue = $this->menu_name->CurrentValue;
		$this->menu_icon->CurrentValue = NULL;
		$this->menu_icon->OldValue = $this->menu_icon->CurrentValue;
		$this->menu_href->CurrentValue = NULL;
		$this->menu_href->OldValue = $this->menu_href->CurrentValue;
		$this->menu_target->CurrentValue = NULL;
		$this->menu_target->OldValue = $this->menu_target->CurrentValue;
		$this->menu_page->CurrentValue = NULL;
		$this->menu_page->OldValue = $this->menu_page->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->menu_id->FldIsDetailKey) {
			$this->menu_id->setFormValue($objForm->GetValue("x_menu_id"));
		}
		if (!$this->menu_pid->FldIsDetailKey) {
			$this->menu_pid->setFormValue($objForm->GetValue("x_menu_pid"));
		}
		if (!$this->page_id->FldIsDetailKey) {
			$this->page_id->setFormValue($objForm->GetValue("x_page_id"));
		}
		if (!$this->status_id->FldIsDetailKey) {
			$this->status_id->setFormValue($objForm->GetValue("x_status_id"));
		}
		if (!$this->menu_order->FldIsDetailKey) {
			$this->menu_order->setFormValue($objForm->GetValue("x_menu_order"));
		}
		if (!$this->menu_name->FldIsDetailKey) {
			$this->menu_name->setFormValue($objForm->GetValue("x_menu_name"));
		}
		if (!$this->menu_icon->FldIsDetailKey) {
			$this->menu_icon->setFormValue($objForm->GetValue("x_menu_icon"));
		}
		if (!$this->menu_href->FldIsDetailKey) {
			$this->menu_href->setFormValue($objForm->GetValue("x_menu_href"));
		}
		if (!$this->menu_target->FldIsDetailKey) {
			$this->menu_target->setFormValue($objForm->GetValue("x_menu_target"));
		}
		if (!$this->menu_page->FldIsDetailKey) {
			$this->menu_page->setFormValue($objForm->GetValue("x_menu_page"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->menu_id->CurrentValue = $this->menu_id->FormValue;
		$this->menu_pid->CurrentValue = $this->menu_pid->FormValue;
		$this->page_id->CurrentValue = $this->page_id->FormValue;
		$this->status_id->CurrentValue = $this->status_id->FormValue;
		$this->menu_order->CurrentValue = $this->menu_order->FormValue;
		$this->menu_name->CurrentValue = $this->menu_name->FormValue;
		$this->menu_icon->CurrentValue = $this->menu_icon->FormValue;
		$this->menu_href->CurrentValue = $this->menu_href->FormValue;
		$this->menu_target->CurrentValue = $this->menu_target->FormValue;
		$this->menu_page->CurrentValue = $this->menu_page->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['menu_id'] = $this->menu_id->CurrentValue;
		$row['menu_pid'] = $this->menu_pid->CurrentValue;
		$row['page_id'] = $this->page_id->CurrentValue;
		$row['status_id'] = $this->status_id->CurrentValue;
		$row['menu_order'] = $this->menu_order->CurrentValue;
		$row['menu_name'] = $this->menu_name->CurrentValue;
		$row['menu_icon'] = $this->menu_icon->CurrentValue;
		$row['menu_href'] = $this->menu_href->CurrentValue;
		$row['menu_target'] = $this->menu_target->CurrentValue;
		$row['menu_page'] = $this->menu_page->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("menu_id")) <> "")
			$this->menu_id->CurrentValue = $this->getKey("menu_id"); // menu_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// menu_id
			$this->menu_id->EditAttrs["class"] = "form-control";
			$this->menu_id->EditCustomAttributes = "";
			$this->menu_id->EditValue = ew_HtmlEncode($this->menu_id->CurrentValue);
			$this->menu_id->PlaceHolder = ew_RemoveHtml($this->menu_id->FldCaption());

			// menu_pid
			$this->menu_pid->EditAttrs["class"] = "form-control";
			$this->menu_pid->EditCustomAttributes = "";
			if (trim(strval($this->menu_pid->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`menu_id`" . ew_SearchString("=", $this->menu_pid->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			if (trim(strval($this->page_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`page_id`" . ew_SearchString("=", $this->page_id->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			if (trim(strval($this->status_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`status_id`" . ew_SearchString("=", $this->status_id->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			$this->menu_order->EditValue = ew_HtmlEncode($this->menu_order->CurrentValue);
			$this->menu_order->PlaceHolder = ew_RemoveHtml($this->menu_order->FldCaption());

			// menu_name
			$this->menu_name->EditAttrs["class"] = "form-control";
			$this->menu_name->EditCustomAttributes = "";
			$this->menu_name->EditValue = ew_HtmlEncode($this->menu_name->CurrentValue);
			$this->menu_name->PlaceHolder = ew_RemoveHtml($this->menu_name->FldCaption());

			// menu_icon
			$this->menu_icon->EditAttrs["class"] = "form-control";
			$this->menu_icon->EditCustomAttributes = "";
			$this->menu_icon->EditValue = ew_HtmlEncode($this->menu_icon->CurrentValue);
			$this->menu_icon->PlaceHolder = ew_RemoveHtml($this->menu_icon->FldCaption());

			// menu_href
			$this->menu_href->EditAttrs["class"] = "form-control";
			$this->menu_href->EditCustomAttributes = "";
			$this->menu_href->EditValue = ew_HtmlEncode($this->menu_href->CurrentValue);
			$this->menu_href->PlaceHolder = ew_RemoveHtml($this->menu_href->FldCaption());

			// menu_target
			$this->menu_target->EditAttrs["class"] = "form-control";
			$this->menu_target->EditCustomAttributes = "";
			$this->menu_target->EditValue = ew_HtmlEncode($this->menu_target->CurrentValue);
			$this->menu_target->PlaceHolder = ew_RemoveHtml($this->menu_target->FldCaption());

			// menu_page
			$this->menu_page->EditAttrs["class"] = "form-control";
			$this->menu_page->EditCustomAttributes = "";
			$this->menu_page->EditValue = ew_HtmlEncode($this->menu_page->CurrentValue);
			$this->menu_page->PlaceHolder = ew_RemoveHtml($this->menu_page->FldCaption());

			// Add refer script
			// menu_id

			$this->menu_id->LinkCustomAttributes = "";
			$this->menu_id->HrefValue = "";

			// menu_pid
			$this->menu_pid->LinkCustomAttributes = "";
			$this->menu_pid->HrefValue = "";

			// page_id
			$this->page_id->LinkCustomAttributes = "";
			$this->page_id->HrefValue = "";

			// status_id
			$this->status_id->LinkCustomAttributes = "";
			$this->status_id->HrefValue = "";

			// menu_order
			$this->menu_order->LinkCustomAttributes = "";
			$this->menu_order->HrefValue = "";

			// menu_name
			$this->menu_name->LinkCustomAttributes = "";
			$this->menu_name->HrefValue = "";

			// menu_icon
			$this->menu_icon->LinkCustomAttributes = "";
			$this->menu_icon->HrefValue = "";

			// menu_href
			$this->menu_href->LinkCustomAttributes = "";
			$this->menu_href->HrefValue = "";

			// menu_target
			$this->menu_target->LinkCustomAttributes = "";
			$this->menu_target->HrefValue = "";

			// menu_page
			$this->menu_page->LinkCustomAttributes = "";
			$this->menu_page->HrefValue = "";
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
		if (!$this->menu_id->FldIsDetailKey && !is_null($this->menu_id->FormValue) && $this->menu_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_id->FldCaption(), $this->menu_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->menu_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->menu_id->FldErrMsg());
		}
		if (!$this->menu_pid->FldIsDetailKey && !is_null($this->menu_pid->FormValue) && $this->menu_pid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_pid->FldCaption(), $this->menu_pid->ReqErrMsg));
		}
		if (!$this->page_id->FldIsDetailKey && !is_null($this->page_id->FormValue) && $this->page_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->page_id->FldCaption(), $this->page_id->ReqErrMsg));
		}
		if (!$this->status_id->FldIsDetailKey && !is_null($this->status_id->FormValue) && $this->status_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status_id->FldCaption(), $this->status_id->ReqErrMsg));
		}
		if (!$this->menu_order->FldIsDetailKey && !is_null($this->menu_order->FormValue) && $this->menu_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_order->FldCaption(), $this->menu_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->menu_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->menu_order->FldErrMsg());
		}
		if (!$this->menu_name->FldIsDetailKey && !is_null($this->menu_name->FormValue) && $this->menu_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->menu_name->FldCaption(), $this->menu_name->ReqErrMsg));
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

		// menu_id
		$this->menu_id->SetDbValueDef($rsnew, $this->menu_id->CurrentValue, 0, FALSE);

		// menu_pid
		$this->menu_pid->SetDbValueDef($rsnew, $this->menu_pid->CurrentValue, 0, FALSE);

		// page_id
		$this->page_id->SetDbValueDef($rsnew, $this->page_id->CurrentValue, 0, strval($this->page_id->CurrentValue) == "");

		// status_id
		$this->status_id->SetDbValueDef($rsnew, $this->status_id->CurrentValue, 0, strval($this->status_id->CurrentValue) == "");

		// menu_order
		$this->menu_order->SetDbValueDef($rsnew, $this->menu_order->CurrentValue, 0, strval($this->menu_order->CurrentValue) == "");

		// menu_name
		$this->menu_name->SetDbValueDef($rsnew, $this->menu_name->CurrentValue, "", FALSE);

		// menu_icon
		$this->menu_icon->SetDbValueDef($rsnew, $this->menu_icon->CurrentValue, NULL, FALSE);

		// menu_href
		$this->menu_href->SetDbValueDef($rsnew, $this->menu_href->CurrentValue, NULL, FALSE);

		// menu_target
		$this->menu_target->SetDbValueDef($rsnew, $this->menu_target->CurrentValue, NULL, FALSE);

		// menu_page
		$this->menu_page->SetDbValueDef($rsnew, $this->menu_page->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['menu_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("phs_menulist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($phs_menu_add)) $phs_menu_add = new cphs_menu_add();

// Page init
$phs_menu_add->Page_Init();

// Page main
$phs_menu_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$phs_menu_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fphs_menuadd = new ew_Form("fphs_menuadd", "add");

// Validate form
fphs_menuadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_menu_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_menu->menu_id->FldCaption(), $phs_menu->menu_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($phs_menu->menu_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_menu_pid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_menu->menu_pid->FldCaption(), $phs_menu->menu_pid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_page_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_menu->page_id->FldCaption(), $phs_menu->page_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_menu->status_id->FldCaption(), $phs_menu->status_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_menu->menu_order->FldCaption(), $phs_menu->menu_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_menu_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($phs_menu->menu_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_menu_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_menu->menu_name->FldCaption(), $phs_menu->menu_name->ReqErrMsg)) ?>");

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
fphs_menuadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fphs_menuadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fphs_menuadd.Lists["x_menu_pid"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_menu_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_menu"};
fphs_menuadd.Lists["x_menu_pid"].Data = "<?php echo $phs_menu_add->menu_pid->LookupFilterQuery(FALSE, "add") ?>";
fphs_menuadd.Lists["x_page_id"] = {"LinkField":"x_page_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_page_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_page"};
fphs_menuadd.Lists["x_page_id"].Data = "<?php echo $phs_menu_add->page_id->LookupFilterQuery(FALSE, "add") ?>";
fphs_menuadd.Lists["x_status_id"] = {"LinkField":"x_status_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_status_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_status"};
fphs_menuadd.Lists["x_status_id"].Data = "<?php echo $phs_menu_add->status_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $phs_menu_add->ShowPageHeader(); ?>
<?php
$phs_menu_add->ShowMessage();
?>
<form name="fphs_menuadd" id="fphs_menuadd" class="<?php echo $phs_menu_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($phs_menu_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $phs_menu_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="phs_menu">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($phs_menu_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($phs_menu->menu_id->Visible) { // menu_id ?>
	<div id="r_menu_id" class="form-group">
		<label id="elh_phs_menu_menu_id" for="x_menu_id" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_id->CellAttributes() ?>>
<span id="el_phs_menu_menu_id">
<input type="text" data-table="phs_menu" data-field="x_menu_id" name="x_menu_id" id="x_menu_id" size="30" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_id->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_id->EditValue ?>"<?php echo $phs_menu->menu_id->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_pid->Visible) { // menu_pid ?>
	<div id="r_menu_pid" class="form-group">
		<label id="elh_phs_menu_menu_pid" for="x_menu_pid" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_pid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_pid->CellAttributes() ?>>
<span id="el_phs_menu_menu_pid">
<select data-table="phs_menu" data-field="x_menu_pid" data-value-separator="<?php echo $phs_menu->menu_pid->DisplayValueSeparatorAttribute() ?>" id="x_menu_pid" name="x_menu_pid"<?php echo $phs_menu->menu_pid->EditAttributes() ?>>
<?php echo $phs_menu->menu_pid->SelectOptionListHtml("x_menu_pid") ?>
</select>
</span>
<?php echo $phs_menu->menu_pid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->page_id->Visible) { // page_id ?>
	<div id="r_page_id" class="form-group">
		<label id="elh_phs_menu_page_id" for="x_page_id" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->page_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->page_id->CellAttributes() ?>>
<span id="el_phs_menu_page_id">
<select data-table="phs_menu" data-field="x_page_id" data-value-separator="<?php echo $phs_menu->page_id->DisplayValueSeparatorAttribute() ?>" id="x_page_id" name="x_page_id"<?php echo $phs_menu->page_id->EditAttributes() ?>>
<?php echo $phs_menu->page_id->SelectOptionListHtml("x_page_id") ?>
</select>
</span>
<?php echo $phs_menu->page_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->status_id->Visible) { // status_id ?>
	<div id="r_status_id" class="form-group">
		<label id="elh_phs_menu_status_id" for="x_status_id" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->status_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->status_id->CellAttributes() ?>>
<span id="el_phs_menu_status_id">
<select data-table="phs_menu" data-field="x_status_id" data-value-separator="<?php echo $phs_menu->status_id->DisplayValueSeparatorAttribute() ?>" id="x_status_id" name="x_status_id"<?php echo $phs_menu->status_id->EditAttributes() ?>>
<?php echo $phs_menu->status_id->SelectOptionListHtml("x_status_id") ?>
</select>
</span>
<?php echo $phs_menu->status_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_order->Visible) { // menu_order ?>
	<div id="r_menu_order" class="form-group">
		<label id="elh_phs_menu_menu_order" for="x_menu_order" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_order->CellAttributes() ?>>
<span id="el_phs_menu_menu_order">
<input type="text" data-table="phs_menu" data-field="x_menu_order" name="x_menu_order" id="x_menu_order" size="30" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_order->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_order->EditValue ?>"<?php echo $phs_menu->menu_order->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_name->Visible) { // menu_name ?>
	<div id="r_menu_name" class="form-group">
		<label id="elh_phs_menu_menu_name" for="x_menu_name" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_name->CellAttributes() ?>>
<span id="el_phs_menu_menu_name">
<input type="text" data-table="phs_menu" data-field="x_menu_name" name="x_menu_name" id="x_menu_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_name->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_name->EditValue ?>"<?php echo $phs_menu->menu_name->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_icon->Visible) { // menu_icon ?>
	<div id="r_menu_icon" class="form-group">
		<label id="elh_phs_menu_menu_icon" for="x_menu_icon" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_icon->FldCaption() ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_icon->CellAttributes() ?>>
<span id="el_phs_menu_menu_icon">
<input type="text" data-table="phs_menu" data-field="x_menu_icon" name="x_menu_icon" id="x_menu_icon" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_icon->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_icon->EditValue ?>"<?php echo $phs_menu->menu_icon->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_href->Visible) { // menu_href ?>
	<div id="r_menu_href" class="form-group">
		<label id="elh_phs_menu_menu_href" for="x_menu_href" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_href->FldCaption() ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_href->CellAttributes() ?>>
<span id="el_phs_menu_menu_href">
<input type="text" data-table="phs_menu" data-field="x_menu_href" name="x_menu_href" id="x_menu_href" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_href->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_href->EditValue ?>"<?php echo $phs_menu->menu_href->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_href->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_target->Visible) { // menu_target ?>
	<div id="r_menu_target" class="form-group">
		<label id="elh_phs_menu_menu_target" for="x_menu_target" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_target->FldCaption() ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_target->CellAttributes() ?>>
<span id="el_phs_menu_menu_target">
<input type="text" data-table="phs_menu" data-field="x_menu_target" name="x_menu_target" id="x_menu_target" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_target->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_target->EditValue ?>"<?php echo $phs_menu->menu_target->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_target->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($phs_menu->menu_page->Visible) { // menu_page ?>
	<div id="r_menu_page" class="form-group">
		<label id="elh_phs_menu_menu_page" for="x_menu_page" class="<?php echo $phs_menu_add->LeftColumnClass ?>"><?php echo $phs_menu->menu_page->FldCaption() ?></label>
		<div class="<?php echo $phs_menu_add->RightColumnClass ?>"><div<?php echo $phs_menu->menu_page->CellAttributes() ?>>
<span id="el_phs_menu_menu_page">
<input type="text" data-table="phs_menu" data-field="x_menu_page" name="x_menu_page" id="x_menu_page" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($phs_menu->menu_page->getPlaceHolder()) ?>" value="<?php echo $phs_menu->menu_page->EditValue ?>"<?php echo $phs_menu->menu_page->EditAttributes() ?>>
</span>
<?php echo $phs_menu->menu_page->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$phs_menu_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $phs_menu_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $phs_menu_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fphs_menuadd.Init();
</script>
<?php
$phs_menu_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$phs_menu_add->Page_Terminate();
?>
