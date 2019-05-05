<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "cpy_exhibitioninfo.php" ?>
<?php include_once "phs_usersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cpy_exhibition_delete = NULL; // Initialize page object first

class ccpy_exhibition_delete extends ccpy_exhibition {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{7F488A10-5B18-4626-9FF1-A34951991D65}';

	// Table name
	var $TableName = 'cpy_exhibition';

	// Page object name
	var $PageObjName = 'cpy_exhibition_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cpy_exhibitionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cpy_exhibition class, cpy_exhibitioninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("cpy_exhibitionlist.php"); // Return to list
			}
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// exhib_id

		$this->exhib_id->CellCssStyle = "white-space: nowrap;";

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
		$conn->BeginTrans();

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
				$sThisKey .= $row['exhib_id'];
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
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cpy_exhibitionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cpy_exhibition_delete)) $cpy_exhibition_delete = new ccpy_exhibition_delete();

// Page init
$cpy_exhibition_delete->Page_Init();

// Page main
$cpy_exhibition_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cpy_exhibition_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcpy_exhibitiondelete = new ew_Form("fcpy_exhibitiondelete", "delete");

// Form_CustomValidate event
fcpy_exhibitiondelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcpy_exhibitiondelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcpy_exhibitiondelete.Lists["x_type_id"] = {"LinkField":"x_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_type_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibtype"};
fcpy_exhibitiondelete.Lists["x_type_id"].Data = "<?php echo $cpy_exhibition_delete->type_id->LookupFilterQuery(FALSE, "delete") ?>";
fcpy_exhibitiondelete.Lists["x_kind_id"] = {"LinkField":"x_kind_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kind_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"cpy_exhibkind"};
fcpy_exhibitiondelete.Lists["x_kind_id"].Data = "<?php echo $cpy_exhibition_delete->kind_id->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $cpy_exhibition_delete->ShowPageHeader(); ?>
<?php
$cpy_exhibition_delete->ShowMessage();
?>
<form name="fcpy_exhibitiondelete" id="fcpy_exhibitiondelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cpy_exhibition_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cpy_exhibition_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cpy_exhibition">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cpy_exhibition_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($cpy_exhibition->type_id->Visible) { // type_id ?>
		<th class="<?php echo $cpy_exhibition->type_id->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_type_id" class="cpy_exhibition_type_id"><?php echo $cpy_exhibition->type_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->kind_id->Visible) { // kind_id ?>
		<th class="<?php echo $cpy_exhibition->kind_id->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_kind_id" class="cpy_exhibition_kind_id"><?php echo $cpy_exhibition->kind_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_year->Visible) { // exhib_year ?>
		<th class="<?php echo $cpy_exhibition->exhib_year->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_year" class="cpy_exhibition_exhib_year"><?php echo $cpy_exhibition->exhib_year->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title1->Visible) { // exhib_title1 ?>
		<th class="<?php echo $cpy_exhibition->exhib_title1->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_title1" class="cpy_exhibition_exhib_title1"><?php echo $cpy_exhibition->exhib_title1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title2->Visible) { // exhib_title2 ?>
		<th class="<?php echo $cpy_exhibition->exhib_title2->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_title2" class="cpy_exhibition_exhib_title2"><?php echo $cpy_exhibition->exhib_title2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_date->Visible) { // exhib_date ?>
		<th class="<?php echo $cpy_exhibition->exhib_date->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_date" class="cpy_exhibition_exhib_date"><?php echo $cpy_exhibition->exhib_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_from->Visible) { // exhib_from ?>
		<th class="<?php echo $cpy_exhibition->exhib_from->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_from" class="cpy_exhibition_exhib_from"><?php echo $cpy_exhibition->exhib_from->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_to->Visible) { // exhib_to ?>
		<th class="<?php echo $cpy_exhibition->exhib_to->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_to" class="cpy_exhibition_exhib_to"><?php echo $cpy_exhibition->exhib_to->FldCaption() ?></span></th>
<?php } ?>
<?php if ($cpy_exhibition->exhib_image->Visible) { // exhib_image ?>
		<th class="<?php echo $cpy_exhibition->exhib_image->HeaderCellClass() ?>"><span id="elh_cpy_exhibition_exhib_image" class="cpy_exhibition_exhib_image"><?php echo $cpy_exhibition->exhib_image->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$cpy_exhibition_delete->RecCnt = 0;
$i = 0;
while (!$cpy_exhibition_delete->Recordset->EOF) {
	$cpy_exhibition_delete->RecCnt++;
	$cpy_exhibition_delete->RowCnt++;

	// Set row properties
	$cpy_exhibition->ResetAttrs();
	$cpy_exhibition->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cpy_exhibition_delete->LoadRowValues($cpy_exhibition_delete->Recordset);

	// Render row
	$cpy_exhibition_delete->RenderRow();
?>
	<tr<?php echo $cpy_exhibition->RowAttributes() ?>>
<?php if ($cpy_exhibition->type_id->Visible) { // type_id ?>
		<td<?php echo $cpy_exhibition->type_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_type_id" class="cpy_exhibition_type_id">
<span<?php echo $cpy_exhibition->type_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition->type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->kind_id->Visible) { // kind_id ?>
		<td<?php echo $cpy_exhibition->kind_id->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_kind_id" class="cpy_exhibition_kind_id">
<span<?php echo $cpy_exhibition->kind_id->ViewAttributes() ?>>
<?php echo $cpy_exhibition->kind_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_year->Visible) { // exhib_year ?>
		<td<?php echo $cpy_exhibition->exhib_year->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_year" class="cpy_exhibition_exhib_year">
<span<?php echo $cpy_exhibition->exhib_year->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_year->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title1->Visible) { // exhib_title1 ?>
		<td<?php echo $cpy_exhibition->exhib_title1->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_title1" class="cpy_exhibition_exhib_title1">
<span<?php echo $cpy_exhibition->exhib_title1->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_title1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_title2->Visible) { // exhib_title2 ?>
		<td<?php echo $cpy_exhibition->exhib_title2->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_title2" class="cpy_exhibition_exhib_title2">
<span<?php echo $cpy_exhibition->exhib_title2->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_title2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_date->Visible) { // exhib_date ?>
		<td<?php echo $cpy_exhibition->exhib_date->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_date" class="cpy_exhibition_exhib_date">
<span<?php echo $cpy_exhibition->exhib_date->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_from->Visible) { // exhib_from ?>
		<td<?php echo $cpy_exhibition->exhib_from->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_from" class="cpy_exhibition_exhib_from">
<span<?php echo $cpy_exhibition->exhib_from->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_from->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_to->Visible) { // exhib_to ?>
		<td<?php echo $cpy_exhibition->exhib_to->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_to" class="cpy_exhibition_exhib_to">
<span<?php echo $cpy_exhibition->exhib_to->ViewAttributes() ?>>
<?php echo $cpy_exhibition->exhib_to->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cpy_exhibition->exhib_image->Visible) { // exhib_image ?>
		<td<?php echo $cpy_exhibition->exhib_image->CellAttributes() ?>>
<span id="el<?php echo $cpy_exhibition_delete->RowCnt ?>_cpy_exhibition_exhib_image" class="cpy_exhibition_exhib_image">
<span>
<?php echo ew_GetFileViewTag($cpy_exhibition->exhib_image, $cpy_exhibition->exhib_image->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$cpy_exhibition_delete->Recordset->MoveNext();
}
$cpy_exhibition_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cpy_exhibition_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcpy_exhibitiondelete.Init();
</script>
<?php
$cpy_exhibition_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cpy_exhibition_delete->Page_Terminate();
?>
