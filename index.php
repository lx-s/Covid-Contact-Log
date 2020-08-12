<?php
   namespace LXS\CCL;

  require 'common.php';

  $errors = [];
  $success = [];

  function add_entry($who)
  {
    global $db_;
    global $errors;
    global $success;
    $added = false;

    $sql = 'INSERT INTO '.DB_TABLE_PREFIX.'contact_log(who) VALUES(:who)';
    $stmt = $db_->prepare($sql);
    if ($stmt === FALSE) {
      $errors[] = 'Failed to prepare SQL statement: <code>'.$db->errorInfo().'</code>';
    } else {
      $stmt->bindValue(':who', $who, \PDO::PARAM_STR);
      if ($stmt->execute() === true) {
        $success[] = 'Entry added!';
        $added = true;
      } else {
        $errors[] = 'Failed to insert entry: <code>'.$db->errorInfo().'</code>';
      }
      $stmt->closeCursor();
    }

    return $added;
  }

  function get_entries($lastDays)
  {
    global $db_;
    global $errors;
    global $success;
    $results = false;

    $sql = 'SELECT entry_id, time, who FROM '.DB_TABLE_PREFIX.'contact_log'
           .' WHERE time BETWEEN(NOW() - INTERVAL :days DAY) AND NOW()'
           .' ORDER BY time DESC';
    $stmt = $db_->prepare($sql);
    if ($stmt === FALSE) {
      $errors[] = 'Failed to prepare SQL statement: <code>'.$db->errorInfo().'</code>';
    } else {
      $stmt->bindValue(':days', $lastDays);
      if (!$stmt->execute() || ($results = $stmt->fetchAll(\PDO::FETCH_ASSOC)) === FALSE) {
        $errors[] = 'Failed to query database: <code>'.$db->errorInfo().'</code>';
      }
      $stmt->closeCursor();
    }

    return $results;
  }

  if (isset($_POST['add_entry'])) {
    $who = isset($_POST['who']) ? $_POST['who'] : '';
    if (strlen($who) <= 1) {
      $errors[] = 'Please enter a name';
    } else {
      add_entry($who);
    }
  }

  $entries = get_entries(ENTRY_LOG_DAYS);

?><!doctype html>
<html lang="de" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <title><?php _t('page.title'); ?></title>
</head>
<body>
  <header>
    <div class="content-wrapper">
      <h1 class="page-title">
        <span class="emoji">&#128106;</span> <?php _t('page.title'); ?>
      </h1>
    </div>
  </header>

  <div class="ccv-form content-wrapper">
    <?php if (!empty($errors)) : ?>
      <ul class="error-list">
        <?php foreach ($errors as $e) : ?>
          <li><?php echo $e; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
      <ul class="success-list">
        <?php foreach ($success as $s) : ?>
          <li><?php echo $s; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif ;?>

    <form name="add_entry_form" action="./" method="post" accept-charset="utf-8">
      <h2><span class="emoji">&#128278;</span> <?php _t('add_entry.title'); ?></h2>
      <div class="input-field">
        <label for="who"><?php _t('add_entry.who.label'); ?></label>
        <input id="who" name="who" type="text" value="" placeholder="<?php _t('add_entry.who.placeholder'); ?>" required>
      </div>
      <input type="submit" name="add_entry" value="<?php _t('add_entry.add_btn'); ?>">
    </form>
  </div>

  <div class="ccl-calendar content-wrapper">
    <h2>
      <span class="emoji">&#128197;</span>
      <?php _t('log.title', ENTRY_LOG_DAYS); ?>
    </h2>
    <div class="ccl-entries">
   <?php
      if ($entries) {
         $lastMonth = 0;
         $lastDay   = 0;
         foreach ($entries as $e) {
            $date = \date_parse($e['time']);
            $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $e['time']);
            $dateObj->setTimezone($dtZone_);
            if ($lastMonth != $date['month']) {
               $monthName = $dtFormaterMonth_->format($dateObj);
               if ($lastMonth != 0) { // Close previous div.month
                  echo '</ul></div>'; // day-list, day
                  echo '</div></div>'; // days, month
               }
               echo '<div class="month">'
                     .'<h3><div class="calendar-month">'.$monthName.' <span class="calendar-month-year">'.$date['year'].'</span></div></h3>'
                     .'<div class="days">';
               $lastMonth = $date['month'];
               $lastDay = 0; /* Reset */
            }
            if ($lastDay != $date['day']) {
               $dayName = $dtFormaterDay_->format($dateObj);
               if ($lastDay != 0) { // close previous div.day
                  echo '</ul></div>'; // day
               }
               echo '<div class="day">'
                     .'<h4><span class="calendar-day">'.$dayName.', '.$date['day'].'</span></h4>'
                     .'<ul class="day-list">';
               $lastDay = $date['day'];
            }
            echo '<li>'.$e['who'].'</li>';
         }
         if (!empty($entries)) {
            echo '</ul></div></div>';
         }

      } ?>
    </div>
  </div>

  <footer>
    <div class="content-wrapper">
      &#128567; <?php _t('footer.text'); ?>
    </div>
  </footer>
</body>
</html>