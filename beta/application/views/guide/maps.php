
<main>
<!--  Main Container  -->
 <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container center">
                <div class="row">
                    <div class="col s12 m12">

                        <h3 class="header  white-text text-lighten-2">Guide</h3>
                        <h5 class="header white-text text-lighten-2"> All Information about the ingame help you can get it here</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax green darken-1"><img src="/images/back-top.jpg" alt="Unsplashed background img 2"></div>
    </div>

<div class="row main-page-container" style="margin-top: -3%;">
    <div class="col  l12 s12">



        <div class="row" >
            <div class="col m12 s12  white z-depth-1">
                <!--  Tabs Panal  -->

                <div class="row hide-on-medium-only  hide-on-small-only " >
                    <div class="col s12 grey lighten-3">
                        <ul class="tabs ">
                            <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/items')?>');">Item</a></li>
                            <li class="tab col s4 grey lighten-3"><a class="active" onclick="window.location.assign('<?php echo site_url('guides/maps')?>');">Maps</a></li>
                            <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/rebirth')?>');">Rebirth</a></li>
                            <li class="tab col s4 grey lighten-3"><a  onclick="window.location.assign('<?php echo site_url('ingameguide') ?>');">Ingame Guide</a></li>
                        </ul>
                    </div>
                </div>

                <div id="head-message" class="section">
                    <h4>Map and Monsters Details</h4>
                </div>
                <div class="divider"></div>

                <div class="row">


                    <!--  left Panal  -->

                    <div class="col s12 m3  ">
                        <div class="section">

                            <ul class="collapsible active" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header"><i class="mdi-action-home" ></i> <a href="<?php echo site_url('guides/maps')?>">Home</a></div>

                                </li>

                                <li class="bold"><div class="collapsible-header active"><i class="mdi-maps-map"></i>Maps</div>

                                    <div class="collapsible-body">

                                        <ul style="margin: 3%">
                                            <?php
                                            foreach($map_menu as $map_item)
                                            {
                                                echo"<li>";
                                                echo "<a  href='".site_url('guides/maps')."?map=$map_item[link]'>".$map_item['map_name']."" ;
                                                echo "(".$map_item['count'].")</a>" ;
                                                echo"</li>";

                                            }
                                            ?>
                                        </ul>

                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <!--  Right Panal  -->

                    <div class="col m9 s12">


                        <div class="section">
                            <b>
                                Search Box
                            </b>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <i class="mdi-action-search prefix"></i>
                                    <input id="icon_prefix" type="text" class="validate monster-search">
                                    <label for="icon_prefix">Search Monster</label>
                                </div>

                            </div>



                            <?php

                            if($info_type=='map')
                            {


                                foreach ($map_info as $data)
                                {

                                    echo '<h4 id="category">'.$data['map_name'].'</h4>
                                    <div class="divider"></div>
                                </div>
                                <div class="result-data">';

                                    foreach ($data['monster'] as $monsters)
                                    {
                                        echo '<div class="col s12 m4" ><a href="'.site_url('guides/maps').'?monster='.$monsters['link'].'">
                                            <div class="card-panel grey lighten-2 black-text" style="cursor:pointer" id="'.$monsters['monster_code'].'" data-href="'.site_url('guides/maps').'?monster='.$monsters['link'].'">
                                                <div class="row valign-wrapper" >
                                                    <div class="col s4">';

                                        echo '<img src="/allitems/monsters/'.$monsters['monster_code'].'.jpg" title="'.$monsters['monster_name'].'" class=" responsive-img"> ';

                                        echo '</div><div class="col s8 " style="min-height:80px;font-size:14px" >';

                                        echo "<span>Name : <b> $monsters[monster_name] </b></span> <br> <span>Map : $data[map_name]<br></span>";

                                        echo "</div>
                                        </div>
                                    </div></a>
                                </div>
                                ";

                                    }
                                    echo "</div>";

                                }

                            }


                            ?>

                            <?php

                            if($info_type=='monster')
                            {

                                foreach ($monster_info as $data)
                                {

                                    echo '<h4 id="category">'.$data['monster_name'].'</h4>
                                    <div class="divider"></div>
                                </div><div class="result-data">';
                                    echo "<div class='section col s12 m12'>
                                    <div class='row valign-wrapper' >
                                    <div class='col s3'>
                                    <img src='/allitems/monsters/$data[monster_code].jpg' title='$data[monster_name]' class='responsive-img monster-image'> <a class='waves-effect waves-light btn animation' data-gif='/allitems/monsters/$data[monster_code].gif' data-jpg='/allitems/monsters/$data[monster_code].jpg'>ANIMATE</a>
                                    </div>
                                    <div class='col s9'>
                                    <span>Name: <b>$data[monster_name]</b> <br>Map: <b>$data[map_name]</b> <br> Info : $data[monster_info]</span>
                                    
                                    </div>
                                    </div>
                                   
                                    <h4 id='items'>Item Drop List</h4>
                                    <div class='divider'></div>
                                    </div>
                                    ";
                                    foreach ($data['items'] as $items)
                                    {
                                        echo '
                                            <a href="'.site_url('guides/items').'?item='.$items['link'].'">
                                       <div class="col s4 m1" >
                                     
                                            ';

                                        echo '<img src="'.$items['image'].'" alt="'.$items['item_name'].'" height="60" width="32" class="tooltipped z-depth-1" data-position="bottom" data-delay="50" data-tooltip="'.$items['item_name'].'" style="min-height:60px"> ';

                                        echo "
                                       
                                        </div>
                                        </a>
                                        ";

                                    }
                                    echo "</div>";
                                }

                            }


                            ?>

                        </div>

                    </div>


                </div>
            </div>



        </div>
    </div>

</main>