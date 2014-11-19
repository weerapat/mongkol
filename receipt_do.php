<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = $_POST["task"]; }
if (isset($_GET['rec_no'])) { $rec_no = $_GET['rec_no']; } else { $rec_no = $_POST["rec_no"]; }

$rec_id = $_POST["rec_id"];
$rec_date = changeformatdate($_POST["rec_date"]);
$rec_customer = $_POST["rec_customer"];
$rec_company = $_POST["rec_company"];
$rec_subtotal = rmComma($_POST["subtotal"]);
$rec_discount = rmComma($_POST["discount"]);
$rec_after_discount = rmComma($_POST["after_discount"]);
$rec_vat = rmComma($_POST["vat"]);
$rec_total = rmComma($_POST["total"]);
$rec_tax_status = $_POST["tax_status"];
$rec_receiver = $_POST["rec_receiver"];

$cash_payment = $_POST["cash_payment"];
$cash_amount = rmComma($_POST["cash_amount"]);
$cheque = $_POST["cheque"];
$cheque_no = $_POST["cheque_no"];
$cheque_bank = $_POST["cheque_bank"];
$cheque_branch = $_POST["cheque_branch"];
$cheque_date = changeformatdate($_POST["cheque_date"]);
$cheque_amount = rmComma($_POST["cheque_amount"]);


$rec_create_by = $_SESSION['user_name'];
$rec_create_date = datetime_now();
$rec_update_by = $_SESSION['user_name'];
$rec_update_date = datetime_now();

$hid_detail = trim($_POST["hid_detail"]);

if ($task == "save") {

  $rec_id = get_preid('receipt_tab', 'rec_id', $rec_company, 'rec_company');
   
  $sql = "INSERT INTO receipt_tab (
            rec_id,
            rec_date,
            rec_customer,
            rec_company,
            rec_subtotal,
            rec_discount,
            rec_after_discount,
            rec_vat,
            rec_total,
            rec_tax_status,
            rec_receiver,
            cash_payment ,
            cash_amount ,
            cheque ,
            cheque_no ,
            cheque_bank ,
            cheque_branch ,
            cheque_date ,
            cheque_amount ,
            rec_create_by,
            rec_create_date
            )VALUES (
            '$rec_id',
            '$rec_date',
            '$rec_customer',
            '$rec_company',
            '$rec_subtotal',
            '$rec_discount',
            '$rec_after_discount',
            '$rec_vat',
            '$rec_total',
            '$rec_tax_status',
            '$rec_receiver',
            '$cash_payment' ,
            '$cash_amount' ,
            '$cheque' ,
            '$cheque_no' ,
            '$cheque_bank' ,
            '$cheque_branch' ,
            '$cheque_date' ,
            '$cheque_amount' ,
            '$rec_create_by',
            '$rec_create_date'
            )
           ";
  //echo $sql;
  $result = mysql_query($sql);
  $message = "บันทึกข้อมูลสำเร็จ";
}

// UPDATE
if ($task == "edit") {
  $sql = "UPDATE receipt_tab SET
            rec_id = '$rec_id',
            rec_date = '$rec_date',
            rec_customer = '$rec_customer',
            rec_company = '$rec_company',
            rec_subtotal= '$rec_subtotal',
            rec_discount= '$rec_discount',
            rec_after_discount= '$rec_after_discount',
            rec_vat= '$rec_vat',
            rec_total= '$rec_total',
            rec_tax_status= '$rec_tax_status',
            rec_receiver= '$rec_receiver',
            cash_payment = '$cash_payment',
            cash_amount='$cash_amount',
            cheque = '$cheque',
            cheque_no = '$cheque_no',
            cheque_bank = '$cheque_bank',
            cheque_branch = '$cheque_branch',
            cheque_date = '$cheque_date',
            cheque_amount = '$cheque_amount',
            rec_update_by = '$rec_update_by',
            rec_update_date = '$rec_update_date'
            WHERE rec_no = '$rec_no' LIMIT 1 ;
  ";

  $result = mysql_query($sql);

  $message = "แก้ไขข้อมูลสำเร็จ";
}

if ($task == 'save' || $task == 'edit') {

  if ($hid_detail) {
    $sql = "DELETE FROM receipt_d  WHERE  rec_id = '{$rec_id}' ";
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
      $sql_detail = "INSERT INTO receipt_d (
                    rec_id ,
                    description ,
                    amount ,
                    unit,
                    perunit ,
                    total
                    )VALUES (
                    '$rec_id',
                    '$description',
                    '$amount',
                    '$unit',
                    '$perunit',
                    '$linetotal'
                    )";
      //echo $sql_detail;
      $result = mysql_query($sql_detail);
    }
  }
}

if ($task == "delete") {
  $sql = "DELETE FROM receipt_tab  WHERE  rec_no = '{$rec_no}' ";
  mysql_query($sql);

  $sql = "DELETE FROM receipt_d  WHERE  rec_id = '{$rec_id}' ";
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
          redirect_page('receipt_search.php', 2);
        }
        ?>
    </div>
  </div>
</div>

<? include "footer.php" ?>
