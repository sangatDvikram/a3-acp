
<div class="row hide-on-medium-only  hide-on-small-only " style="margin-left: -1%;margin-right: -1%;">
    <div class="col s12 grey lighten-3">
        <ul class="tabs ">
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin') ?>">General</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/web') ?>">Site Data</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/tools') ?>">Admin Tools</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link active" href="<?php echo site_url('admin/players') ?>">Players</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/acp') ?>">ACP</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/maintenance') ?>">Maintenance</a></li>

        </ul>
    </div>
</div>

<div class="row">


    <!--  left Panal  -->

    <div class="col s12 m3  ">
        <div class="section">
            <div class="section">
                <p>Welcome - <?php echo $username; ?> <a href="<?php echo site_url('login/logout') ?>">Logout</a></p>



                <div class="collection z-depth-1">
                    <h5 class="collection-item" >Website Logs</h5>

                    <a class="collection-item" href="<?php echo site_url('admin/eshoplog') ?>">Eshop log</a>
                    <a class="collection-item" href="#!">Player action log</a>
                    <a class="collection-item" href="#!">Admin action log</a>
                    <a class="collection-item" href="#!">Auction Log</a>
                    <a class="collection-item" href="#!">Gallery Log</a>
                    <h5 class="collection-item" >Item Tracker</h5>
                    <a class="collection-item" href="<?php echo site_url('admin/tracker') ?>">Item Tracker</a>
                    <h5 class="collection-item" >Game Logs</h5>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/201') ?>">Player item picked log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/202') ?>">Monster item picked log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/204') ?>">Player item drop log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/206') ?>">Player item bought @ NPC log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/207') ?>">Player item sell @ NPC log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/208') ?>">Item dropped on player log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/210') ?>">Item trade with player log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/212') ?>">Item slotting log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/213') ?>">Item crafting log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/233') ?>">Item sold as shop log</a>
                    <a class="collection-item" href="<?php echo site_url('admin/gamelog/234') ?>">Item bought as shop log</a>
                    
                    <h5 class="collection-item" >Setting</h5>
                    
                    <a class="collection-item" href="#!">Website Settings</a>
                    <a class="collection-item" href="#!">Player Settings</a>
                    <a class="collection-item" href="#!">Home Page Settings</a>
                    <a class="collection-item" href="#!">Registrations Settings</a>
                    <a class="collection-item" href="#!">API Settings</a>
                    
                </div>
            </div>

        </div>
    </div>