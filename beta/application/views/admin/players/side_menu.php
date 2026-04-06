
<div class="row hide-on-medium-only  hide-on-small-only " style="margin-left: -1%;margin-right: -1%;">
    <div class="col s12 grey lighten-3">
        <ul class="tabs ">
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin')?>">General</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/web')?>">Site Data</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link" href="<?php echo site_url('admin/tools')?>">Admin Tools</a></li>
            <li class="tab col s2 grey lighten-3"><a class="link active" href="<?php echo site_url('admin/players')?>">Players</a></li>
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

            <b class="">Actions</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Ban Players</a><span class="new badge">It's </span></li>
            </ul>
            <b class="">Players Details</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/playersaccout')?>">Account Details </a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/playerdetails')?>">Player Details </a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/playersinventory')?>">Inventory Details </a><span class="new badge">It's </span></li>
                <li><a class="" href="<?php echo site_url('admin/playersstorage')?>">Storage Details </a><span class="new badge">It's </span></li>
            </ul>
            <b class="">Players Activity</b>
            <div class="divider"></div>
            <ul>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player Game Login Log </a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player Web Site Login Log </a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player RB Log </a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player Reset Log</a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player Eshop Log</a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player Auction Log</a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player PK Log</a></li>
                <li><a class="" href="<?php echo site_url('admin/banplayers')?>">Player Gallery Log</a></li>
            </ul>



        </div>
    </div>