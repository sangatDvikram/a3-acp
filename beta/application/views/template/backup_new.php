
  <nav>
      <div class="nav-wrapper white">
        <a href="#" class="brand-logo">A3ultimate</a>
        <ul id="slide-out" class="side-nav">
    <li class="bold"><a href="/" >Home</i></a></li>
    <li class="bold"><a href="<?php echo site_url()?>">Guide</i></a></li>
      <?php if(!$this->session->userdata('logged_in')){?>
      <li class="bold"><a href="<?php echo site_url('login')?>">Login</i></a></li>
      <?php } else {  ?>

                  <?php
                    if($this->session->userdata('grade')=='BAN')
                    {
                        echo '<li class="bold"><a href="'. site_url('admin').'">Admin</i></a></li>';
                    }

                    ?>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header">Hi, <?=$this->session->userdata('username')?><i class="mdi-navigation-arrow-drop-down"></i></a>
          <div class="collapsible-body">
            <ul>
              <li><a href="#">Profile</a></li>
              <li><a href="<?php echo site_url('login/logout')?>">Logout</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>

     <?php } ?>
  </ul>
  <ul class="right hide-on-med-and-down">
    <li class="bold"><a href="/" >Home</i></a></li>
    <li class="bold"><a href="<?php echo site_url()?>">Guide</i></a></li>
     <?php if(!$this->session->userdata('logged_in')){?>
                <li class="bold"><a href="<?php echo site_url('login')?>">Login</i></a></li>
                <?php } else { ?>
                    <?php
                    if($this->session->userdata('grade')=='BAN')
                    {
                        echo '<li class="bold"><a href="'. site_url('admin').'">Admin</i></a></li>';
                    }

                    ?>

      
              
    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Hi, <?=$this->session->userdata('username')?><i class="mdi-navigation-arrow-drop-down right"></i></a></li>
    <ul id='dropdown1' class='dropdown-content'>
      
      <li><a href="<?php echo site_url('login/logout')?>">Logout</a></li>
    </ul>
    <?php } ?>
  </ul>
    
  <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
        
      </div>
    </nav>
