<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Board of Heroes Player Information</title>
  
<?php include 'header.php'; 

$player=antisql($_GET['player']);
$char=$player;
  include 'inc/stat_of_char2.php';
  include 'inc/m_body_char.php';
$playerInfo=playerInfo($player);
$stat=$STR+$DEX+$INT+$VITAL+$MANA+$RSTAT;
$pvpquery = odbc_exec($con,"SELECT top 10 * FROM Pkstats WHERE pname = '$player' ");
$shue = explode(";",$PETACT[1]);



$shuelvl = $shue[2];

function shuelvlcalc($shuelvl)
{
    $it = $shuelvl;
    $i1 = fmod($it, 2147483648);
    $j1 = $it - $i1;
    $icedef = $j1 / 2147483648;

    $i2 = fmod($i1, 1073741824);
    $j4 = $i1 - $i2;
    $iceatk = $j4 / 1073741824;

    $i3 = fmod($i2, 536870912);
    $j5 = $i2 - $i3;
    $firedef = $j5 / 536870912;

    $i4 = fmod($i3, 268435456);
    $j6 = $i3 - $i4;
    $fireatk = $j6 / 268435456;

    $i5 = fmod($i4, 4194304);
    $j7 = $i4 - $i5;
    $hp = $j7 / 4194304;

    $i6 = fmod($i5, 256);
    $j8 = $i5 - $i6;
    $exp = $j8 / 256;

    $lvl = $i6;

    return $lvl;
}

$pvp = odbc_fetch_array($pvpquery);


?>
    <div class="container-fluid">
          <div class="row-fluid ">
          <div class="span12"><!-- Main -->
              <div class="page-header" style="margin-top:0;">
         <h1>Board of Heros: - Player Information.</h1></div>

         
         <table>
         <tr>
         <td rowspan="3" align="center"><?php echo "$playerInfo[NationImage]";?></td>&nbsp&nbsp&nbsp
         <td rowspan="3" align="center"><?php echo "<img src='/images/chars$playerInfo[TypeNum].jpg' alt='$playerInfo[Type]' title='$playerInfo[Type]'>";?></td>
         <td><?php echo " <h1> $playerInfo[StyledName]</h1>"; ?></td>
         </tr>
         <tr>
            <td width="600px"><div style="font-family:Ubuntu"><h4><?php 
              echo "<span class='span3' style='text-align:center;border-right:1px solid #d9d9d9;padding:10'>"; 
              if(shuelvlcalc($shuelvl)==0)
                echo "No Shue";
              else
                echo "Shue level:" . shuelvlcalc($shuelvl); 

              echo "</span><span class='span3' style='text-align:center;border-right:1px solid #d9d9d9;padding:10'> RB:$playerInfo[Rb] </span> <span class='span3' style='text-align:center;border-right:1px solid #d9d9d9;padding:10'>Rank: <span style='$playerInfo[Style]'> $playerInfo[Rank]</span></span><span class='span3' style='text-align:center'></span>"; ?> </h4> </div></td>
          </tr> 
          
          <tr>
            <td width="800px"><div style="font-family:Ubuntu"><h4><?php echo "<span class='span3' style='text-align:center;border-right:1px solid #d9d9d9;padding:10'>Kills: $pvp[kills]</span>
            <span class='span3' style='text-align:center;border-right:1px solid #d9d9d9;padding:10'> Deaths: $pvp[deaths]</span><span class='span2' style='text-align:center;border-right:1px solid #d9d9d9;padding:10'>Reputation Points: $pvp[rp]</span><span class='span2' style='text-align:center'>Total Stats: $stat</span>";?></h4></div></td>
          </tr> 
         </table>

