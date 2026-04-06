<form method="post" action=" " id="game_guide_create">
    <div class="row">
        <div class="input-field col s6">
            <i class="mdi-content-create prefix"></i>
            <input id="icon_prefix" type="text" name='guide_title' class="validate">
            <label for="icon_prefix">Guide Title</label>
        </div>
        <div class="col s6"></div>
    </div>
    <div class="row">
        <div class="col s6">
            <label>Select Your Category</label>
            <select class="browser-default" name="category_id">
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
        <textarea name="guide_body" style="width:100%;height:100px"></textarea>

    </div>
    <div class="row">
        <div class="input-field col s6">
            <i class="mdi-action-perm-identity prefix"></i>
            <input id="icon_prefix" type="text" class="validate" readonly="" value="<?= $poster ?>">
            <label for="icon_prefix">Posted By</label>
        </div>
        <div class="col s6"></div>
    </div>
    <div class="row">
        <button class="btn waves-effect waves-light submit-button" type="submit" name="action">Submit
            <i class="mdi-content-send right"></i>
        </button>
    </div>
</form>
