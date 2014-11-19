<?php


include "connectdb/conn.php";
include "include/function_general.php";

if ($_SESSION['login'] == null) {
  //header('Location: login.php');
echo "<script type='text/javascript'>top.window.location = './login.php';</script>";
}

$DEBUG = 1;
// SET ERROR REPORTING
if ($DEBUG) {
  ini_set('display_errors', TRUE);
  //error_reporting(E_ALL);
  error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_USER_ERROR);
} else {
  ini_set('display_errors', FALSE);
}


// include firephp debug อย่าลืม set
if (file_exists('includes/class_firephp.php')) {
  include 'includes/class_firephp.php';
  include('includes/fb.php');
  ob_start();
  $fb = & FirePHP::getInstance(true);
  $fb->setEnabled(true);

  //fb($var, 'Iterators');
}
?>