<center>
            
            <table cellpadding="3" cellspacing='3' >                 
                <tbody>
                <tr>
                    <?php                


                        echo "<h1>Wearing Info : </h1>";
                        
                        echo $char." Wearing :";
                        include 'Stats/wear.php';
                        include 'Stats/shue.php';
                        shuedatacalc($shue);
                        if($pic['Necklace']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Necklace]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Necklace]\" data-original-title=\"<b>$names[Necklace]</b>\" ></td>";
                            //echo "<br>Slot 1:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                        if($pic['Helmet']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Helmet]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Helmet]\" data-original-title=\"<b>$names[Helmet]</b>\" ></td>";
                            //echo "<br>Slot 2:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                        if($pic['Ring']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Ring]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Ring]\" data-original-title=\"<b>$names[Ring]</b>\" > </td></tr><tr>";
                            //echo "<br>Slot 3:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td></tr><tr>";}
                        if($pic['Weapon']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Weapon]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Weapon]\" data-original-title=\"<b>$names[Weapon]</b>\" ></td>";
                            //echo "<br>Slot 4:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                        if($pic['Armor']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Armor]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Armor]\" data-original-title=\"<b>$names[Armor]</b>\" > </td>";
                            //echo "<br>Slot 5:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                        if($pic['Shield']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Shield]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Shield]\" data-original-title=\"<b>$names[Shield]</b>\" ></td></tr><tr>";
                            //echo "<br>Slot 6:".$wear['Name'];
                        }
                        else {
                            if($pic['Weapon']!=''&& $$pic['Shield']==''){
                                print "<td style='cursor:pointer'><img src='$pic[Weapon]' class='thumbnail drevil' dissabled ></td></tr><tr>";
                            }
                            else{
                                print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td></tr><tr>";}}
                        if($pic['Gloves']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Gloves]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Gloves]\" data-original-title=\"<b>$names[Gloves]</b>\" ></td>";
                            //echo "<br>Slot 7:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                        if($pic['Pant']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Pant]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Pant]\" data-original-title=\"<b>$names[Pant]</b>\" ></td>";
                            //echo "<br>Slot 8:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                        if($pic['Boots']!=''){
                            print "<td style='cursor:pointer'><img src='$pic[Boots]' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content=\"$stat[Boots]\" data-original-title=\"<b>$names[Boots]</b>\" ></td>";
                            //echo "<br>Slot 9:".$wear['Name'];
                        }
                        else { print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' rel='drevil' class='thumbnail'  data-trigger='hover' data-content='' data-original-title='<b>Empty Inventory</b>' > </td>";}
                     ?>
                </tr>
                </tbody>
            </table>
            <?php
         $char=$player;
                echo "<hr><h1>Inventry Info : </h1>";
                echo $char."'s Inventory :";
                echo "<div id='comments' style='height:260px;overflow:auto' >
   <table cellpadding='3' cellspacing='3' >
  
  
  <tbody>
    <tr>";

                    include('inc/m_body_char.php');
                    $sr = explode(";",$INVEN[1]);
                    $result = array();
                    $source = array_values($sr);
                    $count = count($source);
                    for($i = 3; $i < $count; $i +=4) {
                        $result[] = $source[$i]+1;
                    }
                    $array2 = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29" ,"30");
                    $result1 = array_diff($array2,$result);
                    sort($result);
                    $j=0;
                    $new1=1;
                    $pdo=new PDOExamples();
                    $resultnew = $result + $result1;
                    foreach($array2 as $value1) {
                        if (in_array($value1, $result)) {
                            $slot=$value1;
                            $new=$value1;

                            include 'Stats/opt.php'  ;
                            print "<td style='cursor:pointer'><img width='32px' height='64px' src='$img' rel='drevil' class='thumbnail drevil' data-trigger='hover' data-content=\"$message<b>Slot:</b> $value1\" data-original-title=\"<b>$name</b>\" > </td>";
                            $new1++;
                        }
                        if (in_array($value1, $result1)) {
                            print "<td style='cursor:pointer'><img src='/allitems/Blank.jpg' class='thumbnail drevil' rel='drevil'  data-trigger='hover' data-content='<b>Slot:</b> $value1' data-original-title='<b>Empty Inventory</b>' > </td>";
                        }
                        if(($j+1)%6==0){echo "</tr><tr>";}
                        $j++;

                    }
                
                echo " </tr>
  </tbody></table>
  </div>";

            ?>


        </center>
       
       </center>
        <hr>
    </div><!-- Main -->

</div><!-- Cointainer -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="/js/bootstrap-tooltip.js"></script>
<script src="/js/bootstrap-popover.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("body .drevil").popover({
            placement : 'bottom',
            html: 'true',
            trigger: "hover"
        });
    });
