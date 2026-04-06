<main>
    <!--  Main Container  -->

    <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container center">
                <div class="row">
                    <div class="col s12 m12">

                        <h3 class="header  white-text text-lighten-2">Eshop</h3>
                        <h5 class="header white-text text-lighten-2"> A place to get all you want if you want it ;)</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax green darken-1"><img src="/images/mag.jpg" alt="Unsplashed background img 2"></div>
    </div>


    <div class="row main-page-container" style="margin-top: -3%;">
        <div class="col  l12 s12">



            <div class="row" >
                <div class="col m12 s12  white z-depth-1">

                    <div id="head-message" class="section">
                        <h4>A3 Ultimate Eshop.</h4>
                    </div>
                    <div class="divider"></div>

                    <div class="row">


                        <!--  left Panal  -->

                        <div class="col s12 m7  ">
                            <div class="section">
                                <h4>Item Information</h4>
                                <div class="divider"></div>


                                <div class="card-panel grey lighten-5 ">
                                    <div class="row valign-wrapper">
                                        <div class="col s2">
                                            <a class=" tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?= $item_info['item_name'] ?>" href="<?php echo site_url('guides/items') . '?item=' . $item_info['link']; ?>"><img src="<?= $item_data['image'] ?>" alt="" class=" responsive-img" style='width:50%'></a> <!-- notice the "circle" class -->
                                        </div>
                                        <div class="col s10">
                                            <h4 class='red-text'><?= $item_data['name'] ?></h4>
                                            <div class="divider"></div>
                                            <span>

                                                Class : <?= $item_data['class'] ?> <br>
                                                Type : <?= $item_data['type'] ?> <br>
                                                Description : <?= $item_data['info'] ?> <br>

                                                <?php
                                                if ($item_data['eshop_coins_price'] > '0' && $item_data['eshop_coins_price'] < '99999') {

                                                    if ($item_data['eshop_coins_price'] == 0)
                                                        $item_data['eshop_coins_price'] = 'FREE';
                                                    if($item_data['Deshop_coins_price'] != $item_data['eshop_coins_price'])
                                                        echo "Coins : <span class='indigo-text'><strike>" . number_format($item_data['Deshop_coins_price']) . "</strike> <b>" . number_format($item_data['eshop_coins_price']) . "</b></span> <br>";
                                                    else
                                                        echo "Coins : <span class='indigo-text'><b>" . number_format($item_data['eshop_coins_price']) . " </b></span> <br>";
                                                }
                                                if ($item_data['premium_coins_price'] > '0' && $item_data['premium_coins_price'] < '99999') {

                                                    if ($item_data['premium_coins_price'] == 0)
                                                        $item_data['premium_coins_price'] = 'FREE';
                                                    if($item_data['Dpremium_coins_price'] != $item_data['premium_coins_price'])
                                                        echo "Premium Coins : <span class='orange-text'> <strike>" . number_format($item_data['Dpremium_coins_price']) . " </strike><b>" . number_format($item_data['premium_coins_price']) . "</b></span> <br>";
                                                    else
                                                        echo "Premium Coins : <span class='orange-text'><b> " . number_format($item_data['premium_coins_price']) . " </b></span> <br>";
                                                }
                                                if ($item_data['gold_coins_price'] > '0' && $item_data['gold_coins_price'] < '9999') {


                                                    echo "Gold Coins : <span class='orange-text'><b> " . number_format($item_data['gold_coins_price']) . " </b></span> <br>";
                                                }
                                                if($item_data['reward_coins_price']==1)
                                                {
                                                    echo "Santa Reward Coins : <span class='red-text'><b> " . number_format($item_data['reward_coins_price']) . " </b></span> <br>";
                                                }
                                                ?>

                                            </span>

                                            <?php if ($item_options['data'] != '') { ?>
                                                <h6 class='orange-text center'>Item Options</h6>
                                                <div class="divider"></div>
                                                <span class="">
                                                    <?= $item_options['data'] ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  Right Panal  -->

                        <div class="col m5 s12" >



                            <div class="section">
                                <h4>Player Information</h4>
                                <div class="divider"></div>
                                <div class="section" id="characterinfo">
                                    <div id='loader' style="height:100%"></div>
                                </div>
                            </div>


                        </div>
                    </div>



                </div>
            </div>

            </main>