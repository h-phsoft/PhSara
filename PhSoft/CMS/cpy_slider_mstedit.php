<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_slider_mstinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "cpy_slider_trngridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_slider_mst_edit = NULL; // Initialize page object first

class ccpy_slider_mst_edit extends ccpy_slider_mst {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_slider_mst';

	// Page object name
	var $PageObjName = 'cpy_slider_mst_edit';

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

		// Table object (cpy_slider_mst)
		if (!isset($GLOBALS["cpy_slider_mst"]) || get_class($GLOBALS["cpy_slider_mst"]) == "ccpy_slider_mst") {
			$GLOBALS["cpy_slider_mst"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_slider_mst"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_slider_mst', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("cpy_slider_mstlist.php"));
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
		$this->slid_name->SetVisibility();
		$this->slid_rem->SetVisibility();
		$this->stype_id->SetVisibility();
		$this->scols_id->SetVisibility();

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

			// Process auto fill for detail table 'cpy_slider_trn'
			if (@$_POST["grid"] == "fcpy_slider_trngrid") {
				if (!isset($GLOBALS["cpy_slider_trn_grid"])) $GLOBALS["cpy_slider_trn_grid"] = new ccpy_slider_trn_grid;
				$GLOBALS["cpy_slider_trn_grid"]->Page_Init();
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
		global $EW_EXPORT, $cpy_slider_mst;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_slider_mst);
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
					if ($pageName == "cpy_slider_mstview.php")
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_slid_id")) {
				$this->slid_id->setFormValue($objForm->GetValue("x_slid_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["slid_id"])) {
				$this->slid_id->setQueryStringValue($_GET["slid_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->slid_id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("cpy_slider_mstlist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->slid_id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->slid_id->CurrentValue) == strval($this->Recordset->fields('slid_id'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$this->Recordset->MoveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->LoadRowValues($this->Recordset);

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetupDetailParms();
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("cpy_slider_mstlist.php"); // Return to list page
				} else {
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "cpy_slider_mstlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetupDetailParms();
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->slid_name->FldIsDetailKey) {
			$this->slid_name->setFormValue($objForm->GetValue("x_slid_name"));
		}
		if (!$this->slid_rem->FldIsDetailKey) {
			$this->slid_rem->setFormValue($objForm->GetValue("x_slid_rem"));
		}
		if (!$this->stype_id->FldIsDetailKey) {
			$this->stype_id->setFormValue($objForm->GetValue("x_stype_id"));
		}
		if (!$this->scols_id->FldIsDetailKey) {
			$this->scols_id->setFormValue($objForm->GetValue("x_scols_id"));
		}
		if (!$this->slid_id->FldIsDetailKey)
			$this->slid_id->setFormValue($objForm->GetValue("x_slid_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->slid_id->CurrentValue = $this->slid_id->FormValue;
		$this->slid_name->CurrentValue = $this->slid_name->FormValue;
		$this->slid_rem->CurrentValue = $this->slid_rem->FormValue;
		$this->stype_id->CurrentValue = $this->stype_id->FormValue;
		$this->scols_id->CurrentValue = $this->scols_id->FormValue;
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
		$this->slid_id->setDbValue($row['slid_id']);
		$this->slid_name->setDbValue($row['slid_name']);
		$this->slid_rem->setDbValue($row['slid_rem']);
		$this->stype_id->setDbValue($row['stype_id']);
		$this->scols_id->setDbValue($row['scols_id']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['slid_id'] = NULL;
		$row['slid_name'] = NULL;
		$row['slid_rem'] = NULL;
		$row['stype_id'] = NULL;
		$row['scols_id'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->slid_id->DbValue = $row['slid_id'];
		$this->slid_name->DbValue = $row['slid_name'];
		$this->slid_rem->DbValue = $row['slid_rem'];
		$this->stype_id->DbValue = $row['stype_id'];
		$this->scols_id->DbValue = $row['scols_id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("slid_id")) <> "")
			$this->slid_id->CurrentValue = $this->getKey("slid_id"); // slid_id
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
		// slid_id
		// slid_name
		// slid_rem
		// stype_id
		// scols_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// slid_name
		$this->slid_name->ViewValue = $this->slid_name->CurrentValue;
		$this->slid_name->ViewCustomAttributes = "";

		// slid_rem
		$this->slid_rem->ViewValue = $this->slid_rem->CurrentValue;
		$this->slid_rem->ViewCustomAttributes = "";

		// stype_id
		if (strval($this->stype_id->CurrentValue) <> "") {
			$sFilterWrk = "`stype_jd`" . ew_SearchString("=", $this->stype_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `stype_jd`, `stype_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_slider_type`";
		$sWhereWrk = "";
		$this->stype_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->stype_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->stype_id->ViewValue = $this->stype_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->stype_id->ViewValue = $this->stype_id->CurrentValue;
			}
		} else {
			$this->stype_id->ViewValue = NULL;
		}
		$this->stype_id->ViewCustomAttributes = "";

		// scols_id
		if (strval($this->scols_id->CurrentValue) <> "") {
			$sFilterWrk = "`scols_id`" . ew_SearchString("=", $this->scols_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `scols_id`, `scols_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_slider_cols`";
		$sWhereWrk = "";
		$this->scols_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->scols_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->scols_id->ViewValue = $this->scols_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->scols_id->ViewValue = $this->scols_id->CurrentValue;
			}
		} else {
			$this->scols_id->ViewValue = NULL;
		}
		$this->scols_id->ViewCustomAttributes = "";

			// slid_name
			$this->slid_name->LinkCustomAttributes = "";
			$this->slid_name->HrefValue = "";
			$this->slid_name->TooltipValue = "";

			// slid_rem
			$this->slid_rem->LinkCustomAttributes = "";
			$this->slid_rem->HrefValue = "";
			$this->slid_rem->TooltipValue = "";

			// stype_id
			$this->stype_id->LinkCustomAttributes = "";
			$this->stype_id->HrefValue = "";
			$this->stype_id->TooltipValue = "";

			// scols_id
			$this->scols_id->LinkCustomAttributes = "";
			$this->scols_id->HrefValue = "";
			$this->scols_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// slid_name
			$this->slid_name->EditAttrs["class"] = "form-control";
			$this->slid_name->EditCustomAttributes = "";
			$this->slid_name->EditValue = ew_HtmlEncode($this->slid_name->CurrentValue);
			$this->slid_name->PlaceHolder = ew_RemoveHtml($this->slid_name->FldCaption());

			// slid_rem
			$this->slid_rem->EditAttrs["class"] = "form-control";
			$this->slid_rem->EditCustomAttributes = "";
			$this->slid_rem->EditValue = ew_HtmlEncode($this->slid_rem->CurrentValue);
			$this->slid_rem->PlaceHolder = ew_RemoveHtml($this->slid_rem->FldCaption());

			// stype_id
			$this->stype_id->EditAttrs["class"] = "form-control";
			$this->stype_id->EditCustomAttributes = "";
			if (trim(strval($this->stype_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`stype_jd`" . ew_SearchString("=", $this->stype_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `stype_jd`, `stype_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `phs_slider_type`";
			$sWhereWrk = "";
			$this->stype_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->stype_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->stype_id->EditValue = $arwrk;

			// scols_id
			$this->scols_id->EditAttrs["class"] = "form-control";
			$this->scols_id->EditCustomAttributes = "";
			if (trim(strval($this->scols_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`scols_id`" . ew_SearchString("=", $this->scols_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `scols_id`, `scols_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `phs_slider_cols`";
			$sWhereWrk = "";
			$this->scols_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->scols_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->scols_id->EditValue = $arwrk;

			// Edit refer script
			// slid_name

			$this->slid_name->LinkCustomAttributes = "";
			$this->slid_name->HrefValue = "";

			// slid_rem
			$this->slid_rem->LinkCustomAttributes = "";
			$this->slid_rem->HrefValue = "";

			// stype_id
			$this->stype_id->LinkCustomAttributes = "";
			$this->stype_id->HrefValue = "";

			// scols_id
			$this->scols_id->LinkCustomAttributes = "";
			$this->scols_id->HrefValue = "";
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
		if (!$this->slid_name->FldIsDetailKey && !is_null($this->slid_name->FormValue) && $this->slid_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->slid_name->FldCaption(), $this->slid_name->ReqErrMsg));
		}
		if (!$this->stype_id->FldIsDetailKey && !is_null($this->stype_id->FormValue) && $this->stype_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->stype_id->FldCaption(), $this->stype_id->ReqErrMsg));
		}
		if (!$this->scols_id->FldIsDetailKey && !is_null($this->scols_id->FormValue) && $this->scols_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->scols_id->FldCaption(), $this->scols_id->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cpy_slider_trn", $DetailTblVar) && $GLOBALS["cpy_slider_trn"]->DetailEdit) {
			if (!isset($GLOBALS["cpy_slider_trn_grid"])) $GLOBALS["cpy_slider_trn_grid"] = new ccpy_slider_trn_grid(); // get detail page object
			$GLOBALS["cpy_slider_trn_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// slid_name
			$this->slid_name->SetDbValueDef($rsnew, $this->slid_name->CurrentValue, "", $this->slid_name->ReadOnly);

			// slid_rem
			$this->slid_rem->SetDbValueDef($rsnew, $this->slid_rem->CurrentValue, NULL, $this->slid_rem->ReadOnly);

			// stype_id
			$this->stype_id->SetDbValueDef($rsnew, $this->stype_id->CurrentValue, 0, $this->stype_id->ReadOnly);

			// scols_id
			$this->scols_id->SetDbValueDef($rsnew, $this->scols_id->CurrentValue, 0, $this->scols_id->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("cpy_slider_trn", $DetailTblVar) && $GLOBALS["cpy_slider_trn"]->DetailEdit) {
						if (!isset($GLOBALS["cpy_slider_trn_grid"])) $GLOBALS["cpy_slider_trn_grid"] = new ccpy_slider_trn_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_slider_trn"); // Load user level of detail table
						$EditRow = $GLOBALS["cpy_slider_trn_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if (in_array("cpy_slider_trn", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_slider_trn_grid"]))
					$GLOBALS["cpy_slider_trn_grid"] = new ccpy_slider_trn_grid;
				if ($GLOBALS["cpy_slider_trn_grid"]->DetailEdit) {
					$GLOBALS["cpy_slider_trn_grid"]->CurrentMode = "edit";
					$GLOBALS["cpy_slider_trn_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["cpy_slider_trn_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_slider_trn_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_slider_trn_grid"]->slid_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_slider_trn_grid"]->slid_id->CurrentValue = $this->slid_id->CurrentValue;
					$GLOBALS["cpy_slider_trn_grid"]->slid_id->setSessionValue($GLOBALS["cpy_slider_trn_grid"]->slid_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_slider_mstlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_stype_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `stype_jd` AS `LinkFld`, `stype_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_slider_type`";
			$sWhereWrk = "";
			$this->stype_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`stype_jd` IN ({filter_value})', "t0" => "16", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->stype_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_scols_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `scols_id` AS `LinkFld`, `scols_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `phs_slider_cols`";
			$sWhereWrk = "";
			$this->scols_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`scols_id` IN ({filter_value})', "t0" => "16", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->scols_id, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($cpy_slider_mst_edit)) $cpy_slider_mst_edit = new ccpy_slider_mst_edit();

// Page init
$cpy_slider_mst_edit->Page_Init();

// Page main
$cpy_slider_mst_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_slider_mst_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcpy_slider_mstedit = new ew_Form("fcpy_slider_mstedit", "edit");

// Validate form
fcpy_slider_mstedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_slid_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_slider_mst->slid_name->FldCaption(), $cpy_slider_mst->slid_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_stype_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_slider_mst->stype_id->FldCaption(), $cpy_slider_mst->stype_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_scols_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_slider_mst->scols_id->FldCaption(), $cpy_slider_mst->scols_id->ReqErrMsg)) ?>");

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
fcpy_slider_mstedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_slider_mstedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_slider_mstedit.Lists["x_stype_id"] = {"LinkField":"x_stype_jd","Ajax":true,"AutoFill":false,"DisplayFields":["x_stype_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_slider_type"};
fcpy_slider_mstedit.Lists["x_stype_id"].Data = "<?php echo $cpy_slider_mst_edit->stype_id->LookupFilterQuery(FALSE, "edit") ?>";
fcpy_slider_mstedit.Lists["x_scols_id"] = {"LinkField":"x_scols_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_scols_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"phs_slider_cols"};
fcpy_slider_mstedit.Lists["x_scols_id"].Data = "<?php echo $cpy_slider_mst_edit->scols_id->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_slider_mst_edit->ShowPageHeader(); ?>
<?php
$cpy_slider_mst_edit->ShowMessage();
?>
<?php if (!$cpy_slider_mst_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_slider_mst_edit->Pager)) $cpy_slider_mst_edit->Pager = new cPrevNextPager($cpy_slider_mst_edit->StartRec, $cpy_slider_mst_edit->DisplayRecs, $cpy_slider_mst_edit->TotalRecs, $cpy_slider_mst_edit->AutoHidePager) ?>
<?php if ($cpy_slider_mst_edit->Pager->RecordCount > 0 && $cpy_slider_mst_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_slider_mst_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_slider_mst_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_slider_mst_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_slider_mst_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_slider_mst_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_slider_mst_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcpy_slider_mstedit" id="fcpy_slider_mstedit" class="<?php echo $cpy_slider_mst_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_slider_mst_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_slider_mst_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_slider_mst">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($cpy_slider_mst_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($cpy_slider_mst->slid_name->Visible) { // slid_name ?>
	<div id="r_slid_name" class="form-group">
		<label id="elh_cpy_slider_mst_slid_name" for="x_slid_name" class="<?php echo $cpy_slider_mst_edit->LeftColumnClass ?>"><?php echo $cpy_slider_mst->slid_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_slider_mst_edit->RightColumnClass ?>"><div<?php echo $cpy_slider_mst->slid_name->CellAttributes() ?>>
<span id="el_cpy_slider_mst_slid_name">
<input type="text" data-table="cpy_slider_mst" data-field="x_slid_name" name="x_slid_name" id="x_slid_name" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_slider_mst->slid_name->getPlaceHolder()) ?>" value="<?php echo $cpy_slider_mst->slid_name->EditValue ?>"<?php echo $cpy_slider_mst->slid_name->EditAttributes() ?>>
</span>
<?php echo $cpy_slider_mst->slid_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_slider_mst->slid_rem->Visible) { // slid_rem ?>
	<div id="r_slid_rem" class="form-group">
		<label id="elh_cpy_slider_mst_slid_rem" for="x_slid_rem" class="<?php echo $cpy_slider_mst_edit->LeftColumnClass ?>"><?php echo $cpy_slider_mst->slid_rem->FldCaption() ?></label>
		<div class="<?php echo $cpy_slider_mst_edit->RightColumnClass ?>"><div<?php echo $cpy_slider_mst->slid_rem->CellAttributes() ?>>
<span id="el_cpy_slider_mst_slid_rem">
<input type="text" data-table="cpy_slider_mst" data-field="x_slid_rem" name="x_slid_rem" id="x_slid_rem" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_slider_mst->slid_rem->getPlaceHolder()) ?>" value="<?php echo $cpy_slider_mst->slid_rem->EditValue ?>"<?php echo $cpy_slider_mst->slid_rem->EditAttributes() ?>>
</span>
<?php echo $cpy_slider_mst->slid_rem->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_slider_mst->stype_id->Visible) { // stype_id ?>
	<div id="r_stype_id" class="form-group">
		<label id="elh_cpy_slider_mst_stype_id" for="x_stype_id" class="<?php echo $cpy_slider_mst_edit->LeftColumnClass ?>"><?php echo $cpy_slider_mst->stype_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_slider_mst_edit->RightColumnClass ?>"><div<?php echo $cpy_slider_mst->stype_id->CellAttributes() ?>>
<span id="el_cpy_slider_mst_stype_id">
<select data-table="cpy_slider_mst" data-field="x_stype_id" data-value-separator="<?php echo $cpy_slider_mst->stype_id->DisplayValueSeparatorAttribute() ?>" id="x_stype_id" name="x_stype_id"<?php echo $cpy_slider_mst->stype_id->EditAttributes() ?>>
<?php echo $cpy_slider_mst->stype_id->SelectOptionListHtml("x_stype_id") ?>
</select>
</span>
<?php echo $cpy_slider_mst->stype_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_slider_mst->scols_id->Visible) { // scols_id ?>
	<div id="r_scols_id" class="form-group">
		<label id="elh_cpy_slider_mst_scols_id" for="x_scols_id" class="<?php echo $cpy_slider_mst_edit->LeftColumnClass ?>"><?php echo $cpy_slider_mst->scols_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_slider_mst_edit->RightColumnClass ?>"><div<?php echo $cpy_slider_mst->scols_id->CellAttributes() ?>>
<span id="el_cpy_slider_mst_scols_id">
<select data-table="cpy_slider_mst" data-field="x_scols_id" data-value-separator="<?php echo $cpy_slider_mst->scols_id->DisplayValueSeparatorAttribute() ?>" id="x_scols_id" name="x_scols_id"<?php echo $cpy_slider_mst->scols_id->EditAttributes() ?>>
<?php echo $cpy_slider_mst->scols_id->SelectOptionListHtml("x_scols_id") ?>
</select>
</span>
<?php echo $cpy_slider_mst->scols_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="cpy_slider_mst" data-field="x_slid_id" name="x_slid_id" id="x_slid_id" value="<?php echo ew_HtmlEncode($cpy_slider_mst->slid_id->CurrentValue) ?>">
<?php
	if (in_array("cpy_slider_trn", explode(",", $cpy_slider_mst->getCurrentDetailTable())) && $cpy_slider_trn->DetailEdit) {
?>
<?php if ($cpy_slider_mst->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_slider_trn", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_slider_trngrid.php" ?>
<?php } ?>
<?php if (!$cpy_slider_mst_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_slider_mst_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_slider_mst_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$cpy_slider_mst_edit->IsModal) { ?>
<?php if (!isset($cpy_slider_mst_edit->Pager)) $cpy_slider_mst_edit->Pager = new cPrevNextPager($cpy_slider_mst_edit->StartRec, $cpy_slider_mst_edit->DisplayRecs, $cpy_slider_mst_edit->TotalRecs, $cpy_slider_mst_edit->AutoHidePager) ?>
<?php if ($cpy_slider_mst_edit->Pager->RecordCount > 0 && $cpy_slider_mst_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_slider_mst_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_slider_mst_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_slider_mst_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_slider_mst_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_slider_mst_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_slider_mst_edit->PageUrl() ?>start=<?php echo $cpy_slider_mst_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_slider_mst_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fcpy_slider_mstedit.Init();
</script>
<?php
$cpy_slider_mst_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_slider_mst_edit->Page_Terminate();
?>
