<?php
   namespace LXS\CCL;

  require_once 'common.php';

  check_login();

  $entryId = isset($_GET['entryId']) ? (int)$_GET['entryId'] : 0;
  if ($entryId == 0) {
    header('location: ./index.php');
  }

  if (isset($_POST['do_delete'])) {
    if (db\delete_entry($entryId) === true) {
      header('location: ./index.php?mode=edit#calendar');
    }
  }

  $entry = db\get_entry($entryId);
  if ($entry === false) {
    header('location: ./index.php?mode=edit#calendar');
  }

  print_header(_tr('delete.title'));
?>
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
      <p><input class="btn btn-primary" type="submit" name="do_delete" value="<?php _t('delete.btn.confirm'); ?>"></p>
      <p><a href="./index.php?mode=edit#calendar"><?php _t('delete.btn.decline'); ?></a></p>
    </form>
  </div>
<?php
  print_footer();
?>