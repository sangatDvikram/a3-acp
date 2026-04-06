

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Admin Players Details</h3>
        <div class="divider"></div>
        <p class="caption">Here We Perform action like get players details and all :)</p>
        <br></p>
    </div>
    <div class="section">

    <h3>Select Character</h3>

            <div class="divider"></div>
            <br>
            <div class="section"><?php echo validation_errors();  if(isset($slots))print_r($slots);?></div>
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


    </div>


    <!--Do Not Touch anny thing below here-->
</div>

</div>


</div>
</div>



</div>
</div>

</main>