</script>
<hr>

         <h1>PvP Log for <?php echo "$player"; ?></h1>
           <table id="example" class="display " cellspacing="0" width="100%">
            <thead>
            <tr>
                  <th>Sr.</th>
                  <th>Killer</th>
                  <th>Killer Details</th>
                  <th>Victim</th>
                  <th>Victim Details</th>
                  <th>Kill Time</th>
                  <?php 
                   if(CheckvalidUser())  {
                    echo '<th>Report</th>';
                  }

                  ?>
                </tr>
              </thead>
             
            </table>

</div><!-- Main -->
</div><!-- Cointainer -->
<hr>
<?php include('browser.php'); 
$ua=getBrowser();
 $ip=$_SERVER['REMOTE_ADDR'];
?>
<div class="modal hide fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h3 id="myModalLabel">Report As Fake ? :</h3>
            </div>
            <div class="modal-body">
            <div class="message">
           
         </div>
              <div class="alert">
  Some Alert Stuffs goes here ....

<div id="reportnumb"></div>
</div>
<div class="modal-footer">

  <center>
    
    <button class="btn btn-danger reportYes" type="button" id=''>Yes</button>        <button class="btn btn-success reportNo"  type="button" data-dismiss="modal">No</button>
  </center>

  
</div>
            </div>
            
        </div>
<div class="row-fluid" align="center" class="form-inline">
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr();?> </i></p></div>
<div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version'] ;?></i></p></div>
<div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

</div><!-- details -->
</div> <!-- /container fluid-->
<script type="text/javascript">var cssLink = "<link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css'>";
     $("head").append(cssLink); </script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">$(document).ready(function() {
   

    var table = $('#example').dataTable( {
        "scrollX": true,
        
        "ajax": {
            "url": "/tools/api.generate_pk.php"+<?php echo'"?&player='.$player.'"';  ?>,
            
        }
    } );
    //below line was commented by pritam because he dosent know shit about it. 
	//table.ajax.reload();
} );</script>
<script type="text/javascript">
  
  $('body').on("click", ".report",function() {
  /*$( "body #reportnumb" ).html( $(this).attr('id') );*/
  $("body .reportYes").attr('id',$(this).attr('id'));
  /*alert($(this).attr('id'));*/

});
   $( "body .reportYes" ).click(function() {
        $(this).attr("disabled", 'disabled');
        var url='/tools/api.report_pk.php';
        var id=$(this).attr('id');
        var data = 'id='+$(this).attr('id')+'&report=true';

        $.post(url,data,function(data){

            if(data.error=='Success')
            { 
              $('body .message').html('    <div class="alert alert-success">'+data.message+'</div>');
              $("body  #"+id+"").removeClass('btn-warning').addClass('btn-inverse disabled');
              $("body  #"+id+" i").removeClass('icon-warning-sign').addClass(' icon-ok icon-white');
              $("body  #"+id+"").attr("title", "Reported");
              $("body  #"+id+" i").attr("title", "Reported");
              $("body  #"+id+"").attr("disabled", 'disabled');
               $("body #"+id+"").removeAttr('data-toggle');
               $("body #"+id+"").removeAttr('href ');

            }
            else
            {
              $('body .message').html('    <div class="alert alert-error">'+data.message+' </div>');
            }
            $("body .message .alert").delay(1500).fadeOut();
            $("body .reportYes").removeAttr( "disabled" );

        },'json');


});

 $( "body .reportNo" ).click(function() {  $("body .reportYes").removeAttr( "disabled" );  });
  
</script>
<?php include 'footer.php';?>
