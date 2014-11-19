<?php
include "header.php";
include "header_php.php";
if (!isset($_GET["page"])) { $page = 1; } else { $page = $_GET["page"]; }

$num = $_GET["num"];
$num2 = $_GET["num"];
$name_search = trim($_GET["name_search"]);
$type_search = trim($_GET["type_search"]);

$result = false;

$str_where = "";

if (!empty($name_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (cu_name LIKE '%$name_search%') ";
}

if (!empty($type_search)) { ////// ค้นหาจากชื่อเซลแมน
  $str_where .="AND  (cu_type = '$type_search') ";
}


$sql_search = "SELECT * FROM customer_tab WHERE 1 $str_where  ORDER BY cu_no desc";
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
  $(document).ready(function(){
    $("#formID").validationEngine();
  });
  
  function editFile(id){
    urlchange('customer.php?task=edit&cu_no='+id)
  }
  function delFile(id){
    var r=confirm("ยืนยันว่าต้องการลบข้อมูล!");
    if(r==true)
      urlchange('customer_do.php?task=delete&cu_no='+id)
  }
</script>


<div class="content">

    <div id="navigator"> 
    <a href="menu.php">Menu </a> 
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle" /> 
     ค้นหาข้อมูลลูกค้า
  </div>
  
  <div class="txtHead" >ค้นหาข้อมูลลูกค้า</div>
  <div class="addNew-btn" ><button class="submitBtn" onclick="urlchange('customer.php')"  >เพิ่มข้อมูลลูกค้า</button></div>
  <div class="outter" style="width: 500px">
    <form id="formID" method="get" >
      <table>
        <tr>
          <td class="formLabel" >ชื่อลูกค้า :</td>
          <td><input  name="name_search" id="name_search" type="text" /></td>
        </tr>

        <tr height="50">
          <td><button class="submitBtn" type="submit" >ค้นหา</button></td>
          <td></td>
        </tr>
      </table>
    </form>

  </div>
  <div style="position: relative;top: 50px;">
    <table width="900" align="center" cellpadding="1" cellspacing="1" class="simply">
      <tr align="center" >
        <th width="61">ลำดับ</th>
        <th width="100">รหัสลูกค้า</th>
        <th width="280">ชื่อลูกค้า</th>
        <th width="180">ผู้ติดต่อ</th>
        <th width="80">เบอร์โทร</th>
        <th width="80">เบอร์แฟกซ์</th>
        <th width="120">เงื่อนไขการชำระเงิน</th>
        <th width="40">แก้ไข</th>
        <th width="40">ลบ</th>
      </tr>
      <?php
      if ($result) {
        while ($row = mysql_fetch_array($result)) {
          ?>
          <tr >
            <td align="center" ><?php echo++$num; ?></td>
            <td ><?= $row["cu_id"]; ?></td>
            <td ><?= cuName($row["cu_type"],$row["cu_name"]); ?></td>
            <td ><?= $row["cu_contact"]; ?></td>
            <td ><?= $row["cu_phone"]; ?></td>
            <td ><?= $row["cu_fax"]; ?></td>
            <td ><?= $row["cu_termpayment"]; ?></td>
            <td align="center"><img alt=""  src="images/edit.png" class="icon"  onclick="editFile('<?= $row["cu_no"] ?>')"/></td>
            <td align="center"><img alt=""  src="images/del.png" class="icon"  onclick="delFile('<?=$row["cu_no"] ?>')"/></td>
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
          echo "&nbsp;<a href='customer_search.php?page=$i&num=$nfor&name_search=$name_search&type_search=$type_search' >$i</a>&nbsp;";
        } else {
          echo "&nbsp;<u class='pageActive'>$i</u>&nbsp;";
        }
        $nfor = $nfor + $per_page;
      }///for
      ?>

    </div>

  </div>
  <?php include "footer.php" ?>
