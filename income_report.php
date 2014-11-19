<?php
include "header.php";
include "header_php.php";
if (!isset($_GET["page"])) { $page = 1; } else { $page = $_GET["page"]; }

$num = $_GET["num"];
$num2 = $_GET["num"];
$name_search = trim($_GET["name_search"]);
$status_search = trim($_GET["status_search"]);
$contacten_search = trim($_GET["contacten_search"]);
$contacten_company_search = $_GET["contacten_company_search"];
if ($_GET["datestart_search"] != "") { $datestart_search = changeformatdate($_GET["datestart_search"]); }
if ($_GET["dateend_search"] != "") { $dateend_search = changeformatdate($_GET["dateend_search"]); }

$result = false;

$str_where = "";

if (!empty($name_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (cu_name LIKE '%$name_search%') ";
}

if (!empty($contacten_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (contacten_id LIKE '%$contacten_search%') ";
}

if (!empty($contacten_company_search)) { ////// ค้นหาจากชื่อบริษัท
  $str_where .="AND  (contacten_company = '$contacten_company_search') ";
}

if (!empty($datestart_search)) { ////// ค้าจากวันที่เริ่ม
  $str_where .="AND  (contacten_date >= '$datestart_search') ";
}

if (!empty($dateend_search)) { ////// ค้นหาจากวันที่ จบ
  $str_where .="AND  (contacten_date <= '$dateend_search') ";
}

if ($_GET["datestart_search"]) {
$sql_search = "SELECT contacten_tab.*,cu_name FROM contacten_tab 
                LEFT JOIN customer_tab
                ON contacten_tab.contacten_customer = customer_tab.cu_no
                WHERE pay_status = '1' $str_where  ORDER BY contacten_id desc";

$sql_sum = "SELECT sum(contacten_total) as total FROM contacten_tab WHERE pay_status = '1' $str_where";
$resource = mysql_query($sql_sum);
$sumtotal = mysql_fetch_assoc($resource);
$sumtotal = $sumtotal['total'];

$per_page = 100;
$prev_page = $page - 1;
$next_page = $page + 1;
$re = mysql_query($sql_search);
$page_start = ($per_page * $page) - $per_page;
$allnum = mysql_num_rows($re);
$num_pages = ceil($allnum / $per_page);
$sql_search.=" LIMIT $page_start,$per_page";
$result = mysql_query($sql_search);
}
?>




<script language="javascript" type="text/javascript">
  $(document).ready(function(){
    $("#formID").validationEngine();
  });
  
  function editFile(id){
    urlchange('contact_engage.php?task=edit&contacten_no='+id)
  }
  function delFile(id){
    var r=confirm("ยืนยันว่าต้องการลบข้อมูล!");
    if(r==true)
      urlchange('contact_engage_do.php?task=delete&contacten_no='+id)
  }
</script>


<div class="content">

  <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle" /> 
    ออกรายงานสรุปยอดรายรับ
  </div>

  <div class="txtHead" style="width: 260px" >รายงานสรุปยอดรายรับ</div>
  <!--  <div style="float: right;margin-right: 60px"><button class="submitBtn" onclick="urlchange('contact_engage.php')"  >เพิ่มข้อมูลใหม่</button></div>-->

  <div style="float: right;margin-right: 60px;margin-top: 100px;">
    <table>
      <tr>
        <td class="formLabel" >สรุปยอดรวม :</td>
        <td><input  name="" class="forbidTxt" type="text" value="<?= number_format($sumtotal,2) ?>" /></td>
      </tr>
    </table>
  </div>
  <div class="outter" style="width: 500px">


    <form id="formID" method="get" >
      <table>
<!--        <tr>
          <td class="formLabel" >รหัสใบสัญญา :</td>
          <td><input  name="contacten_search" id="contacten_search" type="text" value="<?= $contacten_search ?>" /></td>
        </tr>-->
<!--        <tr>
          <td class="formLabel" >ชื่อลูกค้า :</td>
          <td><input  name="name_search" id="name_search" type="text" alue="<?= $name_search ?>" /></td>
        </tr>-->
        <tr>
          <td class="formLabel" >วันที่ออกใบสัญญา :</td>
          <td>
            <input name="datestart_search" style="width : 70px"  type="text" class="datepicker" id="datestart_search" value="<?= splitdate($datestart_search, 'max') ?>" />
            - 
            <input name="dateend_search" style="width : 70px"  type="text" class="datepicker" id="dateend_search" value="<?= splitdate($dateend_search, 'max') ?>" />  
          </td>
        </tr>
        <td class="formLabel">ออกโดยบริษัท :</td>
        <td>
          <select name="contacten_company_search" id="contacten_company_search"  >
            <option value="0"> เลือกทั้งหมด</option>
              <?php $company_search = $contacten_company_search;
                  include "company_display_search.php";
              ?>
          </select>
        </td>
        <tr height="50">
          <td><button class="submitBtn" type="submit" >ค้นหา</button></td>
          <td></td>
        </tr>
      </table>
    </form>

  </div>
  <div style="position: relative;top: 50px;">
    <table width="850" align="center"  class="simply">
      <tr align="center" >
        <th width="61">ลำดับ</th>
        <th width="100">รหัสใบสัญญา</th>
        <th width="100">วันที่</th>
        <th width="280">ชื่อลูกค้า</th>
        <th width="120">ออกโดยบริษัท</th>
        <th width="130">จำนวนเงิน</th>
<!--        <th width="130">สถานะการจ่ายเงิน</th>
        <th width="40">พิมพ์</th>
        <th width="40">แก้ไข</th>
        <th width="40">ลบ</th>-->
      </tr>
      <?php
      if ($result) {
        while ($row = mysql_fetch_array($result)) {
          $customer = getCustomer($row['contacten_customer']);
          ?>
          <tr >
            <td align="center" ><?php echo++$num; ?></td>
            <td ><?= $row["contacten_id"]; ?></td>
            <td ><?= splitdate($row["contacten_date"], 'avg') ?></td>
            <td ><?= cuName($customer["cu_type"], $customer["cu_name"]); ?></td>
            <td align="center"><?= getCompanyName($row["contacten_company"]); ?></td>
            <td align="center"><?= number_format($row["contacten_total"], 2); ?></td>

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
          echo "&nbsp;<a href='contact_engage_search.php?page=$i&num=$nfor&contacten_search=$contacten_search
          &contacten_company_search=$contacten_company_search&datestart_search=$datestart_search&name_search=$name_search
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
