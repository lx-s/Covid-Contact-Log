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
  <link rel="apple-touch-icon" sizes="57x57" href="/assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/assets/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/assets/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/assets/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/assets/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/assets/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
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
          <li><a class="btn btn-light dark-bg" href="logout.php"><?php _t('nav.logout'); ?></a></li>
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