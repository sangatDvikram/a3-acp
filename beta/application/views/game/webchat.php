<main>

    <?php if (isset($charcharacter) && $charcharacter != '') { ?>
        <!-- Dropdown Structure -->
        <ul id='character-options' class='dropdown-content'>
            <li><a href="<?php echo site_url('game/change') ?>" title="Change Character">Change Character</a></li>
            <li><a href="/">Home</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
        </ul>
        <ul id='chat-options' class='dropdown-content'>
            <li><a id="home">Home</a></li>
            <li class="divider"></li>
            <li><a href="#!">Refresh</a></li>
        </ul>

        <div class="row webchat" >
            <div class="section grey lighten-4 col offset-l1 s12 l10 z-depth-1 main-container " style=" padding:0;" >

                <div class="col l4 s12 left-menu" style=" padding:0;">

                    <div class="section grey lighten-3 playerinfo" style="padding: 0.75rem;"> 
                        <div class="row player-info valign-wrapper"  style="margin: 0">

                            <div class="col s8 ">
                                <h4 class="flow-text player-name" title="<?php echo $charcharacter;?>"> <b><?php echo $charcharacter;?></b> </h4>
                            </div>
                            <div class="col s4 valign">
                                <span class="right "> <i class="mdi-action-settings small dropdown" href='#' id="button" data-activates='character-options'></i></span>
                            </div>


                        </div>

                    </div>
                    <div class="section search-option">
                        <div class="row">
                            <div class="col s1">
                                
                                <i class="mdi-content-clear small cyan-text " id="clear-text" title="Clear Text" style="display:none" ></i>
                                <i class="mdi-action-search small grey-text text-darken-4" id="search-text" title="Search Text"></i>
                            </div> 
                            <div class="col s11">

                                <form action="" method="post">

                                    <input id="search" type="text" class="serch-bar" placeholder="Search Player" autocomplete="off">
                                    <input id="search-online" type="text" class="serch-bar" placeholder="Search online player" autocomplete="off" style="display:none">

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="section character-list" style="padding: 0">

                        
                        <div class="chat-list" style="height:100%"><div id='loader'></div></div>
                        <div class="online-player-list" style="display: none"></div>
                        
                    </div>

                </div>
                <div class="col l8 s12 right-main hide-on-med-and-down" style="padding:0;">
                    <div class="home-panel center" > 

                        <span class="flow-text "> Welcome To A3 Ultimate Chat Box</span>
                      
                    </div>
                    <div class="chat-panel" > 

                        <div class="section character-info grey lighten-3 " >

                            <div class="row valign-wrapper">
                                <span class="hide-on-large-only back-to-main"><i class="mdi-hardware-keyboard-arrow-left small"></i></span>
                                <div class="col s8 valign">
                                    <h5 class="flow-text back-to-main" id="chat-char-name"></h5>
                                </div>
                                <div class="col s4 valign">
                                    <span class="right dropdown" href='#' id="button" data-activates='chat-options'> <i class="mdi-navigation-more-vert small"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="section character-chat brown lighten-4" >

                            <!--<div class="chat-more center tooltipped hide-on-med-and-down" data-position="bottom" data-delay="50" data-tooltip="Click me to load more." id="chat-more" >

                                <a  class=" " >
                                    <i class="mdi-hardware-keyboard-arrow-down small"></i>

                                </a>


                            </div>
                            <div class="chat-more center hide-on-large-only" title="Click me to load more." id="chat-more" >

                                <a  class=" " >
                                    <i class="mdi-hardware-keyboard-arrow-down small"></i>

                                </a>


                            </div>

                            <div class="chat-messages" id="chat-messages">


                            </div>
                            <div id="chat-messages-bottom" >


                            </div>-->
                             
                                
                        </div>
                        <div class="section character-send grey lighten-3 " >

                            <form id="chatbox-form" action="" method="post">

                                <div class="row valign-wrapper">
                                    <div class="input-field col s10  chat-message">
                                        <input placeholder="Write your chat here" type="text" id="chat-message">
                                    </div>
                                    <div class="input-field col s2 chat-send ">
                                        <button class="btn-floating waves-effect waves-light red" id='chat-send' type="submit" name="chat-text"style="left:30%;">
                                            <i class="mdi-content-send right"></i>
                                        </button>
                                    </div>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>


        <!--Character Selection Modal Structure -->
        <div id="modal1" class="modal ">
            <div class="modal-content">
                <h4>Select Your Character</h4>
                <?php
                if (isset($chat_error)) {
                    foreach ($chat_error as $error) {
                        
                        echo "<span class='red-text'>$error</span><br>";
                    }
                }
                ?>
                <form class="col s12 m6" method="post" action=" ">

                    <p>
                        <label>Character Select</label>
                        <select class="browser-default" name="character">
                            <option value="" disabled selected>Choose Character</option>
                            <?php
                            foreach ($account_characters as $characters) {
                                $name = trim($characters['c_id']);
                                echo "<option value='$name'>$name</option>";
                            };
                            ?>
                        </select>
                    </p>
            </div>
            <div class = "modal-footer">
                <button type="submit" href = "#" class = "waves-effect waves-green btn-flat">Select</button>
            </div>
            </form>
        </div>

        <?php
    }
    ?>

</main>