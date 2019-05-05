<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_exhibitioninfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "cpy_exhibition_imagesgridcls.php" ?>
<?php include_once "cpy_exhibition_videogridcls.php" ?>
<?php include_once "cpy_artwork_exhibtiongridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_exhibition_add = NULL; // Initialize page object first

class ccpy_exhibition_add extends ccpy_exhibition {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_exhibition';

	// Page object name
	var $PageObjName = 'cpy_exhibition_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'cpy_exhibition_images'
			if (@$_POST["grid"] == "fcpy_exhibition_imagesgrid") {
				if (!isset($GLOBALS["cpy_exhibition_images_grid"])) $GLOBALS["cpy_exhibition_images_grid"] = new ccpy_exhibition_images_grid;
				$GLOBALS["cpy_exhibition_images_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'cpy_exhibition_video'
			if (@$_POST["grid"] == "fcpy_exhibition_videogrid") {
				if (!isset($GLOBALS["cpy_exhibition_video_grid"])) $GLOBALS["cpy_exhibition_video_grid"] = new ccpy_exhibition_video_grid;
				$GLOBALS["cpy_exhibition_video_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'cpy_artwork_exhibtion'
			if (@$_POST["grid"] == "fcpy_artwork_exhibtiongrid") {
				if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid;
				$GLOBALS["cpy_artwork_exhibtion_grid"]->Page_Init();
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
			if (@$_GET["exhib_id"] != "") {
				$this->exhib_id->setQueryStringValue($_GET["exhib_id"]);
				$this->setKey("exhib_id", $this->exhib_id->CurrentValue); // Set up key
			} else {
				$this->setKey("exhib_id", ""); // Clear key
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
					$this->Page_Terminate("cpy_exhibitionlist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "cpy_exhibitionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_exhibitionview.php")
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
		$this->exhib_image->Upload->Index = $objForm->Index;
		$this->exhib_image->Upload->UploadFile();
		$this->exhib_image->CurrentValue = $this->exhib_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->exhib_id->CurrentValue = NULL;
		$this->exhib_id->OldValue = $this->exhib_id->CurrentValue;
		$this->type_id->CurrentValue = 1;
		$this->kind_id->CurrentValue = 1;
		$this->exhib_year->CurrentValue = NULL;
		$this->exhib_year->OldValue = $this->exhib_year->CurrentValue;
		$this->exhib_title1->CurrentValue = NULL;
		$this->exhib_title1->OldValue = $this->exhib_title1->CurrentValue;
		$this->exhib_title2->CurrentValue = NULL;
		$this->exhib_title2->OldValue = $this->exhib_title2->CurrentValue;
		$this->exhib_date->CurrentValue = NULL;
		$this->exhib_date->OldValue = $this->exhib_date->CurrentValue;
		$this->exhib_from->CurrentValue = "1900-01-01";
		$this->exhib_to->CurrentValue = "1900-01-01";
		$this->exhib_web->CurrentValue = NULL;
		$this->exhib_web->OldValue = $this->exhib_web->CurrentValue;
		$this->exhib_intro->CurrentValue = NULL;
		$this->exhib_intro->OldValue = $this->exhib_intro->CurrentValue;
		$this->exhib_info->CurrentValue = NULL;
		$this->exhib_info->OldValue = $this->exhib_info->CurrentValue;
		$this->exhib_text->CurrentValue = NULL;
		$this->exhib_text->OldValue = $this->exhib_text->CurrentValue;
		$this->exhib_image->Upload->DbValue = NULL;
		$this->exhib_image->OldValue = $this->exhib_image->Upload->DbValue;
		$this->exhib_image->CurrentValue = NULL; // Clear file related field
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->type_id->FldIsDetailKey) {
			$this->type_id->setFormValue($objForm->GetValue("x_type_id"));
		}
		if (!$this->kind_id->FldIsDetailKey) {
			$this->kind_id->setFormValue($objForm->GetValue("x_kind_id"));
		}
		if (!$this->exhib_year->FldIsDetailKey) {
			$this->exhib_year->setFormValue($objForm->GetValue("x_exhib_year"));
		}
		if (!$this->exhib_title1->FldIsDetailKey) {
			$this->exhib_title1->setFormValue($objForm->GetValue("x_exhib_title1"));
		}
		if (!$this->exhib_title2->FldIsDetailKey) {
			$this->exhib_title2->setFormValue($objForm->GetValue("x_exhib_title2"));
		}
		if (!$this->exhib_date->FldIsDetailKey) {
			$this->exhib_date->setFormValue($objForm->GetValue("x_exhib_date"));
			$this->exhib_date->CurrentValue = ew_UnFormatDateTime($this->exhib_date->CurrentValue, 0);
		}
		if (!$this->exhib_from->FldIsDetailKey) {
			$this->exhib_from->setFormValue($objForm->GetValue("x_exhib_from"));
			$this->exhib_from->CurrentValue = ew_UnFormatDateTime($this->exhib_from->CurrentValue, 0);
		}
		if (!$this->exhib_to->FldIsDetailKey) {
			$this->exhib_to->setFormValue($objForm->GetValue("x_exhib_to"));
			$this->exhib_to->CurrentValue = ew_UnFormatDateTime($this->exhib_to->CurrentValue, 0);
		}
		if (!$this->exhib_web->FldIsDetailKey) {
			$this->exhib_web->setFormValue($objForm->GetValue("x_exhib_web"));
		}
		if (!$this->exhib_intro->FldIsDetailKey) {
			$this->exhib_intro->setFormValue($objForm->GetValue("x_exhib_intro"));
		}
		if (!$this->exhib_info->FldIsDetailKey) {
			$this->exhib_info->setFormValue($objForm->GetValue("x_exhib_info"));
		}
		if (!$this->exhib_text->FldIsDetailKey) {
			$this->exhib_text->setFormValue($objForm->GetValue("x_exhib_text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->type_id->CurrentValue = $this->type_id->FormValue;
		$this->kind_id->CurrentValue = $this->kind_id->FormValue;
		$this->exhib_year->CurrentValue = $this->exhib_year->FormValue;
		$this->exhib_title1->CurrentValue = $this->exhib_title1->FormValue;
		$this->exhib_title2->CurrentValue = $this->exhib_title2->FormValue;
		$this->exhib_date->CurrentValue = $this->exhib_date->FormValue;
		$this->exhib_date->CurrentValue = ew_UnFormatDateTime($this->exhib_date->CurrentValue, 0);
		$this->exhib_from->CurrentValue = $this->exhib_from->FormValue;
		$this->exhib_from->CurrentValue = ew_UnFormatDateTime($this->exhib_from->CurrentValue, 0);
		$this->exhib_to->CurrentValue = $this->exhib_to->FormValue;
		$this->exhib_to->CurrentValue = ew_UnFormatDateTime($this->exhib_to->CurrentValue, 0);
		$this->exhib_web->CurrentValue = $this->exhib_web->FormValue;
		$this->exhib_intro->CurrentValue = $this->exhib_intro->FormValue;
		$this->exhib_info->CurrentValue = $this->exhib_info->FormValue;
		$this->exhib_text->CurrentValue = $this->exhib_text->FormValue;
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
		$this->exhib_id->setDbValue($row['exhib_id']);
		$this->type_id->setDbValue($row['type_id']);
		$this->kind_id->setDbValue($row['kind_id']);
		$this->exhib_year->setDbValue($row['exhib_year']);
		$this->exhib_title1->setDbValue($row['exhib_title1']);
		$this->exhib_title2->setDbValue($row['exhib_title2']);
		$this->exhib_date->setDbValue($row['exhib_date']);
		$this->exhib_from->setDbValue($row['exhib_from']);
		$this->exhib_to->setDbValue($row['exhib_to']);
		$this->exhib_web->setDbValue($row['exhib_web']);
		$this->exhib_intro->setDbValue($row['exhib_intro']);
		$this->exhib_info->setDbValue($row['exhib_info']);
		$this->exhib_text->setDbValue($row['exhib_text']);
		$this->exhib_image->Upload->DbValue = $row['exhib_image'];
		$this->exhib_image->CurrentValue = $this->exhib_image->Upload->DbValue;
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['exhib_id'] = $this->exhib_id->CurrentValue;
		$row['type_id'] = $this->type_id->CurrentValue;
		$row['kind_id'] = $this->kind_id->CurrentValue;
		$row['exhib_year'] = $this->exhib_year->CurrentValue;
		$row['exhib_title1'] = $this->exhib_title1->CurrentValue;
		$row['exhib_title2'] = $this->exhib_title2->CurrentValue;
		$row['exhib_date'] = $this->exhib_date->CurrentValue;
		$row['exhib_from'] = $this->exhib_from->CurrentValue;
		$row['exhib_to'] = $this->exhib_to->CurrentValue;
		$row['exhib_web'] = $this->exhib_web->CurrentValue;
		$row['exhib_intro'] = $this->exhib_intro->CurrentValue;
		$row['exhib_info'] = $this->exhib_info->CurrentValue;
		$row['exhib_text'] = $this->exhib_text->CurrentValue;
		$row['exhib_image'] = $this->exhib_image->Upload->DbValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->exhib_id->DbValue = $row['exhib_id'];
		$this->type_id->DbValue = $row['type_id'];
		$this->kind_id->DbValue = $row['kind_id'];
		$this->exhib_year->DbValue = $row['exhib_year'];
		$this->exhib_title1->DbValue = $row['exhib_title1'];
		$this->exhib_title2->DbValue = $row['exhib_title2'];
		$this->exhib_date->DbValue = $row['exhib_date'];
		$this->exhib_from->DbValue = $row['exhib_from'];
		$this->exhib_to->DbValue = $row['exhib_to'];
		$this->exhib_web->DbValue = $row['exhib_web'];
		$this->exhib_intro->DbValue = $row['exhib_intro'];
		$this->exhib_info->DbValue = $row['exhib_info'];
		$this->exhib_text->DbValue = $row['exhib_text'];
		$this->exhib_image->Upload->DbValue = $row['exhib_image'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("exhib_id")) <> "")
			$this->exhib_id->CurrentValue = $this->getKey("exhib_id"); // exhib_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// type_id
			$this->type_id->EditAttrs["class"] = "form-control";
			$this->type_id->EditCustomAttributes = "";
			if (trim(strval($this->type_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`type_id`" . ew_SearchString("=", $this->type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			if (trim(strval($this->kind_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kind_id`" . ew_SearchString("=", $this->kind_id->CurrentValue, EW_DATATYPE_NUMBER, "");
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
			$this->exhib_year->EditValue = ew_HtmlEncode($this->exhib_year->CurrentValue);
			$this->exhib_year->PlaceHolder = ew_RemoveHtml($this->exhib_year->FldCaption());

			// exhib_title1
			$this->exhib_title1->EditAttrs["class"] = "form-control";
			$this->exhib_title1->EditCustomAttributes = "";
			$this->exhib_title1->EditValue = ew_HtmlEncode($this->exhib_title1->CurrentValue);
			$this->exhib_title1->PlaceHolder = ew_RemoveHtml($this->exhib_title1->FldCaption());

			// exhib_title2
			$this->exhib_title2->EditAttrs["class"] = "form-control";
			$this->exhib_title2->EditCustomAttributes = "";
			$this->exhib_title2->EditValue = ew_HtmlEncode($this->exhib_title2->CurrentValue);
			$this->exhib_title2->PlaceHolder = ew_RemoveHtml($this->exhib_title2->FldCaption());

			// exhib_date
			$this->exhib_date->EditAttrs["class"] = "form-control";
			$this->exhib_date->EditCustomAttributes = "";
			$this->exhib_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->exhib_date->CurrentValue, 8));
			$this->exhib_date->PlaceHolder = ew_RemoveHtml($this->exhib_date->FldCaption());

			// exhib_from
			$this->exhib_from->EditAttrs["class"] = "form-control";
			$this->exhib_from->EditCustomAttributes = "";
			$this->exhib_from->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->exhib_from->CurrentValue, 8));
			$this->exhib_from->PlaceHolder = ew_RemoveHtml($this->exhib_from->FldCaption());

			// exhib_to
			$this->exhib_to->EditAttrs["class"] = "form-control";
			$this->exhib_to->EditCustomAttributes = "";
			$this->exhib_to->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->exhib_to->CurrentValue, 8));
			$this->exhib_to->PlaceHolder = ew_RemoveHtml($this->exhib_to->FldCaption());

			// exhib_web
			$this->exhib_web->EditAttrs["class"] = "form-control";
			$this->exhib_web->EditCustomAttributes = "";
			$this->exhib_web->EditValue = ew_HtmlEncode($this->exhib_web->CurrentValue);
			$this->exhib_web->PlaceHolder = ew_RemoveHtml($this->exhib_web->FldCaption());

			// exhib_intro
			$this->exhib_intro->EditAttrs["class"] = "form-control";
			$this->exhib_intro->EditCustomAttributes = "";
			$this->exhib_intro->EditValue = ew_HtmlEncode($this->exhib_intro->CurrentValue);
			$this->exhib_intro->PlaceHolder = ew_RemoveHtml($this->exhib_intro->FldCaption());

			// exhib_info
			$this->exhib_info->EditAttrs["class"] = "form-control";
			$this->exhib_info->EditCustomAttributes = "";
			$this->exhib_info->EditValue = ew_HtmlEncode($this->exhib_info->CurrentValue);
			$this->exhib_info->PlaceHolder = ew_RemoveHtml($this->exhib_info->FldCaption());

			// exhib_text
			$this->exhib_text->EditAttrs["class"] = "form-control";
			$this->exhib_text->EditCustomAttributes = "";
			$this->exhib_text->EditValue = ew_HtmlEncode($this->exhib_text->CurrentValue);
			$this->exhib_text->PlaceHolder = ew_RemoveHtml($this->exhib_text->FldCaption());

			// exhib_image
			$this->exhib_image->EditAttrs["class"] = "form-control";
			$this->exhib_image->EditCustomAttributes = "";
			$this->exhib_image->UploadPath = '../../assets/img/uploads/';
			if (!ew_Empty($this->exhib_image->Upload->DbValue)) {
				$this->exhib_image->ImageWidth = 100;
				$this->exhib_image->ImageHeight = 0;
				$this->exhib_image->ImageAlt = $this->exhib_image->FldAlt();
				$this->exhib_image->EditValue = $this->exhib_image->Upload->DbValue;
			} else {
				$this->exhib_image->EditValue = "";
			}
			if (!ew_Empty($this->exhib_image->CurrentValue))
				$this->exhib_image->Upload->FileName = $this->exhib_image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->exhib_image);

			// Add refer script
			// type_id

			$this->type_id->LinkCustomAttributes = "";
			$this->type_id->HrefValue = "";

			// kind_id
			$this->kind_id->LinkCustomAttributes = "";
			$this->kind_id->HrefValue = "";

			// exhib_year
			$this->exhib_year->LinkCustomAttributes = "";
			$this->exhib_year->HrefValue = "";

			// exhib_title1
			$this->exhib_title1->LinkCustomAttributes = "";
			$this->exhib_title1->HrefValue = "";

			// exhib_title2
			$this->exhib_title2->LinkCustomAttributes = "";
			$this->exhib_title2->HrefValue = "";

			// exhib_date
			$this->exhib_date->LinkCustomAttributes = "";
			$this->exhib_date->HrefValue = "";

			// exhib_from
			$this->exhib_from->LinkCustomAttributes = "";
			$this->exhib_from->HrefValue = "";

			// exhib_to
			$this->exhib_to->LinkCustomAttributes = "";
			$this->exhib_to->HrefValue = "";

			// exhib_web
			$this->exhib_web->LinkCustomAttributes = "";
			$this->exhib_web->HrefValue = "";

			// exhib_intro
			$this->exhib_intro->LinkCustomAttributes = "";
			$this->exhib_intro->HrefValue = "";

			// exhib_info
			$this->exhib_info->LinkCustomAttributes = "";
			$this->exhib_info->HrefValue = "";

			// exhib_text
			$this->exhib_text->LinkCustomAttributes = "";
			$this->exhib_text->HrefValue = "";

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
		if (!$this->type_id->FldIsDetailKey && !is_null($this->type_id->FormValue) && $this->type_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->type_id->FldCaption(), $this->type_id->ReqErrMsg));
		}
		if (!$this->kind_id->FldIsDetailKey && !is_null($this->kind_id->FormValue) && $this->kind_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kind_id->FldCaption(), $this->kind_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->exhib_year->FormValue)) {
			ew_AddMessage($gsFormError, $this->exhib_year->FldErrMsg());
		}
		if (!$this->exhib_title1->FldIsDetailKey && !is_null($this->exhib_title1->FormValue) && $this->exhib_title1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->exhib_title1->FldCaption(), $this->exhib_title1->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->exhib_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->exhib_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->exhib_from->FormValue)) {
			ew_AddMessage($gsFormError, $this->exhib_from->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->exhib_to->FormValue)) {
			ew_AddMessage($gsFormError, $this->exhib_to->FldErrMsg());
		}
		if ($this->exhib_image->Upload->FileName == "" && !$this->exhib_image->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->exhib_image->FldCaption(), $this->exhib_image->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cpy_exhibition_images", $DetailTblVar) && $GLOBALS["cpy_exhibition_images"]->DetailAdd) {
			if (!isset($GLOBALS["cpy_exhibition_images_grid"])) $GLOBALS["cpy_exhibition_images_grid"] = new ccpy_exhibition_images_grid(); // get detail page object
			$GLOBALS["cpy_exhibition_images_grid"]->ValidateGridForm();
		}
		if (in_array("cpy_exhibition_video", $DetailTblVar) && $GLOBALS["cpy_exhibition_video"]->DetailAdd) {
			if (!isset($GLOBALS["cpy_exhibition_video_grid"])) $GLOBALS["cpy_exhibition_video_grid"] = new ccpy_exhibition_video_grid(); // get detail page object
			$GLOBALS["cpy_exhibition_video_grid"]->ValidateGridForm();
		}
		if (in_array("cpy_artwork_exhibtion", $DetailTblVar) && $GLOBALS["cpy_artwork_exhibtion"]->DetailAdd) {
			if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid(); // get detail page object
			$GLOBALS["cpy_artwork_exhibtion_grid"]->ValidateGridForm();
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
			$this->exhib_image->OldUploadPath = '../../assets/img/uploads/';
			$this->exhib_image->UploadPath = $this->exhib_image->OldUploadPath;
		}
		$rsnew = array();

