<?php
  declare(strict_types=1);

  namespace LXS\CCL;

  require_once 'config.php';
  require_once 'inc/db.inc.php';
  require_once 'inc/header.inc.php';
  require_once 'inc/footer.inc.php';

  // ============================================================
  // Error reporting

  \error_reporting(E_ALL);
  \ini_set('error_log', './error.log');
  \ini_set('display_errors', (CCL_ENV == 'live') ? '0' : '1');

  // ============================================================
  // Translation

  require 'translations/'.CCL_LANG.'.php';

  function _t($index, ...$params)
  {
     global $lang_;
     $str = isset($lang_[$index]) ? $lang_[$index] : null;
     if ($str != null) {
        $str = sprintf($str, ...$params);
     }
     echo ($str == null) ? $index.' not found' : $str;
  }

  /* returns translation */
  function _tr($index, ...$params) {
     global $lang_;
     $str = isset($lang_[$index]) ? $lang_[$index] : null;
     if ($str != null) {
        $str = \sprintf($str, ...$params);
     }
     return ($str == null) ? $index.' not found' : $str;
  }

  // ============================================================
  // User Management

  \session_start(['cookie_lifetime' => CCL_SESSION_LIVETIME]);

  function is_logged_in()
  {
    global $cclUsers_;
    if (empty($cclUsers_)) {
      return true;
    }
    if (isset($_SESSION['ccl-logged-in']) &&
        $_SESSION['ccl-logged-in'] === 1) {
      return true;
    }
    return false;
  }

  function login_user($username)
  {
    $_SESSION['ccl-logged-in'] = 1;
    return true;
  }

  function logout_user()
  {
    $_SESSION['ccl-logged-in'] = 0;
    unset($_SESSION['ccl-logged-in']);
  }

  function check_login()
  {
    if (!is_logged_in()) {
      \header('location: ./login.php');
    }
  }

  // ============================================================
  // Database
  $db_ = db\open_db();

  // ============================================================
  // Time format

  $dtZone_ = new \DateTimeZone(CCL_TIMEZONE);

  $dtFormaterDay_ = new \IntlDateFormatter(
    CCL_LANG_LANGCODE,
    \IntlDateFormatter::FULL,
    \IntlDateFormatter::FULL,
    CCL_TIMEZONE,
    \IntlDateFormatter::GREGORIAN,
    'EEE'
  );

  $dtFormaterMonth_ = new \IntlDateFormatter(
    CCL_LANG_LANGCODE,
    \IntlDateFormatter::FULL,
    \IntlDateFormatter::FULL,
    CCL_TIMEZONE,
    \IntlDateFormatter::GREGORIAN,
    'MMMM'
  );

  // ============================================================
  // Notifications

  $errors_ = [];
  $successes_ = [];