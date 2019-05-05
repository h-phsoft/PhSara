<?php

header('Access-Control-Allow-Origin: *');
?>
<?php

/**
 * PhSoft Common classes and functions
 * (C) 2000-2015 PhSoft.
 */
// Include PHPMailer class
include_once("PhModules/phpmailer527/class.phpmailer.php");

// Email
/*
  define("PH_SMTP_SERVER", "localhost", TRUE); // SMTP server
  define("PH_SMTP_SERVER_PORT", 25, TRUE); // SMTP server port
  define("PH_SMTP_SECURE_OPTION", "", TRUE); // SMTP Secur options: "", "ssl" or "tls"
  define("PH_SMTP_SERVER_USERNAME", "", TRUE); // SMTP server user name
  define("PH_SMTP_SERVER_PASSWORD", "", TRUE); // SMTP server password
 */

// Function to send email
function ph_SendEmail($sRecipients = array(
    "From" => "",
    "To" => "",
    "Cc" => "",
    "Bcc" => ""
), $sSubject = "no Subject", $sMail = "", $SMTPOptions = array(
    "PH_SMTP_SERVER" => "localhost",
    "PH_SMTP_SERVER_PORT" => 25,
    "PH_SMTP_SERVER_USERNAME" => "",
    "PH_SMTP_SERVER_PASSWORD" => "",
    "PH_SMTP_SERVER_SECURE" => ""
), $arAttachments = array(), $sFormat = "", $sCharset = "UTF-8", $arImages = array(), $mail = NULL) {
  $gsEmailErrDesc = '';
  $res = FALSE;
  if (is_null($mail)) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $SMTPOptions["PH_SMTP_SERVER"];
    $mail->SMTPAuth = ($SMTPOptions["PH_SMTP_SERVER_USERNAME"] <> "" && $SMTPOptions["PH_SMTP_SERVER_PASSWORD"] <> "");
    $mail->Username = $SMTPOptions["PH_SMTP_SERVER_USERNAME"];
    $mail->Password = $SMTPOptions["PH_SMTP_SERVER_PASSWORD"];
    $mail->Port = $SMTPOptions["PH_SMTP_SERVER_PORT"];
  }
  if ($SMTPOptions["PH_SMTP_SERVER_SECURE"] <> "") {
    $mail->SMTPSecure = $SMTPOptions["PH_SMTP_SERVER_SECURE"];
  }
  if (preg_match('/^(.+)<([\w.%+-]+@[\w.-]+\.[A-Z]{2,6})>$/i', trim($sRecipients['FROM']), $m)) {
    $mail->From = $m[2];
    $mail->FromName = trim($m[1]);
  } else {
    $mail->From = $sRecipients['FROM'];
    $mail->FromName = $sRecipients['FROM'];
  }
  $mail->Subject = $sSubject;
  $mail->Body = $sMail;
  if ($sCharset <> "" && strtolower($sCharset) <> "iso-8859-1") {
    $mail->CharSet = $sCharset;
  }
  $sRecipients['TO'] = str_replace(";", ",", $sRecipients['TO']);
  $arrTo = explode(",", $sRecipients['TO']);
  foreach ($arrTo as $sTo) {
    $mail->AddAddress(trim($sTo));
  }
  if ($sRecipients['CC'] <> "") {
    $sRecipients['CC'] = str_replace(";", ",", $sRecipients['CC']);
    $arrCc = explode(",", $sRecipients['CC']);
    foreach ($arrCc as $sCc) {
      $mail->AddCC(trim($sCc));
    }
  }
  if ($sRecipients['BCC'] <> "") {
    $sRecipients['BCC'] = str_replace(";", ",", $sRecipients['BCC']);
    $arrBcc = explode(",", $sRecipients['BCC']);
    foreach ($arrBcc as $sBcc) {
      $mail->AddBCC(trim($sBcc));
    }
  }
  if (strtolower($sFormat) == "html") {
    $mail->ContentType = "text/html";
  } else {
    $mail->ContentType = "text/plain";
  }
  if (is_array($arAttachments)) {
    foreach ($arAttachments as $attachment) {
      $mail->AddAttachment($attachment);
    }
  }
  if (is_array($arImages)) {
    foreach ($arImages as $tmpimage) {
      $file = $tmpimage;
      $cid = ew_TmpImageLnk($tmpimage, "cid");
      $mail->AddEmbeddedImage($file, $cid, $tmpimage);
    }
  }
  $res = $mail->Send();
  $gsEmailErrDesc = $mail->ErrorInfo;

  // Uncomment to debug
  // var_dump($mail); exit();

  return $gsEmailErrDesc;
}

