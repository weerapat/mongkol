<?php

include "connectdb/conn.php";

$task = $_POST['task'];

$unit_id = $_POST['unit_id'];
$unit_name = $_POST['unit_name'];



if ($task == "save") {

  $result = mysql_query("INSERT INTO unit_master(
                              unit_name
                              )VALUES(
                              '{$unit_name}'
                              )");
}

if ($task == "edit") {

  $sql = "UPDATE unit_master SET unit_name = '$unit_name' WHERE unit_id = '{$unit_id}'";
  
 // echo $sql;
  $result = mysql_query($sql);
}

if ($task == "delete") {
  $sql = "DELETE FROM unit_master WHERE unit_id = '{$unit_id}' ";
  $result = mysql_query($sql);
}

if ($result) { echo "success"; }
?>
