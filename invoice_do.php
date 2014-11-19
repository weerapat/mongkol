<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = $_POST["task"]; }
if (isset($_GET['inv_no'])) { $inv_no = $_GET['inv_no']; } else { $inv_no = $_POST["inv_no"]; }

$inv_id = $_POST["inv_id"];
$inv_date = changeformatdate($_POST["inv_date"]);
$inv_customer = $_POST["inv_customer"];
$inv_company = $_POST["inv_company"];
$inv_subtotal = rmComma($_POST["subtotal"]);
$inv_discount = rmComma($_POST["discount"]);
$inv_after_discount = rmComma($_POST["after_discount"]);
$inv_vat = rmComma($_POST["vat"]);
$inv_deposit = rmComma($_POST["deposit"]);
$inv_total = rmComma($_POST["total"]);
$inv_tax_status = $_POST["tax_status"];


$inv_create_by = $_SESSION['user_name'];
$inv_create_date = datetime_now();
$inv_update_by = $_SESSION['user_name'];
$inv_update_date = datetime_now();

$hid_detail = trim($_POST["hid_detail"]);

if ($task == "save") {

  $inv_id = get_preid('invoice_tab', 'inv_id', $inv_company, 'inv_company');
  $sql = "INSERT INTO invoice_tab (
            inv_id,
            inv_date,
            inv_customer,
            inv_company,
            inv_subtotal,
            inv_discount,
            inv_after_discount,
            inv_vat,
            inv_deposit,
            inv_total,
            inv_tax_status,
            inv_create_by,
            inv_create_date
            )VALUES (
            '$inv_id',
            '$inv_date',
            '$inv_customer',
            '$inv_company',
            '$inv_subtotal',
            '$inv_discount',
            '$inv_after_discount',
            '$inv_vat',
            '$inv_deposit',
            '$inv_total',
            '$inv_tax_status',
            '$inv_create_by',
            '$inv_create_date'
            )
           ";
  //echo $sql;
  $result = mysql_query($sql);
  $message = "บันทึกข้อมูลสำเร็จ";
}

// UPDATE
if ($task == "edit") {
  $sql = "UPDATE invoice_tab SET
            inv_id = '$inv_id',
            inv_date = '$inv_date',
            inv_customer = '$inv_customer',
            inv_company = '$inv_company',
            inv_subtotal= '$inv_subtotal',
            inv_discount= '$inv_discount',
            inv_after_discount= '$inv_after_discount',
            inv_vat= '$inv_vat',
            inv_deposit= '$inv_deposit',
            inv_total= '$inv_total',
            inv_tax_status= '$inv_tax_status',
            inv_update_by = '$inv_update_by',
            inv_update_date = '$inv_update_date'
            WHERE inv_no = '$inv_no' LIMIT 1 ;
  ";

  $result = mysql_query($sql);

  $message = "แก้ไขข้อมูลสำเร็จ";
}

if ($task == 'save' || $task == 'edit') {

  if ($hid_detail) {
    $sql = "DELETE FROM invoice_d  WHERE  inv_id = '{$inv_id}' ";
    mysql_query($sql);
//  =====insert===========================
    $detail_splid = explode("|", $hid_detail);
    $length = count($detail_splid);
    //print_r($detail_splid);

    for ($i = 0; $i < $length - 1; $i++) {
      $inline = $i + 1;
      $detail_value = $detail_splid[$i];
      $detail_insert = explode("?", $detail_value);
      /*       * ************
        รายการ , จำนวน ,หน่วย,หน่วยละ  , จำนวนเงิน
       * ******** */

      $description = $detail_insert[0]; // รายการ
      $amount = rmComma($detail_insert[1]);
      $unit = rmComma($detail_insert[2]);
      $perunit = rmComma($detail_insert[3]);
      $linetotal = rmComma($detail_insert[4]);
      $text_enclose = $detail_insert[5];
      
      $sql_detail = "INSERT INTO invoice_d (
                    inv_id ,
                    description ,
                    amount ,
                    unit,
                    perunit ,
                    text_enclose ,
                    total
                    )VALUES (
                    '$inv_id',
                    '$description',
                    '$amount',
                    '$unit',
                    '$perunit',
                    '$text_enclose',
                    '$linetotal'
                    )";
      //echo $sql_detail;
      $result = mysql_query($sql_detail);
    }
  }
}

if ($task == "delete") {
  $sql = "DELETE FROM invoice_tab  WHERE  inv_no = '{$inv_no}' ";
  mysql_query($sql);

  $sql = "DELETE FROM invoice_d  WHERE  inv_id = '{$inv_id}' ";
  mysql_query($sql);
  $message = "ลบข้อมูลสำเร็จ";
}

// Error case
$error_msg = mysql_error($conn);
?>
<div class=content>
  <div id ="successMsg">
    <div style="width: 300px;" class="outter">

      <span style="margin-right: 10px;"><img class="icon" src="images/load.gif" alt="loading" /></span>
        <?
        if ($error_msg) {
          echo $error_msg;
        } else {

          echo $message;
          redirect_page('invoice_search.php', 2);
        }
        ?>
    </div>
  </div>
</div>

<? include "footer.php" ?>
