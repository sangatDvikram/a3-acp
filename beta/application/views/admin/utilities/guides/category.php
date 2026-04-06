

<div class="col m9 s12">


    <div id="welcome message" class="section">
        <h3>Guide Category Panel</h3>
        <div class="divider"></div>
        <p class="caption">Here We Do work on Game guide categories</p>
        <br></p>
    </div>
    <div class="section">
        <div class="section">
            <!-- Modal Trigger -->
            <div class="section" id="return-message"></div>
            <a class="waves-effect waves-light btn modal-trigger green" href="#category_model"><i class="mdi-content-add left"></i>Create new category</a>

            <!-- Create Modal Structure -->
            <div id="category_model" class="modal modal-fixed-footer">

                <div class="modal-content">
                    <h4>Create game guide category</h4>
                    
                    <form class="col s12" id="category_form">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="category_name" name="category_name" type="text" class="validate" tabindex="1">
                                <label for="first_name">Category Name</label>
                            </div>
                            <div class="input-field col s6"></div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="checkbox" id="test5" name="enable_posts" tabindex="2" checked=""/>
                                <label for="test5">Enable Posting</label>
                            </div>
                            <div class="input-field col s6"></div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close submit-form" ><i class="mdi-content-send left"></i>Submit</a>
                </div>

            </div>
            
            <!-- Create Modal Structure -->
            <div id="category_update_model" class="modal modal-fixed-footer">

                <div class="modal-content">
                    <h4>Update game guide category</h4>
                    
                    <form class="col s12" id="category_update_form">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="update_category_sr" name="sr" type="text" class="validate" tabindex="1" readonly="" value="0">
                                <label for="first_name">Category Sr</label>
                            </div>
                            <div class="input-field col s6"></div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="update_category_name" name="category_name" type="text" class="validate" tabindex="2" value="0">
                                <label for="first_name">Category Name</label>
                            </div>
                            <div class="input-field col s6"></div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="checkbox" id="update_enable_posts" name="enable_posts" tabindex="3" />
                                <label for="update_enable_posts">Enable Posting</label>
                            </div>
                            <div class="input-field col s6"></div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close edit-category" ><i class="mdi-content-send left"></i>Submit</a>
                </div>

            </div>
            
            
        </div>
        <h4>Category List</h4> 
        <p class="caption">
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Category Name</th>
                    <th>Posting</th>
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