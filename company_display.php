              <select name="<?=$company?>"  id="quo_company"  >
                <option <?php if ($row[$company] == 1) { echo "selected"; } ?> value="1"> มิตรมงคล</option>
                <option <?php if ($row[$company] == 2) { echo "selected"; } ?> value="2"> มงคลทวีทรัพย์</option>
                <option <?php if ($row[$company] == 3) { echo "selected"; } ?> value="3"> มิตรมงคล อีควิปเม้นท์</option>
              </select>
