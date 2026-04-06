

<main>
    <!--  Main Container  -->

    <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container center">
                <div class="row">
                    <div class="col s12 m12">

                        <h3 class="header  white-text text-lighten-2">Players New Writing Theme</h3>
                        <h5 class="header white-text text-lighten-2"> Player will make their guides here.</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax green darken-1"><img src="/images/A3.jpg" alt="Unsplashed background img 2"></div>
    </div>


    <div class="row main-page-container" style="margin-top: -3%;">
        <div class="col  l12 s12">



            <div class="row" >
                <div class="col m12 s12  white z-depth-1">
                    <!--  Tabs Panel  -->


                    <div id="head-message" class="section">
                        <h4>Guide Writing</h4>
                    </div>
                    <div class="divider"></div>

                    <div class="row">


                        <!--  left Panel  -->

                        <div class="col s12 m3  ">
                            <div class="section">
                                <p>Welcome - <?php echo $username; ?> <a href="<?php echo site_url('login/logout') ?>">Logout</a></p>
                                <b class="">Options</b>
                                <div class="divider"></div>
                                <ul>
                                    <li><a class="" href="<?php echo site_url('test/writter') ?>">Create New </a></li>
                                    <li><a class="" href="<?php echo site_url('test/writter') ?>">Edit Your Guide </a></li>
                                    <li><a class="" href="<?php echo site_url('test/writter') ?>">View Guide Status </a></li>

                                </ul>
                            </div>
                        </div>

                        <!--  Right Panel  -->

                        <div class="col m9 s12" >
                            <h3>Create Guide</h3>

                            <div class="divider"></div>
                            <?php
                            if (isset($return)) {
                                echo '<pre>';
                                print_r($return);
                                echo '</pre>';
                            }
                            //Errors Will go Here
                            echo validation_errors();

                           

                            if (isset($max_count_reached)) {
                                echo 'Maxing Guide Posting Count Reached!!';
                            } else {
                                 echo "You have " . $guide_count . " more guides remaining for today<br>";
                                require 'form/form.php';
                            }
                            ?>



                        </div>
                    </div>



                </div>
            </div>

            </main>
