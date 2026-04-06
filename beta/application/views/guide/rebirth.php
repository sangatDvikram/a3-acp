 
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
        <div class="parallax green darken-1"><img src="/images/castle.jpg" alt="Unsplashed background img 2"></div>
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
                                <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/maps')?>');">Maps</a></li>
                                <li class="tab col s4 grey lighten-3"><a class="active" onclick="window.location.assign('<?php echo site_url('guides/rebirth')?>');">Rebirth</a></li>
                                <li class="tab col s4 grey lighten-3"><a  onclick="window.location.assign('<?php echo site_url('ingameguide') ?>');">Ingame Guide</a></li>
                            </ul>
                        </div>
                    </div>

                    <div id="head-message" class="section">
                        <h4>Rebirth Information</h4>
                    </div>
                    <div class="divider"></div>

                    <div class="row">


                        <!--  left Panal  -->

                        <div class="col s12 m3  ">
                            <div class="section">

                                <ul class="collapsible active" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header"><i class="mdi-action-home" ></i> <a href="<?php echo site_url('guides/rebirth')?>">Home</a></div>

                                    </li>

                                    <li class="bold"><div class="collapsible-header active"><i class="mdi-action-wallet-giftcard"></i>Rebirths</div>

                                        <div class="collapsible-body">

                                            <ul style="margin: 3%">
                                                <?php
                                                foreach($rebirth_menu as $rebirth_item)
                                                {
                                                    echo"<li>";
                                                    echo "<a  href='".site_url('guides/rebirth')."?rebirth=$rebirth_item[rb_link]'>".$rebirth_item['rb_name']."" ;
                                                    echo "</a>" ;
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
                          <?php
                          if(isset($rebirth_info))
                          {
                            if($page_type=='Randome')
                            {    
                            echo "<h4>Rebirth info :</h4>";
                            echo '<div class="divider"></div>';

                            foreach ($rebirth_info as $rebirth) {
                               echo '<a href="'.site_url('guides/rebirth').'?rebirth='.$rebirth['rb_link'].'"><div class="col s12 l4 m6 black-text"  >
                                            <div class="card-panel grey lighten-2 " style="cursor:pointer" id="'.$rebirth['Rb'].'" data-href="'.site_url('guides/rebirth').'?rebirth='.$rebirth['rb_link'].'">';

                                    echo "<span>Name : <b> $rebirth[rb_name] </b></span> <br> <span>Level Req : $rebirth[Level_req]<br></span><span>Wz : ".number_format($rebirth['Wz_req'])."<br></span>";

                                    echo "
                                    </div>
                                </div></a>
                                ";
                                }
                            } 
                            else
                            {

                                foreach ($rebirth_info as $rebirth) 
                                {
                                    echo "<h4>$rebirth[rb_name] :</h4>";
                                    echo '<div class="divider"></div>';
                                    //RB Information Section  
                                    echo '<div class="section">';

                                    $wz=$rebirth['Wz_req']." Wz";
                                    if($rebirth['Wz_req']>999999){
                                    $wz=($rebirth['Wz_req']/1000000)." Mil";
                                    }
                                    if ($rebirth['Wz_req']>999999999) {
                                        $wz=($rebirth['Wz_req']/1000000000)." Bil";
                                    }
                                    echo "<span>
                                     Level Required : $rebirth[Level_req] <br>
                                     Wz Required : ".number_format($rebirth['Wz_req'])." ( $wz )<br>
                                     Coins Required : $rebirth[Coin_req] <br>
                                     Gold Coins Required : $rebirth[Gold_req] <br>
                                     Online Points Required : $rebirth[OP_req] <br>


                                    </span>";
                                    //Item Required Info
                                    if(isset($rebirth['items']))
                                    {
                                    echo '<div class="row valign-wrapper">
            
                                            <div class="col s2">
                                              <span class="">
                                                Item Required : 
                                              </span>
                                            </div>
                                            <div class="col s10">';
                                            foreach ($rebirth['items'] as  $item) {
                                               echo '<a href="'.site_url('guides/items').'?item='.$item['link'].'"> <img src="'.$item['image'].'" alt="" class=" responsive-img tooltipped left" data-href="" data-position="bottom" data-delay="50" data-tooltip="'.$item['item_name'].'" style="min-height:60px"></a> ';
                                            }
                                             
                                            echo '</div>
                                            </div>';
                                            echo '<div class="row valign-wrapper">
            
                                            <div class="col s2">
                                              <span class="">
                                                Item Information : 
                                              </span>
                                            </div>
                                            <div class="col s10">';
                                            echo "$rebirth[Item_info]";
                                             
                                            echo '</div>
                                            </div>';

                                              echo '<div class="row valign-wrapper">
            
                                            <div class="col s2">
                                              <span class="">
                                                Quest Information : 
                                              </span>
                                            </div>
                                            <div class="col s10">';
                                            echo "$rebirth[Quest_info]";
                                             
                                            echo '</div>
                                            </div>';
                                            

                                            }
                                     //Result Required Info
                                    if(isset($rebirth['reward']))
                                    {
                                    echo '<div class="row valign-wrapper">
            
                                            <div class="col s2">
                                              <span class="">
                                                Rebirth Reward :
                                              </span>
                                            </div>
                                            <div class="col s10">
                                              <a href="'.site_url('guides/items').'?item='.$rebirth['reward']['link'].'"><img src="'.$rebirth['reward']['image'].'" alt="" class=" responsive-img tooltipped left" data-position="bottom" data-delay="50" data-tooltip="'.$rebirth['reward']['item_name'].'" style="min-height:60px"> </a>
                                            </div>
                                            </div>
                                            ';
                                                   
                                    }

                                    echo "</div>";
                                }

                            }





                           


                            
                          }
                          ?>
                        </div>


                    </div>
                </div>



            </div>
        </div>

</main>