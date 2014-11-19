<?php
include "header.php";
include "header_php.php";

if (isset($_GET['task'])) { $task = $_GET["task"]; } else { $task = $_POST["task"]; }
if (isset($_GET['product_no'])) { $product_no = $_GET['product_no']; } else { $product_no = $_POST["product_no"]; }
$tablename = "product_tab";
$product_id = $_POST["product_id"];
$product_type = $_POST["product_type"];
$product_name = $_POST["product_name"];
$product_size = $_POST["product_size"];
$product_number = $_POST["product_number"];
$product_status = $_POST["product_status"];
$product_remark = $_POST["product_remark"];



$product_othertype = $_POST["product_othertype"];
$product_taxdate = changeformatdate($_POST["product_taxdate"]);
$product_taxprice = rmComma($_POST["product_taxprice"]);
$product_prbdate = changeformatdate($_POST["product_prbdate"]);
$product_prbprice = rmComma($_POST["product_prbprice"]);
$product_warrentydate = changeformatdate($_POST["product_warrentydate"]);
$product_warrentyprice = rmComma($_POST["product_warrentyprice"]);
$product_checkprice = rmComma($_POST["product_checkprice"]);

$product_cost = rmComma($_POST["product_cost"]);
$product_price = rmComma($_POST["product_price"]);
$product_date = changeformatdate($_POST["product_date"]);
$product_from = $_POST["product_from"];
$product_typetool = $_POST["product_typetool"];
$product_typedai = $_POST["product_typedai"];
$product_braiddai = $_POST["product_braiddai"];
$product_braidsola = $_POST["product_braidsola"];
$product_braidair = $_POST["product_braidair"];

$product_create_by = $_SESSION['user_name'];
$product_create_date = datetime_now();
$product_update_by = $_SESSION['user_name'];
$product_update_date = datetime_now();

if ($task == "save") {

//  $sql = "SHOW TABLE STATUS LIKE '$tablename'";
//  $result = mysql_query($sql);
//  $row = mysql_fetch_assoc($result);
//  $next_increment = $row['Auto_increment'];
//  $next_increment = str_pad($next_increment, 5, "0", STR_PAD_LEFT);
//  $product_id = "productS" . $next_increment . "-01";


  $sql = "INSERT INTO product_tab (
            product_id,
            product_type,
            product_size,
            product_number,
            product_cost,
            product_price,
            product_date,
            product_from,
            product_typetool,
            product_typedai,
            product_braiddai,
            product_braidsola,
            product_braidair,
            product_othertype,
            product_taxdate,
            product_taxprice,
            product_prbdate,
            product_prbprice,
            product_warrentydate,
            product_warrentyprice,
            product_checkprice,
            product_status,
            product_remark,
            product_create_by,
            product_create_date
            )VALUES (
            '$product_id',
            '$product_type',
            '$product_size',
            '$product_number',
            '$product_cost',
            '$product_price',
            '$product_date',
            '$product_from',
            '$product_typetool',
            '$product_typedai',
            '$product_braiddai',
            '$product_braidsola',
            '$product_braidair',
            '$product_othertype',
            '$product_taxdate',
            '$product_taxprice',
            '$product_prbdate',
            '$product_prbprice',
            '$product_warrentydate',
            '$product_warrentyprice',
            '$product_checkprice',
            '$product_status',
            '$product_remark',
            '$product_create_by',
            '$product_create_date'
            )
           ";
   //echo $sql;
  $result = mysql_query($sql);
  $message = "บันทึกข้อมูลสำเร็จ";
}

// UPDATE
if ($task == "edit") {
  $sql = "UPDATE product_tab SET
            product_id = '$product_id',
            product_type = '$product_type',
            product_size = '$product_size',
            product_number = '$product_number',
            product_cost = '$product_cost',
            product_price = '$product_price',
            product_date = '$product_date',
            product_from = '$product_from',
            product_typetool = '$product_typetool',
            product_typedai = '$product_typedai',
            product_braiddai = '$product_braiddai',
            product_braidsola = '$product_braidsola',
            product_braidair = '$product_braidair',
            product_othertype = '$product_othertype',
            product_taxdate = '$product_taxdate',
            product_taxprice = '$product_taxprice',
            product_prbdate = '$product_prbdate',
            product_prbprice = '$product_prbprice',
            product_warrentydate = '$product_warrentydate',
            product_warrentyprice = '$product_warrentyprice',
            product_checkprice = '$product_checkprice',
            product_status = '$product_status',
            product_remark = '$product_remark',
            product_update_by = '$product_update_by',
            product_update_date = '$product_update_date'
            WHERE product_no = '$product_no' LIMIT 1 ;
  ";

  $result = mysql_query($sql);
  $message = "แก้ไขข้อมูลสำเร็จ";
}

if ($task == "delete") {
  $sql = "DELETE FROM product_tab  WHERE  product_no = '{$product_no}' ";
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
    <?php
    if ($error_msg) {
      echo $error_msg;
    } else {
      echo $message;
      redirect_page('product_search.php', 2);
    }
    ?>
  </div>
  </div>
</div>
<?php include "footer.php" ?>
