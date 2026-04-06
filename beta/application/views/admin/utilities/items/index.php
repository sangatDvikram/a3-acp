

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Item Panel</h3>
        <div class="divider"></div>
        <p class="caption">Here We Do work on Items</p>
        <br></p>
    </div>
    <div class="section modify-form" style="display:none">
        <h4>Modify Item Information</h4>
        <div class="divider"></div>
        <p class="caption">
        <form action="#" method="post" id='item-edit-form'>
            <div class="row">
                <div class="input-field col s6">
                    <i class="mdi-editor-functions prefix"></i>
                    <input id="icon_prefix" type="text" class="item_code" name='item_code' value="0" >
                    <input type="hidden" class="sr_no" name='sr_no' value="0" >
                    <label for="icon_prefix">Code</label>
                </div>
                <div class="input-field col s6">
                    <i class="mdi-hardware-keyboard prefix"></i>
                    <input id="icon_telephone" type="tel" class="item_name" name='item_name' value="0">
                    <label for="icon_telephone">Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <i class="mdi-hardware-security prefix"></i>
                    <input id="icon_prefix" type="text" class="item_type" name='item_type' value="0">
                    <label for="icon_prefix">Type</label>
                </div>
                <div class="input-field col s6">
                    <i class="mdi-hardware-mouse prefix"></i>
                    <input id="icon_telephone" type="tel" class="item_class" name='item_class' value="0">
                    <label for="icon_telephone">Class</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <i class="mdi-image-photo prefix"></i>
                    <input id="icon_prefix" type="text" class="image" name='image' value="0">
                    <label for="icon_prefix">Image</label>
                </div>
                <div class="input-field col s6">

                    <textarea id="textarea1" class="materialize-textarea item_info" name='item_info'> 000 </textarea>
                    <label for="textarea1">Information</label>
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Update
                <i class="mdi-content-send right"></i>
            </button>
        </form>
    </div>
    <div class="section">
        <h4>Item List</h4>
        <p class="caption">
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Info</th>
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