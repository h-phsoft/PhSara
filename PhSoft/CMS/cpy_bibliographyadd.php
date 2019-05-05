<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_bibliographyinfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_bibliography_add = NULL; // Initialize page object first

class ccpy_bibliography_add extends ccpy_bibliography {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_bibliography';

	// Page object name
	var $PageObjName = 'cpy_bibliography_add';

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

		// Table object (cpy_bibliography)
		if (!isset($GLOBALS["cpy_bibliography"]) || get_class($GLOBALS["cpy_bibliography"]) == "ccpy_bibliography") {
			$GLOBALS["cpy_bibliography"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_bibliography"];
		}

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cpy_bibliography', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("cpy_bibliographylist.php"));
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
		$this->bibl_order->SetVisibility();
		$this->bibl_title1->SetVisibility();
		$this->bibl_title2->SetVisibility();
		$this->bibl_image->SetVisibility();
		$this->bibl_text->SetVisibility();

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
		global $EW_EXPORT, $cpy_bibliography;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cpy_bibliography);
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
					if ($pageName == "cpy_bibliographyview.php")
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
			if (@$_GET["bibl_id"] != "") {
				$this->bibl_id->setQueryStringValue($_GET["bibl_id"]);
				$this->setKey("bibl_id", $this->bibl_id->CurrentValue); // Set up key
			} else {
				$this->setKey("bibl_id", ""); // Clear key
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
					$this->Page_Terminate("cpy_bibliographylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cpy_bibliographylist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cpy_bibliographyview.php")
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
		$this->bibl_image->Upload->Index = $objForm->Index;
		$this->bibl_image->Upload->UploadFile();
		$this->bibl_image->CurrentValue = $this->bibl_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->bibl_id->CurrentValue = NULL;
		$this->bibl_id->OldValue = $this->bibl_id->CurrentValue;
		$this->bibl_order->CurrentValue = 0;
		$this->bibl_title1->CurrentValue = NULL;
		$this->bibl_title1->OldValue = $this->bibl_title1->CurrentValue;
		$this->bibl_title2->CurrentValue = NULL;
		$this->bibl_title2->OldValue = $this->bibl_title2->CurrentValue;
		$this->bibl_image->Upload->DbValue = NULL;
		$this->bibl_image->OldValue = $this->bibl_image->Upload->DbValue;
		$this->bibl_image->CurrentValue = NULL; // Clear file related field
		$this->bibl_text->CurrentValue = NULL;
		$this->bibl_text->OldValue = $this->bibl_text->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->bibl_order->FldIsDetailKey) {
			$this->bibl_order->setFormValue($objForm->GetValue("x_bibl_order"));
		}
		if (!$this->bibl_title1->FldIsDetailKey) {
			$this->bibl_title1->setFormValue($objForm->GetValue("x_bibl_title1"));
		}
		if (!$this->bibl_title2->FldIsDetailKey) {
			$this->bibl_title2->setFormValue($objForm->GetValue("x_bibl_title2"));
		}
		if (!$this->bibl_text->FldIsDetailKey) {
			$this->bibl_text->setFormValue($objForm->GetValue("x_bibl_text"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->bibl_order->CurrentValue = $this->bibl_order->FormValue;
		$this->bibl_title1->CurrentValue = $this->bibl_title1->FormValue;
		$this->bibl_title2->CurrentValue = $this->bibl_title2->FormValue;
		$this->bibl_text->CurrentValue = $this->bibl_text->FormValue;
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
		$this->bibl_id->setDbValue($row['bibl_id']);
		$this->bibl_order->setDbValue($row['bibl_order']);
		$this->bibl_title1->setDbValue($row['bibl_title1']);
		$this->bibl_title2->setDbValue($row['bibl_title2']);
		$this->bibl_image->Upload->DbValue = $row['bibl_image'];
		$this->bibl_image->CurrentValue = $this->bibl_image->Upload->DbValue;
		$this->bibl_text->setDbValue($row['bibl_text']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['bibl_id'] = $this->bibl_id->CurrentValue;
		$row['bibl_order'] = $this->bibl_order->CurrentValue;
		$row['bibl_title1'] = $this->bibl_title1->CurrentValue;
		$row['bibl_title2'] = $this->bibl_title2->CurrentValue;
		$row['bibl_image'] = $this->bibl_image->Upload->DbValue;
		$row['bibl_text'] = $this->bibl_text->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->bibl_id->DbValue = $row['bibl_id'];
		$this->bibl_order->DbValue = $row['bibl_order'];
		$this->bibl_title1->DbValue = $row['bibl_title1'];
		$this->bibl_title2->DbValue = $row['bibl_title2'];
		$this->bibl_image->Upload->DbValue = $row['bibl_image'];
		$this->bibl_text->DbValue = $row['bibl_text'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("bibl_id")) <> "")
			$this->bibl_id->CurrentValue = $this->getKey("bibl_id"); // bibl_id
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
		// bibl_id
		// bibl_order
		// bibl_title1
		// bibl_title2
		// bibl_image
		// bibl_text

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// bibl_order
		$this->bibl_order->ViewValue = $this->bibl_order->CurrentValue;
		$this->bibl_order->ViewCustomAttributes = "";

		// bibl_title1
		$this->bibl_title1->ViewValue = $this->bibl_title1->CurrentValue;
		$this->bibl_title1->ViewCustomAttributes = "";

		// bibl_title2
		$this->bibl_title2->ViewValue = $this->bibl_title2->CurrentValue;
		$this->bibl_title2->ViewCustomAttributes = "";

		// bibl_image
		if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
			$this->bibl_image->ImageWidth = 100;
			$this->bibl_image->ImageHeight = 0;
			$this->bibl_image->ImageAlt = $this->bibl_image->FldAlt();
			$this->bibl_image->ViewValue = $this->bibl_image->Upload->DbValue;
		} else {
			$this->bibl_image->ViewValue = "";
		}
		$this->bibl_image->ViewCustomAttributes = "";

		// bibl_text
		$this->bibl_text->ViewValue = $this->bibl_text->CurrentValue;
		$this->bibl_text->ViewCustomAttributes = "";

			// bibl_order
			$this->bibl_order->LinkCustomAttributes = "";
			$this->bibl_order->HrefValue = "";
			$this->bibl_order->TooltipValue = "";

			// bibl_title1
			$this->bibl_title1->LinkCustomAttributes = "";
			$this->bibl_title1->HrefValue = "";
			$this->bibl_title1->TooltipValue = "";

			// bibl_title2
			$this->bibl_title2->LinkCustomAttributes = "";
			$this->bibl_title2->HrefValue = "";
			$this->bibl_title2->TooltipValue = "";

			// bibl_image
			$this->bibl_image->LinkCustomAttributes = "";
			if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
				$this->bibl_image->HrefValue = ew_GetFileUploadUrl($this->bibl_image, $this->bibl_image->Upload->DbValue); // Add prefix/suffix
				$this->bibl_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->bibl_image->HrefValue = ew_FullUrl($this->bibl_image->HrefValue, "href");
			} else {
				$this->bibl_image->HrefValue = "";
			}
			$this->bibl_image->HrefValue2 = $this->bibl_image->UploadPath . $this->bibl_image->Upload->DbValue;
			$this->bibl_image->TooltipValue = "";
			if ($this->bibl_image->UseColorbox) {
				if (ew_Empty($this->bibl_image->TooltipValue))
					$this->bibl_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->bibl_image->LinkAttrs["data-rel"] = "cpy_bibliography_x_bibl_image";
				ew_AppendClass($this->bibl_image->LinkAttrs["class"], "ewLightbox");
			}

			// bibl_text
			$this->bibl_text->LinkCustomAttributes = "";
			$this->bibl_text->HrefValue = "";
			$this->bibl_text->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// bibl_order
			$this->bibl_order->EditAttrs["class"] = "form-control";
			$this->bibl_order->EditCustomAttributes = "";
			$this->bibl_order->EditValue = ew_HtmlEncode($this->bibl_order->CurrentValue);
			$this->bibl_order->PlaceHolder = ew_RemoveHtml($this->bibl_order->FldCaption());

			// bibl_title1
			$this->bibl_title1->EditAttrs["class"] = "form-control";
			$this->bibl_title1->EditCustomAttributes = "";
			$this->bibl_title1->EditValue = ew_HtmlEncode($this->bibl_title1->CurrentValue);
			$this->bibl_title1->PlaceHolder = ew_RemoveHtml($this->bibl_title1->FldCaption());

			// bibl_title2
			$this->bibl_title2->EditAttrs["class"] = "form-control";
			$this->bibl_title2->EditCustomAttributes = "";
			$this->bibl_title2->EditValue = ew_HtmlEncode($this->bibl_title2->CurrentValue);
			$this->bibl_title2->PlaceHolder = ew_RemoveHtml($this->bibl_title2->FldCaption());

			// bibl_image
			$this->bibl_image->EditAttrs["class"] = "form-control";
			$this->bibl_image->EditCustomAttributes = "";
			if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
				$this->bibl_image->ImageWidth = 100;
				$this->bibl_image->ImageHeight = 0;
				$this->bibl_image->ImageAlt = $this->bibl_image->FldAlt();
				$this->bibl_image->EditValue = $this->bibl_image->Upload->DbValue;
			} else {
				$this->bibl_image->EditValue = "";
			}
			if (!ew_Empty($this->bibl_image->CurrentValue))
				$this->bibl_image->Upload->FileName = $this->bibl_image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->bibl_image);

			// bibl_text
			$this->bibl_text->EditAttrs["class"] = "form-control";
			$this->bibl_text->EditCustomAttributes = "";
			$this->bibl_text->EditValue = ew_HtmlEncode($this->bibl_text->CurrentValue);
			$this->bibl_text->PlaceHolder = ew_RemoveHtml($this->bibl_text->FldCaption());

			// Add refer script
			// bibl_order

			$this->bibl_order->LinkCustomAttributes = "";
			$this->bibl_order->HrefValue = "";

			// bibl_title1
			$this->bibl_title1->LinkCustomAttributes = "";
			$this->bibl_title1->HrefValue = "";

			// bibl_title2
			$this->bibl_title2->LinkCustomAttributes = "";
			$this->bibl_title2->HrefValue = "";

			// bibl_image
			$this->bibl_image->LinkCustomAttributes = "";
			if (!ew_Empty($this->bibl_image->Upload->DbValue)) {
				$this->bibl_image->HrefValue = ew_GetFileUploadUrl($this->bibl_image, $this->bibl_image->Upload->DbValue); // Add prefix/suffix
				$this->bibl_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->bibl_image->HrefValue = ew_FullUrl($this->bibl_image->HrefValue, "href");
			} else {
				$this->bibl_image->HrefValue = "";
			}
			$this->bibl_image->HrefValue2 = $this->bibl_image->UploadPath . $this->bibl_image->Upload->DbValue;

			// bibl_text
			$this->bibl_text->LinkCustomAttributes = "";
			$this->bibl_text->HrefValue = "";
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
		if (!$this->bibl_order->FldIsDetailKey && !is_null($this->bibl_order->FormValue) && $this->bibl_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bibl_order->FldCaption(), $this->bibl_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->bibl_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->bibl_order->FldErrMsg());
		}
		if (!$this->bibl_title1->FldIsDetailKey && !is_null($this->bibl_title1->FormValue) && $this->bibl_title1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bibl_title1->FldCaption(), $this->bibl_title1->ReqErrMsg));
		}
		if (!$this->bibl_text->FldIsDetailKey && !is_null($this->bibl_text->FormValue) && $this->bibl_text->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bibl_text->FldCaption(), $this->bibl_text->ReqErrMsg));
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

		// bibl_order
		$this->bibl_order->SetDbValueDef($rsnew, $this->bibl_order->CurrentValue, 0, strval($this->bibl_order->CurrentValue) == "");

		// bibl_title1
		$this->bibl_title1->SetDbValueDef($rsnew, $this->bibl_title1->CurrentValue, "", FALSE);

		// bibl_title2
		$this->bibl_title2->SetDbValueDef($rsnew, $this->bibl_title2->CurrentValue, NULL, FALSE);

		// bibl_image
		if ($this->bibl_image->Visible && !$this->bibl_image->Upload->KeepFile) {
			$this->bibl_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->bibl_image->Upload->FileName == "") {
				$rsnew['bibl_image'] = NULL;
			} else {
				$rsnew['bibl_image'] = $this->bibl_image->Upload->FileName;
			}
		}

		// bibl_text
		$this->bibl_text->SetDbValueDef($rsnew, $this->bibl_text->CurrentValue, "", FALSE);
		if ($this->bibl_image->Visible && !$this->bibl_image->Upload->KeepFile) {
			if (!ew_Empty($this->bibl_image->Upload->Value)) {
				$rsnew['bibl_image'] = ew_UploadFileNameEx($this->bibl_image->PhysicalUploadPath(), $rsnew['bibl_image']); // Get new file name
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
				if ($this->bibl_image->Visible && !$this->bibl_image->Upload->KeepFile) {
					if (!ew_Empty($this->bibl_image->Upload->Value)) {
						if (!$this->bibl_image->Upload->SaveToFile($rsnew['bibl_image'], TRUE)) {
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

		// bibl_image
		ew_CleanUploadTempPath($this->bibl_image, $this->bibl_image->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_bibliographylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cpy_bibliography_add)) $cpy_bibliography_add = new ccpy_bibliography_add();

// Page init
$cpy_bibliography_add->Page_Init();

// Page main
$cpy_bibliography_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_bibliography_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcpy_bibliographyadd = new ew_Form("fcpy_bibliographyadd", "add");

// Validate form
fcpy_bibliographyadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_bibl_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_bibliography->bibl_order->FldCaption(), $cpy_bibliography->bibl_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bibl_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cpy_bibliography->bibl_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bibl_title1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_bibliography->bibl_title1->FldCaption(), $cpy_bibliography->bibl_title1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bibl_text");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cpy_bibliography->bibl_text->FldCaption(), $cpy_bibliography->bibl_text->ReqErrMsg)) ?>");

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
fcpy_bibliographyadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_bibliographyadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_bibliography_add->ShowPageHeader(); ?>
<?php
$cpy_bibliography_add->ShowMessage();
?>
<form name="fcpy_bibliographyadd" id="fcpy_bibliographyadd" class="<?php echo $cpy_bibliography_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_bibliography_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_bibliography_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_bibliography">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($cpy_bibliography_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($cpy_bibliography->bibl_order->Visible) { // bibl_order ?>
	<div id="r_bibl_order" class="form-group">
		<label id="elh_cpy_bibliography_bibl_order" for="x_bibl_order" class="<?php echo $cpy_bibliography_add->LeftColumnClass ?>"><?php echo $cpy_bibliography->bibl_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_bibliography_add->RightColumnClass ?>"><div<?php echo $cpy_bibliography->bibl_order->CellAttributes() ?>>
<span id="el_cpy_bibliography_bibl_order">
<input type="text" data-table="cpy_bibliography" data-field="x_bibl_order" name="x_bibl_order" id="x_bibl_order" size="30" placeholder="<?php echo ew_HtmlEncode($cpy_bibliography->bibl_order->getPlaceHolder()) ?>" value="<?php echo $cpy_bibliography->bibl_order->EditValue ?>"<?php echo $cpy_bibliography->bibl_order->EditAttributes() ?>>
</span>
<?php echo $cpy_bibliography->bibl_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_bibliography->bibl_title1->Visible) { // bibl_title1 ?>
	<div id="r_bibl_title1" class="form-group">
		<label id="elh_cpy_bibliography_bibl_title1" for="x_bibl_title1" class="<?php echo $cpy_bibliography_add->LeftColumnClass ?>"><?php echo $cpy_bibliography->bibl_title1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_bibliography_add->RightColumnClass ?>"><div<?php echo $cpy_bibliography->bibl_title1->CellAttributes() ?>>
<span id="el_cpy_bibliography_bibl_title1">
<textarea data-table="cpy_bibliography" data-field="x_bibl_title1" name="x_bibl_title1" id="x_bibl_title1" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_bibliography->bibl_title1->getPlaceHolder()) ?>"<?php echo $cpy_bibliography->bibl_title1->EditAttributes() ?>><?php echo $cpy_bibliography->bibl_title1->EditValue ?></textarea>
</span>
<?php echo $cpy_bibliography->bibl_title1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_bibliography->bibl_title2->Visible) { // bibl_title2 ?>
	<div id="r_bibl_title2" class="form-group">
		<label id="elh_cpy_bibliography_bibl_title2" for="x_bibl_title2" class="<?php echo $cpy_bibliography_add->LeftColumnClass ?>"><?php echo $cpy_bibliography->bibl_title2->FldCaption() ?></label>
		<div class="<?php echo $cpy_bibliography_add->RightColumnClass ?>"><div<?php echo $cpy_bibliography->bibl_title2->CellAttributes() ?>>
<span id="el_cpy_bibliography_bibl_title2">
<textarea data-table="cpy_bibliography" data-field="x_bibl_title2" name="x_bibl_title2" id="x_bibl_title2" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_bibliography->bibl_title2->getPlaceHolder()) ?>"<?php echo $cpy_bibliography->bibl_title2->EditAttributes() ?>><?php echo $cpy_bibliography->bibl_title2->EditValue ?></textarea>
</span>
<?php echo $cpy_bibliography->bibl_title2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_bibliography->bibl_image->Visible) { // bibl_image ?>
	<div id="r_bibl_image" class="form-group">
		<label id="elh_cpy_bibliography_bibl_image" class="<?php echo $cpy_bibliography_add->LeftColumnClass ?>"><?php echo $cpy_bibliography->bibl_image->FldCaption() ?></label>
		<div class="<?php echo $cpy_bibliography_add->RightColumnClass ?>"><div<?php echo $cpy_bibliography->bibl_image->CellAttributes() ?>>
<span id="el_cpy_bibliography_bibl_image">
<div id="fd_x_bibl_image">
<span title="<?php echo $cpy_bibliography->bibl_image->FldTitle() ? $cpy_bibliography->bibl_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($cpy_bibliography->bibl_image->ReadOnly || $cpy_bibliography->bibl_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="cpy_bibliography" data-field="x_bibl_image" name="x_bibl_image" id="x_bibl_image"<?php echo $cpy_bibliography->bibl_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_bibl_image" id= "fn_x_bibl_image" value="<?php echo $cpy_bibliography->bibl_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_bibl_image" id= "fa_x_bibl_image" value="0">
<input type="hidden" name="fs_x_bibl_image" id= "fs_x_bibl_image" value="1000">
<input type="hidden" name="fx_x_bibl_image" id= "fx_x_bibl_image" value="<?php echo $cpy_bibliography->bibl_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_bibl_image" id= "fm_x_bibl_image" value="<?php echo $cpy_bibliography->bibl_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_bibl_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $cpy_bibliography->bibl_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cpy_bibliography->bibl_text->Visible) { // bibl_text ?>
	<div id="r_bibl_text" class="form-group">
		<label id="elh_cpy_bibliography_bibl_text" class="<?php echo $cpy_bibliography_add->LeftColumnClass ?>"><?php echo $cpy_bibliography->bibl_text->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $cpy_bibliography_add->RightColumnClass ?>"><div<?php echo $cpy_bibliography->bibl_text->CellAttributes() ?>>
<span id="el_cpy_bibliography_bibl_text">
<?php ew_AppendClass($cpy_bibliography->bibl_text->EditAttrs["class"], "editor"); ?>
<textarea data-table="cpy_bibliography" data-field="x_bibl_text" name="x_bibl_text" id="x_bibl_text" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($cpy_bibliography->bibl_text->getPlaceHolder()) ?>"<?php echo $cpy_bibliography->bibl_text->EditAttributes() ?>><?php echo $cpy_bibliography->bibl_text->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fcpy_bibliographyadd", "x_bibl_text", 35, 4, <?php echo ($cpy_bibliography->bibl_text->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $cpy_bibliography->bibl_text->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cpy_bibliography_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $cpy_bibliography_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_bibliography_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcpy_bibliographyadd.Init();
</script>
<?php
$cpy_bibliography_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_bibliography_add->Page_Terminate();
?>
