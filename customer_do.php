<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = $_POST["task"]; }
if (isset($_GET['cu_no'])) { $cu_no = $_GET['cu_no']; } else { $cu_no = $_POST["cu_no"]; }

$cu_id = $_POST["cu_id"];
$cu_type = $_POST["cu_type"];

$runId = $_POST["runId"];

$cu_name = $_POST["cu_name"];
$cu_address = $_POST["cu_address"];
$cu_phone = $_POST["cu_phone"];
$cu_fax = $_POST["cu_fax"];
$cu_email = $_POST["cu_email"];
$cu_remark = $_POST["cu_remark"];
$cu_contact = $_POST["cu_contact"];
$cu_contacttel = $_POST["cu_contacttel"];
$cu_termpayment = $_POST["cu_termpayment"];
$cu_taxid = $_POST["cu_taxid"];
$cu_create_by = $_SESSION['user_name'];
$cu_create_date = datetime_now();
$cu_update_by = $_SESSION['user_name'];
$cu_update_date = datetime_now();

if ($task == "save") {

  $sql = "SHOW TABLE STATUS LIKE 'customer_tab'";
  $result = mysql_query($sql);
  $row = mysql_fetch_assoc($result);
  $next_increment = $row['Auto_increment'];
  $next_increment = str_pad($next_increment, 5, "0", STR_PAD_LEFT);

  $cu_id = "CUS" . $next_increment;

  if($runId == 2){
    $cu_id = "CUS0000";
  }

  $sql = "INSERT INTO customer_tab (
            cu_id,
            cu_type,
            cu_name,
            cu_address,
            cu_phone,
            cu_fax,
            cu_contact,
            cu_contacttel,
            cu_termpayment,
            cu_taxid,
            cu_email,
            cu_remark,
            cu_create_by,
            cu_create_date
            )VALUES (
            '$cu_id',
            '$cu_type',
            '$cu_name',
            '$cu_address',
            '$cu_phone',
            '$cu_fax',
            '$cu_contact',
            '$cu_contacttel',
            '$cu_termpayment',
            '$cu_taxid',
            '$cu_email',
            '$cu_remark',
            '$cu_create_by',
            '$cu_create_date'
            )
           ";
  //echo $sql;
  $result = mysql_query($sql);
  $message = "บันทึกข้อมูลสำเร็จ";
}

// UPDATE
if ($task == "edit") {
  $sql = "UPDATE customer_tab SET
            cu_id = '$cu_id',
            cu_type = '$cu_type',
            cu_name = '$cu_name',
            cu_address = '$cu_address',
            cu_phone = '$cu_phone',
            cu_fax = '$cu_fax',
            cu_contact = '$cu_contact',
            cu_contacttel = '$cu_contacttel',
            cu_termpayment = '$cu_termpayment',
            cu_taxid = '$cu_taxid',
            cu_email = '$cu_email',
            cu_remark = '$cu_remark',
            cu_update_by = '$cu_update_by',
            cu_update_date = '$cu_update_date'
            WHERE cu_no = '$cu_no' LIMIT 1 ;
  ";

  $result = mysql_query($sql);
  $message = "แก้ไขข้อมูลสำเร็จ";
}

if ($task == "delete") {
  $sql = "DELETE FROM customer_tab  WHERE  cu_no = '{$cu_no}' ";
  mysql_query($sql);
  $message = "ลบข้อมูลสำเร็จ";
}

// Error case
$error_msg = mysql_error($conn);
?>
<div class=content>
  <div id ="successMsg">
    <div style="width: 300px;" class="outter">

      <span style="margin-right: 10px;"><img class="icon" src="images/loading.gif" alt="loading" /></span>
        <?
        if ($error_msg) {
          echo $error_msg;
        } else {

          echo $message;
          redirect_page('customer_search.php', 2);
        }
        ?>
    </div>
  </div>
</div>

<? include "footer.php" ?>
