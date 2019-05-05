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

$cpy_publication_view = NULL; // Initialize page object first

class ccpy_publication_view extends ccpy_publication {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_publication';

	// Page object name
	var $PageObjName = 'cpy_publication_view';

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

		// Table object (cpy_publication)
		if (!isset($GLOBALS["cpy_publication"]) || get_class($GLOBALS["cpy_publication"]) == "ccpy_publication") {
			$GLOBALS["cpy_publication"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_publication"];
		}
		$KeyUrl = "";
		if (@$_GET["pub_id"] <> "") {
			$this->RecKey["pub_id"] = $_GET["pub_id"];
			$KeyUrl .= "&amp;pub_id=" . urlencode($this->RecKey["pub_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (phs_users)
		if (!isset($GLOBALS['phs_users'])) $GLOBALS['phs_users'] = new cphs_users();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->pub_id->SetVisibility();
		$this->pub_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["pub_id"] <> "") {
				$this->pub_id->setQueryStringValue($_GET["pub_id"]);
				$this->RecKey["pub_id"] = $this->pub_id->QueryStringValue;
			} elseif (@$_POST["pub_id"] <> "") {
				$this->pub_id->setFormValue($_POST["pub_id"]);
				$this->RecKey["pub_id"] = $this->pub_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("cpy_publicationlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetupStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->pub_id->CurrentValue) == strval($this->Recordset->fields('pub_id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cpy_publicationlist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "cpy_publicationlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'AddBtn',url:'" . ew_HtmlEncode($this->CopyUrl) . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$row = array();
		$row['pub_id'] = NULL;
		$row['bibl_id'] = NULL;
		$row['pub_order'] = NULL;
		$row['pub_title1'] = NULL;
		$row['pub_title2'] = NULL;
		$row['pub_publisher'] = NULL;
		$row['pub_dimensions'] = NULL;
		$row['pub_editor'] = NULL;
		$row['pub_image'] = NULL;
		$row['pub_text'] = NULL;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// pub_id
		$this->pub_id->ViewValue = $this->pub_id->CurrentValue;
		$this->pub_id->ViewCustomAttributes = "";

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

			// pub_id
			$this->pub_id->LinkCustomAttributes = "";
			$this->pub_id->HrefValue = "";
			$this->pub_id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_publicationlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($cpy_publication_view)) $cpy_publication_view = new ccpy_publication_view();

// Page init
$cpy_publication_view->Page_Init();

// Page main
$cpy_publication_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_publication_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fcpy_publicationview = new ew_Form("fcpy_publicationview", "view");

// Form_CustomValidate event
fcpy_publicationview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_publicationview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_publicationview.Lists["x_bibl_id"] = {"LinkField":"x_bibl_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bibl_title1","x_bibl_title2","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_bibliography"};
fcpy_publicationview.Lists["x_bibl_id"].Data = "<?php echo $cpy_publication_view->bibl_id->LookupFilterQuery(FALSE, "view") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $cpy_publication_view->ExportOptions->Render("body") ?>
<?php
	foreach ($cpy_publication_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $cpy_publication_view->ShowPageHeader(); ?>
<?php
$cpy_publication_view->ShowMessage();
?>
<?php if (!$cpy_publication_view->IsModal) { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_publication_view->Pager)) $cpy_publication_view->Pager = new cPrevNextPager($cpy_publication_view->StartRec, $cpy_publication_view->DisplayRecs, $cpy_publication_view->TotalRecs, $cpy_publication_view->AutoHidePager) ?>
<?php if ($cpy_publication_view->Pager->RecordCount > 0 && $cpy_publication_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_publication_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_publication_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_publication_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_publication_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_publication_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_publication_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcpy_publicationview" id="fcpy_publicationview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_publication_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_publication_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_publication">
<input type="hidden" name="modal" value="<?php echo intval($cpy_publication_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($cpy_publication->pub_id->Visible) { // pub_id ?>
	<tr id="r_pub_id">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_id"><?php echo $cpy_publication->pub_id->FldCaption() ?></span></td>
		<td data-name="pub_id"<?php echo $cpy_publication->pub_id->CellAttributes() ?>>
<span id="el_cpy_publication_pub_id">
<span<?php echo $cpy_publication->pub_id->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->bibl_id->Visible) { // bibl_id ?>
	<tr id="r_bibl_id">
		<td class="col-sm-2"><span id="elh_cpy_publication_bibl_id"><?php echo $cpy_publication->bibl_id->FldCaption() ?></span></td>
		<td data-name="bibl_id"<?php echo $cpy_publication->bibl_id->CellAttributes() ?>>
<span id="el_cpy_publication_bibl_id">
<span<?php echo $cpy_publication->bibl_id->ViewAttributes() ?>>
<?php echo $cpy_publication->bibl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_order->Visible) { // pub_order ?>
	<tr id="r_pub_order">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_order"><?php echo $cpy_publication->pub_order->FldCaption() ?></span></td>
		<td data-name="pub_order"<?php echo $cpy_publication->pub_order->CellAttributes() ?>>
<span id="el_cpy_publication_pub_order">
<span<?php echo $cpy_publication->pub_order->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_order->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_title1->Visible) { // pub_title1 ?>
	<tr id="r_pub_title1">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_title1"><?php echo $cpy_publication->pub_title1->FldCaption() ?></span></td>
		<td data-name="pub_title1"<?php echo $cpy_publication->pub_title1->CellAttributes() ?>>
<span id="el_cpy_publication_pub_title1">
<span<?php echo $cpy_publication->pub_title1->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_title1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_title2->Visible) { // pub_title2 ?>
	<tr id="r_pub_title2">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_title2"><?php echo $cpy_publication->pub_title2->FldCaption() ?></span></td>
		<td data-name="pub_title2"<?php echo $cpy_publication->pub_title2->CellAttributes() ?>>
<span id="el_cpy_publication_pub_title2">
<span<?php echo $cpy_publication->pub_title2->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_title2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_publisher->Visible) { // pub_publisher ?>
	<tr id="r_pub_publisher">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_publisher"><?php echo $cpy_publication->pub_publisher->FldCaption() ?></span></td>
		<td data-name="pub_publisher"<?php echo $cpy_publication->pub_publisher->CellAttributes() ?>>
<span id="el_cpy_publication_pub_publisher">
<span<?php echo $cpy_publication->pub_publisher->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_publisher->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_dimensions->Visible) { // pub_dimensions ?>
	<tr id="r_pub_dimensions">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_dimensions"><?php echo $cpy_publication->pub_dimensions->FldCaption() ?></span></td>
		<td data-name="pub_dimensions"<?php echo $cpy_publication->pub_dimensions->CellAttributes() ?>>
<span id="el_cpy_publication_pub_dimensions">
<span<?php echo $cpy_publication->pub_dimensions->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_dimensions->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_editor->Visible) { // pub_editor ?>
	<tr id="r_pub_editor">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_editor"><?php echo $cpy_publication->pub_editor->FldCaption() ?></span></td>
		<td data-name="pub_editor"<?php echo $cpy_publication->pub_editor->CellAttributes() ?>>
<span id="el_cpy_publication_pub_editor">
<span<?php echo $cpy_publication->pub_editor->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_editor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_image->Visible) { // pub_image ?>
	<tr id="r_pub_image">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_image"><?php echo $cpy_publication->pub_image->FldCaption() ?></span></td>
		<td data-name="pub_image"<?php echo $cpy_publication->pub_image->CellAttributes() ?>>
<span id="el_cpy_publication_pub_image">
<span>
<?php echo ew_GetFileViewTag($cpy_publication->pub_image, $cpy_publication->pub_image->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_publication->pub_text->Visible) { // pub_text ?>
	<tr id="r_pub_text">
		<td class="col-sm-2"><span id="elh_cpy_publication_pub_text"><?php echo $cpy_publication->pub_text->FldCaption() ?></span></td>
		<td data-name="pub_text"<?php echo $cpy_publication->pub_text->CellAttributes() ?>>
<span id="el_cpy_publication_pub_text">
<span<?php echo $cpy_publication->pub_text->ViewAttributes() ?>>
<?php echo $cpy_publication->pub_text->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$cpy_publication_view->IsModal) { ?>
<?php if (!isset($cpy_publication_view->Pager)) $cpy_publication_view->Pager = new cPrevNextPager($cpy_publication_view->StartRec, $cpy_publication_view->DisplayRecs, $cpy_publication_view->TotalRecs, $cpy_publication_view->AutoHidePager) ?>
<?php if ($cpy_publication_view->Pager->RecordCount > 0 && $cpy_publication_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_publication_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_publication_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_publication_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_publication_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_publication_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_publication_view->PageUrl() ?>start=<?php echo $cpy_publication_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_publication_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fcpy_publicationview.Init();
</script>
<?php
$cpy_publication_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_publication_view->Page_Terminate();
?>
