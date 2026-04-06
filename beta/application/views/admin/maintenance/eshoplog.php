

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Eshop item purchase log</h3>
        <div class="divider"></div>
        <p class="caption">Here we keep track of all the logs and stuffs happening in website</p>
        <br></p>
    </div>
    <div class="section">
        
        <table id="eshoplog" class="display " cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Character</th>
                    <th>Account</th>
                    <th>Item</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Old Coins</th>
                    <th>New Coins</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($list))
                    {
                    $i=1;
                    
                    foreach ($list as $result) {
                        $class=($i%2==0)?"class=\"even\"":"class=\"odd\"";
                        $item="<img src='$result[image]' width='32px'><br> Name : $result[name]";
                        echo "<tr $class> "
                        . "<td>$i</td>"
                                . "<td>$result[character_name]</td>"
                                . "<td>$result[account_id]</td>"
                                . "<td>$item</td>"
                                . "<td>$result[transaction_type] coins</td>"
                                . "<td>$result[item_amount]</td>"
                                . "<td>$result[old_balance]</td>"
                                . "<td>$result[new_balance]</td>"
                                . "<td>$result[date]</td>"
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