// Get DB Setting Varchar Value from Database
function ph_Setting($vKey) {
  $vRet = ph_SettingValue($vKey, 'set_val');
  return $vRet;
}

// Get DB Setting Number Value from Database
function ph_SettingValue($vKey, $vValue = 'set_val') {
  $vRet = ph_GetDBValue($vValue, 'phs_setting', 'upper(`set_name`)=upper("' . $vKey . '")');
  return $vRet;
}

// Get value from database from table by condition
function ph_GetDBValue($sField, $sTable, $sWhere = '') {
  $sRetVal = '';
  $sSQL = "SELECT " . $sField . " AS `vValue` FROM " . $sTable;
  if ($sWhere != '') {
    $sSQL .= " WHERE " . $sWhere;
  }
  try {
    $res = ph_Execute($sSQL);
    if ($res != "") {
      if (!$res->EOF) {
        $sRetVal = $res->fields('vValue');
      }
      $res->Close();
    }
  } catch (Exception $ex) {
    $sRetVal = "";
  }
  return $sRetVal;
}

// Get DB Keys Value from Array
function ph_DBKey($sKey, $nLang = 1) {
  global $dbKeys;
  $sUKey = strtoupper($sKey);
  $sRetVar = $sKey;
  if (!isset($dbKeys)) {
    $dbKeys = ph_LoadDBKeys($nLang);
  }
  if (array_key_exists($sUKey, $dbKeys)) {
    $sRetVar = $dbKeys[$sUKey];
  } else {
    $sRetVar = ph_DBKeyValue($sKey, $nLang);
    if ($sRetVar == '') {
      $sRetVar = $sKey;
    }
  }
  return $sRetVar;
}

// Load DB Keys into Matrix
function ph_LoadDBKeys($nLang) {
  global $dbKeys;
  $sSQL = "SELECT `key_name`, `key_value`" .
          " FROM `phs_vkeys` " .
          " WHERE `lang_id`=" . $nLang;
  $res = ph_Execute($sSQL);
  $dbKeys = array();
  if ($res != "") {
    while (!$res->EOF) {
      $dbKeys[strtoupper($res->fields('key_name'))] = $res->fields('key_value');
      $res->MoveNext();
    }
    $res->Close();
  }
  return $dbKeys;
}

// Get DB Keys Value from Database
function ph_DBKeyValue($sKey, $nLang = 1) {
  $sRetVar = ph_GetDBValue("`key_value`", "`phs_vkeys`", 'UPPER(`key_name`)=UPPER("' . $sKey . '") AND `lang_id`=' . $nLang);
  return $sRetVar;
}

// Get DB Keys Value from Database
function ph_DBKeyText($sKey, $nLang = 1) {
  $sRetVar = ph_GetDBValue("`key_text`", "`phs_vkeys`", 'UPPER(`key_name`)=UPPER("' . $sKey . '") AND `lang_id`=' . $nLang);
  return $sRetVar;
}

// Load Metta Data
function ph_GetMetta() {
  $sSQL = "SELECT `metta_type`, `metta_name`, `metta_value` FROM `phs_metta` ORDER BY `metta_type`, `metta_name`";
  $vRet = chr(13);
  $res = ph_Execute($sSQL);
  if ($res != "") {
    while (!$res->EOF) {
      $vRet .= '<meta ' . $res->fields('metta_type') . '="' . $res->fields('metta_name') . '" content="' . $res->fields('metta_value') . '">' . chr(13);
      $res->MoveNext();
    }
    $res->Close();
  }
  return $vRet;
}

// Generate random number
function ph_Random() {
  return mt_rand();
}

function base64_to_jpeg($base64_string, $output_file) {
  $ifp = fopen($output_file, "wb");
  $data = explode(',', $base64_string);
  fwrite($ifp, base64_decode($data[1]));
  fclose($ifp);
  return $output_file;
}

// Check email
function ph_CheckEmail($value) {
  $retVar = TRUE;
  if (strval($value) == "") {
    $retVar = TRUE;
  } else {
    $retVar = preg_match('/^[\w.%+-]+@[\w.-]+\.[A-Z]{2,6}$/i', trim($value));
  }
  return $retVar;
}

