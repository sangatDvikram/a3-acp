
<div class="row hide-on-medium-only  hide-on-small-only " style="margin-left: -1%;margin-right: -1%;">
    <div class="col s12 grey lighten-3">
        <ul class="tabs ">
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin')?>">General</a></li>
            <li class="tab col s2 grey lighten-3"><a class="active link" href="<?php echo site_url('admin/web')?>">Site Data</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/tools')?>">Admin Tools</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/players')?>">Players</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/acp')?>">ACP</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/maintenance')?>">Maintenance</a></li>

        </ul>
    </div>
</div>

<div class="row">


    <!--  left Panal  -->

    <div class="col s12 m3  ">
        <div class="section">
            <p>Welcome - <?php echo $username; ?> <a href="<?php echo site_url('login/logout')?>">Logout</a></p>
            
            <b class="">Game Guides</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/guidesettings')?>">Manage Guide Settings </a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/managecategories')?>">Manage Guide Categories </a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/manageguide')?>">Manage Guides</a><span class="new badge">It's </span></li>
            </ul>
            <b class="">Rebirth</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/rebirth')?>">Manage Rebirths</a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/reset')?>">Manage Reset</a><span class="new badge">It's </span></li>
            </ul>

            <b class="">Guide</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/maps')?>">Manage Maps</a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/monsters')?>">Manage Monsters</a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/items')?>">Manage Items</a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/crafting')?>">Manage Crafting</a><span class="new badge">It's </span></li>
            </ul>

            <b class="">Eshop</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="#!">Manage Eshop</a></li>
                <li><a class="" href="#!">Eshop Settings</a></li>
            </ul>
            <b class="">Auction</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="#!">Manage Auction</a></li>
                <li><a class="" href="#!">Auction Settings</a></li>
            </ul>
            <b class="">Gallery</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="#!">Manage Gallery</a></li>
                <li><a class="" href="#!">Gallery Settings</a></li>
            </ul>

        </div>
    </div>