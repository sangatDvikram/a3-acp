<table class="table table-condensed" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:0;font-family:Trebuchet MS;font-weight: normal;">
<tr><th>Name</th><th >Status</th></tr>
<?php $conf = parse_ini_file('C:\Users\Administrator\Desktop\status\config.ini',1);
echo "";
if($conf['Status']['Zone Server']== 'Online'){echo "<tr><td>Monster/Maps  Server </td><td>:<span style=' padding:0;text-align:center;' class='text-success'><img src='/images/status.png' title='online'>Online </span></td></tr>";}else{echo "<tr><td>Monster/Maps Server </td><td>:<span class='text-error' style=' padding:0;text-align:center;'><img src='/images/status-offline-red.png' title='offline'>Offline</span></td></tr>";}

if($conf['Status']['Main Server']== 'Online'){echo "<tr><td>Shout Server </td><td>:<span style=' padding:0;text-align:center;' class='text-success'><img src='/images/status.png' title='online'>Online </span></td></tr>";}else{echo "<tr><td>Shout Server </td><td>:<span class='text-error' style=' padding:0;text-align:center;'><img src='/images/status-offline-red.png' title='offline'>Offline</span></td></tr><tr>";}

if($conf['Status']['Account Server']== 'Online'){echo "<tr><td>Account Server </td><td>:<span style=' padding:0;text-align:center;' class='text-success'><img src='/images/status.png' title='online'>Online </span></td></tr>";}else{echo "<tr><td>Account Server </td><td>:<span class='text-error' style=' padding:0;text-align:center;'><img src='/images/status-offline-red.png' title='offline'>Offline</span></td></tr>";}

if($conf['Status']['Login Server']== 'Online'){echo "<tr><td>Login Server </td><td>:<span style=' padding:0;text-align:center;' class='text-success'><img src='/images/status.png' title='online'>Online </span></td></tr>";}else{echo "<tr><td>Login Server </td><td>:<span class='text-error' style=' padding:0;text-align:center;'><img src='/images/status-offline-red.png' title='offline'>Offline</span></td></tr>";}
echo "";
 ?></table>