<?php
include "header.php";
include "header_php.php";
if (!isset($_GET["page"])) { $page = 1; } else { $page = $_GET["page"]; }

$num = $_GET["num"];
$num2 = $_GET["num"];
$name_search = trim($_GET["name_search"]);
$rec_search = trim($_GET["rec_search"]);
$rec_company_search = $_GET["rec_company_search"];
if ($_GET["datestart_search"] != "") { $datestart_search = changeformatdate($_GET["datestart_search"]); }
if ($_GET["dateend_search"] != "") { $dateend_search = changeformatdate($_GET["dateend_search"]); }

$result = false;

$str_where = "";


if (!empty($name_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (cu_name LIKE '%$name_search%') ";
}


if (!empty($rec_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (rec_id LIKE '%$rec_search%') ";
}

if (!empty($rec_company_search)) { ////// ค้นหาจากชื่อบริษัท
  $str_where .="AND  (rec_company = '$rec_company_search') ";
}

if (!empty($datestart_search)) { ////// ค้าจากวันที่เริ่ม
  $str_where .="AND  (rec_date >= '$datestart_search') ";
}

if (!empty($dateend_search)) { ////// ค้นหาจากวันที่ จบ
  $str_where .="AND  (rec_date <= '$dateend_search') ";
}

$sql_search = "SELECT * FROM receipt_tab 
  LEFT JOIN customer_tab
                ON receipt_tab.rec_customer = customer_tab.cu_no
WHERE 1 $str_where  ORDER BY rec_no desc";

$per_page = 20;
$prev_page = $page - 1;
$next_page = $page + 1;
$re = mysql_query($sql_search);
$page_start = ($per_page * $page) - $per_page;
$allnum = mysql_num_rows($re);
$num_pages = ceil($allnum / $per_page);
$sql_search.=" LIMIT $page_start,$per_page";
$result = mysql_query($sql_search);
?>




<script language="javascript" type="text/javascript">
  $(document).ready(function() {
    $("#formID").validationEngine();
  });

  function editFile(id) {
    urlchange('receipt.php?task=edit&rec_no=' + id);
  }
  function delFile(id) {
    var r = confirm("ยืนยันว่าต้องการลบข้อมูล!");
    if (r == true)
      urlchange('receipt_do.php?task=delete&rec_no=' + id);
  }
</script>


<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle" /> 
    ค้นหาข้อมูลใบเสร็จรับเงิน/ใบกำกับภาษี
  </div>

  <div class="txtHead" >ใบเสร็จรับเงิน/ใบกำกับภาษี</div>
  <div class="addNew-btn" ><button class="submitBtn" onclick="urlchange('receipt.php')"  >เพิ่มข้อมูลใหม่</button></div>
  <div class="outter" style="width: 500px">
    <form id="formID" method="get" >
      <table>
        <tr>
          <td class="formLabel" >รหัสใบเสร็จรับเงิน :</td>
          <td><input  name="rec_search" id="rec_search" type="text" value="<?= $rec_search ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >วันที่ออกใบเสร็จรับเงิน :</td>
          <td>
            <input name="datestart_search" style="width : 70px"  type="text" class="datepicker" id="datestart_search" value="<?= splitdate($datestart_search, 'max') ?>" />
            - 
            <input name="dateend_search" style="width : 70px"  type="text" class="datepicker" id="dateend_search" value="<?= splitdate($dateend_search, 'max') ?>" />  
          </td>
        </tr>
        <tr>
          <td class="formLabel" >ชื่อลูกค้า :</td>
          <td><input  name="name_search" id="name_search" type="text" alue="<?= $name_search ?>" /></td>
        </tr>
        <tr>
          <td class="formLabel">ออกโดยบริษัท :</td>
          <td>
            <select name="rec_company_search"  id="rec_company_search"  >
              <option value="0"> เลือกทั้งหมด</option>
              <?php
              $company_search = $rec_company_search;
              include "company_display_search.php";
              ?>
            </select>
          </td>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="submit" >ค้นหา</button></td>
          <td></td>
        </tr>
      </table>
    </form>

  </div>
  <div class="listing-container" >
    <table align="center"  class="simply">
      <tr align="center" >
        <th width="61">ลำดับ</th>
        <th width="120">รหัสใบเสร็จรับเงิน</th>
        <th width="60">วันที่</th>
        <th width="280">ชื่อลูกค้า</th>
        <th width="120">ออกโดยบริษัท</th>
        <th width="40">พิมพ์</th>
        <th width="40">แก้ไข</th>
        <th width="40">ลบ</th>
      </tr>
      <?php
      if ($result) {
        while ($row = mysql_fetch_array($result)) {
          $customer = getCustomer($row['rec_customer']);
          ?>
          <tr >
            <td align="center" ><? echo++$num; ?></td>
            <td ><?= getPrefix($row["rec_id"], $row["rec_company"]); ?></td>
            <td ><?= splitdate($row["rec_date"], 'avg') ?></td>
            <td ><?= cuName($customer["cu_type"], $customer["cu_name"]); ?></td>
            <td align="center" ><?= getCompanyName($row["rec_company"]); ?></td>
            <td align="center"><a href="rec_print.php?rec_no=<?= $row["rec_no"] ?>" ><img src="images/vcalendar.png" class="icon"  /></a></td>
            <td align="center"><img alt="edit"  src="images/edit.png" class="icon"  onclick="editFile('<?= $row["rec_no"] ?>')"/></td>
            <td align="center"><img alt="del"  src="images/del.png" class="icon"  onclick="delFile('<?= $row["rec_no"] ?>')"/></td>
          </tr>
          <?php
        }//while
      }//if result
      if (!$result or $allnum == 0) {
        ?>
        <tr>
          <td colspan="9" align="center"><span class="style1">...........ไม่มีข้อมูล.........</span></td>
        </tr>
      <?php } ?>
    </table>
    <div style="position: relative;left: 50px; top:10px;" class="pagination">
      <?php
      if ($allnum != "") {
        ?>
        <font color="gray">หน้าที่ </font>
        <?php
      }
      $nfor = 0;
      for ($i = 1; $i <= $num_pages; $i++) {

        if ($num2 == 0 and $page == 1 and $i == 1) {
          echo "&nbsp;<u class='pageActive'>$i</u>&nbsp;";
        } else if ($i <> $page) {
          echo "&nbsp;<a href='receipt_search.php?page=$i&num=$nfor&rec_search=$rec_search
          &rec_company_search=$rec_company_search&datestart_search=$datestart_search
          &dateend_search=$dateend_search' >$i</a>&nbsp;";
        } else {
          echo "&nbsp;<u class='pageActive'>$i</u>&nbsp;";
        }
        $nfor = $nfor + $per_page;
      }///for
      ?>

    </div>

  </div>
  <?php include "footer.php" ?>
