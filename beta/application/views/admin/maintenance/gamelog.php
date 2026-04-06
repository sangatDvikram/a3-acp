

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Game log</h3>
        <div class="divider"></div>
        <p class="caption">Here we keep track of all the  logs and stuffs happening in game</p>
        <br></p>
    </div>
    <div class="section">

        <table id="gamelog" class="display " cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Character</th>
                    <th>Account</th>
                    <th>Item</th>
                    <th>Location</th>
                    <th>IP address</th>
                    <?php if ($type == 208 || $type == 210 || $type == 233 || $type == 234) { ?>

                        <th>To Character</th>
                        <th>To Account</th>
                        <th>IP address</th>

                    <?php } ?>
                    <th>Item Option</th>
                    <th>Date</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($list)) {
                    $i = 1;

                    foreach ($list as $result) {
                        $class = ($i % 2 == 0) ? "class=\"even\"" : "class=\"odd\"";
                        $item = "<img src='$result[image]' width='32px'><br> Name : $result[item_name]<br> Item code:<br><b>$result[code];$result[item_unique]</b>";
                        echo "<tr $class> "
                        . "<td>$i</td>"
                        . "<td>$result[actor_name]</td>"
                        . "<td>$result[actor_account]</td>"
                        . "<td>$item</td>"
                        . "<td>$result[actor_location]</td>"
                        . "<td>$result[actor_ip_address]</td>";
                        if ($type == 208 || $type == 210 || $type == 233 || $type == 234) {
                            echo "<td>$result[receiver_name]</td>"
                            . "<td>$result[receiver_account]</td>"
                            . "<td>$result[receiver_ip_address]</td>";
                        }
                        echo "<td>$result[item_option]</td>"."<td>$result[date]</td>"
                        . "</tr>";
                        $i++;
                    }
                }
                ?>
            </tbody>
            </thead>


        </table>
    </div>


    <!--Do Not Touch anny thing below here-->
</div>

</div>


</div>
</div>



</div>
</div>

</main>