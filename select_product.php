<?php
  session_start();
  include "header_php.php";
  if (!isset($_GET["page"])) { $page = 1; } else { $page = $_GET["page"]; }

  $id_search = trim($_GET["id_search"]);
  $type_search = trim($_GET["type_search"]);
  //$status_search = trim($_GET["status_search"]);

  $result = false;

  $str_where = "";

  //if (!empty($name_search)) { ////// ค้นหาจากชื่อสินค้า
  //  $str_where .="AND  (product_name LIKE '%$name_search%') ";
  //}

  if (!empty($id_search)) { ////// ค้นหาจากชื่อลูกค้า
    $str_where .="AND  (product_id LIKE '%$id_search%') ";
  }

  if (!empty($type_search)) { ////// ค้นหาจากชื่อเซลแมน
    $str_where .="AND  (product_type = '$type_search') ";
  }

    $str_where .="AND  (product_status = '0') ";





  if (!empty($type_search)) {
    $sql_search = "SELECT * FROM product_tab WHERE 1 $str_where  order by product_no desc";

    //echo $sql_search;
    $result = mysql_query($sql_search);
    $numrow = mysql_num_rows($result);
  }
?>




<script language="javascript" type="text/javascript">
  $(document).ready(function(){
    $("#formID").validationEngine();
  });
  
  
  function searchProduct(){
    
    var name_search = $('#name_search').val();
    var id_search = $('#id_search').val();
    var type_search = $('#type_search').val();
    var status_search = $('input[name=status_search]:checked').val();

    if(type_search ==""){
      alert("คุณยังไม่เลือกประเภทสินค้า");
    }else{
      $("#formsrh").load("select_product.php?name_search="+name_search+"&type_search="+type_search+"&status_search="+status_search+"&id_search="+id_search); 
    }
  }
  
</script>




<div class="outter" style="width: 405px">

    <table>
<!--      <tr>
        <td class="formLabel" >รหัสสินค้า :</td>
        <td><input  name="name_search" id="name_search" type="text" value="<?= $name_search ?>" /></td>
      </tr>-->
      <tr>
        <td class="formLabel" >ชื่อสินค้า/ประเภทสินค้า :</td>
        <td>
          <?php
            $sql = "SELECT * FROM product_type";
            $resource = mysql_query($sql);
          ?>
          <select name="type_search" id="type_search"  >
            <option value="0"> == โปรดเลือก ==</option>
            <?php while ($type = mysql_fetch_assoc($resource)) { ?>
              <option <?php if ($type_search == $type['producttype_id']) { echo "selected"; } ?>  value="<?= $type['producttype_id'] ?>"><?= $type['producttype_name'] ?></option>
            <?php } ?>
          </select>
        </td>
<!--      <tr>
        <td class="formLabel" >สถานะสินค้า :</td>
        <td>
          <input type="radio" <? if ($status_search == 2 || $status_search == "") { echo "checked"; } ?>  name="status_search" id="product_status1" value="2" />
          <label for="product_status1">เลือกทั้งหมด</label>
          <input type="radio" <? if ($status_search == "0") { echo "checked"; } ?> name="status_search" id="product_status2" value="0" />
          <label for="product_status2">พร้อมใช้งาน</label>
          <input type="radio" <? if ($status_search == 1) { echo "checked"; } ?> name="status_search" id="product_status3" value="1" />
          <label for="product_status3">ไม่พร้อมใช้งาน</label>
        </td>
      </tr>-->
       <tr>
        <td class="formLabel" >รหัสสินค้า :</td>
        <td>
          <input type="text" name="id_search" id="id_search" value="<?=$id_search?>" >
        </td>
      </tr>
      </tr>
      <tr height="50">
        <td></td>
        <td><button class="submitBtn" onclick="searchProduct()" >ค้นหา</button></td>
        
      </tr>
    </table>


</div>
<?php if ($result) { ?>
  <div style="position: relative;top: 50px;">
    <table width="320" align="center" cellpadding="1" cellspacing="1" class="simply">
      <tr align="center" >
        <th width="30">ลำดับ</th>
        <th width="80">รหัสสินค้า</th>
        <th width="120">ชื่อสินค้า/ประเภทสินค้า</th>
      </tr>
      <?php
      if ($result) {
        while ($row = mysql_fetch_array($result)) {
          ?>
          <tr onclick="loadProduct('<?= $row["product_no"] ?>')" style="cursor: pointer">
            <td align="center" ><?php echo++$num; ?></td>
            <td ><?= $row["product_id"]; ?></td>
            <td ><?= productType($row["product_type"], $row["product_no"]) ?></td>
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
