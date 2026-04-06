<nav>
      <div class="nav-wrapper white">
        <a href="#" class="brand-logo">A3ultimate</a>
        <ul id="nav-mobiles" class="right hide-on-med-and-down">
         

                <li class="bold"><a href="/" >Home</i></a></li>
                <li class="bold"><a href="<?php echo site_url()?>">Guide</i></a></li>
                <?php if(!$this->session->userdata('logged_in')){?>
                <li class="bold"><a href="<?php echo site_url('login')?>">Login</i></a></li>
                <?php } else { 

                    if($this->session->userdata('grade')=='BAN')
                    {
                        echo '<li class="bold"><a href="'. site_url('admin').'">Admin</i></a></li>';
                    }

                    ?>

                <li class="bold"><a href="<?php echo site_url('login/logout')?>">Logout</i></a></li>
                <?php } ?>
            </ul>
            <ul id="nav-mobile" class="full side-nav">
         

                <li class="bold"><a href="/" >Home</i></a></li>
                <li class="bold"><a href="<?php echo site_url()?>">Guide</i></a></li>
                <?php if(!$this->session->userdata('logged_in')){?>
                <li class="bold"><a href="<?php echo site_url('login')?>">Login</i></a></li>
                <?php } else { 

                    if($this->session->userdata('grade')=='BAN')
                    {
                        echo '<li class="bold"><a href="'. site_url('admin').'">Admin</i></a></li>';
                    }

                    ?>

                <li class="bold"><a href="<?php echo site_url('login/logout')?>">Logout</i></a></li>
                <?php } ?>
            </ul>
<!-- Include this line below -->
        <a class="button-collapse" href="#" data-activates="nav-mobile"><i class="mdi-navigation-menu"></i></a>
        <!-- End -->
         </div>
    </nav>
    