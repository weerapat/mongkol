<?php
session_start();
include "connectdb/conn.php";

$u = $_POST['username'];
$p = $_POST['password'];

$sql = "SELECT * FROM user WHERE user_name = '{$u}' AND user_password = '{$p}' 
        ";
// echo $sql;
// exit();

$result = mysql_query($sql);

if (mysql_num_rows($result) > 0) {
  $rc = mysql_fetch_assoc($result);
 
  $_SESSION['user_name'] = $rc['user_name'];
  $_SESSION['level'] = $rc['user_level'];
  $_SESSION['login'] = 1;

  echo 'ok';
} else {
  echo 'failed';
}
?>