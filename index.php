<!DOCTYPE html>
<html lang="en">
    <head><meta charset="utf-8">
        <title>Welcome to A3 Ultimate .</title>

        <?php include 'header.php'; ?>
        <script>

            
            var refreshId = setInterval(function()
            {
                $('#hero').load('/Stats/hero.php?randval=' + Math.random());
                $('#server').load('/Stats/server.php?randval=' + Math.random());
                $('#ping').load('/macchk.php?randval=' + Math.random());
                $('#status').load('/ini.php?randval=' + Math.random());
                document.getElementById('changelogframe').contentWindow.location.reload();
            }, 10000);
        </script>
        <script type="text/javascript" async src="/js/css-pop.js"></script>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="page-header" style="margin-top:0;">


                    <h1 ><span style="text-shadow: 1px 1px 3px #424242;">Welcome To A3 UltimatE.</span>

                    </h1>
                </div>
                <div id="myCarousel" class="carousel " >
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>

                    </ol>

                    <div class="carousel-inner">

                        <div class="item active">
                            <img src="/images/ma.JPG" width="100%" alt="">
                            <div class="carousel-caption">
                                <h4>MAGE</h4>
                                <p>
                                    Her class is Long-range attack using the 3 basic elements of nature: Fire, Ice and Lightning as the Source of her Magic Strength. HP & MP automatically rise at Level-up. Unique skill effects never been seen in a MMORPG are to come.
                                </p>
                            </div>
                        </div>
                        <div class="item ">
                            <img src="/images/arc.JPG" width="100%" alt="">
                            <div class="carousel-caption">
                                <h4>Archer</h4>
                                <p>
                                    Her class is Long-range attack using a bow and arrows with 3 basic elements of nature Fire, Ice and Lightning as the source of her magic strength. She is perfectly balanced between strength and dexterity. HP & MP automatically rise at Level-Up.
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="/images/hk.JPG" width="100%" alt="">
                            <div class="carousel-caption">
                                <h4>Holy Knight</h4>
                                <p>
                                    His sword divides the wind. Using both combat and magic skills, the Knight offers most diverse game play among play characters. He is the most essential character in party play such as Clan Warfare, Nation warfare and Raid.
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <img src="/images/war.JPG" width="100%"  alt="">
                            <div class="carousel-caption">
                                <h4>Warrior</h4>
                                <p>
                                    As master of close encounter Combat, Warriros use two hand Swords, Spears and Axes as their main weapons. They can'y equip shields for protection. HP & MP status automatically rise at Level Up.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel nav -->
                    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                    <a class="carousel-control right" id="thisclick" href="#myCarousel" data-slide="next">&rsaquo;</a>
                </div>
                <h3>A3Ultimate Episode 5 Server!!</h3>
                <p style="font-weight:normal;padding:0"><b> <font size="5">Welcome to A3 Ultimate. :</font></b><big><big> The place to unleash the Ultimate Gamer in You. </big></big><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A3 (Art, Alive, Attraction) is an Online MMORPG where you can create character, Level Up, Perform Quests, Make Knighthoods/Alliances. A3 Ultimate serving players since Nov' 2011, by providing a great platform to perform the Tasks ingame.</p><br>
                <hr>
                <div class="row-fluid" style=" margin:0 auto; width:100%" >
                    <div class="span12" style="font-family:Calibri;" >
                        
                        <h2>Ingame Shout Chat</h2>
                        <iframe src="/beta/game/homepageshout" style="border:2px solid blue;width:100%" height="250px"></iframe><br><br>
                        
                        <h2>Changelogs  <small>For detailed view:<a href="/changelog.php">Click here</a></h2>
                        <iframe id='changelogframe' src="/changelogbox.php" style="border:2px solid blue;width:100%" height="250px"></iframe><br><br>
                        
                    </div>



                    <br>
                    <hr>

                </div>

            </div>
        </div>

        <div class="row-fluid">

            <div class="span3">

                <div class="well" style=" padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Server Ping</li>
                        <li class="alert">Ping : <span id="ping"><?php
                                require('macchk.php');
                                ?></span></li>
                        <li class="nav-header">Server Status</li>
                        <li id="status"><?php
                            require('ini.php');
                            ?></li><!--
                        <li class="nav-header">Player Online</li>
                        <li id="server"><?php
                            require('Stats/server.php');
                            ?></li>
                        <li class="divider"></li>-->

                        <li class="nav-header">Top 15 Player</li>
                        <li id="hero"style='zoom:-1'><?php
                            require('Stats/hero.php');
                            ?></li>
                    </ul>
                </div>
            </div>
            <div class="span9" style="font-family:Calibri;">

                <div class="row" style=" margin:0 auto; width:100%" >
                    <a href="/Downloads/"><div class="quickLinks downloads"></div></a>
                    <a href="/ACP/"><div class="quickLinks acp"></div></a>
                    <a href="/beta/Eshop/"><div class="quickLinks eshop"></div></a>
                    <a href="/Challenge/View/"><div class="quickLinks Gall"></div></a>
                </div>

                <hr>
                <div id="blanket" onclick="replcUrl()" style="display:none;cursor:pointer"></div>
                <div id="popUpDiv" style="display:none;">
                    <div class='leftpanel' >
                        <div class="directions prv" id="345" >&#x2039;</div>
                        <div class="directions next nxt" id="123" >&#x203a;</div>
                        <div class="popimg" style="width:auto"> </div>
                        <span class="num" style="width:100%"> </span>
                    </div>
                    <div class='rightpanel'>
                        <button type="button" class="close" onclick="replcUrl()" aria-hidden="true">
                            x
                        </button>
                        <div class='details' id='comments' style='height:88%; overflow:auto;margin-left:5px;width:95%;padding:5px'>


                        </div>
                        <a class="btn btn-block btn-primary comment" id= "norediusbutton" href="#" target="_blank" style="bottom:0;position:absolute;">Add Comment</a>


                    </div>
                </div>

                <div class="row" style=" margin:0 auto; width:100%" >
                    <div class="span5" style="margin-right:6%" >
                        <!--<h2  align="center">Gallery</h2>
                        <hr>

                        <span id="gal"><?php
                            $query1 = "SELECT top 9 * FROM gallery_info where verify=1 order by sr_no desc  ";
                            $rs1 = odbc_exec($con2, $query1);
                            while ($dd = odbc_fetch_array($rs1)) {
                                echo "<a class='pop' href='#' id='$dd[unq_id]'>
                  <img src=' $dd[thumb]' title='$dd[descr]' class='img-polaroid'  >
                  </a>";
                            }
                            ?></span>-->
                    </div>
                    <div class="span5"  align="center">
                        <h2 align="center">Stay Connected (FB)</h2>
                        <hr>
                        <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FA3Ultimate&amp;width=300&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:300px;width:300px" allowTransparency="true"></iframe>
                    </div>
                </div>

            </div>

        </div>

        <hr>
<?php
include('browser.php');
$ua = getBrowser();
$ip = $_SERVER['REMOTE_ADDR'];
?>
        <div class="row-fluid" align="center">
            <div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr(); ?> </i></p></div>
            <div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version']; ?></i></p></div>
            <div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

        </div>
    </div> <!-- /container -->

<?php include 'footer.php'; ?>