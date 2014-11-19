<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<script type="text/javascript">
  $(function(){
    
    $('#formEdit').dialog({ 
      autoOpen: false,
      width : 350,
      modal: true
    }
  );
    
    $('#noteList').dialog({ 
      autoOpen: false,
      width : 350,
      modal: true
    }
    
  );
    
    
    $('#searchSubmit').click(function() {
      $('#search').submit();
    });
   
    $('#addButton ').click(function() {
      
      $('#building_name').val("");

      $( "#formEdit" ).dialog({ 
        title: 'เพิ่มข้อมูล' ,               
        buttons: { "Save": function() {
            
            var building_name = $('#building_name').val();

            
            if(building_name == ""){
              alert("คุณยังไม่ได้ใส่ข้อมูลสำคัญ");
            }else{
              $.post("building_ajax.php", { 
                task:"save" ,
                building_name: building_name,
                site_id : <?= $site_id ?>
              },
              function(data){
                //reload table
                
                if(data != "success"){
                  alert(data);
                }else{
                  $('#dataList').load('building.php?site_id=<?= $site_id ?> #table', function() {

                    $('#table tr:last').effect( 'highlight','slow');
                  });
                }
              });
  
              $(this).dialog("close"); 
            }
          }}
      });
      $( "#formEdit" ).dialog("open");
      
    });
  });
  
  function edit(id){
  
    $('#building_name').val($('#building_name'+id).text());

    $( "#formEdit" ).dialog({ 
      title: 'แก้ไขข้อมูล' ,               
      buttons: { "Save": function() {
            
          var building_name = $('#building_name').val();
            
            
          if(building_name==""){
            alert("คุณยังไม่ได้ใส่ข้อมูลสำคัญ");
          }else{
            $.post("building_ajax.php", { 
              task:"edit" ,
              building_id: id,
              building_name: building_name ,
              site_id : <?= $site_id ?>
            },
            function(data){
              
              if(data != "success"){
                alert(data);
              }else{
                //reload table
                $('#dataList').load('building.php?site_id=<?= $site_id ?> #table', function() {
                  
                  // highlight แถวที่เพิ่ม
                  $('#row'+id).effect( 'highlight','slow');
                });
              }
            });
  
            $(this).dialog("close"); 
          }
        }}
    });
    $( "#formEdit" ).dialog("open");
  }
  
  function del(id){
    var r=confirm("ยืนยันว่าต้องการลบข้อมูล!");
    if(r==true)
      $.post("building_ajax.php", { 
        task:"delete" ,
        building_id: id
      },
    function(data){
      $('#row'+id).effect( 'highlight','slow');
      $('#dataList').load('building.php?site_id=<?= $site_id ?> #table');
                
    });
  }
</script>

<div id="noteList" style="margin: 20px 0px 0px 20px">

  <table id="table" class="simply">
    <tr class="ui-widget-header ">

      <th style="width: 30px">No</th>
      <th style="width: 160px">ชื่อ</th>
      <?php if ($_SESSION['level'] == "admin") { ?>
        <th style="width: 30px">Edit</th>
        <th style="width: 30px">Del</th>
      <?php } ?>
    </tr>

    <?php
    $building_list = get_buildinglist($searchw, $site_id);

    if ($building_list) {
      $i = 0;
      while ($row = $building_list[$i]) {
        ?>

        <tr id="row<?= $building_list[$i]['building_id'] ?>" <? if (($i + 1) % 2 == 0) { echo "style='background-color: #f4f9f6'"; } ?> >

          <td  align="center" ><?= $i + 1 ?>.</td>
          <td id="building_name<?= $building_list[$i]['building_id'] ?>" ><a href="floor.php?building_id=<?= $building_list[$i]['building_id'] ?>" ><?= $building_list[$i]['building_name'] ?></a></td>
          <?php if ($_SESSION['level'] == "admin") { ?>
            <td align="center" ><span onclick="edit('<?= $building_list[$i]['building_id'] ?>')" class="ui-state-default ui-corner-all ui-icon ui-icon-wrench"></span></td>
            <td align="center" ><span onclick="del('<?= $building_list[$i]['building_id'] ?>')" class="ui-state-default ui-corner-all ui-icon ui-icon-closethick"></span></td>
          <?php } ?>
        </tr>
        <?php
        $i++;
      }
    } else {
      ?>

      <td <?php if ($_SESSION['level'] == "admin") { echo "colspan = '4'"; } else { echo "colspan = '2'"; } ?> style="text-align: center">
        ..ไม่มีข้อมูล..
      </td>
    <?php } ?>
  </table>
</div>