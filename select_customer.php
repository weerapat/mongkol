<?php
session_start();
include "header_php.php";


$name_search = $_POST["name_search"];
$type_search = trim($_POST["type_search"]);
$result = false;

$str_where = "";

if (!empty($name_search)) { ////// ค้นหาจากชื่อลูกค้า
  $str_where .="AND  (cu_name LIKE '%$name_search%') ";
}

if (!empty($type_search)) {
  $str_where .="AND  (cu_type = '$type_search') ";
}

if (!empty($name_search)) {
  $sql_search = "SELECT * FROM customer_tab WHERE 1 $str_where  ORDER BY cu_no desc";
  $result = mysql_query($sql_search);
  $numrow = mysql_num_rows($result);
}
?>




<script language="javascript" type="text/javascript">
  $(document).ready(function(){
    $("#formID").validationEngine();
  });
  
  
  function searchCustomer(){
    
    var name_search = $('#name_search').val();
    var type_search = $('#type_search').val();
    
    if(name_search ==""){
      alert("คุณยังไม่ใส่รหัสลูกค้า");
    }else{
      $("#formsrh").load("select_customer.php",{ name_search: name_search, type_search: type_search }); 
    }
  }
  
</script>



<a href="customer.php" target="_blank" class="submitBtn" style="margin-bottom: 10px;">เพิ่มข้อมูลลูกค้า</a>
<div class="outter">
  <table>
    <tr>
      <td class="formLabel" >ชื่อลูกค้า :</td>
      <td><input  name="name_search" id="name_search" type="text" value="<?= $name_search ?>" /></td>
    </tr>
    <tr>
      <td class="formLabel" >ประเภทบริษัท :</td>
      <td>
        <select name="type_search" id="type_search"  >
          <option value="0">เลือกทั้งหมด</option>
          <option <?php if ($type_search == 1) { echo "selected"; } ?> value="1">บริษัท</option>
          <option <?php if ($type_search == 2) { echo "selected"; } ?> value="2">ห้างหุ้นส่วน</option>
          <option <?php if ($type_search == 3) { echo "selected"; } ?> value="3">บุคคลธรรมดา</option>
        </select>
      </td>
    </tr>
    <tr height="50">
      <td><button class="submitBtn" onclick="searchCustomer()" type="button" >ค้นหา</button></td>
      <td></td>
    </tr>
  </table>
</div>
<?php if ($result) { ?>
  <div style="position: relative;top: 50px;">
    <table style="width : 100%;" align="center" cellpadding="1" cellspacing="1" class="simply">
      <tr align="center" >
        <th width="30">ลำดับ</th>
        <th width="80">รหัสลูกค้า</th>
        <th width="120">ชื่อลูกค้า</th>
      </tr>
      <?php
      if ($result) {
        while ($row = mysql_fetch_array($result)) {
          ?>
          <tr onclick="loadCus('<?= $row["cu_no"] ?>')" style="cursor: pointer">
            <td align="center" ><?php echo++$num; ?></td>
            <td ><?= $row["cu_id"]; ?></td>
            <td ><?= cuName($row["cu_type"], $row["cu_name"]); ?></td>
          </tr>
          <?php
        }//while
      }//if result
      if (!$numrow) {
        ?>
        <tr>
          <td colspan="3" align="center"><span class="style1">...........ไม่มีข้อมูล.........</span></td>
        </tr>
      <?php } ?>
    </table>


  </div>
<?php } ?>
