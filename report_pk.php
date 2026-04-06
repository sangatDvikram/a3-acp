<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>A3Ultimate - Reported Pk Confirmation</title>
	
<?php include 'header-acp.php'; 
if($_SESSION['grade'] != "BAN") {
header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }

//include 'tools/report_pk_function.php';
?>

    <div class="container-fluid">
     <div class="page-header" style="margin-top:0;">
 			   <h1>Admin panel -Reported Pk Confirmation :
</h1></div>
          <div class="row-fluid ">
		  
          <div class="span3">
             <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
              <div class="span9"><!-- Main -->
              
	              <button class="btn btn-large btn-primary refresh" type="button"> <i class="icon-refresh"></i> Refresh</button>
             
             <table id="example" class="display " cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>PK Sr. No.</th>
                <th>Details</th>
                <th>Kill Date</th>
                <th>Report Count</th>
                <th>Operation</th>
                
                
            </tr>
        </thead>
 

</table>
	
  <div class="modal hide fade" id="take_action" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
                <h3 id="myModalLabel">Report As Fake ? :</h3>
            </div>
            <div class="modal-body">
            <div class="message">
           
         </div>
  <div class="alert action-message">
  Some Alert Stuffs goes here ....

<div id="reportnumb"></div>
</div>
<div class="modal-footer">

  <center>
    
    <button class="btn btn-danger reportYes" type="button" id='' >Yes</button>        <button class="btn btn-success reportNo"  type="button" data-dismiss="modal">No</button>
  </center>

  
</div>
            </div>
            
        </div>
			
</div><!-- Main -->
</div><!-- Cointainer -->
<hr>
<?php include('browser.php'); 
$ua=getBrowser();
 $ip=$_SERVER['REMOTE_ADDR'];
?>
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
            "url": "/tools/api.generate_report_pk.php",
            
        }
    });

 $('body').on("click", " .refresh",function() {
 
            $('#example').dataTable().fnDestroy();
            var table = $('#example').dataTable( {
        "scrollX": true,
         
        "ajax": {
            "url": "/tools/api.generate_report_pk.php",
            
        }
    });

});
     
     $('body').on("click", " .yes",function() {
  $( "body .action-message" ).html( "Your Performing Yes KIND OF Operation!!");
  $("body .reportYes").attr('id',$(this).attr('id'));
  $("body .reportYes").attr('data-type','Yes');
  
  /*alert($(this).attr('id'));*/

});

      $('body').on("click", " .no",function() {
  $( "body .action-message" ).html( "Your Performing NO KIND OF Operation!!");
  $("body .reportYes").attr('id',$(this).attr('id'));
  $("body .reportYes").attr('data-type','No');
  /*alert($(this).attr('id'));*/

});

      //Final Submission

      $('body').on("click", ".reportYes",function() 
      {
          var id=$(this).attr('id');
          var type=$(this).attr('data-type');
var url="";
          if(type=='Yes')
          {
            url="/beta/index.php/api/pk/report/format/json";
          }
          else 
          {
             url="/beta/index.php/api/pk/reject/format/json";
          }
        url='/tools/api.action_report.php';
        var id=$(this).attr('id');
        var data = 'id='+$(this).attr('id')+'&report=true&type='+type;

         $.post(url,data,function(data)
          {
            $("body .action-message").html(data.message);
            $("body .action-message").delay(1500).fadeOut();
            $('#take_action').delay(3000).modal('hide');

            $('#example').dataTable().fnDestroy();
            var table = $('#example').dataTable( {
        "scrollX": true,
         
        "ajax": {
            "url": "/tools/api.generate_report_pk.php",
            
        }
    });
            

          }
          ,'json');

      });

     // button state demo
$(':input[data-loading-text]').click(function () {
    var btn = $(this)
    btn.button('loading')
    setTimeout(function () {
        btn.button('reset')
    }, 3000)
})
} );</script>
<?php include 'footer.php';?>
