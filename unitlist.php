<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$sql = "SELECT * FROM unit_master";

$resource = mysql_query($sql);
while ($row = mysql_fetch_assoc($resource)) {
  ?>
  <option  value="<?= $row['unit_name'] ?>"> <?= $row['unit_name'] ?></option>

  <?php
}?>