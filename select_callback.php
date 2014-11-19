<?php
session_start(); 
include "header_php.php";

$task = $_GET['task'];
$id = $_GET['id'];

if($task == "customer"){
  
  $sql_search = "SELECT * FROM customer_tab WHERE cu_no = '{$id}' ";
  $result = mysql_query($sql_search);
  $row = mysql_fetch_assoc($result);
  $row["cu_name"] = cuName($row["cu_type"],$row["cu_name"]);
  echo json_encode($row);
}

if($task == "product"){
  
  $sql_search = "SELECT * FROM product_tab WHERE product_no = '{$id}' ";
  $result = mysql_query($sql_search);
  $row = mysql_fetch_assoc($result);
  
  $row['product_typeid'] = $row["product_type"];
  $row['product_type'] = productType($row["product_type"],$row["product_no"]);
  echo json_encode($row);
}


// get list depart ment
if ($task == 'equiplist') {
  if (isset($id) && $id != "") {
    echo "<option value=''> -- เลือกอุปกรณ์ -- </option>";
    $sql = "SELECT * FROM equip_list WHERE equip_maintype ='{$id}' ";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
      echo "<option value='{$row['equip_id']}'>{$row['equip_name']}</option>";
    }
  } else {
    echo "<option value=''> -- ไม่มีข้อมูล -- </option>";
  }
}

if($task == "get_equipmentunit"){
  
  $sql_search = "SELECT equip_requirenum FROM equip_list WHERE equip_id = '{$id}' ";
  $result = mysql_query($sql_search);
  $row = mysql_fetch_assoc($result);
  
  echo $row['equip_requirenum'];
}


if($task == "checkCustomer"){
  
  $sql_search = "SELECT count(*) as numrow FROM customer_tab WHERE cu_name = '{$id}' ";
  $result = mysql_query($sql_search);
  
  $row = mysql_fetch_assoc($result);
  
  echo $row['numrow'];
}
?>

