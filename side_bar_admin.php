<div class="well" style=" padding: 8px 0;">
<ul class="nav nav-list">
<li class="nav-header">Admin Options</li>
		<?php echo (curPageName()=='acct.php')||(curPageName()=='vacct.php')||(curPageName()=='eacct.php') ? "<li class=\"active\">": "<li>"  ?><a href="/Admin/ManageAccount/" title="Manage Accounts">Manage Account</a></li>
		<?php echo (curPageName()=='echar.php')||(curPageName()=='vchar.php')||(curPageName()=='char.php') ? "<li class=\"active\">": "<li>"  ?><a href="/Admin/ManageChar/" title="Manage Characters">Manage Characters</a></li>
		<?php echo (curPageName()=='manageitem.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/Admin/ManageItems/" title="Manage Items">Manage Eshop</a></li>		
       <?php echo (curPageName()=='additems.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/Admin/AddItems/" title="Add Items">Add Items to eShop</a></li>
        
       <?php echo (curPageName()=='copyinv.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/Admin/CopyInv/" title="Copy Inventory">Copy Inventory</a></li>
		<?php echo (curPageName()=='addc.php') ? "<li class=\"active\">": "<li>"  ?><a href="/Admin/Givecoins/" title="Add coins to account">Give Coins</a></li>
        <li><a href="/Admin/Auction/" title="Check Eshop Details">Check eShop History</a></li>
       <?php echo (curPageName()=='auction_log.php') ? "<li class=\"active\">": "<li>"  ?><a href="/Admin/PayPal/" title="Check Paypal payment Details">Check Auction Histoty</a></li>
       <?php echo (curPageName()=='paypal_payments.php') ? "<li class=\"active\">": "<li>"  ?><a href="/Admin/PayPal/" title="Check Paypal payment Details">Check Paypal payment Details</a></li>
       <?php echo (curPageName()=='report_pk.php') ? "<li class=\"active\">": "<li>"  ?><a href="/Admin/ReportPK/" title="Reported Pk Confirmation">Reported Pk Log <?php echo  generateReportedPk_Count(); ?></a></li>
                </ul>
            </div> <!-- /well -->