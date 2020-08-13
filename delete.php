<?php
   namespace LXS\CCL;

  require 'common.php';

  if (!is_logged_in()) {
    \header('location: ./login.php');
  }

  $entryId = isset($_GET['entryId']) ? (int)$_GET['entryId'] : 0;
  if ($entryId == 0) {
    header('location: ./index.php');
  }

  function get_entry($entryId) {
    global $db_;
    global $errrors;
    $sql = 'SELECT entry_id, time, who FROM '.DB_TABLE_PREFIX.'contact_log WHERE entry_id=:id';
    $stmt = $db_->prepare($sql);
    $entry = false;
    if ($stmt === false) {
      $errors[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':id', $entryId, \PDO::PARAM_INT);
      if ($stmt->execute() === false || ($entry = $stmt->fetchAll(\PDO::FETCH_ASSOC)) === false) {
        $errors[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
      }
      $stmt->closeCursor();
    }
    return ($entry !== false) ? $entry[0] : false;
  }

  $errors = [];

  if (isset($_POST['do_delete'])) {
    $sql = 'DELETE FROM '.DB_TABLE_PREFIX.'contact_log WHERE entry_id=:id';
    $stmt = $db_->prepare($sql);
    if ($stmt === false) {
      $errors[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':id', $entryId, \PDO::PARAM_INT);
      if ($stmt->execute() === false) {
        $errors[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
      } else {
        header('location: ./index.php?mode=edit#calendar');
      }
      $stmt->closeCursor();
    }
  }

  $entry = get_entry($entryId);
  if ($entry === false) {
    header('location: ./index.php?mode=edit#calendar');
  }
?><!doctype html>
<html lang="<?php echo CCL_LANG; ?>" dir="<?php echo CCL_LANG_LANGDIR; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <title><?php _t('page.title'); ?> &bull; <?php _t('delete.title'); ?></title>
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
    <h2><?php _t('delete.title'); ?></h2>

    <?php if (!empty($errors)) : ?>
      <ul class="error-list">
        <?php foreach ($errors as $e) : ?>
          <li><?php echo $e; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form name="delete_entry" method="post" action="?entryId=<?php echo $entryId; ?>"
          accept-charset="utf-8">
      <p><?php _t('delete.confirm'); ?></p>
      <ul class="entry-data">
        <li><?php echo $entry['who']; ?></li>
        <li><?php echo $entry['time']; ?></li>
      </ul>
      <p><input type="submit" name="do_delete" value="<?php _t('delete.btn.confirm'); ?>"></p>
      <p><a href="./index.php?mode=edit#calendar"><?php _t('delete.btn.decline'); ?></a></p>
    </form>
  </div>

  <footer>
    <div class="content-wrapper">
      &#128567; <?php _t('footer.text'); ?>
    </div>
  </footer>
</body>
</html>