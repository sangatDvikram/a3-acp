

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Item Tracker</h3>
        <div class="divider"></div>
        <p class="caption">Here we keep track of all the  logs and stuffs happening in game</p>
        <br></p>
    </div>
    <div class="section">
        <div class="row">
            <form class="col s12" action="" method="get">
                <div class="row">
                    <div class="input-field col s6 m3">
                        <input placeholder="Account" id="account" type="text" class="validate" name="account">
                        <label for="account">Account</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input placeholder="Character"  id="character" type="text" class="validate" name="character">
                        <label for="character">Character</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input placeholder="Item code" id="ic" type="text" class="validate" name="ic">
                        <label for="ic">Item code</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input placeholder="Item Unique Code" id="iu" type="text" class="validate" name="iu">
                        <label for="iu">Item Unique Code</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action" value="search" >Search
                            <i class="mdi-action-search right"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="divider"></div>

            <table id="itemtracker" class="display " cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Character</th>
                        <th>Account</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>IP address</th>

                        <th>To Character</th>
                        <th>To Account</th>
                        <th>IP address</th>


                        <th>Item Option</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($list)) {
                        $i = 1;

                        foreach ($list as $result) {
                            $type = "";
                            switch ($result['action_type']) {
                                case 201:
                                    $type = "Item Pick up";
                                    break;
                                case 202:
                                    $type = "Item Pick up";
                                    break;
                                case 204:
                                    $type = "Item droped on ground";
                                    break;
                                case 205:
                                    $type = "MOR used";
                                    break;
                                case 206:
                                    $type = "Bought item at NPC";
                                    break;
                                case 207:
                                    $type = "Sold item at NPC";
                                    break;
                                case 208:
                                    $type = "Drop item on player";
                                    break;
                                case 210:
                                    $type = "Traded item";
                                    break;
                                case 212:
                                    $type = "Used for sloting";
                                    break;
                                case 213:
                                    $type = "Done sloting";
                                    break;
                                case 214:
                                    $type = "Used for crafting";
                                    break;
                                case 215:
                                    $type = "Done crafting";
                                    break;
                                case 216:
                                    $type = "Bought Shue at NPC";
                                    break;
                                case 217:
                                    $type = "Sold Shue at NPC";
                                    break;
                                case 218:
                                    $type = "Trade Shue";
                                    break;
                                case 231:
                                    $type = "Sold Shue to player";
                                    break;
                                case 232:
                                    $type = "Bought Shue from player";
                                    break;
                                case 233:
                                    $type = "Sold Item as shop";
                                    break;
                                case 234:
                                    $type = "Bought item as shop";
                                    break;

                                default: $type = "Unknown - $result[action_type]";
                                    break;
                            }
                            $class = ($i % 2 == 0) ? "class=\"even\"" : "class=\"odd\"";
                            $item = "<img src='$result[image]' width='32px'><br> Name : $result[item_name]<br> Item code:<br><b>$result[code];$result[item_unique]</b>";
                            echo "<tr $class> "
                            . "<td>$i</td>"
                            . "<td>$result[actor_name]</td>"
                            . "<td>$result[actor_account]</td>"
                            . "<td>$item</td>"
                            . "<td>$type</td>"
                            . "<td>$result[actor_location]</td>"
                            . "<td>$result[actor_ip_address]</td>";

                            echo "<td>$result[receiver_name]</td>"
                            . "<td>$result[receiver_account]</td>"
                            . "<td>$result[receiver_ip_address]</td>";

                            echo "<td>$result[item_option]</td>" . "<td>$result[date]</td>"
                            . "</tr>";
                            $i++;
                        }
                    }
                    ?>
                </tbody>
                </thead>


            </table>
        </div>

    </div>


    <!--Do Not Touch anny thing below here-->
</div>

</div>


</div>
</div>



</div>
</div>

</main>