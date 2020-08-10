<?php
  namespace LXS\CCL;

  require 'config.php';

  date_default_timezone_set(CCL_TIMEZONE);

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