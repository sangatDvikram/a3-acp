

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Item Insert Panel</h3>
        <div class="divider"></div>
        <p class="caption">Here We Do work on ADDing item to in the Character</p>
        <br></p>
    </div>
    <div class="section">
        <form class="col s12" action="#" method="post">
            <h3>Select Character</h3>

            <div class="divider"></div>
            <br>
            <div class="section"><?php echo validation_errors();  if(isset($slots))print_r($slots);?></div>
            <b>
                Select Characterr
            </b>
            <div class="row">
                <div class="input-field col s6">
                    <i class="mdi-action-search prefix"></i>
                    <input type="text" name="character" id="autocomplete"/>
                    <!--<input id="icon_prefix" type="text" class="validate item-search">-->
                    <label for="icon_prefix">--</label>
                </div>
                <div class="input-field col s6">
                    <i class="mdi-navigation-arrow-forward prefix"></i>
                    <input type="text" name="item_code" id="item"/>
                    <!--<input id="icon_prefix" type="text" class="validate item-search">-->
                    <label for="icon_prefix">Item Code</label>
                </div>

                <div id="result"></div>
            </div>

            <div class="col offser-s1 autocomplete-suggestions">

            </div>
           <!-- <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                <i class="mdi-content-send right"></i>
            </button>-->
        </form>

    </div>


    <!--Do Not Touch anny thing below here-->
</div>

</div>


</div>
</div>



</div>
</div>

</main>