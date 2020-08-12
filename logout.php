<?php
   namespace LXS\CCL;

   require 'common.php';

   logout_user();

   \header('location: login.php');