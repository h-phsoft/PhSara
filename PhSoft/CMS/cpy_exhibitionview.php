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

$cpy_exhibition_view = NULL; // Initialize page object first

class ccpy_exhibition_view extends ccpy_exhibition {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_exhibition';

	// Page object name
	var $PageObjName = 'cpy_exhibition_view';

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

		// Table object (cpy_exhibition)
		if (!isset($GLOBALS["cpy_exhibition"]) || get_class($GLOBALS["cpy_exhibition"]) == "ccpy_exhibition") {
			$GLOBALS["cpy_exhibition"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cpy_exhibition"];
		}
		$KeyUrl = "";
		if (@$_GET["exhib_id"] <> "") {
			$this->RecKey["exhib_id"] = $_GET["exhib_id"];
			$KeyUrl .= "&amp;exhib_id=" . urlencode($this->RecKey["exhib_id"]);
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
				$this->Page_Terminate(ew_GetUrl("cpy_exhibitionlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

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
	var $cpy_exhibition_images_Count;
	var $cpy_exhibition_video_Count;
	var $cpy_artwork_exhibtion_Count;
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
			if (@$_GET["exhib_id"] <> "") {
				$this->exhib_id->setQueryStringValue($_GET["exhib_id"]);
				$this->RecKey["exhib_id"] = $this->exhib_id->QueryStringValue;
			} elseif (@$_POST["exhib_id"] <> "") {
				$this->exhib_id->setFormValue($_POST["exhib_id"]);
				$this->RecKey["exhib_id"] = $this->exhib_id->FormValue;
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
						$this->Page_Terminate("cpy_exhibitionlist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetupStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->exhib_id->CurrentValue) == strval($this->Recordset->fields('exhib_id'))) {
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
						$sReturnUrl = "cpy_exhibitionlist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}
		} else {
			$sReturnUrl = "cpy_exhibitionlist.php"; // Not page request, return to list
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

		// Set up detail parameters
		$this->SetupDetailParms();
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
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_cpy_exhibition_images"
		$item = &$option->Add("detail_cpy_exhibition_images");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("cpy_exhibition_images", "TblCaption");
		$body .= str_replace("%c", $this->cpy_exhibition_images_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("cpy_exhibition_imageslist.php?" . EW_TABLE_SHOW_MASTER . "=cpy_exhibition&fk_exhib_id=" . urlencode(strval($this->exhib_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["cpy_exhibition_images_grid"] && $GLOBALS["cpy_exhibition_images_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'cpy_exhibition_images')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=cpy_exhibition_images")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "cpy_exhibition_images";
		}
		if ($GLOBALS["cpy_exhibition_images_grid"] && $GLOBALS["cpy_exhibition_images_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'cpy_exhibition_images')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=cpy_exhibition_images")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "cpy_exhibition_images";
		}
		if ($GLOBALS["cpy_exhibition_images_grid"] && $GLOBALS["cpy_exhibition_images_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'cpy_exhibition_images')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=cpy_exhibition_images")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "cpy_exhibition_images";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'cpy_exhibition_images');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "cpy_exhibition_images";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_cpy_exhibition_video"
		$item = &$option->Add("detail_cpy_exhibition_video");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("cpy_exhibition_video", "TblCaption");
		$body .= str_replace("%c", $this->cpy_exhibition_video_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("cpy_exhibition_videolist.php?" . EW_TABLE_SHOW_MASTER . "=cpy_exhibition&fk_exhib_id=" . urlencode(strval($this->exhib_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["cpy_exhibition_video_grid"] && $GLOBALS["cpy_exhibition_video_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'cpy_exhibition_video')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=cpy_exhibition_video")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "cpy_exhibition_video";
		}
		if ($GLOBALS["cpy_exhibition_video_grid"] && $GLOBALS["cpy_exhibition_video_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'cpy_exhibition_video')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=cpy_exhibition_video")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "cpy_exhibition_video";
		}
		if ($GLOBALS["cpy_exhibition_video_grid"] && $GLOBALS["cpy_exhibition_video_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'cpy_exhibition_video')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=cpy_exhibition_video")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "cpy_exhibition_video";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'cpy_exhibition_video');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "cpy_exhibition_video";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_cpy_artwork_exhibtion"
		$item = &$option->Add("detail_cpy_artwork_exhibtion");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("cpy_artwork_exhibtion", "TblCaption");
		$body .= str_replace("%c", $this->cpy_artwork_exhibtion_Count, $Language->Phrase("DetailCount"));
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("cpy_artwork_exhibtionlist.php?" . EW_TABLE_SHOW_MASTER . "=cpy_exhibition&fk_exhib_id=" . urlencode(strval($this->exhib_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["cpy_artwork_exhibtion_grid"] && $GLOBALS["cpy_artwork_exhibtion_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'cpy_artwork_exhibtion')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=cpy_artwork_exhibtion")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "cpy_artwork_exhibtion";
		}
		if ($GLOBALS["cpy_artwork_exhibtion_grid"] && $GLOBALS["cpy_artwork_exhibtion_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'cpy_artwork_exhibtion')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=cpy_artwork_exhibtion")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "cpy_artwork_exhibtion";
		}
		if ($GLOBALS["cpy_artwork_exhibtion_grid"] && $GLOBALS["cpy_artwork_exhibtion_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'cpy_artwork_exhibtion')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=cpy_artwork_exhibtion")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "cpy_artwork_exhibtion";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'cpy_artwork_exhibtion');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "cpy_artwork_exhibtion";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		if (!isset($GLOBALS["cpy_exhibition_images_grid"])) $GLOBALS["cpy_exhibition_images_grid"] = new ccpy_exhibition_images_grid;
		$sDetailFilter = $GLOBALS["cpy_exhibition_images"]->SqlDetailFilter_cpy_exhibition();
		$sDetailFilter = str_replace("@exhib_id@", ew_AdjustSql($this->exhib_id->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["cpy_exhibition_images"]->setCurrentMasterTable("cpy_exhibition");
		$sDetailFilter = $GLOBALS["cpy_exhibition_images"]->ApplyUserIDFilters($sDetailFilter);
		$this->cpy_exhibition_images_Count = $GLOBALS["cpy_exhibition_images"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["cpy_exhibition_video_grid"])) $GLOBALS["cpy_exhibition_video_grid"] = new ccpy_exhibition_video_grid;
		$sDetailFilter = $GLOBALS["cpy_exhibition_video"]->SqlDetailFilter_cpy_exhibition();
		$sDetailFilter = str_replace("@exhib_id@", ew_AdjustSql($this->exhib_id->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["cpy_exhibition_video"]->setCurrentMasterTable("cpy_exhibition");
		$sDetailFilter = $GLOBALS["cpy_exhibition_video"]->ApplyUserIDFilters($sDetailFilter);
		$this->cpy_exhibition_video_Count = $GLOBALS["cpy_exhibition_video"]->LoadRecordCount($sDetailFilter);
		if (!isset($GLOBALS["cpy_artwork_exhibtion_grid"])) $GLOBALS["cpy_artwork_exhibtion_grid"] = new ccpy_artwork_exhibtion_grid;
		$sDetailFilter = $GLOBALS["cpy_artwork_exhibtion"]->SqlDetailFilter_cpy_exhibition();
		$sDetailFilter = str_replace("@exhib_id@", ew_AdjustSql($this->exhib_id->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["cpy_artwork_exhibtion"]->setCurrentMasterTable("cpy_exhibition");
		$sDetailFilter = $GLOBALS["cpy_artwork_exhibtion"]->ApplyUserIDFilters($sDetailFilter);
		$this->cpy_artwork_exhibtion_Count = $GLOBALS["cpy_artwork_exhibtion"]->LoadRecordCount($sDetailFilter);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['exhib_id'] = NULL;
		$row['type_id'] = NULL;
		$row['kind_id'] = NULL;
		$row['exhib_year'] = NULL;
		$row['exhib_title1'] = NULL;
		$row['exhib_title2'] = NULL;
		$row['exhib_date'] = NULL;
		$row['exhib_from'] = NULL;
		$row['exhib_to'] = NULL;
		$row['exhib_web'] = NULL;
		$row['exhib_intro'] = NULL;
		$row['exhib_info'] = NULL;
		$row['exhib_text'] = NULL;
		$row['exhib_image'] = NULL;
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
				if ($GLOBALS["cpy_exhibition_images_grid"]->DetailView) {
					$GLOBALS["cpy_exhibition_images_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["cpy_exhibition_video_grid"]->DetailView) {
					$GLOBALS["cpy_exhibition_video_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["cpy_artwork_exhibtion_grid"]->DetailView) {
					$GLOBALS["cpy_artwork_exhibtion_grid"]->CurrentMode = "view";

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
if (!isset($cpy_exhibition_view)) $cpy_exhibition_view = new ccpy_exhibition_view();

// Page init
$cpy_exhibition_view->Page_Init();

// Page main
$cpy_exhibition_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_exhibition_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fcpy_exhibitionview = new ew_Form("fcpy_exhibitionview", "view");

// Form_CustomValidate event
fcpy_exhibitionview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_exhibitionview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_exhibitionview.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibtype"};
fcpy_exhibitionview.Lists["x_type_id"].Data = "<?php echo $cpy_exhibition_view->type_id->LookupFilterQuery(FALSE, "view") ?>";
fcpy_exhibitionview.Lists["x_kind_id"] = {"LinkField":"x_kind_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kind_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibkind"};
fcpy_exhibitionview.Lists["x_kind_id"].Data = "<?php echo $cpy_exhibition_view->kind_id->LookupFilterQuery(FALSE, "view") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $cpy_exhibition_view->ExportOptions->Render("body") ?>
<?php
	foreach ($cpy_exhibition_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $cpy_exhibition_view->ShowPageHeader(); ?>
<?php
$cpy_exhibition_view->ShowMessage();
?>
<?php if (!$cpy_exhibition_view->IsModal) { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cpy_exhibition_view->Pager)) $cpy_exhibition_view->Pager = new cPrevNextPager($cpy_exhibition_view->StartRec, $cpy_exhibition_view->DisplayRecs, $cpy_exhibition_view->TotalRecs, $cpy_exhibition_view->AutoHidePager) ?>
<?php if ($cpy_exhibition_view->Pager->RecordCount > 0 && $cpy_exhibition_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_exhibition_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_exhibition_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_exhibition_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_exhibition_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_exhibition_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_exhibition_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fcpy_exhibitionview" id="fcpy_exhibitionview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_exhibition_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_exhibition_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_exhibition">
<input type="hidden" name="modal" value="<?php echo intval($cpy_exhibition_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($cpy_exhibition->type_id->Visible) { // type_id ?>
	<tr id="r_type_id">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_type_id"><?php echo $cpy_exhibition->type_id->FldCaption() ?></span></td>
		<td data-name="type_id"<?php echo $cpy_exhibition->type_id->CellAttributes() ?>>
<span id="el_cpy_exhibition_type_id">
<span<?php echo $cpy_exhibition->type_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition->type_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->kind_id->Visible) { // kind_id ?>
	<tr id="r_kind_id">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_kind_id"><?php echo $cpy_exhibition->kind_id->FldCaption() ?></span></td>
		<td data-name="kind_id"<?php echo $cpy_exhibition->kind_id->CellAttributes() ?>>
<span id="el_cpy_exhibition_kind_id">
<span<?php echo $cpy_exhibition->kind_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition->kind_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_year->Visible) { // exhib_year ?>
	<tr id="r_exhib_year">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_year"><?php echo $cpy_exhibition->exhib_year->FldCaption() ?></span></td>
		<td data-name="exhib_year"<?php echo $cpy_exhibition->exhib_year->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_year">
<span<?php echo $cpy_exhibition->exhib_year->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_year->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title1->Visible) { // exhib_title1 ?>
	<tr id="r_exhib_title1">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_title1"><?php echo $cpy_exhibition->exhib_title1->FldCaption() ?></span></td>
		<td data-name="exhib_title1"<?php echo $cpy_exhibition->exhib_title1->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_title1">
<span<?php echo $cpy_exhibition->exhib_title1->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_title1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title2->Visible) { // exhib_title2 ?>
	<tr id="r_exhib_title2">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_title2"><?php echo $cpy_exhibition->exhib_title2->FldCaption() ?></span></td>
		<td data-name="exhib_title2"<?php echo $cpy_exhibition->exhib_title2->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_title2">
<span<?php echo $cpy_exhibition->exhib_title2->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_title2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_date->Visible) { // exhib_date ?>
	<tr id="r_exhib_date">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_date"><?php echo $cpy_exhibition->exhib_date->FldCaption() ?></span></td>
		<td data-name="exhib_date"<?php echo $cpy_exhibition->exhib_date->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_date">
<span<?php echo $cpy_exhibition->exhib_date->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_from->Visible) { // exhib_from ?>
	<tr id="r_exhib_from">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_from"><?php echo $cpy_exhibition->exhib_from->FldCaption() ?></span></td>
		<td data-name="exhib_from"<?php echo $cpy_exhibition->exhib_from->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_from">
<span<?php echo $cpy_exhibition->exhib_from->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_from->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_to->Visible) { // exhib_to ?>
	<tr id="r_exhib_to">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_to"><?php echo $cpy_exhibition->exhib_to->FldCaption() ?></span></td>
		<td data-name="exhib_to"<?php echo $cpy_exhibition->exhib_to->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_to">
<span<?php echo $cpy_exhibition->exhib_to->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_to->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_web->Visible) { // exhib_web ?>
	<tr id="r_exhib_web">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_web"><?php echo $cpy_exhibition->exhib_web->FldCaption() ?></span></td>
		<td data-name="exhib_web"<?php echo $cpy_exhibition->exhib_web->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_web">
<span<?php echo $cpy_exhibition->exhib_web->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_web->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_intro->Visible) { // exhib_intro ?>
	<tr id="r_exhib_intro">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_intro"><?php echo $cpy_exhibition->exhib_intro->FldCaption() ?></span></td>
		<td data-name="exhib_intro"<?php echo $cpy_exhibition->exhib_intro->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_intro">
<span<?php echo $cpy_exhibition->exhib_intro->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_intro->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_info->Visible) { // exhib_info ?>
	<tr id="r_exhib_info">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_info"><?php echo $cpy_exhibition->exhib_info->FldCaption() ?></span></td>
		<td data-name="exhib_info"<?php echo $cpy_exhibition->exhib_info->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_info">
<span<?php echo $cpy_exhibition->exhib_info->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_info->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_text->Visible) { // exhib_text ?>
	<tr id="r_exhib_text">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_text"><?php echo $cpy_exhibition->exhib_text->FldCaption() ?></span></td>
		<td data-name="exhib_text"<?php echo $cpy_exhibition->exhib_text->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_text">
<span<?php echo $cpy_exhibition->exhib_text->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_text->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cpy_exhibition->exhib_image->Visible) { // exhib_image ?>
	<tr id="r_exhib_image">
		<td class="col-sm-2"><span id="elh_cpy_exhibition_exhib_image"><?php echo $cpy_exhibition->exhib_image->FldCaption() ?></span></td>
		<td data-name="exhib_image"<?php echo $cpy_exhibition->exhib_image->CellAttributes() ?>>
<span id="el_cpy_exhibition_exhib_image">
<span>
<?php echo ew_GetFileViewTag($cpy_exhibition->exhib_image, $cpy_exhibition->exhib_image->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$cpy_exhibition_view->IsModal) { ?>
<?php if (!isset($cpy_exhibition_view->Pager)) $cpy_exhibition_view->Pager = new cPrevNextPager($cpy_exhibition_view->StartRec, $cpy_exhibition_view->DisplayRecs, $cpy_exhibition_view->TotalRecs, $cpy_exhibition_view->AutoHidePager) ?>
<?php if ($cpy_exhibition_view->Pager->RecordCount > 0 && $cpy_exhibition_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cpy_exhibition_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cpy_exhibition_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cpy_exhibition_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cpy_exhibition_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cpy_exhibition_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cpy_exhibition_view->PageUrl() ?>start=<?php echo $cpy_exhibition_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cpy_exhibition_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php
	if (in_array("cpy_exhibition_images", explode(",", $cpy_exhibition->getCurrentDetailTable())) && $cpy_exhibition_images->DetailView) {
?>
<?php if ($cpy_exhibition->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_exhibition_images", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_exhibition_imagesgrid.php" ?>
<?php } ?>
<?php
	if (in_array("cpy_exhibition_video", explode(",", $cpy_exhibition->getCurrentDetailTable())) && $cpy_exhibition_video->DetailView) {
?>
<?php if ($cpy_exhibition->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_exhibition_video", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_exhibition_videogrid.php" ?>
<?php } ?>
<?php
	if (in_array("cpy_artwork_exhibtion", explode(",", $cpy_exhibition->getCurrentDetailTable())) && $cpy_artwork_exhibtion->DetailView) {
?>
<?php if ($cpy_exhibition->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cpy_artwork_exhibtion", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cpy_artwork_exhibtiongrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fcpy_exhibitionview.Init();
</script>
<?php
$cpy_exhibition_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_exhibition_view->Page_Terminate();
?>
