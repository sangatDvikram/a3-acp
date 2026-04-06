<?php require_once "inc/config.php";
require_once "inc/secondary_functions.php";

ini_set( "display_errors", 0);
$cur=curPageURL();
if(isset($_SESSION['hashurl'])&& $cur=='/'){

	header("Location: $_SESSION[hashurl]");
	unset($_SESSION['hashurl']);
	exit;
}
if(curPageName()!='login.php')
 $_SESSION['redirect_url'] =curPageURL(); 
?>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to A3Ultimate.com. Project A3 Episode 5 Server Ultimate Server for Ultimate Gamers. With some interface changes for refreshing experience in A3  ">
	<meta name="keywords" content="A3 Ultimate,A3 Ultimate MMORPG, A3ultimate,A3, MMORPG,ultiamte">
 
	<meta name="site" content="a3ultimate.com">

    <link rel="icon" type="image/ico" href="/images/favicon.ico">
    <LINK REL="SHORTCUT ICON" HREF="/images/favicon.ico">
	<link href="/css/my_nw.css" type="text/css" rel="stylesheet"/>
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/docs.css" rel="stylesheet">
	<link href="/css/bootstrap-responsive.css" rel="stylesheet">
	<script src="/js/jquery.min.js" ></script>
    
    <style type="text/css">
      body {
     }
	  
      @media (max-width: 980px) {
     
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
	
    </style>
   
						   
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
      <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
          <div class="nav-collapse collapse">
            <ul class="nav">
  <?php echo (curPageName()=='boot.php') ? "<li class=\"active\">": "<li>"  ?> <a href="/Home">Home</a></li>
  
<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Community <b class="caret"></b></a>
<ul class="dropdown-menu" aria-labelledby="dLabel">
			<li><a href="https://www.facebook.com/A3Ultimate">Facebook Page</a></li>
			<li><a href="https://www.facebook.com/groups/a3ultimate/">Facebook Group</a></li>
		</ul></li>
<?php echo (curPageName()=='down.php') ? "<li class=\"active\">": "<li>"  ?> <a href="/Downloads/">Download</a></li>
<?php echo (curPageName()=='beta') ? "<li class=\"active\">": "<li>"  ?> <a href="/Beta/">Guide (Beta)</a></li>
<!--/<?php echo (curPageName()=='rebdetails.php')||(curPageName()=='options.php') ||(curPageName()=='craftinginfo.php')? "<li class=\"active dropdown  \">": "<li class=\" dropdown  \">"  ?> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Guide<b class="caret"></b></a>
<ul class="dropdown-menu" aria-labelledby="dLabel">
			<li><a href="/Guide/RebirthDetails/">Rebirth Details <img src="/images/new.gif"></a></li>
			<li><a href="/Guide/Crafting/">Crafting Details <img src="/images/new.gif"></a></li>
			<li><a href="/Guide/ItemOptions/">Item Options</a></li>
	
</ul>-->
</li>

<?php 
if (!logged_in()) {?>
<li><a href="/Register">Register</a></li><?php }?>
</li>
<?php 
if (logged_in()) {?>
	<?php echo (curPageName()=='index.php')||(curPageName()=='profile.php')||(curPageName()=='lore.php')||(curPageName()=='ueneri.php') ||(curPageName()=='tp.php')||(curPageName()=='rb.php')||(curPageName()=='change.php')||(curPageName()=='mana.php')||(curPageName()=='vital.php')||(curPageName()=='str.php')||(curPageName()=='dex.php')||(curPageName()=='int.php')||(curPageName()=='gold.php')||(curPageName()=='lvl.php')||(curPageName()=='coins.php')||(curPageName()=='gold.php')||(curPageName()=='rbgift.php') ||(curPageName()=='ibox.php') ||(curPageName()=='ilogin.php')||(curPageName()=='sss.php')||(curPageName()=='ehist1.php')||(curPageName()=='eshu.php')||(curPageName()=='reset.php')||(curPageName()=='player_storage.php')||(curPageName()=='onlinepoints.php')  ? "<li class=\"active dropdown  \">": "<li class=\" dropdown  \">"  ?> <a href="#" class="dropdown-toggle" data-toggle="dropdown">ACP  <b class="caret"></b></a>
<ul class="dropdown-menu" >
<li class="nav-header">ACP Options</li>
<li><a href="/ACP/">ACP Home</a></li>			
			<li class="dropdown-submenu"><a tabindex="-1" href="#">Special Options</a>
			<ul class="dropdown-menu">			
			<li><a href="/ACP/OfflineTP/">Offline TP</a></li>		
			<li><a href="/ACP/BuySkills/">Learn All Skills</a></li>			
			<li><a href="/ACP/Storage/">Storage Information</a></li>
			</ul>
			</li>
			<li class="dropdown-submenu"><a tabindex="-1" href="#">Change Stats </a>
			<ul class="dropdown-menu">
			<li><a href="/ACP/All-Stat-Changer/">All Stats Changer</a></li>
			</ul>
			</li>
			<li class="dropdown-submenu"><a tabindex="-1" href="#">Shue </a>
			<ul class="dropdown-menu">
			<li><a href="/ACP/BuySSS/">Buy 150 level SS</a></li>
			</ul>
			</li>
			<li><a href="/ACP/Rebirth/">Take Rebirth</a></li>
			<li class="dropdown-submenu"><a tabindex="-1" href="#">Converter </a>
			<ul class="dropdown-menu">
			<li><a href="/ACP/ConvertOnline/">OP to Online Points Converter</a></li>
			<li><a href="/ACP/ConvertOp/">Online Points to OP Converter</a></li>

			</ul>
			</li><!--
			<li><a href="/ACP/UnstuckAccount/">Account Stuck?</a></li>-->
			
			
			 
			  </ul>
</li>
<?php }else{ ?>
<li><a href="/ACP/">ACP</a></li>
<?php } ?>
<?php if($_SESSION['grade'] == "BAN") { ?>
     <?php echo (curPageName()=='acct.php') ||(curPageName()=='vacct.php')||(curPageName()=='eacct.php')||(curPageName()=='echar.php')||(curPageName()=='vchar.php')||(curPageName()=='char.php')||(curPageName()=='addc.php')||(curPageName()=='iteminfo.php')||(curPageName()=='echker.php')||(curPageName()=='paypal_payments.php')? "<li class=\"active dropdown  \">": "<li class=\" dropdown  \">"  ?> 
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <?php echo  generateReportedPk_Count(); ?> <b class="caret"></b></a>
			
<ul class="dropdown-menu">
<li class="nav-header">Admin Options</li>
		<li><a href="/Admin/ManageAccount/" title="Manage Accounts">Manage Account</a></li>
		<li><a href="/Admin/ManageChar/" title="Manage Characters">Manage Characters</a></li>
		<li><a href="/Admin/ManageItems/" title="Manage Items">Manage Eshop</a></li>
		<li><a href="/Admin/ItemCodeList/" title="Items">Item Code List</a></li>
		<li><a href="/Admin/CopyInv/" title="Copy Inventory">Copy Inventory</a></li>
		<li><a href="/Admin/CopyStat/" title="Copy Stats">Copy Stats</a></li>
		<li><a href="/Admin/SearchItem/" title="Search By Item Code">Search Item Code</a></li>
		<li><a href="/Admin/Givecoins/" title="Add coins to account">Give Coins</a></li>
		<li><a href="/Admin/InventoryAdmin/" title="Check Inventorty Details">Inventory Info</a>
		<li class="dropdown-submenu"><a tabindex="-1" href="#">Auction </a>
			<ul class="dropdown-menu">
			<li><a href="/Admin/Auction/" title="Check Auction Details">Claimed Back History</a></li>
			<li><a href="/Admin/AuctionT/" title="Check Auction Details">Traded History</a></li>
			</ul>
			</li>
        <li><a href="/Admin/Ehistory/" title="Check Eshop Details">Check eShop History</a></li>
        <li><a href="/Admin/PayPal/" title="Check Paypal payment Details">Check Paypal payment Details</a></li>

</ul>
</li>

<?php } ?>

<?php echo (curPageName()=='B-eshop.php')||(curPageName()=='eshop-buy.php') ? "<li class=\"active\">": "<li>"  ?><a href="/beta/Eshop/">E-Shop</a></li>
<?php echo (curPageName()=='bhero.php') ? "<li class=\"active\">": "<li>"  ?><?php $charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE pnline='1'");
			$numb=odbc_num_rows($charquery);
			echo "<a href='/Board_Of_Heroes/' title='The Heroes !!' >Board of Heroes<span class='label label-info'></span>";?></a></li>


<!--<li><a href="/beta/game/webchat/" title="Chat with ingame players">Web Chat</a></li>-->
<li><a href="/beta/Staff/">Staff</a></li>
<li><a href="http://support.a3ultimate.com/">Support</a></li>
     
            </ul>
             <div class="pull-right">
                <ul class="nav pull-right">
                    <?php
           
				if (isset($_SESSION['username'])) {
				echo " <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Welcome, $_SESSION[Player]. <b class='caret'></b></a>
                        <ul class='dropdown-menu'>
                            <li><a href='/ACP/MyProfile/'><i class='icon-user'></i> My Profile</a></li>
                            <li><a href='/ACP/ReferFriend/'><i class=' icon-gift'></i> Reffer Friend </a></li>
                            <li class='divider'></li>
                            <li><a href='/Logout'><i class='icon-off'></i> Logout</a></li>
                        </ul>
                    </li>";
				
				}else{
				echo  '<li><a href="#myModal" class="navbar-link" role="button"  data-toggle="modal">Login</a></li>';
				}?>
            
                </ul>
              </div>

          </div><!--/.nav-collapse-->
        </div>
      </div>
    </div>
	<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h3 id="myModalLabel">Login:</h3>
            </div>
            <div class="modal-body">
    <form class="form-horizontal" method="post" action="/Login">
	<table>
     <tr>
	 <td>
    <label class="control-label" for="inputEmail">Username</label>
    </td><td>
    <input type="text" id="username" name="username" placeholder="Username" required validationMessage="Please enter a Username" />
    </td>
    </tr>
    <tr>
	 <td>
    <label class="control-label" for="inputPassword"  >Password</label>
     </td><td>
    <input type="password" name="password" id="inputPassword" placeholder="Password"  required validationMessage="Please enter a Password" />
    </td>
    </tr>
   <tr>
	 <td></td><td>
    <label class="checkbox" >
     <a href="/ForgotPass/" style="color:#09C">Forgot Password</a>
    </label>
    <button type="submit"  name="doLogin" class="btn btn-primary"  style="margin-left:30%">Login</button>
    </td>
    </tr>
	</table>
    </form>
            </div>
            
        </div>
 
    <div id="Logo" style="margin-bottom:20px">
    <img src="/images/logo.png" width="960" height="235" /></div>
<div id="wrapper">
<div id="Container">
