<?php
   namespace LXS\CCL;

  require 'common.php';
?><!doctype html>
<html lang="<?php echo CCL_LANG; ?>" dir="<?php echo CCL_LANG_LANGDIR; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
  <title><?php _t('page.title'); ?> &bull; <?php _t('tool.create_user.form.title'); ?></title>
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
    <h2><?php _t('tool.create_user.form.title'); ?></h2>

    <?php
      if (isset($_POST['do_create_user_entry'])) {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        if ($username != null && $password != null) {
          $entry = '\''.$username.'\' => \''.hash('sha256', $password).'\',';
          echo '<div class="generated-entry">'
           .'<code class="muted">$cclUsers_ = [</code>'
           .'<code class="user-entry">'.$entry.'</code>'
           .'<code class="muted">];</code></div>';
        }
      }
    ?>
    <form name="create_user" method="post" accept-charset="utf-8">
      <div class="input-field">
        <label for="username"><?php _t('tool.create_user.form.username.label'); ?></label>
        <input id="username" name="username" type="text"
               placeholder="<?php _t('tool.create_user.form.username.placeholder'); ?>" required>
      </div>
      <div class="input-field">
        <label for="password"><?php _t('tool.create_user.form.password.label'); ?></label>
        <input id="password" name="password" type="password"
               placeholder="<?php _t('tool.create_user.form.password.label'); ?>" required>
      </div>
      <input type="submit" name="do_create_user_entry"
             value="<?php _t('tool.create_user.form.create.btn'); ?>">
    </form>
  </div>

  <footer>
    <div class="content-wrapper">
      &#128567; <?php _t('footer.text'); ?>
    </div>
  </footer>
</body>
</html>