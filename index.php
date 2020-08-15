<?php
   namespace LXS\CCL;

  require_once 'common.php';

  check_login();

  if (isset($_POST['do_add_entry'])) {
    $when = isset($_POST['when']) ? $_POST['when'] : '';
    $who = isset($_POST['who']) ? $_POST['who'] : '';
    if (\strlen($when) != 4+1+2+1+2) {
      $errors_[] = _tr('main.add_entry.error.nodate');
    } else if (\strlen($who) <= 1) {
      $errors_[] = _tr('main.add_entry.error.noname');
    } else {
      if (db\add_entry($when, $who) === true) {
        header('location: ./index.php?entryAdded=1');
      }
    }
  }

  db\delete_old_entries();
  $editMode = isset($_GET['mode']) ? $_GET['mode'] === 'edit' : false;
  $entries = db\get_entries(ENTRY_LOG_DAYS);

  if (isset($_GET['entryAdded']) && (int)$_GET['entryAdded'] == 1) {
    $successes_[] = _tr('sql.success.added');
  }

  print_header(_tr('main.title'));
?>
  <div class="ccv-form content-wrapper">
    <form name="add_entry_form" action="./" method="post" accept-charset="utf-8">
      <h2><span class="emoji">&#128278;</span> <?php _t('main.add_entry.title'); ?></h2>
      <div class="input-field">
        <label for="when"><?php _t('main.add_entry.when.label'); ?></label>
        <input id="when" name="when" type="date" value="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <div class="input-field">
        <label for="who"><?php _t('main.add_entry.who.label'); ?></label>
        <input id="who" name="who" type="text" value="" placeholder="<?php _t('main.add_entry.who.placeholder'); ?>" required>
      </div>
      <input type="submit" name="do_add_entry" value="<?php _t('main.add_entry.add_btn'); ?>">
    </form>
  </div>

  <div id="calendar" class="ccl-calendar content-wrapper">
    <h2>
      <span class="emoji">&#128197;</span>
      <?php _t('main.log.title', ENTRY_LOG_DAYS); ?>
    </h2>
    <div class="mode-switch">
      <?php if ($editMode) : ?>
        <a href="?mode="><span class="emoji">&#10060;</span> <?php _t('main.edit_mode.deactivate'); ?></a>
      <?php else : ?>
        <a href="?mode=edit#calendar"><span class="emoji">&#9998;</span> <?php _t('main.edit_mode.activate'); ?></a>
      <?php endif; ?>
    </div>
    <?php if ($editMode) : ?>
        <p class="edit-explanation"><?php _t('main.edit_mode.explanation'); ?></p>
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
                     .'<h4><div class="calendar-day"><span class="day-date">'.$date['day'].'</span> <span class="day-name">'.$dayName.'</span></div></h4>'
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

<?php
  print_footer();
?>