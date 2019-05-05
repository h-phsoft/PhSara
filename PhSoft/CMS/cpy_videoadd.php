<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_videoinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_video_add = NULL; // Initialize page object first

class ccpy_video_add extends ccpy_video {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_video';

	// Page object name
	var $PageObjName = 'cpy_video_add';

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

		// Table object (cpy_video)
		if (!isset($GLOBALS["cpy_video"]) || get_class($GLOBALS["cpy_video"]) == "ccpy_video") {
			$GLOBALS["cpy_video"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_video"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_video', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_videolist.php"));
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
		$this->video_date->SetVisibility();
		$this->video_title1->SetVisibility();
		$this->video_title2->SetVisibility();
		$this->video_URL->SetVisibility();
		$this->video_text->SetVisibility();

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
		global $EW_EXPORT, $cpy_video;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_video);
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
					if ($pageName == "cpy_videoview.php")
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
			if (@$_GET["video_id"] != "") {
				$this->video_id->setQueryStringValue($_GET["video_id"]);
				$this->setKey("video_id", $this->video_id->CurrentValue); // Set up key
			} else {
				$this->setKey("video_id", ""); // Clear key
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
					$this->Page_Terminate("cpy_videolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_videolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_videoview.php")
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
		$this->video_id->CurrentValue = NULL;
		$this->video_id->OldValue = $this->video_id->CurrentValue;
		$this->video_date->CurrentValue = NULL;
		$this->video_date->OldValue = $this->video_date->CurrentValue;
		$this->video_title1->CurrentValue = NULL;
		$this->video_title1->OldValue = $this->video_title1->CurrentValue;
		$this->video_title2->CurrentValue = NULL;
		$this->video_title2->OldValue = $this->video_title2->CurrentValue;
		$this->video_URL->CurrentValue = NULL;
		$this->video_URL->OldValue = $this->video_URL->CurrentValue;
		$this->video_text->CurrentValue = NULL;
		$this->video_text->OldValue = $this->video_text->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->video_date->FldIsDetailKey) {
			$this->video_date->setFormValue($objForm->GetValue("x_video_date"));
			$this->video_date->CurrentValue = ew_UnFormatDateTime($this->video_date->CurrentValue, 0);
		}
		if (!$this->video_title1->FldIsDetailKey) {
			$this->video_title1->setFormValue($objForm->GetValue("x_video_title1"));
		}
		if (!$this->video_title2->FldIsDetailKey) {
			$this->video_title2->setFormValue($objForm->GetValue("x_video_title2"));
		}
		if (!$this->video_URL->FldIsDetailKey) {
			$this->video_URL->setFormValue($objForm->GetValue("x_video_URL"));
		}
		if (!$this->video_text->FldIsDetailKey) {
			$this->video_text->setFormValue($objForm->GetValue("x_video_text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->video_date->CurrentValue = $this->video_date->FormValue;
		$this->video_date->CurrentValue = ew_UnFormatDateTime($this->video_date->CurrentValue, 0);
		$this->video_title1->CurrentValue = $this->video_title1->FormValue;
		$this->video_title2->CurrentValue = $this->video_title2->FormValue;
		$this->video_URL->CurrentValue = $this->video_URL->FormValue;
		$this->video_text->CurrentValue = $this->video_text->FormValue;
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
		$this->video_id->setDbValue($row['video_id']);
		$this->video_date->setDbValue($row['video_date']);
		$this->video_title1->setDbValue($row['video_title1']);
		$this->video_title2->setDbValue($row['video_title2']);
		$this->video_URL->setDbValue($row['video_URL']);
		$this->video_text->setDbValue($row['video_text']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['video_id'] = $this->video_id->CurrentValue;
		$row['video_date'] = $this->video_date->CurrentValue;
		$row['video_title1'] = $this->video_title1->CurrentValue;
		$row['video_title2'] = $this->video_title2->CurrentValue;
		$row['video_URL'] = $this->video_URL->CurrentValue;
		$row['video_text'] = $this->video_text->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->video_id->DbValue = $row['video_id'];
		$this->video_date->DbValue = $row['video_date'];
		$this->video_title1->DbValue = $row['video_title1'];
		$this->video_title2->DbValue = $row['video_title2'];
		$this->video_URL->DbValue = $row['video_URL'];
		$this->video_text->DbValue = $row['video_text'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("video_id")) <> "")
			$this->video_id->CurrentValue = $this->getKey("video_id"); // video_id
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
		// video_id
		// video_date
		// video_title1
		// video_title2
		// video_URL
		// video_text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// video_date
		$this->video_date->ViewValue = $this->video_date->CurrentValue;
		$this->video_date->ViewValue = ew_FormatDateTime($this->video_date->ViewValue, 0);
		$this->video_date->ViewCustomAttributes = "";

		// video_title1
		$this->video_title1->ViewValue = $this->video_title1->CurrentValue;
		$this->video_title1->ViewCustomAttributes = "";

		// video_title2
		$this->video_title2->ViewValue = $this->video_title2->CurrentValue;
		$this->video_title2->ViewCustomAttributes = "";

		// video_URL
		$this->video_URL->ViewValue = $this->video_URL->CurrentValue;
		$this->video_URL->ViewCustomAttributes = "";

		// video_text
		$this->video_text->ViewValue = $this->video_text->CurrentValue;
		$this->video_text->ViewCustomAttributes = "";

			// video_date
			$this->video_date->LinkCustomAttributes = "";
			$this->video_date->HrefValue = "";
			$this->video_date->TooltipValue = "";

			// video_title1
			$this->video_title1->LinkCustomAttributes = "";
			$this->video_title1->HrefValue = "";
			$this->video_title1->TooltipValue = "";

			// video_title2
			$this->video_title2->LinkCustomAttributes = "";
			$this->video_title2->HrefValue = "";
			$this->video_title2->TooltipValue = "";

			// video_URL
			$this->video_URL->LinkCustomAttributes = "";
			$this->video_URL->HrefValue = "";
			$this->video_URL->TooltipValue = "";

			// video_text
			$this->video_text->LinkCustomAttributes = "";
			$this->video_text->HrefValue = "";
			$this->video_text->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// video_date
			$this->video_date->EditAttrs["class"] = "form-control";
			$this->video_date->EditCustomAttributes = "";
			$this->video_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->video_date->CurrentValue, 8));
			$this->video_date->PlaceHolder = ew_RemoveHtml($this->video_date->FldCaption());

			// video_title1
			$this->video_title1->EditAttrs["class"] = "form-control";
			$this->video_title1->EditCustomAttributes = "";
			$this->video_title1->EditValue = ew_HtmlEncode($this->video_title1->CurrentValue);
			$this->video_title1->PlaceHolder = ew_RemoveHtml($this->video_title1->FldCaption());

			// video_title2
			$this->video_title2->EditAttrs["class"] = "form-control";
			$this->video_title2->EditCustomAttributes = "";
			$this->video_title2->EditValue = ew_HtmlEncode($this->video_title2->CurrentValue);
			$this->video_title2->PlaceHolder = ew_RemoveHtml($this->video_title2->FldCaption());

			// video_URL
			$this->video_URL->EditAttrs["class"] = "form-control";
			$this->video_URL->EditCustomAttributes = "";
			$this->video_URL->EditValue = ew_HtmlEncode($this->video_URL->CurrentValue);
			$this->video_URL->PlaceHolder = ew_RemoveHtml($this->video_URL->FldCaption());

			// video_text
			$this->video_text->EditAttrs["class"] = "form-control";
			$this->video_text->EditCustomAttributes = "";
			$this->video_text->EditValue = ew_HtmlEncode($this->video_text->CurrentValue);
			$this->video_text->PlaceHolder = ew_RemoveHtml($this->video_text->FldCaption());

			// Add refer script
			// video_date

			$this->video_date->LinkCustomAttributes = "";
			$this->video_date->HrefValue = "";

			// video_title1
			$this->video_title1->LinkCustomAttributes = "";
			$this->video_title1->HrefValue = "";

			// video_title2
			$this->video_title2->LinkCustomAttributes = "";
			$this->video_title2->HrefValue = "";

			// video_URL
			$this->video_URL->LinkCustomAttributes = "";
			$this->video_URL->HrefValue = "";

			// video_text
			$this->video_text->LinkCustomAttributes = "";
			$this->video_text->HrefValue = "";
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
		if (!$this->video_date->FldIsDetailKey && !is_null($this->video_date->FormValue) && $this->video_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->video_date->FldCaption(), $this->video_date->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->video_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->video_date->FldErrMsg());
		}
		if (!$this->video_title1->FldIsDetailKey && !is_null($this->video_title1->FormValue) && $this->video_title1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->video_title1->FldCaption(), $this->video_title1->ReqErrMsg));
		}
		if (!$this->video_title2->FldIsDetailKey && !is_null($this->video_title2->FormValue) && $this->video_title2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->video_title2->FldCaption(), $this->video_title2->ReqErrMsg));
		}
		if (!$this->video_URL->FldIsDetailKey && !is_null($this->video_URL->FormValue) && $this->video_URL->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->video_URL->FldCaption(), $this->video_URL->ReqErrMsg));
		}
		if (!$this->video_text->FldIsDetailKey && !is_null($this->video_text->FormValue) && $this->video_text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->video_text->FldCaption(), $this->video_text->ReqErrMsg));
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
		if ($this->video_title1->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(video_title1 = '" . ew_AdjustSql($this->video_title1->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->video_title1->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->video_title1->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// video_date
		$this->video_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->video_date->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// video_title1
		$this->video_title1->SetDbValueDef($rsnew, $this->video_title1->CurrentValue, "", FALSE);

		// video_title2
		$this->video_title2->SetDbValueDef($rsnew, $this->video_title2->CurrentValue, "", FALSE);

		// video_URL
		$this->video_URL->SetDbValueDef($rsnew, $this->video_URL->CurrentValue, "", FALSE);

		// video_text
		$this->video_text->SetDbValueDef($rsnew, $this->video_text->CurrentValue, "", FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_videolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
if (!isset($cpy_video_add)) $cpy_video_add = new ccpy_video_add();

// Page init
$cpy_video_add->Page_Init();

// Page main
$cpy_video_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_video_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_videoadd = new ew_Form("fcpy_videoadd", "add");

// Validate form
fcpy_videoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_video_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_video->video_date->FldCaption(), $cpy_video->video_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_video_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_video->video_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_video_title1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_video->video_title1->FldCaption(), $cpy_video->video_title1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_video_title2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_video->video_title2->FldCaption(), $cpy_video->video_title2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_video_URL");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_video->video_URL->FldCaption(), $cpy_video->video_URL->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_video_text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_video->video_text->FldCaption(), $cpy_video->video_text->ReqErrMsg)) ?>");

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
fcpy_videoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_videoadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_video_add->ShowPageHeader(); ?>
<?php
$cpy_video_add->ShowMessage();
?>
<form name="fcpy_videoadd" id="fcpy_videoadd" class="<?php echo $cpy_video_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_video_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_video_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_video">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_video_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_video->video_date->Visible) { // video_date ?>
	<div id="r_video_date" class="form-group">
		<label id="elh_cpy_video_video_date" for="x_video_date" class="<?php echo $cpy_video_add->LeftColumnClass ?>"><?php echo $cpy_video->video_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_video_add->RightColumnClass ?>"><div<?php echo $cpy_video->video_date->CellAttributes() ?>>
<span id="el_cpy_video_video_date">
<input type="text" data-table="cpy_video" data-field="x_video_date" name="x_video_date" id="x_video_date" placeholder="<?php echo ew_HtmlEncode($cpy_video->video_date->getPlaceHolder()) ?>" value="<?php echo $cpy_video->video_date->EditValue ?>"<?php echo $cpy_video->video_date->EditAttributes() ?>>
<?php if (!$cpy_video->video_date->ReadOnly && !$cpy_video->video_date->Disabled && !isset($cpy_video->video_date->EditAttrs["readonly"]) && !isset($cpy_video->video_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fcpy_videoadd", "x_video_date", {"ignoreReadonly":true,"useCurrent":false,"format":0});
</script>
<?php } ?>
</span>
<?php echo $cpy_video->video_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_video->video_title1->Visible) { // video_title1 ?>
	<div id="r_video_title1" class="form-group">
		<label id="elh_cpy_video_video_title1" for="x_video_title1" class="<?php echo $cpy_video_add->LeftColumnClass ?>"><?php echo $cpy_video->video_title1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_video_add->RightColumnClass ?>"><div<?php echo $cpy_video->video_title1->CellAttributes() ?>>
<span id="el_cpy_video_video_title1">
<input type="text" data-table="cpy_video" data-field="x_video_title1" name="x_video_title1" id="x_video_title1" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($cpy_video->video_title1->getPlaceHolder()) ?>" value="<?php echo $cpy_video->video_title1->EditValue ?>"<?php echo $cpy_video->video_title1->EditAttributes() ?>>
</span>
<?php echo $cpy_video->video_title1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_video->video_title2->Visible) { // video_title2 ?>
	<div id="r_video_title2" class="form-group">
		<label id="elh_cpy_video_video_title2" for="x_video_title2" class="<?php echo $cpy_video_add->LeftColumnClass ?>"><?php echo $cpy_video->video_title2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_video_add->RightColumnClass ?>"><div<?php echo $cpy_video->video_title2->CellAttributes() ?>>
<span id="el_cpy_video_video_title2">
<textarea data-table="cpy_video" data-field="x_video_title2" name="x_video_title2" id="x_video_title2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_video->video_title2->getPlaceHolder()) ?>"<?php echo $cpy_video->video_title2->EditAttributes() ?>><?php echo $cpy_video->video_title2->EditValue ?></textarea>
</span>
<?php echo $cpy_video->video_title2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_video->video_URL->Visible) { // video_URL ?>
	<div id="r_video_URL" class="form-group">
		<label id="elh_cpy_video_video_URL" for="x_video_URL" class="<?php echo $cpy_video_add->LeftColumnClass ?>"><?php echo $cpy_video->video_URL->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_video_add->RightColumnClass ?>"><div<?php echo $cpy_video->video_URL->CellAttributes() ?>>
<span id="el_cpy_video_video_URL">
<textarea data-table="cpy_video" data-field="x_video_URL" name="x_video_URL" id="x_video_URL" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_video->video_URL->getPlaceHolder()) ?>"<?php echo $cpy_video->video_URL->EditAttributes() ?>><?php echo $cpy_video->video_URL->EditValue ?></textarea>
</span>
<?php echo $cpy_video->video_URL->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_video->video_text->Visible) { // video_text ?>
	<div id="r_video_text" class="form-group">
		<label id="elh_cpy_video_video_text" for="x_video_text" class="<?php echo $cpy_video_add->LeftColumnClass ?>"><?php echo $cpy_video->video_text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_video_add->RightColumnClass ?>"><div<?php echo $cpy_video->video_text->CellAttributes() ?>>
<span id="el_cpy_video_video_text">
<textarea data-table="cpy_video" data-field="x_video_text" name="x_video_text" id="x_video_text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_video->video_text->getPlaceHolder()) ?>"<?php echo $cpy_video->video_text->EditAttributes() ?>><?php echo $cpy_video->video_text->EditValue ?></textarea>
</span>
<?php echo $cpy_video->video_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_video_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_video_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_video_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_videoadd.Init();
</script>
<?php
$cpy_video_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_video_add->Page_Terminate();
?>
