<?php

  namespace LXS\CCL\db;

  function open_db()
  {
    return new \PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s;charset=%s',
                 DB_HOST,
                 DB_NAME,
                 DB_PORT,
                 DB_CHARSET
              ),
              DB_USER,
              DB_PASSWORD
           );
  }

  function get_sql_error($db)
  {
    $errorMsg = $db->errorInfo();
    return $errorMsg[2];
  }


  function add_entry($date, $who)
  {
    global $db_;
    global $errors_;
    $added = false;

    $when = $date.' '.date('H:i:s');

    $sql = 'INSERT INTO '.DB_TABLE_PREFIX.'contact_log(time, who) VALUES(:when, :who)';
    $stmt = $db_->prepare($sql);
    if ($stmt === false) {
      $errors_[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':when', $when, \PDO::PARAM_STR);
      $stmt->bindValue(':who', $who, \PDO::PARAM_STR);
      if ($stmt->execute() === true) {
        $added = true;
      } else {
        $errors_[] = _tr('sql.error.insert').': <code>'.get_sql_error($stmt).'</code>';
      }
      $stmt->closeCursor();
    }

    return $added;
  }

  function delete_old_entries()
  {
    if (defined('KEEP_OLD_ENTRIES') && KEEP_OLD_ENTRIES === false) {
      global $db_;
      global $errors_;
      $sql = 'DELETE FROM '.DB_TABLE_PREFIX.'contact_log'
            .' WHERE time < NOW() - INTERVAL :days DAY';
      $stmt = $db_->prepare($sql);
      if ($stmt === false) {
        $errors_[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
      } else {
        $stmt->bindValue(':days', ENTRY_LOG_DAYS, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
          $errors_[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
        }
        $stmt->closeCursor();
      }
    }
  }

  function delete_entry($entryId)
  {
    global $db_;
    global $errors_;
    $success = false;
    $sql = 'DELETE FROM '.DB_TABLE_PREFIX.'contact_log WHERE entry_id=:id';
    $stmt = $db_->prepare($sql);
    if ($stmt === false) {
      $errors_[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':id', $entryId, \PDO::PARAM_INT);
      if ($stmt->execute() === false) {
        $errors_[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
      } else {
        $success = true;

      }
      $stmt->closeCursor();
    }
    return $success;
  }

  function get_entry($entryId)
  {
    global $db_;
    global $errors_;
    $sql = 'SELECT entry_id, time, who FROM '.DB_TABLE_PREFIX.'contact_log WHERE entry_id=:id';
    $stmt = $db_->prepare($sql);
    $entry = false;
    if ($stmt === false) {
      $errors_[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':id', $entryId, \PDO::PARAM_INT);
      if ($stmt->execute() === false || ($entry = $stmt->fetchAll(\PDO::FETCH_ASSOC)) === false) {
        $errors_[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
      }
      $stmt->closeCursor();
    }
    return ($entry !== false) ? $entry[0] : false;
  }

  function get_entries($lastDays)
  {
    global $db_;
    global $errors_;
    $results = false;

    $sql = 'SELECT entry_id, time, who FROM '.DB_TABLE_PREFIX.'contact_log'
           .' WHERE time BETWEEN(NOW() - INTERVAL :days DAY) AND NOW()'
           .' ORDER BY time DESC';
    $stmt = $db_->prepare($sql);
    if ($stmt === false) {
      $errors_[] = _tr('sql.error.prepare').': <code>'.get_sql_error($db_).'</code>';
    } else {
      $stmt->bindValue(':days', $lastDays, \PDO::PARAM_INT);
      if ($stmt->execute() === false || ($results = $stmt->fetchAll(\PDO::FETCH_ASSOC)) === false) {
        $errors_[] = _tr('sql.error.query').': <code>'.get_sql_error($stmt).'</code>';
      }
      $stmt->closeCursor();
    }

    return $results;
  }