		// type_id
		$this->type_id->SetDbValueDef($rsnew, $this->type_id->CurrentValue, 0, strval($this->type_id->CurrentValue) == "");

		// kind_id
		$this->kind_id->SetDbValueDef($rsnew, $this->kind_id->CurrentValue, 0, strval($this->kind_id->CurrentValue) == "");

		// exhib_year
		$this->exhib_year->SetDbValueDef($rsnew, $this->exhib_year->CurrentValue, NULL, FALSE);

		// exhib_title1
		$this->exhib_title1->SetDbValueDef($rsnew, $this->exhib_title1->CurrentValue, "", FALSE);

		// exhib_title2
		$this->exhib_title2->SetDbValueDef($rsnew, $this->exhib_title2->CurrentValue, NULL, FALSE);

		// exhib_date
		$this->exhib_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->exhib_date->CurrentValue, 0), NULL, FALSE);

		// exhib_from
		$this->exhib_from->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->exhib_from->CurrentValue, 0), NULL, FALSE);

		// exhib_to
		$this->exhib_to->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->exhib_to->CurrentValue, 0), NULL, FALSE);

		// exhib_web
		$this->exhib_web->SetDbValueDef($rsnew, $this->exhib_web->CurrentValue, NULL, FALSE);

		// exhib_intro
		$this->exhib_intro->SetDbValueDef($rsnew, $this->exhib_intro->CurrentValue, NULL, FALSE);

		// exhib_info
		$this->exhib_info->SetDbValueDef($rsnew, $this->exhib_info->CurrentValue, NULL, FALSE);

		// exhib_text
		$this->exhib_text->SetDbValueDef($rsnew, $this->exhib_text->CurrentValue, NULL, FALSE);

		// exhib_image
		if ($this->exhib_image->Visible && !$this->exhib_image->Upload->KeepFile) {
			$this->exhib_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->exhib_image->Upload->FileName == "") {
				$rsnew['exhib_image'] = NULL;
			} else {
				$rsnew['exhib_image'] = $this->exhib_image->Upload->FileName;
			}
		}
		if ($this->exhib_image->Visible && !$this->exhib_image->Upload->KeepFile) {
			$this->exhib_image->UploadPath = '../../assets/img/uploads/';
			if (!ew_Empty($this->exhib_image->Upload->Value)) {
				$rsnew['exhib_image'] = ew_UploadFileNameEx($this->exhib_image->PhysicalUploadPath(), $rsnew['exhib_image']); // Get new file name
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
				if ($this->exhib_image->Visible && !$this->exhib_image->Upload->KeepFile) {
					if (!ew_Empty($this->exhib_image->Upload->Value)) {
						if (!$this->exhib_image->Upload->SaveToFile($rsnew['exhib_image'], TRUE)) {
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
			if (in_array("cpy_exhibition_images", $DetailTblVar) && $GLOBALS["cpy_exhibition_images"]->DetailAdd) {
				$GLOBALS["cpy_exhibition_images"]->exhib_id->setSessionValue($this->exhib_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["cpy_exhibition_images_grid"])) $GLOBALS["cpy_exhibition_images_grid"] = new ccpy_exhibition_images_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_exhibition_images"); // Load user level of detail table
				$AddRow = $GLOBALS["cpy_exhibition_images_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["cpy_exhibition_images"]->exhib_id->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("cpy_exhibition_video", $DetailTblVar) && $GLOBALS["cpy_exhibition_video"]->DetailAdd) {
				$GLOBALS["cpy_exhibition_video"]->exhib_id->setSessionValue($this->exhib_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["cpy_exhibition_video_grid"])) $GLOBALS["cpy_exhibition_video_grid"] = new ccpy_exhibition_video_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_exhibition_video"); // Load user level of detail table
				$AddRow = $GLOBALS["cpy_exhibition_video_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["cpy_exhibition_video"]->exhib_id->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("cpy_artwork_exhibtion", $DetailTblVar) && $GLOBALS["cpy_artwork_exhibtion"]->DetailAdd) {
				$GLOBALS["cpy_artwork_exhibtion"]->exhib_id->setSessionValue($this->exhib_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "cpy_artwork_exhibtion"); // Load user level of detail table
				$AddRow = $GLOBALS["cpy_artwork_exhibtion_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["cpy_artwork_exhibtion"]->exhib_id->setSessionValue(""); // Clear master key if insert failed
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

		// exhib_image
		ew_CleanUploadTempPath($this->exhib_image, $this->exhib_image->Upload->Index);
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
			if (in_array("cpy_exhibition_images", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_exhibition_images_grid"]))
					$GLOBALS["cpy_exhibition_images_grid"] = new ccpy_exhibition_images_grid;
				if ($GLOBALS["cpy_exhibition_images_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cpy_exhibition_images_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cpy_exhibition_images_grid"]->CurrentMode = "add";
					$GLOBALS["cpy_exhibition_images_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cpy_exhibition_images_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_exhibition_images_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_exhibition_images_grid"]->exhib_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_exhibition_images_grid"]->exhib_id->CurrentValue = $this->exhib_id->CurrentValue;
					$GLOBALS["cpy_exhibition_images_grid"]->exhib_id->setSessionValue($GLOBALS["cpy_exhibition_images_grid"]->exhib_id->CurrentValue);
				}
			}
			if (in_array("cpy_exhibition_video", $DetailTblVar)) {
				if (!isset($GLOBALS["cpy_exhibition_video_grid"]))
					$GLOBALS["cpy_exhibition_video_grid"] = new ccpy_exhibition_video_grid;
				if ($GLOBALS["cpy_exhibition_video_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cpy_exhibition_video_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cpy_exhibition_video_grid"]->CurrentMode = "add";
					$GLOBALS["cpy_exhibition_video_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cpy_exhibition_video_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cpy_exhibition_video_grid"]->setStartRecordNumber(1);
					$GLOBALS["cpy_exhibition_video_grid"]->exhib_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_exhibition_video_grid"]->exhib_id->CurrentValue = $this->exhib_id->CurrentValue;
					$GLOBALS["cpy_exhibition_video_grid"]->exhib_id->setSessionValue($GLOBALS["cpy_exhibition_video_grid"]->exhib_id->CurrentValue);
				}
			}
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
					$GLOBALS["cpy_artwork_exhibtion_grid"]->exhib_id->FldIsDetailKey = TRUE;
					$GLOBALS["cpy_artwork_exhibtion_grid"]->exhib_id->CurrentValue = $this->exhib_id->CurrentValue;
					$GLOBALS["cpy_artwork_exhibtion_grid"]->exhib_id->setSessionValue($GLOBALS["cpy_artwork_exhibtion_grid"]->exhib_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_exhibitionlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cpy_exhibition_add)) $cpy_exhibition_add = new ccpy_exhibition_add();

// Page init
$cpy_exhibition_add->Page_Init();

// Page main
$cpy_exhibition_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_exhibition_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_exhibitionadd = new ew_Form("fcpy_exhibitionadd", "add");

// Validate form
fcpy_exhibitionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_type_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition->type_id->FldCaption(), $cpy_exhibition->type_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kind_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition->kind_id->FldCaption(), $cpy_exhibition->kind_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_exhib_year");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_year->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_exhib_title1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition->exhib_title1->FldCaption(), $cpy_exhibition->exhib_title1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_exhib_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_exhib_from");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_from->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_exhib_to");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_exhibition->exhib_to->FldErrMsg()) ?>");
			felm = this.GetElements("x" + infix + "_exhib_image");
			elm = this.GetElements("fn_x" + infix + "_exhib_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_exhibition->exhib_image->FldCaption(), $cpy_exhibition->exhib_image->ReqErrMsg)) ?>");

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
fcpy_exhibitionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_exhibitionadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_exhibitionadd.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibtype"};
fcpy_exhibitionadd.Lists["x_type_id"].Data = "<?php echo $cpy_exhibition_add->type_id->LookupFilterQuery(FALSE, "add") ?>";
fcpy_exhibitionadd.Lists["x_kind_id"] = {"LinkField":"x_kind_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kind_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibkind"};
fcpy_exhibitionadd.Lists["x_kind_id"].Data = "<?php echo $cpy_exhibition_add->kind_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_exhibition_add->ShowPageHeader(); ?>
<?php
$cpy_exhibition_add->ShowMessage();
?>
<form name="fcpy_exhibitionadd" id="fcpy_exhibitionadd" class="<?php echo $cpy_exhibition_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_exhibition_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_exhibition_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_exhibition">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_exhibition_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_exhibition->type_id->Visible) { // type_id ?>
	<div id="r_type_id" class="form-group">
		<label id="elh_cpy_exhibition_type_id" for="x_type_id" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->type_id->CellAttributes() ?>>
<span id="el_cpy_exhibition_type_id">
<select data-table="cpy_exhibition" data-field="x_type_id" data-value-separator="<?php echo $cpy_exhibition->type_id->DisplayValueSeparatorAttribute() ?>" id="x_type_id" name="x_type_id"<?php echo $cpy_exhibition->type_id->EditAttributes() ?>>
<?php echo $cpy_exhibition->type_id->SelectOptionListHtml("x_type_id") ?>
</select>
</span>
<?php echo $cpy_exhibition->type_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->kind_id->Visible) { // kind_id ?>
	<div id="r_kind_id" class="form-group">
		<label id="elh_cpy_exhibition_kind_id" for="x_kind_id" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->kind_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->kind_id->CellAttributes() ?>>
<span id="el_cpy_exhibition_kind_id">
<select data-table="cpy_exhibition" data-field="x_kind_id" data-value-separator="<?php echo $cpy_exhibition->kind_id->DisplayValueSeparatorAttribute() ?>" id="x_kind_id" name="x_kind_id"<?php echo $cpy_exhibition->kind_id->EditAttributes() ?>>
<?php echo $cpy_exhibition->kind_id->SelectOptionListHtml("x_kind_id") ?>
</select>
</span>
<?php echo $cpy_exhibition->kind_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_year->Visible) { // exhib_year ?>
	<div id="r_exhib_year" class="form-group">
		<label id="elh_cpy_exhibition_exhib_year" for="x_exhib_year" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_year->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_year->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_year">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_year" name="x_exhib_year" id="x_exhib_year" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_year->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_year->EditValue ?>"<?php echo $cpy_exhibition->exhib_year->EditAttributes() ?>>
</span>
<?php echo $cpy_exhibition->exhib_year->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title1->Visible) { // exhib_title1 ?>
	<div id="r_exhib_title1" class="form-group">
		<label id="elh_cpy_exhibition_exhib_title1" for="x_exhib_title1" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_title1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_title1->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_title1">
<textarea data-table="cpy_exhibition" data-field="x_exhib_title1" name="x_exhib_title1" id="x_exhib_title1" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_title1->getPlaceHolder()) ?>"<?php echo $cpy_exhibition->exhib_title1->EditAttributes() ?>><?php echo $cpy_exhibition->exhib_title1->EditValue ?></textarea>
</span>
<?php echo $cpy_exhibition->exhib_title1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title2->Visible) { // exhib_title2 ?>
	<div id="r_exhib_title2" class="form-group">
		<label id="elh_cpy_exhibition_exhib_title2" for="x_exhib_title2" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_title2->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_title2->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_title2">
<textarea data-table="cpy_exhibition" data-field="x_exhib_title2" name="x_exhib_title2" id="x_exhib_title2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_title2->getPlaceHolder()) ?>"<?php echo $cpy_exhibition->exhib_title2->EditAttributes() ?>><?php echo $cpy_exhibition->exhib_title2->EditValue ?></textarea>
</span>
<?php echo $cpy_exhibition->exhib_title2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_date->Visible) { // exhib_date ?>
	<div id="r_exhib_date" class="form-group">
		<label id="elh_cpy_exhibition_exhib_date" for="x_exhib_date" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_date->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_date->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_date">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_date" name="x_exhib_date" id="x_exhib_date" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_date->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_date->EditValue ?>"<?php echo $cpy_exhibition->exhib_date->EditAttributes() ?>>
<?php if (!$cpy_exhibition->exhib_date->ReadOnly && !$cpy_exhibition->exhib_date->Disabled && !isset($cpy_exhibition->exhib_date->EditAttrs["readonly"]) && !isset($cpy_exhibition->exhib_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_exhibitionadd", "x_exhib_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
<?php echo $cpy_exhibition->exhib_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_from->Visible) { // exhib_from ?>
	<div id="r_exhib_from" class="form-group">
		<label id="elh_cpy_exhibition_exhib_from" for="x_exhib_from" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_from->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_from->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_from">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_from" name="x_exhib_from" id="x_exhib_from" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_from->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_from->EditValue ?>"<?php echo $cpy_exhibition->exhib_from->EditAttributes() ?>>
<?php if (!$cpy_exhibition->exhib_from->ReadOnly && !$cpy_exhibition->exhib_from->Disabled && !isset($cpy_exhibition->exhib_from->EditAttrs["readonly"]) && !isset($cpy_exhibition->exhib_from->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_exhibitionadd", "x_exhib_from", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
<?php echo $cpy_exhibition->exhib_from->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_to->Visible) { // exhib_to ?>
	<div id="r_exhib_to" class="form-group">
		<label id="elh_cpy_exhibition_exhib_to" for="x_exhib_to" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_to->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_to->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_to">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_to" name="x_exhib_to" id="x_exhib_to" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_to->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_to->EditValue ?>"<?php echo $cpy_exhibition->exhib_to->EditAttributes() ?>>
<?php if (!$cpy_exhibition->exhib_to->ReadOnly && !$cpy_exhibition->exhib_to->Disabled && !isset($cpy_exhibition->exhib_to->EditAttrs["readonly"]) && !isset($cpy_exhibition->exhib_to->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_exhibitionadd", "x_exhib_to", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
<?php echo $cpy_exhibition->exhib_to->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_web->Visible) { // exhib_web ?>
	<div id="r_exhib_web" class="form-group">
		<label id="elh_cpy_exhibition_exhib_web" for="x_exhib_web" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_web->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_web->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_web">
<input type="text" data-table="cpy_exhibition" data-field="x_exhib_web" name="x_exhib_web" id="x_exhib_web" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_web->getPlaceHolder()) ?>" value="<?php echo $cpy_exhibition->exhib_web->EditValue ?>"<?php echo $cpy_exhibition->exhib_web->EditAttributes() ?>>
</span>
<?php echo $cpy_exhibition->exhib_web->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_intro->Visible) { // exhib_intro ?>
	<div id="r_exhib_intro" class="form-group">
		<label id="elh_cpy_exhibition_exhib_intro" for="x_exhib_intro" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_intro->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_intro->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_intro">
<textarea data-table="cpy_exhibition" data-field="x_exhib_intro" name="x_exhib_intro" id="x_exhib_intro" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_intro->getPlaceHolder()) ?>"<?php echo $cpy_exhibition->exhib_intro->EditAttributes() ?>><?php echo $cpy_exhibition->exhib_intro->EditValue ?></textarea>
</span>
<?php echo $cpy_exhibition->exhib_intro->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_info->Visible) { // exhib_info ?>
	<div id="r_exhib_info" class="form-group">
		<label id="elh_cpy_exhibition_exhib_info" for="x_exhib_info" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_info->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_info->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_info">
<textarea data-table="cpy_exhibition" data-field="x_exhib_info" name="x_exhib_info" id="x_exhib_info" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_info->getPlaceHolder()) ?>"<?php echo $cpy_exhibition->exhib_info->EditAttributes() ?>><?php echo $cpy_exhibition->exhib_info->EditValue ?></textarea>
</span>
<?php echo $cpy_exhibition->exhib_info->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_text->Visible) { // exhib_text ?>
	<div id="r_exhib_text" class="form-group">
		<label id="elh_cpy_exhibition_exhib_text" for="x_exhib_text" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_text->FldCaption() ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_text->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_text">
<textarea data-table="cpy_exhibition" data-field="x_exhib_text" name="x_exhib_text" id="x_exhib_text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_exhibition->exhib_text->getPlaceHolder()) ?>"<?php echo $cpy_exhibition->exhib_text->EditAttributes() ?>><?php echo $cpy_exhibition->exhib_text->EditValue ?></textarea>
</span>
<?php echo $cpy_exhibition->exhib_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_exhibition->exhib_image->Visible) { // exhib_image ?>
	<div id="r_exhib_image" class="form-group">
		<label id="elh_cpy_exhibition_exhib_image" class="<?php echo $cpy_exhibition_add->LeftColumnClass ?>"><?php echo $cpy_exhibition->exhib_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_exhibition_add->RightColumnClass ?>"><div<?php echo $cpy_exhibition->exhib_image->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_image">
<div id="fd_x_exhib_image">
<span title="<?php echo $cpy_exhibition->exhib_image->FldTitle() ? $cpy_exhibition->exhib_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_exhibition->exhib_image->ReadOnly || $cpy_exhibition->exhib_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_exhibition" data-field="x_exhib_image" name="x_exhib_image" id="x_exhib_image"<?php echo $cpy_exhibition->exhib_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_exhib_image" id= "fn_x_exhib_image" value="<?php echo $cpy_exhibition->exhib_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_exhib_image" id= "fa_x_exhib_image" value="0">
<input type="hidden" name="fs_x_exhib_image" id= "fs_x_exhib_image" value="1000">
<input type="hidden" name="fx_x_exhib_image" id= "fx_x_exhib_image" value="<?php echo $cpy_exhibition->exhib_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_exhib_image" id= "fm_x_exhib_image" value="<?php echo $cpy_exhibition->exhib_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_exhib_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_exhibition->exhib_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("cpy_exhibition_images", explode(",", $cpy_exhibition->getCurrentDetailTable())) && $cpy_exhibition_images->DetailAdd) {
?>
<?php if ($cpy_exhibition->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_exhibition_images", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_exhibition_imagesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("cpy_exhibition_video", explode(",", $cpy_exhibition->getCurrentDetailTable())) && $cpy_exhibition_video->DetailAdd) {
?>
<?php if ($cpy_exhibition->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_exhibition_video", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_exhibition_videogrid.php" ?>
<?php } ?>
<?php
	if (in_array("cpy_artwork_exhibtion", explode(",", $cpy_exhibition->getCurrentDetailTable())) && $cpy_artwork_exhibtion->DetailAdd) {
?>
<?php if ($cpy_exhibition->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_artwork_exhibtion", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_artwork_exhibtiongrid.php" ?>
<?php } ?>
<?php if (!$cpy_exhibition_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_exhibition_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_exhibition_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_exhibitionadd.Init();
</script>
<?php
$cpy_exhibition_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_exhibition_add->Page_Terminate();
?>
