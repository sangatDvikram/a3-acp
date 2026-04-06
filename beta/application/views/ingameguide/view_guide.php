
<main>
    <!--  Main Container  -->

    <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container center">
                <div class="row">
                    <div class="col s12 m12">

                        <h3 class="header  white-text text-lighten-2">Players Guide</h3>
                        <h5 class="header white-text text-lighten-2"> All Information about the ingame help you can get it here</h5>
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

                            <h4><?= $data['guide_title']; ?></h4>
                            <div class="divider"></div>

                            <div class="section">
                                <?php if ($data['verified'] == 0 && $data['username'] == $this->session->userdata('username')) { ?>
                                    <blockquote>
                                        <span class="red-text">

                                            <h5>This Post is not verified yet. No one other than you can view it till its verified.</h5>

                                        </span>

                                    </blockquote>
                                <?php } ?>
                                <?= $data['guide_body']; ?>
                            </div>
                            <blockquote><br>
                                Posted by : <?= $data['playername']; ?><br>
                                Posted on : <?php
                                $date = strtotime($data['date']);
                                echo date('D jS M Y \a\t H:i a', $date);
                                ?><br><br>
                            </blockquote>
                            <?php if ($data['verified'] == 1) { ?>
                                <div class="section">

                                    <div id="disqus_thread"></div>
                                    <script type="text/javascript">
                                        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                        var disqus_shortname = 'a3ultimate'; // required: replace example with your forum shortname

                                        /* * * DON'T EDIT BELOW THIS LINE * * */
                                        (function() {
                                            var dsq = document.createElement('script');
                                            dsq.type = 'text/javascript';
                                            dsq.async = true;
                                            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                        })();
                                    </script>
                                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
                                <?php } ?>

                            </div>    
                        </div>
                    </div>



                </div>
            </div>

            </main>