// Get server variable by name
if (!function_exists('ph_ServerVar')) {

  function ph_ServerVar($Name) {
    $str = $_SERVER[$Name];
    if (empty($str)) {
      $str = $_ENV[$Name];
    }
    return $str;
  }

}

/* * ****************************** */

if (!function_exists('ph_PrepareGets')) {

  function ph_PrepareGets() {
    foreach ($_GET as $key => $value) {
      if (!is_array($key)) {
        if (!is_array($value)) {
          $_GET[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
        }
      }
    }
  }

}

if (!function_exists('ph_PreparePosts')) {

  function ph_PreparePosts() {
    foreach ($_POST as $key => $value) {
      if (!is_array($key)) {
        if (!is_array($value)) {
          $_POST[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
        }
      }
    }
  }

}

if (!function_exists('ph_PrepareRequests')) {

  function ph_PrepareRequests() {
    foreach ($_REQUEST as $key => $value) {
      if (!is_array($key)) {
        $_REQUEST[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
      }
    }
  }

}

/**
 * Get GET input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Get')) {

  function ph_Get($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_GET, $filter) : $_GET;
      } else {
        $retVar = $_GET;
      }
    } else {
      if (isset($_GET[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_GET, $key, $filter) : $_GET[$key];
        } else {
          $retVar = $_GET[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}
/**
 * Get POST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Post')) {

  function ph_Post($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_POST, $filter) : $_POST;
      } else {
        $retVar = $_POST;
      }
    } else {
      if (isset($_POST[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_POST, $key, $filter) : $_POST[$key];
        } else {
          $retVar = $_POST[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get GET_POST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Get_Post')) {

  function ph_Get_Post($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!isset($GLOBALS['_GET_POST'])) {
      $GLOBALS['_GET_POST'] = array_merge($_GET, $_POST);
    }
    if (!$key) {
      if (function_exists('filter_var_array')) {
        $retVar = $filter ? filter_var_array($GLOBALS['_GET_POST'], $filter) : $GLOBALS['_GET_POST'];
      } else {
        $retVar = $GLOBALS['_GET_POST'];
      }
    } else {
      if (isset($GLOBALS['_GET_POST'][$key])) {
        if (function_exists('filter_var')) {
          $retVar = $filter ? filter_var($GLOBALS['_GET_POST'][$key], $filter) : $GLOBALS['_GET_POST'][$key];
        } else {
          $retVar = $GLOBALS['_GET_POST'][$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get REQUEST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Request')) {

  function ph_Request($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_REQUEST, $filter) : $_REQUEST;
      } else {
        $retVar = $_REQUEST;
      }
    } else {
      if (isset($_REQUEST[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_REQUEST, $key, $filter) : $_REQUEST[$key];
        } else {
          $retVar = $_REQUEST[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get COOKIE input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Cookie')) {

  function ph_Cookie($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_COOKIE, $filter) : $_COOKIE;
      } else {
        $retVar = $_COOKIE;
      }
    } else {
      if (isset($_COOKIE[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_COOKIE, $key, $filter) : $_COOKIE[$key];
        } else {
          $retVar = $_COOKIE[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Set COOKIE input
 *
 * time can be set in seconds
 *
 * @param String $key
 * @param Mixed  $value
 * @param Int    $time
 */
if (!function_exists('ph_SetCookie')) {

  function ph_SetCookie($key, $value, $time = SECONDS_IN_A_HOUR) {
    setcookie($key, $value, time() + $time, "/");
  }

}

/**
 * Delete COOKIE input
 *
 * @param String $key
 */
if (!function_exists('ph_DeleteCookie')) {

  function ph_DeleteCookie($key) {
    setcookie($key, null, time() - SECONDS_IN_A_HOUR, "/");
    unset($_COOKIE[$key]);
  }

}

/**
 * Get a session variable.
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Session')) {

  function ph_Session($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_var_array')) {
        $retVar = $filter ? filter_var_array($_SESSION, $filter) : $_SESSION;
      } else {
        $retVar = $_SESSION;
      }
    } else {
      if (isset($_SESSION[$key])) {
        if (function_exists('filter_var')) {
          $retVar = $filter ? filter_var($_SESSION[$key], $filter) : $_SESSION[$key];
        } else {
          $retVar = $_SESSION[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Set a session variable.
 *
 * @param String $key
 * @param mixed  $value
 */
if (!function_exists('ph_SetSession')) {

  function ph_SetSession($key, $value = '') {
    if (isset($key)) {
      $_SESSION[$key] = $value;
    }
  }

}

/* * ****************************** */

function ph_Clean_String($sString) {
  $sString = str_replace('#', '', $sString);
  $sString = str_replace('&', '', $sString);
  $sString = str_replace(';', '', $sString);
  $sString = str_replace('!', '', $sString);
  $sString = str_replace('"', '', $sString);
  $sString = str_replace('$', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('%', '', $sString);
  $sString = str_replace("'", '', $sString);
  $sString = str_replace('(', '', $sString);
  $sString = str_replace(')', '', $sString);
  $sString = str_replace('*', '', $sString);
  $sString = str_replace('+', '', $sString);
  $sString = str_replace(',', '', $sString);
  $sString = str_replace('-', '', $sString);
  $sString = str_replace('.', '', $sString);
  $sString = str_replace('/', '', $sString);
  $sString = str_replace(':', '', $sString);
  $sString = str_replace('<', '', $sString);
  $sString = str_replace('=', '', $sString);
  $sString = str_replace('>', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('[', '', $sString);
  $sString = str_replace('\\', '', $sString);
  $sString = str_replace(']', '', $sString);
  $sString = str_replace('^', '', $sString);
  $sString = str_replace('_', '', $sString);
  $sString = str_replace('`', '', $sString);
  $sString = str_replace('{', '', $sString);
  $sString = str_replace('|', '', $sString);
  $sString = str_replace('}', '', $sString);
  $sString = str_replace('~', '', $sString);
  $sString = str_replace("select", "", $sString);
  $sString = str_replace("SELECT", "", $sString);
  $sString = str_replace("update", "", $sString);
  $sString = str_replace("UPDATE", "", $sString);
  $sString = str_replace("delete", "", $sString);
  $sString = str_replace("DELETE", "", $sString);
  $sString = str_replace("union", "", $sString);
  $sString = str_replace("UNION", "", $sString);
  $sString = str_replace("from", "", $sString);
  $sString = str_replace("FROM", "", $sString);
  $sString = str_replace("concat", "", $sString);
  $sString = str_replace("CONCAT", "", $sString);
  $sString = str_replace("usrnam", "", $sString);
  $sString = str_replace("passwod", "", $sString);
  $sString = str_replace("cmslog", "", $sString);
  $sString = str_replace("drop", "", $sString);
  $sString = str_replace("DROP", "", $sString);
  $sString = str_replace(";", "", $sString);
  $sString = str_replace("--", "", $sString);
  $sString = str_replace("\0", "", $sString);
  $sString = htmlspecialchars($sString);
  $sString = strip_tags($sString);

  return $sString;
}

function ph_Clean_EMail($sString) {
  $sString = str_replace('#', '', $sString);
  $sString = str_replace('&', '', $sString);
  $sString = str_replace(';', '', $sString);
  $sString = str_replace(' ', '', $sString);
  $sString = str_replace('!', '', $sString);
  $sString = str_replace('"', '', $sString);
  $sString = str_replace('$', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('%', '', $sString);
  $sString = str_replace("'", '', $sString);
  $sString = str_replace('(', '', $sString);
  $sString = str_replace(')', '', $sString);
  $sString = str_replace('*', '', $sString);
  $sString = str_replace('+', '', $sString);
  $sString = str_replace(',', '', $sString);
  $sString = str_replace('-', '', $sString);
  $sString = str_replace('/', '', $sString);
  $sString = str_replace(':', '', $sString);
  $sString = str_replace('<', '', $sString);
  $sString = str_replace('=', '', $sString);
  $sString = str_replace('>', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('[', '', $sString);
  $sString = str_replace('\\', '', $sString);
  $sString = str_replace(']', '', $sString);
  $sString = str_replace('^', '', $sString);
  $sString = str_replace('_', '', $sString);
  $sString = str_replace('`', '', $sString);
  $sString = str_replace('{', '', $sString);
  $sString = str_replace('|', '', $sString);
  $sString = str_replace('}', '', $sString);
  $sString = str_replace('~', '', $sString);
  $sString = str_replace("select", "", $sString);
  $sString = str_replace("SELECT", "", $sString);
  $sString = str_replace("update", "", $sString);
  $sString = str_replace("UPDATE", "", $sString);
  $sString = str_replace("delete", "", $sString);
  $sString = str_replace("DELETE", "", $sString);
  $sString = str_replace("union", "", $sString);
  $sString = str_replace("UNION", "", $sString);
  $sString = str_replace("from", "", $sString);
  $sString = str_replace("FROM", "", $sString);
  $sString = str_replace("concat", "", $sString);
  $sString = str_replace("CONCAT", "", $sString);
  $sString = str_replace("usrnam", "", $sString);
  $sString = str_replace("passwod", "", $sString);
  $sString = str_replace("cmslog", "", $sString);
  $sString = str_replace("drop", "", $sString);
  $sString = str_replace("DROP", "", $sString);
  $sString = str_replace(";", "", $sString);
  $sString = str_replace("--", "", $sString);
  $sString = str_replace("\0", "", $sString);
  $sString = htmlspecialchars($sString);
  $sString = strip_tags($sString);

  return $sString;
}

function ph_Clean_Password($sString) {
  $sString = str_replace('"', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace("'", '', $sString);
  $sString = str_replace('(', '', $sString);
  $sString = str_replace(')', '', $sString);
  $sString = str_replace('<', '', $sString);
  $sString = str_replace('=', '', $sString);
  $sString = str_replace('>', '', $sString);
  $sString = str_replace('?', '', $sString);
  $sString = str_replace('[', '', $sString);
  $sString = str_replace('\\', '', $sString);
  $sString = str_replace(']', '', $sString);
  $sString = str_replace('`', '', $sString);
  $sString = str_replace('{', '', $sString);
  $sString = str_replace('|', '', $sString);
  $sString = str_replace('}', '', $sString);
  $sString = str_replace("select", "", $sString);
  $sString = str_replace("SELECT", "", $sString);
  $sString = str_replace("update", "", $sString);
  $sString = str_replace("UPDATE", "", $sString);
  $sString = str_replace("delete", "", $sString);
  $sString = str_replace("DELETE", "", $sString);
  $sString = str_replace("union", "", $sString);
  $sString = str_replace("UNION", "", $sString);
  $sString = str_replace("from", "", $sString);
  $sString = str_replace("FROM", "", $sString);
  $sString = str_replace("concat", "", $sString);
  $sString = str_replace("CONCAT", "", $sString);
  $sString = str_replace("usrnam", "", $sString);
  $sString = str_replace("passwod", "", $sString);
  $sString = str_replace("cmslog", "", $sString);
  $sString = str_replace("drop", "", $sString);
  $sString = str_replace("DROP", "", $sString);
  $sString = str_replace(";", "", $sString);
  $sString = str_replace("--", "", $sString);
  $sString = str_replace("\0", "", $sString);
  $sString = htmlspecialchars($sString);
  $sString = strip_tags($sString);

  return $sString;
}

function ph_UploadFile($srcFilename, $target_dir = 'uploads/', $newFileName = '') {

  $uploadOk = 0;
  if ($newFileName == '') {
    $newFileName = $srcFilename;
  }
  $distFilename = $target_dir . $newFileName . date("ymdHis") . '.' . pathinfo(basename($_FILES[$srcFilename]["name"]), PATHINFO_EXTENSION);
  $imageFileType = pathinfo(basename($_FILES[$srcFilename]["name"]), PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES[$srcFilename]["tmp_name"]);
  if ($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 0;
  } else {
    //echo "File is not an image.";
    $uploadOk = 1;
  }

// Check if file already exists
  if (file_exists($distFilename)) {
    //echo "Sorry, file already exists.";
    $uploadOk = 2;
  }
// Check file size
  if ($_FILES[$srcFilename]["size"] > 200000) {
    //echo "Sorry, your file is too large.";
    $uploadOk = 3;
  }
// Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 4;
  }
// Check if $uploadOk is set to 0 by an error
  if ($uploadOk != 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES[$srcFilename]["tmp_name"], $distFilename)) {
      //echo "The file " . basename($_FILES["idImage1"]["name"]) . " has been uploaded.";
    } else {
      //echo "Sorry, there was an error uploading your file.";
      $uploadOk = 2;
    }
  }
  return array("Status" => $uploadOk, "NewFileName" => $distFilename);
}
