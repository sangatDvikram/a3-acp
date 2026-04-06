
<div class="row">

<div class="row hide-on-medium-only  hide-on-small-only " style="">
    <div class="col s12 grey lighten-3">
        <ul class="tabs ">
            <li class="tab col s2 grey lighten-3"><a class="active link" href="<?php echo site_url('admin')?>">General</a></li>
            <li class="tab col s2 grey lighten-3"><a class='link' href="<?php echo site_url('admin/web')?>">Site Data</a></li>
            <li class="tab col s2 grey lighten-3"><a class='link'  href="<?php echo site_url('admin/tools')?>">Admin Tools</a></li>
            <li class="tab col s2 grey lighten-3"><a class='link'  href="<?php echo site_url('admin/players')?>">Players</a></li>
            <li class="tab col s2 grey lighten-3"><a class='link' href="<?php echo site_url('admin/acp')?>">ACP</a></li>
            <li class="tab col s2 grey lighten-3"><a class='link' href="<?php echo site_url('admin/maintenance')?>">Maintenance</a></li>

        </ul>
    </div>
</div>

    <!--  left Panal  -->

    <div class="col s12 m3  ">
        <div class="section">
            <p>Welcome - <?php echo $username; ?> <a href="<?php echo site_url('login/logout')?>">Logout</a></p>

            
            
            <div class="collection z-depth-1">
                <h5 class="collection-item" >Quick Access</h5>
                <div class="divider"></div>
                <a class="collection-item" href="<?php echo site_url('admin/playersaccount')?>">Manage Players</a>
                <a class="collection-item" href="#!">Manage guide</a>
                <a class="collection-item" href="#!">Player Log</a>
                <a class="collection-item" href="<?php echo site_url('admin/maintenance')?>">Maintenance</a>
            
            <h5 class="collection-item" >Website Configuration</h5>
           
                <a class="collection-item" href="#!">Website Settings</a>
                <a class="collection-item" href="#!">Player Settings</a>
                <a class="collection-item" href="#!">Home Page Settings</a>
                <a class="collection-item" href="#!">Registrations Settings</a>
                <a class="collection-item" href="#!">API Settings</a>
            </div>
        </div>
    </div>

    <!--  Right Panal  -->

    <div class="col m9 s12">


        <div id="welcome message" class="section">
            <h3>Welcome to Admin Panel</h3>
            <p class="caption"> I got good idea why don't we make changes to website it self to keep track of what to do and what is done ??  what do you say??.  So if you are interested just simply add things to TO Do LIst over here so that i can work it on .<br> <code>"Index File Link : " beta/application/views/admin/index.php   
                </code><br>
                <code>
                    Changes Type :  MODIFIED,FIXED,REPLACED,ADDED,DELETED.
                </code></p>
        </div>
        <div class='divider'></div>
        <div class="section">
            <h4>Changes Log : </h4>
            <ol>
                <li><span class="red-text"> * </span>Added - Added Paging in Guides Category information 12 items at a time <a href="/beta/guides/items">click here</a> - 26.2.2015</li>
                <li><span class="red-text"> * </span>Added - Changed ingame guide delete function to jquery + dialog which as for yes | no. - 25.2.2015</li>
                <li><span class="red-text"> * </span>Added - /controlpanel shifted to /beta. - 21.2.2015</li>
                <li><span class="red-text"> * </span>Added - Item Search and Update in Site Data section <a href="/beta/admin/items">Click Here</a>. - 21.2.2015</li>
                <li><span class="red-text"> * </span>Modified - Paypal Success and Cancle Pages. - 21.2.2015</li>
                <li><span class="red-text"> * </span>Modified - Modified Admin Log table generation for faster page load. - 21.2.2015</li>
                <li><span class="red-text"> * </span>Modified - Made Game Guide Management Easy (Select Change Game Guide Status to change visibility Status of the guide.) - 21.2.2015 </li>
                <li><span class="red-text"> * </span>Fixed - Item Searching in game guide ( there was simple typing mistake in the API). - 21.2.2015 </li>
            </ol>
        </div>
        <div class='divider'></div>
        <div class="section">
            <h4>To Do List : </h4>
            <ol>
                <li>Add your suggestions over here</li>
            </ol>
        </div>
        <div class='divider'></div>
        <div class="section">
            <h4>Error List : </h4>
            <ol>
                <li>If you  find any error write it down here.</li>
            </ol>
        </div>
        <div class='divider'></div>
        <div class="section player-action-log">
            <h4>Player Logs sections</h4>
            <p class="caption">The best players so far </p>
            <p class="caption">Top 15 Player Logs </p>
            <span id="player-action-log" class="col s12">
                
            </span>
            
        </div>
        <div class='divider'></div>
        <div class="section admin-action-log">
            <h4>Admin Logs sections</h4>
            <p class="caption">Top 15 Admin Logs </p>
            <span id="admin-action-log" class="col s12">
                
            </span>
            
        </div>
        <div class='divider'></div>
        <div class="section">
            <h4>Some Admin Pending Requests</h4>
            <p class="caption">Track Down admins pending works.</p>
        </div>
        <div class='divider'></div>
        <div class="section online-list">
            <h4>Some Website online Peoples</h4>
            
            <span id="online-list" class="col s12">
                
            </span>
            
        </div>


    </div>

</div>


</div>
</div>



</div>
</div>

</main>