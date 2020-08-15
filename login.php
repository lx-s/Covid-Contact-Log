<?php
   namespace LXS\CCL;

  require_once 'common.php';

  if (isset($_POST['do_login'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? hash('sha256', $_POST['password']) : null;
    if ($username == null || $password == null) {
      $errors_[] = _tr('login.error.enter_information');
    } else {
      $found = false;
      foreach ($cclUsers_ as $user=>$pw) {
        if ($user === $username && $password === $pw) {
          if (login_user($user)) {
            \header('location: ./index.php');
            $found = true;
            break;
          }
        }
      }
      if (!$found) {
        $errors_[] = _tr('login.error.wrong_credentials');
      }
    }
  }

  print_header(_tr('login.title'));
?>
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
      <input class="btn btn-primary" type="submit" name="do_login"
             value="<?php _t('login.form.login.btn'); ?>">
    </form>
  </div>
<?php
  print_footer();
?>