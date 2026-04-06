

<div class="col m9 s12">


    <div id="welcome message" class="section"> 
        <h3>Ban Players Panel</h3>
        <div class="divider"></div>
        <p class="caption">Here We have Bann Players with the help of lots of date and time things </p>
        <br></p>
    </div>
    <div class="section"><?php echo validation_errors();  if(isset($status))print_r($status);?></div>
    <div class="section">
        <form class="col s12" action="#" method="post">
            <h3>Select Character</h3>

            <div class="divider"></div>
            <br>
            
            <b>
                Select Character
            </b>
            <div class="row">
                <div class="input-field col s6">
                    <i class="mdi-action-search prefix"></i>
                    <input type="text" name="character" id="autocomplete"/>
                    <!--<input id="icon_prefix" type="text" class="validate item-search">-->
                    <label for="icon_prefix">--</label>
                    <br>
                    <div class="col offser-s1 autocomplete-suggestions" id="characterSearch">

                    </div>
                </div>
                <div class="input-field col s6">
                    <i class="mdi-navigation-arrow-forward prefix"></i>
                    <input type="text" name="account" id="account" value=" " />
                    <!--<input id="icon_prefix" type="text" class="validate item-search">-->
                    <label for="icon_prefix">Character Account</label>
                </div>


            </div>


            <div class="row">
                <div class="col s6">
                    
                </div>
                <div class="input-field col s6">
                    <div class="col s6">
                        <div class="col offser-s1 autocomplete-suggestions" id="accountSearch">

                        </div>
                    </div>
                </div>
            </div>
             <b>
                Select Ban Status
            </b>
            <div class="row">
                <div class="col s6">
                    <label>Browser Select</label>
                    <select class="browser-default" name='status' id="bans">
                        <option value="X" data-info="Select something or else players may get banned :) " selected>Choose your option</option>
                        <?php 
                           foreach ($status_list as $status)
                           {
                               echo "<option value='$status[status]' data-info='$status[message]'>$status[status] - $status[message]";
                               echo "</option>";
                           }

                        ?>
                    </select>
                </div>
                <div class="col s6">
                    
                        <h5>Ban information</h5>
                        <div class="divider"></div>
                        <textarea name='msg' id='msg'>
                            
                        </textarea>
                    
                </div>
            </div>
             <b>
                Select Ban Till
            </b>
            <div class="row">
                <div class="col s6"> 
                   <label for="birthdate">Select Date</label>
                    <input id="birthdate" type="text" name='ban_date' class="datepicker"></input>

                </div>
                <div class="col s6">
        
                    
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                <i class="mdi-content-send right"></i>
            </button>
        </form>

    </div>

    <div class="section">

    </div>


    <!--Do Not Touch anny thing below here-->
</div>

</div>


</div>
</div>



</div>
</div>

</main>