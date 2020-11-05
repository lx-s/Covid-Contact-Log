<?php
   namespace LXS\CCL;

  require_once 'common.php';

  check_login();

  $entryId = isset($_GET['entryId']) ? (int)$_GET['entryId'] : 0;
  if ($entryId == 0) {
    header('location: ./index.php');
  }

  if (isset($_POST['do_edit_entry'])) {
    $date = isset($_POST['date']) ? $_POST['date'] : null;
    $time = isset($_POST['time']) ? $_POST['time'] : null;
    $who = isset($_POST['who']) ? $_POST['who'] : null;

    if ($date === null) {
      $errors_[] = _t('edit.error.forgot.date');
    }
    if ($time === null) {
      $errors_[] = _t('edit.error.forgot.time');
    }
    if ($who === null) {
      $errors_[] = _t('edit.error.forgot.who');
    }

    if ($date !== null && $time !== null && $who !== null) {
      $time .= ':00'; // add seconds
      if (db\edit_entry($entryId, $date, $time, $who) === true) {
        header('location: ./index.php?mode=edit#calendar');
      }
    }
  }

  $entry = db\get_entry($entryId);
  if ($entry === false) {
    header('location: ./index.php?mode=edit#calendar');
  }

  $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $entry['time']);

  print_header(_tr('edit.title'));
?>
  <div class="content-wrapper">
    <h2><span class="emoji">&#128278;</span> <?php _t('edit.title'); ?></h2>

    <?php if (!empty($errors)) : ?>
      <ul class="error-list">
        <?php foreach ($errors as $e) : ?>
          <li><?php echo $e; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form name="edit_entry_form" action="./edit.php?entryId=<?php echo $entryId; ?>" method="post" accept-charset="utf-8">
       <p><?php _t('edit.intro'); ?></p>

      <div class="input-field">
        <label for="date"><?php _t('edit.date.label'); ?></label>
        <input id="date" name="date" type="date" value="<?php echo $dateObj->format('Y-m-d'); ?>" required>
      </div>
      <div class="input-field">
        <label for="time"><?php _t('edit.time.label'); ?></label>
        <input id="time" name="time" type="time" value="<?php echo $dateObj->format('H:i'); ?>" required>
      </div>
      <div class="input-field">
        <label for="who"><?php _t('edit.who.label'); ?></label>
        <input id="who" name="who" type="text" value="<?php echo $entry['who']; ?>" placeholder="<?php _t('main.add_entry.who.placeholder'); ?>" required>
      </div>
      <p>
        <input class="btn btn-primary" type="submit" name="do_edit_entry" value="<?php _t('edit.btn.confirm'); ?>">
        <a class="btn" href="./index.php?mode=edit#calendar"><?php _t('edit.btn.decline'); ?></a>
      </p>
    </form>
    <hr>
    <p><a class="btn btn-light" href="delete.php?entryId=<?php echo $entryId; ?>"><?php _t('edit.btn.delete'); ?></a></p>

  </div>
<?php
  print_footer();
?>