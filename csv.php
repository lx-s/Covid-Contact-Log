<?php
  namespace LXS\CCL;

  require_once 'common.php';

  check_login();

  $entries = db\get_entries(ENTRY_LOG_DAYS);

  if (($csv = \fopen('php://output', 'w')) == FALSE) {
    die('Failed to open output-device');
  } else {
    header('Content-type: application/csv');
    header('Content-disposition: attachment; filename=covid-contact-log.csv');
    \fputcsv($csv, array('Date', 'Contact'), ';');
    if ($entries) {
      foreach ($entries as $e) {
        $date = \date_parse($e['time']);
        $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $e['time']);
        $dateObj->setTimezone($dtZone_);
        \fputcsv($csv, array($dateObj->format('Y-m-d H:i:s'), $e['who']), ';');
      }
    }
    \fclose($csv);
  }
