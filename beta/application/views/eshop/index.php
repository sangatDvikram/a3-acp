<script>
    function init() {
        var imgDefer = document.getElementsByTagName('img');
        for (var i = 0; i < imgDefer.length; i++) {
            if (imgDefer[i].getAttribute('data-src')) {
                imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-src'));
            }
        }
    }
    window.onload = init;
</script>
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

                        <div class="col s12 m3  ">
                            <div class="section">
                                <h5 class="">Buy Premium Coins</h5>
                                <div class="divider"></div>
                                <br>
                                <a class="waves-effect waves-light btn-large orange darken-1 center-align" align="center" href="<?php echo site_url('payment') ?>" title="Add Premium Coins to your account"><i class="material-icons left">credit_card</i>Buy Premium Coins</a>
                            </div>
                            <div class="section">
                                <h5>Menu</h5>
                                <div class="divider"></div>
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header"><i class="mdi-action-home" ></i> <a href="<?php echo site_url('eshop') ?>">Home</a></div>

                                    </li>

                                    <?php
                                    foreach ($eshop_side_menu as $menu_item) {
                                        echo"<li>";

                                        echo "<div class='collapsible-header'><i class='' id='" . str_replace(" ", '', $menu_item['item_type']) . "'></i>$menu_item[item_type]</div>";

                                        echo '<div class="collapsible-body">';
                                        echo'<ul style="margin: 3%">';
                                        foreach ($menu_item['class'] as $menu_class) {
                                            echo"<li>";
                                            $url = $menu_class['item_class'];
                                            echo " <a class='eshop_menu_item' href='?category=" . urlencode($url) . "' id='$url' style='cursor:pointer'>$menu_class[item_class]  - ($menu_class[count])</a>";
                                            echo"</li>";
                                        }
                                        echo'</ul>';
                                        echo'</div>';
                                        echo"</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <!--  Right Panal  -->

                        <div class="col m9 s12" >



                            <div class="section">
                                <b>
                                    Search Box
                                </b>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <i class="mdi-action-search prefix"></i>
                                        <input type="text" name="country" placeholder="Enter item name" id="autocomplete" class="search"/>
                                        <!--<input id="icon_prefix" type="text" class="validate item-search">-->

                                    </div>

                                    <div id="result"></div>
                                </div>
                                <div class="col offser-s1 autocomplete-suggestions">

                                </div>

                                <h4 id="category">Top Eshop Items</h4>
                                <div class="divider"></div>
                                <div id="items-list">


                                </div>
                            </div>


                        </div>
                    </div>



                </div>
            </div>

            </main>