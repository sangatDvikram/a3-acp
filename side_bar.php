<div class="well" style=" padding: 8px 0;">
<ul class="nav nav-list">
<li class="nav-header">ACP Options</li>
            <?php echo (curPageName()=='index.php') ? "<li class=\"active\">": "<li>"  ?>  <a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/">ACP Home</a></li>
            <?php echo (curPageName()=='profile.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/MyProfile/">My Profile</a></li>
            <?php echo (curPageName()=='player_storage.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/Storage/">Storage Information</a></li>			
			<?php echo (curPageName()=='refer.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/ReferFriend/">Refer Friend</a></li>
			<li class="nav-header">Special Options</li>
				        <li class="divider"></li>						
			
			
			<?php echo (curPageName()=='tp.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/OfflineTP/">Offline TP</a></li>
			
			
			<?php echo (curPageName()=='skills.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/BuySkills/">Learn All Skills</a></li>			
			
         
			<li class="nav-header">Change Stats</li>
				        <li class="divider"></li>
			<?php echo (curPageName()=='statchanger.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/All-Stat-Changer/">All Stats Changer</a></li>
			
  <li class="nav-header">Shue</li>
				        <li class="divider"></li>
						
						<?php echo (curPageName()=='sss.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/BuySSS/">Buy 150 level SS</a></li>
  <li class="nav-header">Rebirth</li>
				        <li class="divider"></li>
						<?php echo (curPageName()=='rb.php') ? "<li class=\"active\">": "<li>"  ?><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/ACP/Rebirth/">Take Rebirth</a></li>		
			
              </ul>
            </div> <!-- /well -->