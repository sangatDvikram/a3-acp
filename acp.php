<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>A3 Ultimate - ACP Home</title>
<?php include 'header-acp.php'; ?>
<div class="container-fluid">
<script>
    $(document).ready(function()
    {
        $('#online').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/chkonline.php?randval='+ Math.random());
        $('#coins').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/coins.php?randval='+ Math.random());

        var refreshId = setInterval(function()
        {
            $('#online').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/chkonline.php?randval='+ Math.random());
            $('#coins').load('http://<?php echo $_SERVER['SERVER_NAME'];?>/Stats/coins.php?randval='+ Math.random());
        }, 30000);


    });
</script>
<script language="javascript">
    function submit(){document.getElementById('theForm').submit();}

</script>
<div class="hero-unit" style="padding-top:10px; padding-bottom:5px">
    <h1>Welcome <?php echo $_SESSION['Player'];?> To A3 Ultimate!!</h1>
    <p style="margin:0;margin-top:10px; padding:0">
        <marquee  onmouseover="this.stop();" onmouseout="this.start();" direction=up loop=true height="100" scrollamount=2 ><?php
            $dsf1 = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$_SESSION[username]'");
            $fgh1 = odbc_fetch_array($dsf1); ?>
            <?php echo $fgh1['msg']; ?> </marquee>
    </p>
    <br />
</div>
<div class="row-fluid ">
    <div class="span3">
        <?php include 'side_bar.php';?>
    </div><!-- Menu -->
    <div class="span9"><!-- Main -->
        <div class="page-header" style="margin-top:0;">
            <h1>Account Control Panel:&nbsp;&nbsp; <small>Home</small></h1></div>
        <h3 style="font-family:Calibri;">Charecter info:</h3>
        <div id='online'></div><!-- Characher Info -->
        <a id="InvtOpt"></a>
        <hr>
        <div class="page-header" style="margin-top:0;">
            <h1>Character Inventory : </h1></div>
        <center>
            <form action='' method='POST' class="form-inline" id="theForm" name="theForm">
                Select Charecter :
                <select name="country" class="char owner" Onchange="submit()">
                    <option selected='selected' >--Select Character--</option>
                    <?php
                    $getchars = odbc_exec($con,"SELECT * FROM charac0 WHERE c_sheadera = '$_SESSION[username]' AND c_status = 'A'");
                    while (odbc_fetch_row($getchars))
                    {
                        $heroes1 = odbc_result($getchars, "c_id");
                        ?>
                        <option  value="<?php echo $heroes1; ?>"><?php echo $heroes1; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </form>

            <?php
             if($_POST['country'])
            {
                 foreach($_POST as $key => $value) {
                            $data[$key] = antisql($value); }
                $char=$data['country'];
             $query1 = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id='$char' and c_sheadera='$_SESSION[username]'"); 
                    $numb=odbc_num_rows($query1);
            
            if($numb>0){
?>
            <table cellpadding="3" cellspacing='3' > 

                
                <tbody>
                <tr>
                    <?php
                    if($_POST['country'])
                    {
                        foreach($_POST as $key => $value) {
                            $data[$key] = antisql($value); }
                        echo "<h1>Wearing Info : </h1>";
                        
                        echo $char." Wearing :";
                        include 'Stats/wear.php';
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
                    } ?>
                </tr>
                </tbody>
            </table>



            <?php
            if($_POST['country'])
            {
                foreach($_POST as $key => $value) {
                    $data[$key] = antisql($value); }

                $char=$data['country'];
                echo "<hr><h1>Inventry Info : </h1>";
                echo $char."'s Inventory :";
                echo "<div id='comments' style='height:260px;overflow:auto' >
	 <table cellpadding='3' cellspacing='3' >
  
  
  <tbody>
    <tr>";

                $query1 = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id='$char' and c_sheadera='$_SESSION[username]'");

                while ($sup = odbc_fetch_array($query1))
                {
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
                }
                echo " </tr>
  </tbody></table>
  </div>";
            } 


        

            ?>


        </center>
       
        <hr>
<?php  } else { echo '    <div class="alert alert-error">
    Make Sure Your Not trying some thing awsom . :) !!
    </div>'; } }?>
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
<?php include('browser.php');
$ua=getBrowser();
$ip=$_SERVER['REMOTE_ADDR'];
?>
<div class="row-fluid" align="center">
    <div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your IP:&nbsp;&nbsp;  <i>  <?php echo getRealIpAddr();?> </i></p></div>
    <div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version'] ;?></i></p></div>
    <div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>&nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

</div><!-- details -->
</div> <!-- /container fluid-->
<?php include 'footer.php';?>