<?php
   namespace LXS\CCL;

  require 'common.php';

  if (!is_logged_in()) {
    \header('location: ./login.php');
  }

  $errors = [];

  function add_entry($who)
  {
    global $db_;
    global $errors;
    $added = false;

    $sql = 'INSERT INTO '.DB_TABLE_PREFIX.'contact_log(who) VALUES(:who)';
    $stmt = $db_->prepare($sql);
    if ($stmt === false) {
      $errors[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':who', $who, \PDO::PARAM_STR);
      if ($stmt->execute() === true) {
        $added = true;
      } else {
        $errors[] = _tr('sql.error.insert').': <code>'.get_sql_error($stmt).'</code>';
      }
      $stmt->closeCursor();
    }

    return $added;
  }

  function delete_old_entries()
  {
    if (defined('KEEP_OLD_ENTRIES') && KEEP_OLD_ENTRIES === false) {
      global $db_;
      global $errors;
      $sql = 'DELETE FROM '.DB_TABLE_PREFIX.'contact_log'
            .' WHERE time < NOW() - INTERVAL :days DAY';
      $stmt = $db_->prepare($sql);
      if ($stmt === false) {
        $errors[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
      } else {
        $stmt->bindValue(':days', ENTRY_LOG_DAYS, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
          $errors[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
        }
        $stmt->closeCursor();
      }
    }
  }

  function get_entries($lastDays)
  {
    global $db_;
    global $errors;
    $results = false;

    $sql = 'SELECT entry_id, time, who FROM '.DB_TABLE_PREFIX.'contact_log'
           .' WHERE time BETWEEN(NOW() - INTERVAL :days DAY) AND NOW()'
           .' ORDER BY time DESC';
    $stmt = $db_->prepare($sql);
    if ($stmt === false) {
      $errors[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':days', $lastDays, \PDO::PARAM_INT);
      if ($stmt->execute() === false || ($results = $stmt->fetchAll(\PDO::FETCH_ASSOC)) === false) {
        $errors[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
      }
      $stmt->closeCursor();
    }

    return $results;
  }

  if (isset($_POST['do_add_entry'])) {
    $who = isset($_POST['who']) ? $_POST['who'] : '';
    if (\strlen($who) <= 1) {
      $errors[] = _tr('add_entry.error.noname');
    } else {
      if (add_entry($who) === true) {
        header('location: ./index.php?entryAdded=1');
      }
    }
  }

  delete_old_entries();
  $entries = get_entries(ENTRY_LOG_DAYS);
  $editMode = isset($_GET['mode']) ? $_GET['mode'] === 'edit' : false;

?><!doctype html>
<html lang="<?php echo CCL_LANG; ?>" dir="<?php echo CCL_LANG_LANGDIR; ?>">
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
      <?php if (!empty($cclUsers_) && is_logged_in()) : ?>
        <ul class="meta-nav">
          <li><a href="logout.php"><?php _t('nav.logout'); ?></a></li>
        </ul>
      <?php endif; ?>
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

    <?php if (isset($_GET['entryAdded']) && ((int)$_GET['entryAdded'] === 1)) : ?>
      <ul class="success-list">
        <li><?php _t('sql.success.added') ?></li>
      </ul>
    <?php endif ;?>

    <form name="add_entry_form" action="./" method="post" accept-charset="utf-8">
      <h2><span class="emoji">&#128278;</span> <?php _t('add_entry.title'); ?></h2>
      <div class="input-field">
        <label for="who"><?php _t('add_entry.who.label'); ?></label>
        <input id="who" name="who" type="text" value="" placeholder="<?php _t('add_entry.who.placeholder'); ?>" required>
      </div>
      <input type="submit" name="do_add_entry" value="<?php _t('add_entry.add_btn'); ?>">
    </form>
  </div>

  <div id="calendar" class="ccl-calendar content-wrapper">
    <h2>
      <span class="emoji">&#128197;</span>
      <?php _t('log.title', ENTRY_LOG_DAYS); ?>
    </h2>
    <div class="mode-switch">
      <?php if ($editMode) : ?>
        <a href="?mode="><span class="emoji">&#10060;</span> <?php _t('edit_mode.deactivate'); ?></a>
      <?php else : ?>
        <a href="?mode=edit#calendar"><span class="emoji">&#9998;</span> <?php _t('edit_mode.activate'); ?></a>
      <?php endif; ?>
    </div>
    <?php if ($editMode) : ?>
        <p class="edit-explanation"><?php _t('edit_mode.explanation'); ?></p>
    <?php endif; ?>

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
            if ($editMode) {
              echo '<li><a class="delete-link" href="delete.php?entryId='.$e['entry_id'].'">'.$e['who'].'</a></li>';
            } else {
              echo '<li>'.$e['who'].'</li>';
            }
         }
         if (!empty($entries)) {
            echo '</ul></div></div>';
         }

      } ?>
    </div>
  </div>

  <footer>
    <div class="content-wrapper">
      <span class="emoji">&#128567;</span> <?php _t('footer.text'); ?>
    </div>
  </footer>
</body>
</html>