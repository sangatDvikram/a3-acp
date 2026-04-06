
<main>
    <!--  Main Container  -->

    <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container center">
                <div class="row">
                    <div class="col s12 m12">

                        <h3 class="header  white-text text-lighten-2">Players Guide</h3>
                        <h5 class="header white-text text-lighten-2"> Community Guide Created by players</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax green darken-1"><img src="/images/back-top-war.jpg" alt="Unsplashed background img 2"></div>
    </div>


    <div class="row main-page-container" style="margin-top: -3%;">
        <div class="col  l12 s12">



            <div class="row" >
                <div class="col m12 s12  white z-depth-1">
                    <!--  Tabs Panal  -->

                    <div class="row hide-on-medium-only  hide-on-small-only " >
                        <div class="col s12 grey lighten-3">
                            <ul class="tabs ">
                                <li class="tab col s4 grey lighten-3"><a  onclick="window.location.assign('<?php echo site_url('guides/items') ?>');">Item</a></li>
                                <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/maps') ?>');">Maps</a></li>
                                <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/rebirth') ?>');">Rebirth</a></li>
                                <li class="tab col s4 grey lighten-3"><a class="active" onclick="window.location.assign('<?php echo site_url('ingameguide') ?>');">Ingame Guide</a></li>
                            </ul>
                        </div>
                    </div>

                    <div id="head-message" class="section">
                        <h4>Players Guides</h4>
                    </div>
                    <div class="divider"></div>

                    <div class="row">


                        <!--  left Panel  -->

                        <div class="col s12 m3  ">
                            <div class="section">
                                      <div class="collection z-depth-1">
                                   
                                        <a class="collection-item" href="<?php echo site_url('ingameguide') ?>"><i class="mdi-action-home" ></i> Home </a>

                                    
                                    <?php
                                    foreach ($mainmenu as $category) {
                                       

                                      
                                        if (isset($category['link'])) {
                                             echo'<h5 class="collection-item">
      <i class="mdi-action-bookmark"></i>';

                                        echo " $category[categories]</h5>";
                                            foreach ($category['link'] as $menu_class) {

                                        if (isset($current) && $current == $menu_class['guide_link'])
                                            echo"<a class='collection-item active'  href='" . site_url('ingameguide') . "/$menu_class[guide_link]'>";
                                        else
                                           echo"<a class='collection-item '  href='" . site_url('ingameguide') . "/$menu_class[guide_link]'>";
                                                echo " $menu_class[guide_title]";
                                                echo"</a>";
                                            }
                                        }
                                       
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!--  Right Panel  -->

                        <div class="col m9 s12" >

                            <h4>Welcome to A3ultimate Ingame Guide</h4>
                            <div class='divider'></div>
                            
                             <p>Here you can find Guides for A3 Ultimate, Created by players for players. <br> Also, You can Share your own Guide by <a href="/beta/writer">Clicking here</a>. </p>




                        </div>
                    </div>



                </div>
            </div>

            </main>