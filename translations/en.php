<?php
  // Language: Englisch

  define('CCL_LANG_LANGCODE', 'en_US');
  define('CCL_LANG_LANGDIR', 'ltr');

  $lang_ = [
    // General
    'page.title' => 'Covid Contact Log',
    'nav.logout' => 'Log out',
    'footer.text' => 'Let\'s fight together <em>(by following proper hygiene rules)</em>!',
    'sql.error.prepare' => 'Failed to prepare SQL statement',
    'sql.error.query' => 'Failed to query database',
    'sql.error.insert' => 'Failed to insert entry into database',
    'sql.error.update' => 'Failed to update entry',
    'sql.error.invalid.date' => 'Wrong date/time format',
    'sql.success.added' => 'Entry added!',

    // index.php
    'main.title' => 'Index',
    'main.export_as_csv' => 'Als CSV exportieren',
    'main.add_entry.title' => 'Met someone today?',
    'main.add_entry.who.label' => 'Who?',
    'main.add_entry.who.placeholder' => 'Name(s) of person(s)',
    'main.add_entry.when.label' => 'When?',
    'main.add_entry.add_btn' => 'Add',
    'main.add_entry.error.noname' => 'Please enter a name',
    'main.add_entry.error.nodate' => 'Please enter a date',
    'main.edit_mode.activate' => 'Edit entries',
    'main.edit_mode.deactivate' => 'Stop editting entries',
    'main.edit_mode.explanation' => 'Clicking on an entry allows you to delete it',
    'main.log.title' => 'Contacts within the last %d days',

    // login.php
    'login.title' => 'Login',
    'login.form.username.label' => 'Username',
    'login.form.username.placeholder' => 'Username goes here&hellip;',
    'login.form.password.label' => 'Password',
    'login.form.password.placeholder' => 'Password goes here&hellip;',
    'login.form.login.btn' => 'Log in',
    'login.error.enter_information' => 'Please provide a username and a password',
    'login.error.wrong_credentials' => 'No matching user was found with the provided credentials',

    // delete.php
    'delete.title' => 'Delete entry',
    'delete.confirm' => 'Do you really want to delete the following entry?',
    'delete.btn' => 'Yes, delete!',
    'delete.btn.decline' => 'No, please don\'t',

    // edit.php
    'edit.title' => 'Edit entry',
    'edit.intro' => 'Here you may edit this entry.',
    'edit.date.label' => 'Date',
    'edit.time.label' => 'Time',
    'edit.who.label' => 'Who',
    'edit.error.forgot.date' => 'Please enter a date',
    'edit.error.forgot.time' => 'Please enter a time',
    'edit.error.forgot.who' => 'Please enter who you\'ve met',
    'edit.btn.confirm' => 'Save',
    'edit.btn.decline' => 'Cancel',
    'edit.btn.delete' => 'Delete entry instead',

    // tools/create_user.php
    'tool.create_user.form.title' => 'Generate User Entry',
    'tool.create_user.form.username.label' => 'Username',
    'tool.create_user.form.username.placeholder' => 'Username goes here&hellip;',
    'tool.create_user.form.password.label' => 'Password',
    'tool.create_user.form.password.placeholder' => 'Password goes here&hellip;',
    'tool.create_user.form.create.btn' => 'Create user entry',
  ];

