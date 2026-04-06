<script>
function init() {
var imgDefer = document.getElementsByTagName('img');
for (var i=0; i<imgDefer.length; i++) {
if(imgDefer[i].getAttribute('data-src')) {
imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
} } }
window.onload = init;
</script>
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
        <div class="parallax green darken-1"><img src="/images/mag.jpg" alt="Unsplashed background img 2"></div>
    </div>


    <div class="row main-page-container" style="margin-top: -3%;">
        <div class="col  l12 s12">



            <div class="row" >
                <div class="col m12 s12  white z-depth-1">
                    <!--  Tabs Panal  -->

                    <div class="row hide-on-medium-only  hide-on-small-only ">
                        <div class="col s12 grey lighten-3">
                            <ul class="tabs ">
                                <li class="tab col s4 grey lighten-3"><a class="active" onclick="window.location.assign('<?php echo site_url('guides/items') ?>');">Item</a></li>
                                <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/maps') ?>');">Maps</a></li>
                                <li class="tab col s4 grey lighten-3"><a onclick="window.location.assign('<?php echo site_url('guides/rebirth') ?>');">Rebirth</a></li>
                                <li class="tab col s4 grey lighten-3"><a  onclick="window.location.assign('<?php echo site_url('ingameguide') ?>');">Ingame Guide</a></li>
                            </ul>
                        </div>
                    </div>

                    <div id="head-message" class="section">
                        <h4>Item Details and Crafting</h4>
                    </div>
                    <div class="divider"></div>

                    <div class="row">


                        <!--  left Panal  -->

                        <div class="col s12 m3  ">
                            <div class="section">
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header"><i class="mdi-action-home" ></i> <a href="<?php echo site_url('guides/items') ?>">Home</a></div>

                                    </li>

                                    <?php
                                    foreach ($crafting_menu as $menu_item) {
                                        echo"<li>";
                                        if (($request_type == 'item' && $item_data[0]['item_type'] == $menu_item['item_type']) || (isset($cat) && $cat == $menu_item['item_type'])) {
                                            echo "<div class='collapsible-header active'><i class='mdi-action-list'></i>$menu_item[item_type]</div>";
                                        } else {
                                            echo "<div class='collapsible-header'><i class='mdi-action-list'></i>$menu_item[item_type]</div>";
                                        }
                                        echo '<div class="collapsible-body">';
                                        echo'<ul style="margin: 3%">';
                                        foreach ($menu_item['class'] as $menu_class) {
                                            echo"<li>";
                                            $url = ($menu_class['item_class'] == $menu_item['item_type']) ? $menu_item['item_type'] : $menu_class['item_class'] . " " . $menu_item['item_type'];
                                            echo " <a href='" . site_url('guides/items') . "?category=" . urlencode($url) . "' style='cursor:pointer'>$menu_class[item_class]  - ($menu_class[count])</a>";
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
                                        <input type="text" name="country" placeholder="Enter item name" id="autocomplete"/>
                                        <!--<input id="icon_prefix" type="text" class="validate item-search">-->
                                        <label for="icon_prefix">Search Item</label>
                                    </div>

                                    <div id="result"></div>
                                </div>
                                <div class="col offser-s1 autocomplete-suggestions">

                                </div>

                                <?php
                                if ($request_type == 'randome') {
                                    $category = (isset($cat)) ? $cat : 'Random Items';
                                    echo '
                                <h4 id="category">' . $category . '</h4>
                                <div class="divider"></div>
                            </div><div class="result-data">';

                                    echo '<div class="row"  >';
                                    $i = 1;
                                    foreach ($item_data as $item) {

                                        echo '<a href="' . site_url('guides/items') . '?item=' . $item['link'] . '"><div class="col s12 l4 m6 black-text"  >
                                            <div class="card-panel grey lighten-2 " style="cursor:pointer" id="' . $item['item_code'] . '" data-href="' . site_url('guides/items') . '?item=' . $item['link'] . '">
                                                <div class="row valign-wrapper" >  
                                                    <div class="col s3">';

                                        echo '<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="  data-src="' . $item['image'] . '" alt="" class=" responsive-img"> ';

                                        echo '</div><div class="col s9 ">';

                                        echo "<span>Name : <b> $item[item_name] </b></span> <br> <span>Type : $item[item_type]<br></span><span>Class : $item[item_class]<br></span>";
                                        if ($this->session->userdata('grade') == 'BAN') {
                                            echo "Code : <b>$item[item_code]</b>";
                                        }
                                        echo "</div>
                                        </div>
                                    </div>
                                </div></a>
                                ";
                                        if ($i % 3 == 0)
                                            echo '</div><div class="row">';
                                        $i++;
                                    }
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>

                                <?php
                                if ($request_type == 'item') {

                                    foreach ($item_data as $item) {
                                        echo '
                                        <h4 id="category">' . $item['item_name'] . '</h4>
                                        <div class="divider"></div>
                                    </div><div class="result-data">';
                                        //Item info
                                        echo "<div class='section col s12 m12'>
                                        <div class='row valign-wrapper' >
                                    <div class='col s3'>
                                    <img src='$item[image]'  class='responsive-img'>
                                    </div>
                                    <div class='col s9'>
                                    <span>Name: <b>$item[item_name]</b> <br>Type: <b>$item[item_type]</b> <br> Class : $item[item_class]<br> Info : $item[item_info]<br></span>";
                                        if ($this->session->userdata('grade') == 'BAN') {
                                            echo "Code : <b>$item[item_code]</b>";
                                        }
                                        echo"
                                    </div>
                                    </div>
                                    </div>";

                                        if (isset($item['options'])) {
                                            ?>


                                            <h4 id='items' style='cursor:pointer;' data-toggle='options-info' data-state='show' class='hidder' >Item Options <i class='mdi-hardware-keyboard-arrow-down arrowoptions right' style='cursor:pointer;margin-bottom:-1%' data-toggle='options-info' data-state='show'></i><span class="right" style="font-size: 16px"> Click here for info</span>
                                            </h4>
                                            <div class='divider'></div>
                                            <div class='section col s12 m12 center' id='options-info' data-item='' data-type='options' style="display:none">

                                                <table class="responsive-table bordered center">
                                                    <thead>
                                                        <tr >
                                                            <th class="center" data-field="id">Name</th>
                                                            <th class="center" data-field="price">Item Level</th>
                                                            <th class="center" data-field="name">Requirements</th>
                                                            <th class="center" data-field="name">Cost</th>

                                                            <th class="center" data-field="price">Range</th>
                                                            <th class="center" data-field="price">Damage/Defense</th>
                                                            <th class="center" data-field="price">Peridot/Sapphire(Blue) Max Option</th>
                                                            <th class="center" data-field="price">Garnet/Ruby(Red) Max Option</th>
                                                            <th class="center" data-field="price">Opal/Topaz(Yellow) Max Option</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>

                                                            <?php
                                                            $total = count($item['options']);
                                                            echo "<td class='center hide-on-med-and-down' rowspan='$total'><b> $item[item_name] </b> </td>";

                                                            foreach ($item['options'] as $options) {
                                                                echo "<td class='center hide-on-large-only'> <b>$item[item_name]</b>  </td>";

                                                                echo "<td class='center'>$options[item_range]</td>";

                                                                echo "<td class='center'>";
                                                                if ($options['item_str'] > 0)
                                                                    echo "Str : $options[item_str]<br>";
                                                                if ($options['item_int'] > 0)
                                                                    echo "Int : $options[item_int]<br>";
                                                                if ($options['item_dex'] > 0)
                                                                    echo "Dex : $options[item_dex]<br>";
                                                                if ($options['item_str'] == 0 && $options['item_int'] == 0 && $options['item_dex'] == 0)
                                                                    echo "-";

                                                                echo"</td>";

                                                                echo "<td class='center'>" . number_format($options['item_price']) . "</td>
                                                
                                                <td class='center'>$options[item_lvl]</td>
                                                <td class='center'>$options[item_min] - $options[item_max]</td>
                                                <td class='center'>$options[item_blue]</td>
                                                <td class='center'>$options[item_red]</td>
                                                <td class='center'>$options[item_yellow]</td>
                                              </tr><tr>";
                                                            }
                                                            ?>
                                                        </tr>



                                                    </tbody>
                                                </table>


                                            </div>




                                            <?php
                                            //$this->view('/guide/items/options',$item['options']);
                                        }

                                        echo "
                                    <br><br><h4 id='items' style='cursor:pointer;' data-toggle='monster-info' data-state='show' class='hidder' >Monster List  <i class='mdi-hardware-keyboard-arrow-down arrowmonster right' style='cursor:pointer;margin-bottom:-1%' data-toggle='monster-info' data-state='show'></i><span class='right' style='font-size: 16px'> Click here for info</span>
                                    ";
                                        echo '

                                          <div class="preloader-wrapper small active loadermonster" style="display: none">
                                          <div class="spinner-layer spinner-blue">
                                            <div class="circle-clipper left">
                                              <div class="circle"></div>
                                            </div><div class="gap-patch">
                                              <div class="circle"></div>
                                            </div><div class="circle-clipper right">
                                              <div class="circle"></div>
                                            </div>
                                          </div>

                                          <div class="spinner-layer spinner-red">
                                            <div class="circle-clipper left">
                                              <div class="circle"></div>
                                            </div><div class="gap-patch">
                                              <div class="circle"></div>
                                            </div><div class="circle-clipper right">
                                              <div class="circle"></div>
                                            </div>
                                          </div>

                                          <div class="spinner-layer spinner-yellow">
                                            <div class="circle-clipper left">
                                              <div class="circle"></div>
                                            </div><div class="gap-patch">
                                              <div class="circle"></div>
                                            </div><div class="circle-clipper right">
                                              <div class="circle"></div>
                                            </div>
                                          </div>

                                          <div class="spinner-layer spinner-green">
                                            <div class="circle-clipper left">
                                              <div class="circle"></div>
                                            </div><div class="gap-patch">
                                              <div class="circle"></div>
                                            </div><div class="circle-clipper right">
                                              <div class="circle"></div>
                                            </div>
                                          </div>
                                        </div>
                                    ';

                                        echo "
                                    </h4>
                                    <div class='divider'></div>
                                    <div class='section col s12 m12' id='monster-info' data-item='$item[item_code]' data-type='monster'>";

                                        echo "</div>";


                                        // Crafting list


                                        echo "<br><br><h4 id='items' style='cursor:pointer;' data-toggle='crafting-info' data-state='show' class='hidder'><br>Crafting info  <i class='mdi-hardware-keyboard-arrow-down arrowcrafting right' style='cursor:pointer;margin-bottom:-1%' ></i><span class='right' style='font-size: 16px'> Click here for info</span>
                                     ";
                                        echo '

                                                    <div class="preloader-wrapper small active loadercrafting" style="display: none">
                                                          <div class="spinner-layer spinner-blue">
                                                            <div class="circle-clipper left">
                                                              <div class="circle"></div>
                                                            </div><div class="gap-patch">
                                                              <div class="circle"></div>
                                                            </div><div class="circle-clipper right">
                                                              <div class="circle"></div>
                                                            </div>
                                                          </div>

                                                          <div class="spinner-layer spinner-red">
                                                            <div class="circle-clipper left">
                                                              <div class="circle"></div>
                                                            </div><div class="gap-patch">
                                                              <div class="circle"></div>
                                                            </div><div class="circle-clipper right">
                                                              <div class="circle"></div>
                                                            </div>
                                                          </div>

                                                          <div class="spinner-layer spinner-yellow">
                                                            <div class="circle-clipper left">
                                                              <div class="circle"></div>
                                                            </div><div class="gap-patch">
                                                              <div class="circle"></div>
                                                            </div><div class="circle-clipper right">
                                                              <div class="circle"></div>
                                                            </div>
                                                          </div>

                                                          <div class="spinner-layer spinner-green">
                                                            <div class="circle-clipper left">
                                                              <div class="circle"></div>
                                                            </div><div class="gap-patch">
                                                              <div class="circle"></div>
                                                            </div><div class="circle-clipper right">
                                                              <div class="circle"></div>
                                                            </div>
                                                          </div>
                                                        </div>
                                    ';

                                        echo "</h4><div class='divider'></div>
                                    
                                    <div class='section col s12 m12' id='crafting-info' data-item='$item[item_code]' data-type='crafting'>";
                                   echo "</div>";
                                   
                                    }
                                }
                                ?>


                               <div class="section ">
                                  
                                <?php
                                if (isset($paging)) {

                                    echo "$paging"; 
                                }
                                ?>
                                       
                            </div>
                            </div>
                            

                        </div>
                    </div>



                </div>
            </div>

            </main>