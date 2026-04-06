
<div class="row  ">

    <div class="col s12 m12  ">
        <div id="shouts"  class=" red-text text-lighten-2">


        </div>
    </div>


</div>
<?php if (!$this->session->userdata('logged_in')) { ?>
    <div class="fixed-action-btn" style="top: 70%; right: 5%;">
        <a class="btn-floating  red tooltipped  modal-trigger" href="#modal1" data-position="left" data-delay="10" data-tooltip="Reply to all">
            <i class="large  mdi-content-reply"></i>


        </a>
    </div>

    <!-- Modal Structure -->
    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <form action="/beta/login" method="post" id="login-form-homepage" >
                <div class="row">

                    <div class="col s12">

                        <div class="row">

                            <div class="col m2 s12 valign"><b>Login : </b></div>
                            <div class=" col m5 s12">
                                <input placeholder="Username" id="first_name" type="text" class="validate" name="username">
                            </div>
                            <div class=" col m5 s12">
                                <input placeholder="Password" id="last_name" type="password" class="validate" name="password">
                            </div>
                        </div>

                    </div>
                    <div class="fixed-action-btn" style="bottom: -5%; right: 17px;">
                        <a class="btn-floating  blue tooltipped login-player " data-position="left" data-delay="10" data-tooltip="Login">
                            <i class="large  mdi-content-send"></i>


                        </a >
                        </form>
                    </div>
                </div>
        </div>


        <?php
    } else {
        ?>

        <div class="fixed-action-btn " style="top: 5%; right: 5%;">
        <a class="btn-floating  red tooltipped   logmeout"  data-position="left" data-delay="10" data-tooltip="Logout">
            <i class="large mdi-action-settings-power"></i>


        </a>
      
    </div>
    <?php 
               if(isset($poster['c_id']))
               { ?>
        <div class="row valign-wrapper " id="send_shout" style="margin:0">

           
            <div class="col s8 m10  white-text ">

                <input placeholder="<?php  echo "".trim($poster['c_id'])." : "; ?>Write Your Shout Here" id="shout_text" name="shout_text" type="text" class="validate white-text" maxlength="50" autocomplete="off">
            </div>

            <div class="col s4 m2 ">

                <button class="btn waves-effect waves-light send-web-shout  light-blue" type="submit" name="action">Send
                    <i class="mdi-content-send right"></i>
                </button>
            </div>
        </div>
    <?php } 
    else {
            ?>

<div class="row valign-wrapper center " id="send_shouts" style="margin:0">

           
            <div class="col s12  red-text flow-text  " >

            You dont have any characters in this account. Create character first in game. 
                
            </div>
        </div>

        <?php
    }



    } ?>
