<?php
include "header.php";
include "header_php.php";
if (!isset($_GET["page"])) { $page = 1; } else { $page = $_GET["page"]; }

$num = $_GET["num"];
$num2 = $_GET["num"];
$name_search = trim($_GET["name_search"]);
$type_search = trim($_GET["type_search"]);
$status_search = trim($_GET["status_search"]);

$result = false;

$str_where = "";

if (!empty($name_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (product_name LIKE '%$name_search%') ";
}

if (!empty($type_search)) { ////// ค้นหาจากชื่อเซลแมน
  $str_where .="AND  (product_type = '$type_search') ";
}

if ($status_search == 2 || empty($status_search)) { ////// ค้นหาจากชื่อเซลแมน
  $str_where .="AND  (product_status in (0,1)) ";
}else{
  $str_where .="AND  (product_status = '{$status_search}') ";
}


$sql_search = "SELECT * FROM product_tab WHERE 1 $str_where  order by product_no desc";

$per_page = 20;
$prev_page = $page - 1;
$next_page = $page + 1;
$re = mysql_query($sql_search);
$page_start = ($per_page * $page) - $per_page;
$allnum = mysql_num_rows($re);
$num_pages = ceil($allnum / $per_page);
$sql_search.=" limit $page_start,$per_page";
//echo $sql_search;
$result = mysql_query($sql_search);
//echo $result;
?>




<script language="javascript" type="text/javascript">
  $(document).ready(function(){
    $("#formID").validationEngine();
  });

  function editFile(id){
    urlchange('product.php?task=edit&product_no='+id)
  }
  function delFile(id){
    var r=confirm("ยืนยันว่าต้องการลบข้อมูล!");
    if(r==true)
      urlchange('product_do.php?task=delete&product_no='+id)
  }
</script>


<div class="content">

  <div id="navigator">
    <a href="menu.php">Menu </a>
    <img src="images/btween_link.png" width="10" height="7" align="absmiddle">
    ค้นหาข้อมูลสินค้า
  </div>

  <div class="txtHead" style="width: 120px" >ค้นหาข้อมูลสินค้า</div>
  <div style="float: right;margin-right: 60px"><button class="submitBtn" onclick="urlchange('product.php')"  >เพิ่มข้อมูลสินค้า</button></div>
  <div class="outter" style="width: 500px">
    <form id="formID" method="get" >
      <table>
        <tr>
          <td class="formLabel" >รหัสสินค้า :</td>
          <td><input  name="name_search" id="name_search" type="text" value="<?=$name_search?>" /></td>
        </tr>
        <tr>
          <td class="formLabel" >ชื่อสินค้า/ประเภทสินค้า :</td>
          <td>
            <?php
              $sql = "SELECT * FROM product_type";
              $resource = mysql_query($sql);
            ?>
            <select name="type_search" id="type_search"  >
              <option value="0">เลือกทั้งหมด</option>
              <?php while ($type = mysql_fetch_assoc($resource)) { ?>
                <option <?php if($type_search == $type['producttype_id']){echo "selected";} ?>  value="<?= $type['producttype_id'] ?>"><?= $type['producttype_name'] ?></option>
              <?php } ?>
            </select>
          </td>
          <tr>
            <td class="formLabel" >สถานะสินค้า :</td>
          <td>
            <input type="radio" <?php if ($status_search == 2 || $status_search =="") { echo "checked"; } ?>  name="status_search" id="product_status1" value="2" />
            <label for="product_status1">เลือกทั้งหมด</label>
            <input type="radio" <?php if ($status_search == "0" ) { echo "checked"; } ?> name="status_search" id="product_status2" value="0" />
            <label for="product_status2">พร้อมใช้งาน</label>
            <input type="radio" <?php if ($status_search == 1 ) { echo "checked"; } ?> name="status_search" id="product_status3" value="1" />
            <label for="product_status3">ไม่พร้อมใช้งาน</label>
          </td>
          </tr>
        </tr>
        <tr height="50">
          <td><button class="submitBtn" type="submit" >ค้นหา</button></td>
          <td></td>
        </tr>
      </table>
    </form>

  </div>
  <div style="position: relative;top: 50px;left : 50px;">
    <table width="850" cellpadding="1" cellspacing="1" class="simply">
      <tr align="center" >
        <th width="61">ลำดับ</th>
        <th width="150">รหัสสินค้า</th>
        <th width="150">ชื่อสินค้า/ประเภทสินค้า</th>
        <th width="100">แบบ/รุ่น/ขนาด</th>
        <th width="100">หมายเลข</th>
        <th width="40">แก้ไข</th>
        <th width="40">ลบ</th>
      </tr>
      <?php
      if ($result) {
        while ($row = mysql_fetch_array($result)) {
          ?>
          <tr >
            <td align="center" ><?php echo++$num; ?></td>
            <td ><?= $row["product_id"]; ?></td>
            <td ><?= productType($row["product_type"],$row["product_no"]) ?></td>
            <td ><?= $row["product_size"]; ?></td>
            <td ><?= $row["product_number"]; ?></td>
            <td align="center"><img alt=""  src="images/edit.png" class="icon"  onclick="editFile('<?= $row["product_no"] ?>')"/></td>
            <td align="center"><img alt=""  src="images/del.png" class="icon"  onclick="delFile('<?= $row["product_no"] ?>')"/></td>
          </tr>
          <?php
        }//while
      }//if result
      if (!$result or $allnum == 0) {
        ?>
        <tr>
          <td colspan="8" align="center"><span class="style1">...........ไม่มีข้อมูล.........</span></td>
        </tr>
      <?php } ?>
    </table>
    <div style="position: relative;left: 0px; top:20px;" class="pagination">
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
          echo "&nbsp;<a href='product_search.php?page=$i&num=$nfor&name_search=$name_search&type_search=$type_search' >$i</a>&nbsp;";
        } else {
          echo "&nbsp;<u class='pageActive'>$i</u>&nbsp;";
        }
        $nfor = $nfor + $per_page;
      }///for
      ?>

    </div>
  </div>

  <?php include "footer.php" ?>
