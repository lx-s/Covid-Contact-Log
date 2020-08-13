<?php
   namespace LXS\CCL;

  require 'common.php';

  $errors = [];

  if (isset($_POST['do_login'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? hash('sha256', $_POST['password']) : null;
    if ($username == null || $password == null) {
      $errors[] = _tr('login.error.enter_information');
    } else {
      $found = false;
      foreach ($cclUsers_ as $user=>$pw) {
        if ($user === $username && $pw === $pw) {
          if (login_user($user)) {
            \header('location: ./index.php');
            $found = true;
            break;
          }
        }
      }
      if (!$found) {
        $errors[] = _tr('login.error.wrong_credentials');
      }
    }
  }

?><!doctype html>
<html lang="<?php echo CCL_LANG; ?>" dir="<?php echo CCL_LANG_LANGDIR; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <title><?php _t('page.title'); ?> &bull; <?php _t('login.title'); ?></title>
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
    <h2><?php _t('login.title'); ?></h2>

    <?php if (!empty($errors)) : ?>
      <ul class="error-list">
        <?php foreach ($errors as $e) : ?>
          <li><?php echo $e; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form name="login_user" method="post" accept-charset="utf-8">
      <div class="input-field">
        <label for="username"><?php _t('login.form.username.label'); ?></label>
        <input id="username" name="username" type="text"
               placeholder="<?php _t('login.form.username.placeholder'); ?>" required>
      </div>
      <div class="input-field">
        <label for="password"><?php _t('login.form.password.label'); ?></label>
        <input id="password" name="password" type="password"
               placeholder="<?php _t('login.form.password.label'); ?>" required>
      </div>
      <input type="submit" name="do_login"
             value="<?php _t('login.form.login.btn'); ?>">
    </form>
  </div>

  <footer>
    <div class="content-wrapper">
      &#128567; <?php _t('footer.text'); ?>
    </div>
  </footer>
</body>
</html>