<?php
  namespace LXS\CCV;

  define('DB_HOST', 'localhost');
  define('DB_PORT', 3306);
  define('DB_USER', '');
  define('DB_NAME', '');
  define('DB_PASSWORD', '');
  define('DB_CHARSET', 'utf8');
  define('DB_TABLE_PREFIX', 'ccl');

  // Possible values are 'live' or 'dev'. Affects error reporting.
  // 'dev' displays errors and logs them to error.log
  // 'live' only logs them to error.log
  define('CCL_ENV', 'live');

  // see https://www.php.net/manual/timezones.php
  define('CCL_TIMEZONE', 'Europe/Berlin');

  // see contents of translations directory
  define('CCL_LANG', 'en');

  define('ENTRY_LOG_DAYS', 3 * 7); // Last 3 weeks
