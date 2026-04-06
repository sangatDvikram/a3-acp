<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="<?php echo site_url('') ?>">Home</a></li>
    
    <li class="divider"></li>
    <li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
</ul>
<nav>
    <div class="nav-wrapper white">
        <div class="col s12"><a href="#" data-activates="slide-out" class="button-collapse top-nav full"><i class="mdi-navigation-menu"></i></a> 
            <a href="/" class="brand-logo"><i class="mdi-navigation-chevron-left left"></i> Back</a>
            <ul id="slide-out" class="side-nav">
                <li class="bold"><a href="<?php echo site_url('') ?>" >Home</i></a></li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header">Guide<i class="mdi-navigation-arrow-drop-down"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="<?php echo site_url('guides/items') ?>">Items</a></li>
                                    <li><a href="<?php echo site_url('guides/maps') ?>">Maps</a></li>
                                    <li><a href="<?php echo site_url('guides/rebirth') ?>">Rebirth</a></li>
                                    <li><a href="<?php echo site_url('ingameguide') ?>">Player's Guides</a></li>

                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php if (!$this->session->userdata('logged_in')) { ?>
                    <li class="bold"><a href="<?php echo site_url('login') ?>">Login</i></a></li>
                <?php } else { ?>

                    <?php
                    echo '<li class="bold"><a href="' . site_url('writer') . '">Write Guide</i></a></li>';
                    if ($this->session->userdata('grade') == 'BAN') {
                        echo '<li class="bold"><a href="' . site_url('admin') . '">Admin</i></a></li>';
                    }
                    ?>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Hi, <?= $this->session->userdata('username') ?><i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="<?php echo site_url('') ?>">Home</a></li>
                                        <li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                <?php } ?>
            </ul>
            <ul class="right hide-on-med-and-down">
                <li class="bold"><a href="<?php echo site_url('') ?>" >Home</i></a></li>
                <li class="bold"><a href="<?php echo site_url('guides') ?>">Guide</i></a></li>
                <?php if (!$this->session->userdata('logged_in')) { ?>
                    <li class="bold"><a href="<?php echo site_url('login') ?>">Login</i></a></li>
                <?php } else { ?>


                    <?php
                    echo '<li class="bold"><a href="' . site_url('writer') . '">Write Guide</i></a></li>';
                    if ($this->session->userdata('grade') == 'BAN') {
                        echo '<li class="bold"><a href="' . site_url('admin') . '">Admin</i></a></li>';
                    }
                    ?>



                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Hi, <?= $this->session->userdata('username') ?><i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                    <ul id='dropdown1' class='dropdown-content'>

                        <li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
                    </ul>
                <?php } ?>
            </ul>


        </div>

    </div>

</nav>