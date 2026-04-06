<nav class="white lighten-2">
    <div class="nav-wrapper">
        <div class="col s12">
            <a href="/" class="brand-logo hide-on-med-and-down" style="font-size: 18px"><i class="mdi-navigation-chevron-left left"></i> Back to Main Website</a>
            <a href="/" class="brand-logo hide-on-large-only" style="font-size: 18px"><i class="mdi-navigation-chevron-left left"></i>  Main Website</a>

            <!-- Side Navigation bar on the Small Devices-->

            <ul id="slide-out" class="side-nav">
                <li><a href="<?php echo site_url('') ?>">Home</a></li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header">Guide<i class="mdi-navigation-arrow-drop-down"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo site_url('guides/items') ?>">Items</a></li>
                                    <li><a href="<?php echo site_url('guides/maps') ?>">Maps</a></li>
                                    <li><a href="<?php echo site_url('guides/rebirth') ?>">Rebirth</a></li>
                                    <li><a href="<?php echo site_url('ingameguide') ?>">Ingame Guide</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a href="<?php echo site_url('eshop') ?>">Eshop</a></li>
                <?php if (!$this->session->userdata('logged_in')) { ?>

                    <li><a href="<?php echo site_url('login') ?>">Login</a></li>

                <?php } else { ?>

                    <li><a href="<?php echo site_url('writer') ?>">Write Guide</a></li>

                    <?php if ($this->session->userdata('grade') == 'BAN') { ?>
                        <li><a href="<?php echo site_url('admin') ?>">Admin</a></li>
                    <?php } ?>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Hi, <?= $this->session->userdata('username') ?><i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="<?php echo site_url('') ?>">Home</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

            </ul>
            <!-- Main Navigation bar on the Large Devices-->
            <ul class="right hide-on-med-and-down">
                <li><a href="<?php echo site_url('') ?>">Home</a></li>
                
                <li><a href="<?php echo site_url('guides') ?>">Guide</a></li>
                <li><a href="<?php echo site_url('eshop') ?>">Eshop</a></li>


                <?php if (!$this->session->userdata('logged_in')) { ?>

                    <li><a href="<?php echo site_url('login') ?>">Login</a></li>

                <?php } else { ?>

                    <li><a href="<?php echo site_url('writer') ?>">Write Guide</a></li>

                    <?php if ($this->session->userdata('grade') == 'BAN') { ?>
                        <li><a href="<?php echo site_url('admin') ?>">Admin</a></li>
                    <?php } ?>

                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Hi, <?= $this->session->userdata('username') ?><i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                    <ul id='dropdown1' class='dropdown-content'>
                        <!-- <li><a href="#!">First</a></li>
                         <li><a href="#!">Second</a></li>
                         <li><a href="#!">Third</a></li>-->
                        <li><a href="<?php echo site_url('') ?>">Home</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
                    </ul>

                <?php } ?>


            </ul>
            <a href="#" data-activates="slide-out" class="button-collapse " id='main-menu-show'><i class="mdi-navigation-menu grey-text text-darken-4"></i></a>
        </div>
    </div>
</nav>      