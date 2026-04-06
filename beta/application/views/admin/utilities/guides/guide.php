

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Game guide Panel</h3>
        <div class="divider"></div>
        <p class="caption">Here We Do work on player submitted game guides</p>
        <br></p>
    </div>
    <div class="section">
        <!-- Information Modal Structure -->
        <div id="preview_game_guide_modal" class="modal modal-fixed-footer">

            <div class="modal-content">
                <h4>Preview Game Guide</h4>
                <div id="preview-game-guide-title"></div>
                <div class="divider"></div>
                <div id="preview-game-guide"></div>
            </div>

            <div class="modal-footer">
                <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close edit-category" ><i class="mdi-content-send left"></i>Close</a>
            </div>

        </div>

        <!-- Information Modal Structure -->
        <div id="update_game_guide_modal" class="modal modal-fixed-footer">

            <div class="modal-content">
                <h4>Update Game Guide</h4>
                <form method="post" action=" " id="game_guide_update">
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="mdi-content-create prefix"></i>
                            <input id="icon_prefix" type="text" name='guide_title'  value="0" class="validate guide_title">
                            <label for="icon_prefix">Guide Title</label>
                            <input type="hidden" id="sr">
                        </div>
                        <div class="col s6"></div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <label>Select Your Category</label>
                            <select class="browser-default" name="category_id" id="category_id">
                                <option value="" disabled selected>Choose your category</option>
                                <?php
                                if (isset($categories)) {
                                    foreach ($categories as $value) {
                                        echo "<option value='$value[sr]'>$value[category_name]</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col s6"></div>
                    </div>
                    <div class="row">
                        <label for="icon_prefix2">Description</label>
                        <textarea name="guide_body" id="guide_body" style="width:100%;height:100px"></textarea>

                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="mdi-action-perm-identity prefix"></i>
                            <input id="icon_prefix" type="text" class="validate playername" name="playername" readonly="" value="0">
                            <label for="icon_prefix">Posted By</label>
                        </div>
                        <div class="col s6"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="checkbox" id="verified" name="verified" tabindex="2" />
                            <label for="verified">Verify</label>
                        </div>
                        <div class="col s6"></div>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close edit-game-guide" ><i class="mdi-content-send left"></i>Update</a>
            </div>

        </div>
        <h4>Game Guide List</h4>
        <p class="caption">
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Username</th>
                    <th>Player Name</th>
                    <th>Guide Title</th>
                    <th>Guide Body</th>
                    <th>View</th>
                    <th>Change Status</th>
                    <th>Edit</th>

                </tr>
            </thead>
        </table>
        </p>
    </div>


</div>

</div>


</div>
</div>



</div>
</div>

</main>