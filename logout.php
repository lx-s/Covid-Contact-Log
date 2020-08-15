<?php
   namespace LXS\CCL;

   require_once 'common.php';

   logout_user();

   \header('location: login.php');