<?php
  namespace LXS\CCL;

  require_once 'common.php';

  function print_header($pageTitle = '')
  {
    global $cclUsers_;
    global $errors_;
    global $successes_;
    ?>
<!doctype html>
<html lang="<?php echo CCL_LANG; ?>" dir="<?php echo CCL_LANG_LANGDIR; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <title><?php
    if ($pageTitle != '') {
      echo $pageTitle.' &bull; ';
    }
    _t('page.title');
  ?></title>
</head>
<body>
  <header>
    <div class="content-wrapper">
      <h1 class="page-title">
      <a href="./index.php"><span class="emoji">&#128106;</span> <?php _t('page.title'); ?></a>
      </h1>
      <?php if (!empty($cclUsers_) && is_logged_in()) : ?>
        <ul class="meta-nav">
          <li><a href="logout.php"><?php _t('nav.logout'); ?></a></li>
        </ul>
      <?php endif; ?>
    </div>
  </header>

  <div class="notifications content-wrapper">
    <?php if (!empty($errors_)) : ?>
      <ul class="error-list">
        <?php foreach ($errors_ as $e) : ?>
          <li><?php echo $e; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (!empty($successes_)) : ?>
      <ul class="success-list">
        <?php foreach ($successes_ as $s): ?>
          <li><?php echo $s; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif ;?>
  </div>
<?php }