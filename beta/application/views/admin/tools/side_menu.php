
<div class="row hide-on-medium-only  hide-on-small-only " style="margin-left: -1%;margin-right: -1%;">
    <div class="col s12 grey lighten-3">
        <ul class="tabs ">
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin')?>">General</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/web')?>">Site Data</a></li>
            <li class="tab col s2 grey lighten-3"><a class="active link" href="<?php echo site_url('admin/tools')?>">Admin Tools</a></li>
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

            <b class="">Account</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/')?>">Manage Account Settings</a></li>
                <li><a class="" href="<?php echo site_url('admin/')?>">Manage Account Status</a></li>
            </ul>
            <b class="">Players</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Copy Inventory</a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Copy Stats</a></li>
            </ul>
            <b class="">Items</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/itemoptions')?>">Item Options</a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/searchitems')?>">Search Items</a></li>
                <li><a class="" href="<?php echo site_url('admin/insertitem')?>">Insert Items</a></li>
            </ul>


        </div>
    </div>