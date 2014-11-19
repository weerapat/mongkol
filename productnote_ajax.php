<?php
session_start();
include "header_php.php";

$task = $_POST['task'];

$productnote_id = $_POST['productnote_id'];
$product_no = $_POST['product_no'];
$notemsg = $_POST['notemsg'];
$note_hourmeter = $_POST['note_hourmeter'];
$note_actionby = $_POST['note_actionby'];
$notedate = changeformatdate($_POST['notedate']);

if ($task == "save") {
  $sql = "INSERT INTO product_note(
                              product_no,
                              notemsg,
                              note_hourmeter,
                              note_actionby,
                              notedate
                              )VALUES(
                              '{$product_no}',
                              '{$notemsg}',
                              '{$note_hourmeter}',
                              '{$note_actionby}',
                              '{$notedate}'
                              )";
  //echo $sql;
  $result = mysql_query($sql);
}

if ($task == "edit") {
  $sql = "UPDATE product_note SET notemsg = '$notemsg',
                                  note_hourmeter = '$note_hourmeter',
                                  note_actionby = '$note_actionby',
                                  notedate = '{$notedate}'
                          WHERE productnote_id = '{$productnote_id}'
                        ";
  $result = mysql_query($sql);
}


if ($task == "delete") {
  $sql = "DELETE FROM product_note  WHERE  productnote_id = '{$productnote_id}' ";
  $result = mysql_query($sql);
}

if ($error) { echo $error; }
if ($result) { echo "success"; }
?>
