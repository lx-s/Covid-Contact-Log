<?php
  declare(strict_types=1);

  namespace LXS\CCL;

  // ============================================================
  // Error reporting

  \error_reporting(E_ALL);
  \ini_set('error_log', './error.log');
  \ini_set('display_errors', (CCL_ENV == 'live') ? '0' : '1');

  require 'config.php';

  require 'translations/'.CCL_LANG.'.php';

  // ============================================================
  // Translation

  function _t($index, ...$params) {
     global $lang_;
     $str = isset($lang_[$index]) ? $lang_[$index] : null;
     if ($str != null) {
        $str = sprintf($str, $params);
     }
     echo ($str == null) ? $index.' not found' : $str;
  }

  // ============================================================
  // Database

  $db_ = new \PDO(
      sprintf('mysql:host=%s;dbname=%s;port=%s;charset=%s',
               DB_HOST,
               DB_NAME,
               DB_PORT,
               DB_CHARSET
            ),
            DB_USER,
            DB_PASSWORD
         );

  // ============================================================
  // Time format

  $dtZone_ = new \DateTimeZone(CCL_TIMEZONE);

  $dtFormaterDay_ = new \IntlDateFormatter(
    CCL_LANG_LANG_CODE,
    \IntlDateFormatter::FULL,
    \IntlDateFormatter::FULL,
    CCL_TIMEZONE,
    \IntlDateFormatter::GREGORIAN,
    'EEE'
  );

  $dtFormaterMonth_ = new \IntlDateFormatter(
    CCL_LANG_LANG_CODE,
    \IntlDateFormatter::FULL,
    \IntlDateFormatter::FULL,
    CCL_TIMEZONE,
    \IntlDateFormatter::GREGORIAN,
    'MMMM'
  );