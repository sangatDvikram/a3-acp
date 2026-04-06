<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Players Inventory Details</h3>
        <div class="divider"></div>
        <p class="caption">Here We Perform action like get inventory's details and all :). Here we will get information about character's Wear and Inventory  Information.</p>
        <br></p>
    </div>
    <div class="section">

        <h3>Select Character</h3>

        <div class="divider"></div>
        <br>
        <div class="section"><?php echo validation_errors();
if (isset($slots)) print_r($slots); ?></div>
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
        </div>
        <div id="player-info" style="display: none">
        <h3>Wear Details</h3>
        <div class='divider'></div>
        <div class="section" >
            <div class="row">
                <div class="col s12 m6" id='result-wear'></div>
                <div class="col s12 m6" id='wear-info'></div>

            </div>
        </div>
        <h3>Inventory Details</h3>
        <div class='divider'></div>
        <div class="section" >
            <div class="row">
                <div class="col s12 m6" id='result-inventory'></div>
                <div class="col s12 m6" id='item-info'></div>

            </div>
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