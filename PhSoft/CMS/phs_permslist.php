<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "phs_permsinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$phs_perms_list = NULL; // Initialize page object first

class cphs_perms_list extends cphs_perms {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'phs_perms';

	// Page object name
	var $PageObjName = 'phs_perms_list';

	// Grid form hidden field names
	var $FormName = 'fphs_permslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (phs_perms)
		if (!isset($GLOBALS["phs_perms"]) || get_class($GLOBALS["phs_perms"]) == "cphs_perms") {
			$GLOBALS["phs_perms"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["phs_perms"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "phs_permsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "phs_permsdelete.php";
		$this->MultiUpdateUrl = "phs_permsupdate.php";

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'phs_perms', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fphs_permslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->pgrp_id->SetVisibility();
		$this->perm_table->SetVisibility();
		$this->perm_perm->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $phs_perms;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($phs_perms);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Exit inline mode
	function ClearInlineMode() {
		$this->setKey("perm_id", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (isset($_GET["perm_id"])) {
			$this->perm_id->setQueryStringValue($_GET["perm_id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("perm_id", $this->perm_id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1;
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("perm_id")) <> strval($this->perm_id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["perm_id"] <> "") {
				$this->perm_id->setQueryStringValue($_GET["perm_id"]);
				$this->setKey("perm_id", $this->perm_id->CurrentValue); // Set up key
			} else {
				$this->setKey("perm_id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old record
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->perm_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->perm_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->perm_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_pgrp_id") && $objForm->HasValue("o_pgrp_id") && $this->pgrp_id->CurrentValue <> $this->pgrp_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_perm_table") && $objForm->HasValue("o_perm_table") && $this->perm_table->CurrentValue <> $this->perm_table->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_perm_perm") && $objForm->HasValue("o_perm_perm") && $this->perm_perm->CurrentValue <> $this->perm_perm->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fphs_permslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->pgrp_id->AdvancedSearch->ToJson(), ","); // Field pgrp_id
		$sFilterList = ew_Concat($sFilterList, $this->perm_table->AdvancedSearch->ToJson(), ","); // Field perm_table
		$sFilterList = ew_Concat($sFilterList, $this->perm_perm->AdvancedSearch->ToJson(), ","); // Field perm_perm
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fphs_permslistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field pgrp_id
		$this->pgrp_id->AdvancedSearch->SearchValue = @$filter["x_pgrp_id"];
		$this->pgrp_id->AdvancedSearch->SearchOperator = @$filter["z_pgrp_id"];
		$this->pgrp_id->AdvancedSearch->SearchCondition = @$filter["v_pgrp_id"];
		$this->pgrp_id->AdvancedSearch->SearchValue2 = @$filter["y_pgrp_id"];
		$this->pgrp_id->AdvancedSearch->SearchOperator2 = @$filter["w_pgrp_id"];
		$this->pgrp_id->AdvancedSearch->Save();

		// Field perm_table
		$this->perm_table->AdvancedSearch->SearchValue = @$filter["x_perm_table"];
		$this->perm_table->AdvancedSearch->SearchOperator = @$filter["z_perm_table"];
		$this->perm_table->AdvancedSearch->SearchCondition = @$filter["v_perm_table"];
		$this->perm_table->AdvancedSearch->SearchValue2 = @$filter["y_perm_table"];
		$this->perm_table->AdvancedSearch->SearchOperator2 = @$filter["w_perm_table"];
		$this->perm_table->AdvancedSearch->Save();

		// Field perm_perm
		$this->perm_perm->AdvancedSearch->SearchValue = @$filter["x_perm_perm"];
		$this->perm_perm->AdvancedSearch->SearchOperator = @$filter["z_perm_perm"];
		$this->perm_perm->AdvancedSearch->SearchCondition = @$filter["v_perm_perm"];
		$this->perm_perm->AdvancedSearch->SearchValue2 = @$filter["y_perm_perm"];
		$this->perm_perm->AdvancedSearch->SearchOperator2 = @$filter["w_perm_perm"];
		$this->perm_perm->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->pgrp_id, $Default, FALSE); // pgrp_id
		$this->BuildSearchSql($sWhere, $this->perm_table, $Default, FALSE); // perm_table
		$this->BuildSearchSql($sWhere, $this->perm_perm, $Default, FALSE); // perm_perm

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->pgrp_id->AdvancedSearch->Save(); // pgrp_id
			$this->perm_table->AdvancedSearch->Save(); // perm_table
			$this->perm_perm->AdvancedSearch->Save(); // perm_perm
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->perm_table, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->pgrp_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->perm_table->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->perm_perm->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->pgrp_id->AdvancedSearch->UnsetSession();
		$this->perm_table->AdvancedSearch->UnsetSession();
		$this->perm_perm->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->pgrp_id->AdvancedSearch->Load();
		$this->perm_table->AdvancedSearch->Load();
		$this->perm_perm->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->pgrp_id); // pgrp_id
			$this->UpdateSort($this->perm_table); // perm_table
			$this->UpdateSort($this->perm_perm); // perm_perm
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->pgrp_id->setSort("ASC");
				$this->perm_table->setSort("ASC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->pgrp_id->setSort("");
				$this->perm_table->setSort("");
				$this->perm_perm->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_UrlAddHash($this->PageName(), "r" . $this->RowCnt . "_" . $this->TableVar) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->perm_id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddHash($this->InlineEditUrl, "r" . $this->RowCnt . "_" . $this->TableVar)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->perm_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->perm_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fphs_permslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fphs_permslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fphs_permslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fphs_permslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fphs_permslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		if (ew_IsMobile())
			$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"phs_permssrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		else
			$item->Body = "<button type=\"button\" class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-table=\"phs_perms\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'SearchBtn',url:'phs_permssrch.php'});\">" . $Language->Phrase("AdvancedSearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fphs_permslistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
		$item->Visible = ($this->SearchWhere <> "" && $this->TotalRecs > 0);

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load default values
	function LoadDefaultValues() {
		$this->perm_id->CurrentValue = NULL;
		$this->perm_id->OldValue = $this->perm_id->CurrentValue;
		$this->pgrp_id->CurrentValue = NULL;
		$this->pgrp_id->OldValue = $this->pgrp_id->CurrentValue;
		$this->perm_table->CurrentValue = NULL;
		$this->perm_table->OldValue = $this->perm_table->CurrentValue;
		$this->perm_perm->CurrentValue = NULL;
		$this->perm_perm->OldValue = $this->perm_perm->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// pgrp_id

		$this->pgrp_id->AdvancedSearch->SearchValue = @$_GET["x_pgrp_id"];
		if ($this->pgrp_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->pgrp_id->AdvancedSearch->SearchOperator = @$_GET["z_pgrp_id"];

		// perm_table
		$this->perm_table->AdvancedSearch->SearchValue = @$_GET["x_perm_table"];
		if ($this->perm_table->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->perm_table->AdvancedSearch->SearchOperator = @$_GET["z_perm_table"];

		// perm_perm
		$this->perm_perm->AdvancedSearch->SearchValue = @$_GET["x_perm_perm"];
		if ($this->perm_perm->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->perm_perm->AdvancedSearch->SearchOperator = @$_GET["z_perm_perm"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->pgrp_id->FldIsDetailKey) {
			$this->pgrp_id->setFormValue($objForm->GetValue("x_pgrp_id"));
		}
		$this->pgrp_id->setOldValue($objForm->GetValue("o_pgrp_id"));
		if (!$this->perm_table->FldIsDetailKey) {
			$this->perm_table->setFormValue($objForm->GetValue("x_perm_table"));
		}
		$this->perm_table->setOldValue($objForm->GetValue("o_perm_table"));
		if (!$this->perm_perm->FldIsDetailKey) {
			$this->perm_perm->setFormValue($objForm->GetValue("x_perm_perm"));
		}
		$this->perm_perm->setOldValue($objForm->GetValue("o_perm_perm"));
		if (!$this->perm_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->perm_id->setFormValue($objForm->GetValue("x_perm_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->perm_id->CurrentValue = $this->perm_id->FormValue;
		$this->pgrp_id->CurrentValue = $this->pgrp_id->FormValue;
		$this->perm_table->CurrentValue = $this->perm_table->FormValue;
		$this->perm_perm->CurrentValue = $this->perm_perm->FormValue;
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
		$this->perm_id->setDbValue($row['perm_id']);
		$this->pgrp_id->setDbValue($row['pgrp_id']);
		$this->perm_table->setDbValue($row['perm_table']);
		$this->perm_perm->setDbValue($row['perm_perm']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['perm_id'] = $this->perm_id->CurrentValue;
		$row['pgrp_id'] = $this->pgrp_id->CurrentValue;
		$row['perm_table'] = $this->perm_table->CurrentValue;
		$row['perm_perm'] = $this->perm_perm->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->perm_id->DbValue = $row['perm_id'];
		$this->pgrp_id->DbValue = $row['pgrp_id'];
		$this->perm_table->DbValue = $row['perm_table'];
		$this->perm_perm->DbValue = $row['perm_perm'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("perm_id")) <> "")
			$this->perm_id->CurrentValue = $this->getKey("perm_id"); // perm_id
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// perm_id

		$this->perm_id->CellCssStyle = "white-space: nowrap;";

		// pgrp_id
		// perm_table
		// perm_perm

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// pgrp_id
		if (strval($this->pgrp_id->CurrentValue) <> "") {
			$sFilterWrk = "`pgrp_id`" . ew_SearchString("=", $this->pgrp_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `pgrp_id`, `pgrp_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_pgroup`";
		$sWhereWrk = "";
		$this->pgrp_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pgrp_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pgrp_id->ViewValue = $this->pgrp_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pgrp_id->ViewValue = $this->pgrp_id->CurrentValue;
			}
		} else {
			$this->pgrp_id->ViewValue = NULL;
		}
		$this->pgrp_id->ViewCustomAttributes = "";

		// perm_table
		$this->perm_table->ViewValue = $this->perm_table->CurrentValue;
		$this->perm_table->ViewCustomAttributes = "";

		// perm_perm
		$this->perm_perm->ViewValue = $this->perm_perm->CurrentValue;
		$this->perm_perm->ViewCustomAttributes = "";

			// pgrp_id
			$this->pgrp_id->LinkCustomAttributes = "";
			$this->pgrp_id->HrefValue = "";
			$this->pgrp_id->TooltipValue = "";

			// perm_table
			$this->perm_table->LinkCustomAttributes = "";
			$this->perm_table->HrefValue = "";
			$this->perm_table->TooltipValue = "";
			if ($this->Export == "")
				$this->perm_table->ViewValue = $this->HighlightValue($this->perm_table);

			// perm_perm
			$this->perm_perm->LinkCustomAttributes = "";
			$this->perm_perm->HrefValue = "";
			$this->perm_perm->TooltipValue = "";
			if ($this->Export == "")
				$this->perm_perm->ViewValue = $this->HighlightValue($this->perm_perm);
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pgrp_id
			$this->pgrp_id->EditAttrs["class"] = "form-control";
			$this->pgrp_id->EditCustomAttributes = "";
			if (trim(strval($this->pgrp_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`pgrp_id`" . ew_SearchString("=", $this->pgrp_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `pgrp_id`, `pgrp_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `phs_pgroup`";
			$sWhereWrk = "";
			$this->pgrp_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pgrp_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pgrp_id->EditValue = $arwrk;

			// perm_table
			$this->perm_table->EditAttrs["class"] = "form-control";
			$this->perm_table->EditCustomAttributes = "";
			$this->perm_table->EditValue = ew_HtmlEncode($this->perm_table->CurrentValue);
			$this->perm_table->PlaceHolder = ew_RemoveHtml($this->perm_table->FldCaption());

			// perm_perm
			$this->perm_perm->EditAttrs["class"] = "form-control";
			$this->perm_perm->EditCustomAttributes = "";
			$this->perm_perm->EditValue = ew_HtmlEncode($this->perm_perm->CurrentValue);
			$this->perm_perm->PlaceHolder = ew_RemoveHtml($this->perm_perm->FldCaption());

			// Add refer script
			// pgrp_id

			$this->pgrp_id->LinkCustomAttributes = "";
			$this->pgrp_id->HrefValue = "";

			// perm_table
			$this->perm_table->LinkCustomAttributes = "";
			$this->perm_table->HrefValue = "";

			// perm_perm
			$this->perm_perm->LinkCustomAttributes = "";
			$this->perm_perm->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// pgrp_id
			$this->pgrp_id->EditAttrs["class"] = "form-control";
			$this->pgrp_id->EditCustomAttributes = "";
			if (trim(strval($this->pgrp_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`pgrp_id`" . ew_SearchString("=", $this->pgrp_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `pgrp_id`, `pgrp_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `phs_pgroup`";
			$sWhereWrk = "";
			$this->pgrp_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pgrp_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pgrp_id->EditValue = $arwrk;

			// perm_table
			$this->perm_table->EditAttrs["class"] = "form-control";
			$this->perm_table->EditCustomAttributes = "";
			$this->perm_table->EditValue = ew_HtmlEncode($this->perm_table->CurrentValue);
			$this->perm_table->PlaceHolder = ew_RemoveHtml($this->perm_table->FldCaption());

			// perm_perm
			$this->perm_perm->EditAttrs["class"] = "form-control";
			$this->perm_perm->EditCustomAttributes = "";
			$this->perm_perm->EditValue = ew_HtmlEncode($this->perm_perm->CurrentValue);
			$this->perm_perm->PlaceHolder = ew_RemoveHtml($this->perm_perm->FldCaption());

			// Edit refer script
			// pgrp_id

			$this->pgrp_id->LinkCustomAttributes = "";
			$this->pgrp_id->HrefValue = "";

			// perm_table
			$this->perm_table->LinkCustomAttributes = "";
			$this->perm_table->HrefValue = "";

			// perm_perm
			$this->perm_perm->LinkCustomAttributes = "";
			$this->perm_perm->HrefValue = "";
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->pgrp_id->FldIsDetailKey && !is_null($this->pgrp_id->FormValue) && $this->pgrp_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pgrp_id->FldCaption(), $this->pgrp_id->ReqErrMsg));
		}
		if (!$this->perm_table->FldIsDetailKey && !is_null($this->perm_table->FormValue) && $this->perm_table->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->perm_table->FldCaption(), $this->perm_table->ReqErrMsg));
		}
		if (!$this->perm_perm->FldIsDetailKey && !is_null($this->perm_perm->FormValue) && $this->perm_perm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->perm_perm->FldCaption(), $this->perm_perm->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->perm_perm->FormValue)) {
			ew_AddMessage($gsFormError, $this->perm_perm->FldErrMsg());
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
				$sThisKey .= $row['perm_id'];
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// pgrp_id
			$this->pgrp_id->SetDbValueDef($rsnew, $this->pgrp_id->CurrentValue, 0, $this->pgrp_id->ReadOnly);

			// perm_table
			$this->perm_table->SetDbValueDef($rsnew, $this->perm_table->CurrentValue, "", $this->perm_table->ReadOnly);

			// perm_perm
			$this->perm_perm->SetDbValueDef($rsnew, $this->perm_perm->CurrentValue, 0, $this->perm_perm->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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

		// pgrp_id
		$this->pgrp_id->SetDbValueDef($rsnew, $this->pgrp_id->CurrentValue, 0, FALSE);

		// perm_table
		$this->perm_table->SetDbValueDef($rsnew, $this->perm_table->CurrentValue, "", FALSE);

		// perm_perm
		$this->perm_perm->SetDbValueDef($rsnew, $this->perm_perm->CurrentValue, 0, FALSE);

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->pgrp_id->AdvancedSearch->Load();
		$this->perm_table->AdvancedSearch->Load();
		$this->perm_perm->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_pgrp_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `pgrp_id` AS `LinkFld`, `pgrp_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_pgroup`";
			$sWhereWrk = "";
			$this->pgrp_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`pgrp_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pgrp_id, $sWhereWrk); // Call Lookup Selecting
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($phs_perms_list)) $phs_perms_list = new cphs_perms_list();

// Page init
$phs_perms_list->Page_Init();

// Page main
$phs_perms_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$phs_perms_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fphs_permslist = new ew_Form("fphs_permslist", "list");
fphs_permslist.FormKeyCountName = '<?php echo $phs_perms_list->FormKeyCountName ?>';

// Validate form
fphs_permslist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_pgrp_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_perms->pgrp_id->FldCaption(), $phs_perms->pgrp_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_perm_table");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_perms->perm_table->FldCaption(), $phs_perms->perm_table->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_perm_perm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $phs_perms->perm_perm->FldCaption(), $phs_perms->perm_perm->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_perm_perm");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($phs_perms->perm_perm->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fphs_permslist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "pgrp_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "perm_table", false)) return false;
	if (ew_ValueChanged(fobj, infix, "perm_perm", false)) return false;
	return true;
}

// Form_CustomValidate event
fphs_permslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fphs_permslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fphs_permslist.Lists["x_pgrp_id"] = {"LinkField":"x_pgrp_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pgrp_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_pgroup"};
fphs_permslist.Lists["x_pgrp_id"].Data = "<?php echo $phs_perms_list->pgrp_id->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = fphs_permslistsrch = new ew_Form("fphs_permslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($phs_perms_list->TotalRecs > 0 && $phs_perms_list->ExportOptions->Visible()) { ?>
<?php $phs_perms_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($phs_perms_list->SearchOptions->Visible()) { ?>
<?php $phs_perms_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($phs_perms_list->FilterOptions->Visible()) { ?>
<?php $phs_perms_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
if ($phs_perms->CurrentAction == "gridadd") {
	$phs_perms->CurrentFilter = "0=1";
	$phs_perms_list->StartRec = 1;
	$phs_perms_list->DisplayRecs = $phs_perms->GridAddRowCount;
	$phs_perms_list->TotalRecs = $phs_perms_list->DisplayRecs;
	$phs_perms_list->StopRec = $phs_perms_list->DisplayRecs;
} else {
	$bSelectLimit = $phs_perms_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($phs_perms_list->TotalRecs <= 0)
			$phs_perms_list->TotalRecs = $phs_perms->ListRecordCount();
	} else {
		if (!$phs_perms_list->Recordset && ($phs_perms_list->Recordset = $phs_perms_list->LoadRecordset()))
			$phs_perms_list->TotalRecs = $phs_perms_list->Recordset->RecordCount();
	}
	$phs_perms_list->StartRec = 1;
	if ($phs_perms_list->DisplayRecs <= 0 || ($phs_perms->Export <> "" && $phs_perms->ExportAll)) // Display all records
		$phs_perms_list->DisplayRecs = $phs_perms_list->TotalRecs;
	if (!($phs_perms->Export <> "" && $phs_perms->ExportAll))
		$phs_perms_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$phs_perms_list->Recordset = $phs_perms_list->LoadRecordset($phs_perms_list->StartRec-1, $phs_perms_list->DisplayRecs);

	// Set no record found message
	if ($phs_perms->CurrentAction == "" && $phs_perms_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$phs_perms_list->setWarningMessage(ew_DeniedMsg());
		if ($phs_perms_list->SearchWhere == "0=101")
			$phs_perms_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$phs_perms_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$phs_perms_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($phs_perms->Export == "" && $phs_perms->CurrentAction == "") { ?>
<form name="fphs_permslistsrch" id="fphs_permslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($phs_perms_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fphs_permslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="phs_perms">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($phs_perms_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($phs_perms_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $phs_perms_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($phs_perms_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($phs_perms_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($phs_perms_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($phs_perms_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $phs_perms_list->ShowPageHeader(); ?>
<?php
$phs_perms_list->ShowMessage();
?>
<?php if ($phs_perms_list->TotalRecs > 0 || $phs_perms->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($phs_perms_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> phs_perms">
<div class="box-header ewGridUpperPanel">
<?php if ($phs_perms->CurrentAction <> "gridadd" && $phs_perms->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($phs_perms_list->Pager)) $phs_perms_list->Pager = new cPrevNextPager($phs_perms_list->StartRec, $phs_perms_list->DisplayRecs, $phs_perms_list->TotalRecs, $phs_perms_list->AutoHidePager) ?>
<?php if ($phs_perms_list->Pager->RecordCount > 0 && $phs_perms_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($phs_perms_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($phs_perms_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $phs_perms_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($phs_perms_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($phs_perms_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $phs_perms_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $phs_perms_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $phs_perms_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $phs_perms_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($phs_perms_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fphs_permslist" id="fphs_permslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($phs_perms_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $phs_perms_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="phs_perms">
<div id="gmp_phs_perms" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($phs_perms_list->TotalRecs > 0 || $phs_perms->CurrentAction == "add" || $phs_perms->CurrentAction == "copy" || $phs_perms->CurrentAction == "gridedit") { ?>
<table id="tbl_phs_permslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$phs_perms_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$phs_perms_list->RenderListOptions();

// Render list options (header, left)
$phs_perms_list->ListOptions->Render("header", "left");
?>
<?php if ($phs_perms->pgrp_id->Visible) { // pgrp_id ?>
	<?php if ($phs_perms->SortUrl($phs_perms->pgrp_id) == "") { ?>
		<th data-name="pgrp_id" class="<?php echo $phs_perms->pgrp_id->HeaderCellClass() ?>"><div id="elh_phs_perms_pgrp_id" class="phs_perms_pgrp_id"><div class="ewTableHeaderCaption"><?php echo $phs_perms->pgrp_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pgrp_id" class="<?php echo $phs_perms->pgrp_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $phs_perms->SortUrl($phs_perms->pgrp_id) ?>',1);"><div id="elh_phs_perms_pgrp_id" class="phs_perms_pgrp_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $phs_perms->pgrp_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($phs_perms->pgrp_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($phs_perms->pgrp_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($phs_perms->perm_table->Visible) { // perm_table ?>
	<?php if ($phs_perms->SortUrl($phs_perms->perm_table) == "") { ?>
		<th data-name="perm_table" class="<?php echo $phs_perms->perm_table->HeaderCellClass() ?>"><div id="elh_phs_perms_perm_table" class="phs_perms_perm_table"><div class="ewTableHeaderCaption"><?php echo $phs_perms->perm_table->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="perm_table" class="<?php echo $phs_perms->perm_table->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $phs_perms->SortUrl($phs_perms->perm_table) ?>',1);"><div id="elh_phs_perms_perm_table" class="phs_perms_perm_table">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $phs_perms->perm_table->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($phs_perms->perm_table->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($phs_perms->perm_table->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($phs_perms->perm_perm->Visible) { // perm_perm ?>
	<?php if ($phs_perms->SortUrl($phs_perms->perm_perm) == "") { ?>
		<th data-name="perm_perm" class="<?php echo $phs_perms->perm_perm->HeaderCellClass() ?>"><div id="elh_phs_perms_perm_perm" class="phs_perms_perm_perm"><div class="ewTableHeaderCaption"><?php echo $phs_perms->perm_perm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="perm_perm" class="<?php echo $phs_perms->perm_perm->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $phs_perms->SortUrl($phs_perms->perm_perm) ?>',1);"><div id="elh_phs_perms_perm_perm" class="phs_perms_perm_perm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $phs_perms->perm_perm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($phs_perms->perm_perm->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($phs_perms->perm_perm->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$phs_perms_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($phs_perms->CurrentAction == "add" || $phs_perms->CurrentAction == "copy") {
		$phs_perms_list->RowIndex = 0;
		$phs_perms_list->KeyCount = $phs_perms_list->RowIndex;
		if ($phs_perms->CurrentAction == "copy" && !$phs_perms_list->LoadRow())
			$phs_perms->CurrentAction = "add";
		if ($phs_perms->CurrentAction == "add")
			$phs_perms_list->LoadRowValues();
		if ($phs_perms->EventCancelled) // Insert failed
			$phs_perms_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$phs_perms->ResetAttrs();
		$phs_perms->RowAttrs = array_merge($phs_perms->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_phs_perms', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$phs_perms->RowType = EW_ROWTYPE_ADD;

		// Render row
		$phs_perms_list->RenderRow();

		// Render list options
		$phs_perms_list->RenderListOptions();
		$phs_perms_list->StartRowCnt = 0;
?>
	<tr<?php echo $phs_perms->RowAttributes() ?>>
<?php

// Render list options (body, left)
$phs_perms_list->ListOptions->Render("body", "left", $phs_perms_list->RowCnt);
?>
	<?php if ($phs_perms->pgrp_id->Visible) { // pgrp_id ?>
		<td data-name="pgrp_id">
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_pgrp_id" class="form-group phs_perms_pgrp_id">
<select data-table="phs_perms" data-field="x_pgrp_id" data-value-separator="<?php echo $phs_perms->pgrp_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" name="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id"<?php echo $phs_perms->pgrp_id->EditAttributes() ?>>
<?php echo $phs_perms->pgrp_id->SelectOptionListHtml("x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id") ?>
</select>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_pgrp_id" name="o<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" id="o<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" value="<?php echo ew_HtmlEncode($phs_perms->pgrp_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($phs_perms->perm_table->Visible) { // perm_table ?>
		<td data-name="perm_table">
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_table" class="form-group phs_perms_perm_table">
<input type="text" data-table="phs_perms" data-field="x_perm_table" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_table->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_table->EditValue ?>"<?php echo $phs_perms->perm_table->EditAttributes() ?>>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_perm_table" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_table" value="<?php echo ew_HtmlEncode($phs_perms->perm_table->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($phs_perms->perm_perm->Visible) { // perm_perm ?>
		<td data-name="perm_perm">
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_perm" class="form-group phs_perms_perm_perm">
<input type="text" data-table="phs_perms" data-field="x_perm_perm" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" size="30" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_perm->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_perm->EditValue ?>"<?php echo $phs_perms->perm_perm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_perm_perm" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_perm" value="<?php echo ew_HtmlEncode($phs_perms->perm_perm->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$phs_perms_list->ListOptions->Render("body", "right", $phs_perms_list->RowCnt);
?>
<script type="text/javascript">
fphs_permslist.UpdateOpts(<?php echo $phs_perms_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($phs_perms->ExportAll && $phs_perms->Export <> "") {
	$phs_perms_list->StopRec = $phs_perms_list->TotalRecs;
} else {

	// Set the last record to display
	if ($phs_perms_list->TotalRecs > $phs_perms_list->StartRec + $phs_perms_list->DisplayRecs - 1)
		$phs_perms_list->StopRec = $phs_perms_list->StartRec + $phs_perms_list->DisplayRecs - 1;
	else
		$phs_perms_list->StopRec = $phs_perms_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($phs_perms_list->FormKeyCountName) && ($phs_perms->CurrentAction == "gridadd" || $phs_perms->CurrentAction == "gridedit" || $phs_perms->CurrentAction == "F")) {
		$phs_perms_list->KeyCount = $objForm->GetValue($phs_perms_list->FormKeyCountName);
		$phs_perms_list->StopRec = $phs_perms_list->StartRec + $phs_perms_list->KeyCount - 1;
	}
}
$phs_perms_list->RecCnt = $phs_perms_list->StartRec - 1;
if ($phs_perms_list->Recordset && !$phs_perms_list->Recordset->EOF) {
	$phs_perms_list->Recordset->MoveFirst();
	$bSelectLimit = $phs_perms_list->UseSelectLimit;
	if (!$bSelectLimit && $phs_perms_list->StartRec > 1)
		$phs_perms_list->Recordset->Move($phs_perms_list->StartRec - 1);
} elseif (!$phs_perms->AllowAddDeleteRow && $phs_perms_list->StopRec == 0) {
	$phs_perms_list->StopRec = $phs_perms->GridAddRowCount;
}

// Initialize aggregate
$phs_perms->RowType = EW_ROWTYPE_AGGREGATEINIT;
$phs_perms->ResetAttrs();
$phs_perms_list->RenderRow();
$phs_perms_list->EditRowCnt = 0;
if ($phs_perms->CurrentAction == "edit")
	$phs_perms_list->RowIndex = 1;
if ($phs_perms->CurrentAction == "gridadd")
	$phs_perms_list->RowIndex = 0;
if ($phs_perms->CurrentAction == "gridedit")
	$phs_perms_list->RowIndex = 0;
while ($phs_perms_list->RecCnt < $phs_perms_list->StopRec) {
	$phs_perms_list->RecCnt++;
	if (intval($phs_perms_list->RecCnt) >= intval($phs_perms_list->StartRec)) {
		$phs_perms_list->RowCnt++;
		if ($phs_perms->CurrentAction == "gridadd" || $phs_perms->CurrentAction == "gridedit" || $phs_perms->CurrentAction == "F") {
			$phs_perms_list->RowIndex++;
			$objForm->Index = $phs_perms_list->RowIndex;
			if ($objForm->HasValue($phs_perms_list->FormActionName))
				$phs_perms_list->RowAction = strval($objForm->GetValue($phs_perms_list->FormActionName));
			elseif ($phs_perms->CurrentAction == "gridadd")
				$phs_perms_list->RowAction = "insert";
			else
				$phs_perms_list->RowAction = "";
		}

		// Set up key count
		$phs_perms_list->KeyCount = $phs_perms_list->RowIndex;

		// Init row class and style
		$phs_perms->ResetAttrs();
		$phs_perms->CssClass = "";
		if ($phs_perms->CurrentAction == "gridadd") {
			$phs_perms_list->LoadRowValues(); // Load default values
		} else {
			$phs_perms_list->LoadRowValues($phs_perms_list->Recordset); // Load row values
		}
		$phs_perms->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($phs_perms->CurrentAction == "gridadd") // Grid add
			$phs_perms->RowType = EW_ROWTYPE_ADD; // Render add
		if ($phs_perms->CurrentAction == "gridadd" && $phs_perms->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$phs_perms_list->RestoreCurrentRowFormValues($phs_perms_list->RowIndex); // Restore form values
		if ($phs_perms->CurrentAction == "edit") {
			if ($phs_perms_list->CheckInlineEditKey() && $phs_perms_list->EditRowCnt == 0) { // Inline edit
				$phs_perms->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($phs_perms->CurrentAction == "gridedit") { // Grid edit
			if ($phs_perms->EventCancelled) {
				$phs_perms_list->RestoreCurrentRowFormValues($phs_perms_list->RowIndex); // Restore form values
			}
			if ($phs_perms_list->RowAction == "insert")
				$phs_perms->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$phs_perms->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($phs_perms->CurrentAction == "edit" && $phs_perms->RowType == EW_ROWTYPE_EDIT && $phs_perms->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$phs_perms_list->RestoreFormValues(); // Restore form values
		}
		if ($phs_perms->CurrentAction == "gridedit" && ($phs_perms->RowType == EW_ROWTYPE_EDIT || $phs_perms->RowType == EW_ROWTYPE_ADD) && $phs_perms->EventCancelled) // Update failed
			$phs_perms_list->RestoreCurrentRowFormValues($phs_perms_list->RowIndex); // Restore form values
		if ($phs_perms->RowType == EW_ROWTYPE_EDIT) // Edit row
			$phs_perms_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$phs_perms->RowAttrs = array_merge($phs_perms->RowAttrs, array('data-rowindex'=>$phs_perms_list->RowCnt, 'id'=>'r' . $phs_perms_list->RowCnt . '_phs_perms', 'data-rowtype'=>$phs_perms->RowType));

		// Render row
		$phs_perms_list->RenderRow();

		// Render list options
		$phs_perms_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($phs_perms_list->RowAction <> "delete" && $phs_perms_list->RowAction <> "insertdelete" && !($phs_perms_list->RowAction == "insert" && $phs_perms->CurrentAction == "F" && $phs_perms_list->EmptyRow())) {
?>
	<tr<?php echo $phs_perms->RowAttributes() ?>>
<?php

// Render list options (body, left)
$phs_perms_list->ListOptions->Render("body", "left", $phs_perms_list->RowCnt);
?>
	<?php if ($phs_perms->pgrp_id->Visible) { // pgrp_id ?>
		<td data-name="pgrp_id"<?php echo $phs_perms->pgrp_id->CellAttributes() ?>>
<?php if ($phs_perms->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_pgrp_id" class="form-group phs_perms_pgrp_id">
<select data-table="phs_perms" data-field="x_pgrp_id" data-value-separator="<?php echo $phs_perms->pgrp_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" name="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id"<?php echo $phs_perms->pgrp_id->EditAttributes() ?>>
<?php echo $phs_perms->pgrp_id->SelectOptionListHtml("x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id") ?>
</select>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_pgrp_id" name="o<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" id="o<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" value="<?php echo ew_HtmlEncode($phs_perms->pgrp_id->OldValue) ?>">
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_pgrp_id" class="form-group phs_perms_pgrp_id">
<select data-table="phs_perms" data-field="x_pgrp_id" data-value-separator="<?php echo $phs_perms->pgrp_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" name="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id"<?php echo $phs_perms->pgrp_id->EditAttributes() ?>>
<?php echo $phs_perms->pgrp_id->SelectOptionListHtml("x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id") ?>
</select>
</span>
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_pgrp_id" class="phs_perms_pgrp_id">
<span<?php echo $phs_perms->pgrp_id->ViewAttributes() ?>>
<?php echo $phs_perms->pgrp_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="phs_perms" data-field="x_perm_id" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_id" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_id" value="<?php echo ew_HtmlEncode($phs_perms->perm_id->CurrentValue) ?>">
<input type="hidden" data-table="phs_perms" data-field="x_perm_id" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_id" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_id" value="<?php echo ew_HtmlEncode($phs_perms->perm_id->OldValue) ?>">
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_EDIT || $phs_perms->CurrentMode == "edit") { ?>
<input type="hidden" data-table="phs_perms" data-field="x_perm_id" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_id" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_id" value="<?php echo ew_HtmlEncode($phs_perms->perm_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($phs_perms->perm_table->Visible) { // perm_table ?>
		<td data-name="perm_table"<?php echo $phs_perms->perm_table->CellAttributes() ?>>
<?php if ($phs_perms->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_table" class="form-group phs_perms_perm_table">
<input type="text" data-table="phs_perms" data-field="x_perm_table" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_table->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_table->EditValue ?>"<?php echo $phs_perms->perm_table->EditAttributes() ?>>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_perm_table" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_table" value="<?php echo ew_HtmlEncode($phs_perms->perm_table->OldValue) ?>">
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_table" class="form-group phs_perms_perm_table">
<input type="text" data-table="phs_perms" data-field="x_perm_table" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_table->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_table->EditValue ?>"<?php echo $phs_perms->perm_table->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_table" class="phs_perms_perm_table">
<span<?php echo $phs_perms->perm_table->ViewAttributes() ?>>
<?php echo $phs_perms->perm_table->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($phs_perms->perm_perm->Visible) { // perm_perm ?>
		<td data-name="perm_perm"<?php echo $phs_perms->perm_perm->CellAttributes() ?>>
<?php if ($phs_perms->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_perm" class="form-group phs_perms_perm_perm">
<input type="text" data-table="phs_perms" data-field="x_perm_perm" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" size="30" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_perm->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_perm->EditValue ?>"<?php echo $phs_perms->perm_perm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_perm_perm" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_perm" value="<?php echo ew_HtmlEncode($phs_perms->perm_perm->OldValue) ?>">
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_perm" class="form-group phs_perms_perm_perm">
<input type="text" data-table="phs_perms" data-field="x_perm_perm" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" size="30" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_perm->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_perm->EditValue ?>"<?php echo $phs_perms->perm_perm->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($phs_perms->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $phs_perms_list->RowCnt ?>_phs_perms_perm_perm" class="phs_perms_perm_perm">
<span<?php echo $phs_perms->perm_perm->ViewAttributes() ?>>
<?php echo $phs_perms->perm_perm->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$phs_perms_list->ListOptions->Render("body", "right", $phs_perms_list->RowCnt);
?>
	</tr>
<?php if ($phs_perms->RowType == EW_ROWTYPE_ADD || $phs_perms->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fphs_permslist.UpdateOpts(<?php echo $phs_perms_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($phs_perms->CurrentAction <> "gridadd")
		if (!$phs_perms_list->Recordset->EOF) $phs_perms_list->Recordset->MoveNext();
}
?>
<?php
	if ($phs_perms->CurrentAction == "gridadd" || $phs_perms->CurrentAction == "gridedit") {
		$phs_perms_list->RowIndex = '$rowindex$';
		$phs_perms_list->LoadRowValues();

		// Set row properties
		$phs_perms->ResetAttrs();
		$phs_perms->RowAttrs = array_merge($phs_perms->RowAttrs, array('data-rowindex'=>$phs_perms_list->RowIndex, 'id'=>'r0_phs_perms', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($phs_perms->RowAttrs["class"], "ewTemplate");
		$phs_perms->RowType = EW_ROWTYPE_ADD;

		// Render row
		$phs_perms_list->RenderRow();

		// Render list options
		$phs_perms_list->RenderListOptions();
		$phs_perms_list->StartRowCnt = 0;
?>
	<tr<?php echo $phs_perms->RowAttributes() ?>>
<?php

// Render list options (body, left)
$phs_perms_list->ListOptions->Render("body", "left", $phs_perms_list->RowIndex);
?>
	<?php if ($phs_perms->pgrp_id->Visible) { // pgrp_id ?>
		<td data-name="pgrp_id">
<span id="el$rowindex$_phs_perms_pgrp_id" class="form-group phs_perms_pgrp_id">
<select data-table="phs_perms" data-field="x_pgrp_id" data-value-separator="<?php echo $phs_perms->pgrp_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" name="x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id"<?php echo $phs_perms->pgrp_id->EditAttributes() ?>>
<?php echo $phs_perms->pgrp_id->SelectOptionListHtml("x<?php echo $phs_perms_list->RowIndex ?>_pgrp_id") ?>
</select>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_pgrp_id" name="o<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" id="o<?php echo $phs_perms_list->RowIndex ?>_pgrp_id" value="<?php echo ew_HtmlEncode($phs_perms->pgrp_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($phs_perms->perm_table->Visible) { // perm_table ?>
		<td data-name="perm_table">
<span id="el$rowindex$_phs_perms_perm_table" class="form-group phs_perms_perm_table">
<input type="text" data-table="phs_perms" data-field="x_perm_table" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_table" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_table->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_table->EditValue ?>"<?php echo $phs_perms->perm_table->EditAttributes() ?>>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_perm_table" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_table" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_table" value="<?php echo ew_HtmlEncode($phs_perms->perm_table->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($phs_perms->perm_perm->Visible) { // perm_perm ?>
		<td data-name="perm_perm">
<span id="el$rowindex$_phs_perms_perm_perm" class="form-group phs_perms_perm_perm">
<input type="text" data-table="phs_perms" data-field="x_perm_perm" name="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="x<?php echo $phs_perms_list->RowIndex ?>_perm_perm" size="30" placeholder="<?php echo ew_HtmlEncode($phs_perms->perm_perm->getPlaceHolder()) ?>" value="<?php echo $phs_perms->perm_perm->EditValue ?>"<?php echo $phs_perms->perm_perm->EditAttributes() ?>>
</span>
<input type="hidden" data-table="phs_perms" data-field="x_perm_perm" name="o<?php echo $phs_perms_list->RowIndex ?>_perm_perm" id="o<?php echo $phs_perms_list->RowIndex ?>_perm_perm" value="<?php echo ew_HtmlEncode($phs_perms->perm_perm->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$phs_perms_list->ListOptions->Render("body", "right", $phs_perms_list->RowCnt);
?>
<script type="text/javascript">
fphs_permslist.UpdateOpts(<?php echo $phs_perms_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($phs_perms->CurrentAction == "add" || $phs_perms->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $phs_perms_list->FormKeyCountName ?>" id="<?php echo $phs_perms_list->FormKeyCountName ?>" value="<?php echo $phs_perms_list->KeyCount ?>">
<?php } ?>
<?php if ($phs_perms->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $phs_perms_list->FormKeyCountName ?>" id="<?php echo $phs_perms_list->FormKeyCountName ?>" value="<?php echo $phs_perms_list->KeyCount ?>">
<?php echo $phs_perms_list->MultiSelectKey ?>
<?php } ?>
<?php if ($phs_perms->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $phs_perms_list->FormKeyCountName ?>" id="<?php echo $phs_perms_list->FormKeyCountName ?>" value="<?php echo $phs_perms_list->KeyCount ?>">
<?php } ?>
<?php if ($phs_perms->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $phs_perms_list->FormKeyCountName ?>" id="<?php echo $phs_perms_list->FormKeyCountName ?>" value="<?php echo $phs_perms_list->KeyCount ?>">
<?php echo $phs_perms_list->MultiSelectKey ?>
<?php } ?>
<?php if ($phs_perms->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($phs_perms_list->Recordset)
	$phs_perms_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($phs_perms->CurrentAction <> "gridadd" && $phs_perms->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($phs_perms_list->Pager)) $phs_perms_list->Pager = new cPrevNextPager($phs_perms_list->StartRec, $phs_perms_list->DisplayRecs, $phs_perms_list->TotalRecs, $phs_perms_list->AutoHidePager) ?>
<?php if ($phs_perms_list->Pager->RecordCount > 0 && $phs_perms_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($phs_perms_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($phs_perms_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $phs_perms_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($phs_perms_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($phs_perms_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $phs_perms_list->PageUrl() ?>start=<?php echo $phs_perms_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $phs_perms_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $phs_perms_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $phs_perms_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $phs_perms_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($phs_perms_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($phs_perms_list->TotalRecs == 0 && $phs_perms->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($phs_perms_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fphs_permslistsrch.FilterList = <?php echo $phs_perms_list->GetFilterList() ?>;
fphs_permslistsrch.Init();
fphs_permslist.Init();
</script>
<?php
$phs_perms_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$phs_perms_list->Page_Terminate();
?>
