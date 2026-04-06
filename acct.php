<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Manage Accounts</title>

    <?php include 'header-acp.php';
    if($_SESSION['grade'] != "BAN") {
        header("Location: http://$_SERVER[SERVER_NAME]/ACP/"); }
    ?>
    <div class="container-fluid">


        <div class="row-fluid ">
            <div class="span3">
                <?php include 'side_bar_admin.php' ?>
            </div><!-- Menu -->
            <div class="span9"><!-- Main -->
                <div class="page-header" style="margin-top:0;">
                    <h1>Admin Control Panel: <small>Select Account</small></h1></div>
                <div class="alert">
                    1. Click on [VIEW] to see Account information.<br>2. Click on [EDIT] to edit Account information.
                </div>
                <h3>Search By id </h3>
                <div class="input-append">
                    <input type="text" name="country" id="autocomplete"/>
                    <input type="submit" name="S1" value="Search" class="btn search_id"  >
                </div>
                <hr>
                <table id="registerd_accounts" class="display " cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>

                        <th>Password</th>
                        <th>Refferd By</th>
                        <th>Creat Date</th>
                        <th>Status</th>
                        <th>Registrarion IP</th>
                        <th>Operations</th>
                    </tr>
                    </thead>


                </table>
                <!-- Main
                -->

            </div><!-- Main -->
        </div><!-- Cointainer -->
        <style type="text/css">
            .dataTables_filter {
                display: none;
            }
        </style>
        <script type="text/javascript">var cssLink = "<link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css'><link rel='stylesheet' type='text/css' href='/beta/assects/css/autocomplete.css'>";
            $("head").append(cssLink); </script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="/beta/assects/js/jquery.autocomplete.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function() {
                $('#autocomplete').autocomplete({
                    serviceUrl: '/beta/api/admin/searchaccount/format/json',
                    minChars:3,
                    onSelect: function (suggestion) {
                        $("#result").html('You selected: ' + suggestion.value + ', ' + suggestion.data);
                    }
                });
                $('#registerd_accounts').dataTable( {
                    "scrollX": true,
                    "searching": false,
                    "ajax":
                    {
                        "url": "/beta/api/admin/registerd_accounts/format/json",
                        "type": "POST"
                    }
                } );
                $('body').on("click", " .search_id",function() {
                    var id=$("#autocomplete").val();
                    //alert(id);
                    $('#registerd_accounts').dataTable().fnDestroy();
                    var table = $('#registerd_accounts').dataTable( {
                        "scrollX": true,
                        "searching": false,
                        "ajax": {
                            "url": "/beta/api/admin/registerd_accounts/char/"+id+"/format/json",
                            "type": "POST",
                            "data": function ( d ) {
                                d.char = id;
                                // d.custom = $('#myInput').val();
                                // etc
                            }
                        }
                    });

                });
            } );
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