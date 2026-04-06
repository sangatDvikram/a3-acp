<?php


?>
    <!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="utf-8">
    <title>A3 Ultimate - ACP Refer a Friend!</title>
    <?php include 'header-acp.php';
    $err = array();
    $msg = array();
    $ttt = array();


    if (isset($_POST['ref']))
    {
        foreach ($_POST as $key => $value)
        {
            $data[$key] = antisql($value); // post variables are filtered
        }

        $char = $_POST['character'];
        $mail = $_POST['email'];


        if (!isset($char))
        {
            $err[] = "ERROR : Please Select atlease one character.";
        }
        if (!isEmail($mail))
        {
            $err[] = "ERROR : Invalid email address.";
        }
        $rs_duplicate = odbc_exec($con, "SELECT c_headerb FROM account WHERE c_headerb='$mail'");
        /*if (odbc_fetch_row($rs_duplicate) > 0)
        { $err[] = "ERROR : The email-id already exists. Please try again with different email."; }*/
        $rs_duplicate = odbc_exec($con, "SELECT c_headerb FROM account WHERE c_id='$_SESSION[username]'");
        $em = odbc_fetch_row($rs_duplicate);
        $email = $em['c_headerb'];
        /*if ($email==$mail)
        { $err[] = "ERROR : You cannot refer your own email id."; }*/
        if (empty($err))
        {

            $log = "Hello New Player,<br>Your Friend " . $_SESSION['Player'] . " want you to join A3 Ultimate ,<br>To Register your account please <a href=\"http://$_SERVER[SERVER_NAME]/Register/" . base64_encode($mail) . "/" . trim($char) . "/\"><b>Click Here.</b></a><br>
			If you can't see the link please copy paste the following link into your address bar and press enter.<br>http://$_SERVER[SERVER_NAME]/Register/" . base64_encode($mail) . "/" . trim($char) . "/<br>- Admin Ultimate";
            log_action($mail, "N.A", $log, $con);
            $subject = "A3 Ultimate : $_SESSION[Player] referred you.";
            email_action_single($mail, $subject, $log, $con);

            $user_email = explode("@", $mail);
            $msg[] = "Referance Link has been successfully Sent to " . truncate($user_email[0]) . "@" . $user_email[1] . " and follow the link to register a referal account.";


        }


    }
    ?>
    <div class="container-fluid">


        <div class="row-fluid ">
            <div class="span3">
                <?php include 'side_bar.php'; ?>
            </div><!-- Menu -->
            <div class="span9"><!-- Main -->
                <div class="page-header" style="margin-top:0;">
                    <h1>Account Control Panel:
                        <small>Refer a Friend!</small>
                    </h1>
                </div>
                <div class="alert alert-block"><b>Select Email ID of friend to be reffered.</b></div>
                <?php if (!empty($err))
                {
                    echo "<div class=\"alert alert-error\" align=\"Center\"><h4>";
                    foreach ($err as $e)
                    {
                        echo "$e <br>";
                    }
                    echo "</h4></div>";
                }
                if (!empty($msg))
                {
                    echo "<div class=\"alert alert-success\" align=\"Center\"> <h4>" . $msg[0] . "</h4></div>";

                }
                if (!empty($ttt))
                {
                    echo "<div class=\"alert alert-info\" align=\"Center\"> <h4>" . $ttt[0] . "</h4></div>";

                } ?>
                <form method="POST" action=" ">
                    <div class="control-group" align="center">
                        <div class="input-prepend">
                            <span class="add-on">@</span>
                            <input type="email" id="email" name="email" class="k-textbox" style="color:#000;"
                                   placeholder="e.g. myname@example.net" <?php if (isset($data['email']))
                            {
                                echo 'value="' . $data['email'] . '"';
                            } ?> required data-email-msg="Email format is not valid"/>
                        </div>
                    </div>

                    <?php
                    $query1 = "SELECT charac0.c_id FROM account INNER JOIN charac0 ON account.c_id = charac0.c_sheadera WHERE (charac0.c_sheadera = '$_SESSION[username]') AND (charac0.c_status = 'A') ORDER BY charac0.c_id";
                    $rs1 = odbc_exec($con, $query1);
                    if (odbc_num_rows($rs1) == 0)
                    {
                        echo '<div class="alert alert-error" align="center">No Character was found in the account. Please create a character in game first.</div>';
                    } else
                    {


                        echo '<h4 class="text-center text-info"> - SELECT A CHARACTER - </h4><div class="controls" align="center"> ';

                        while (odbc_fetch_row($rs1))
                        {
                            $heroes1 = odbc_result($rs1, "c_id");
                            ?> <label class="radio inline">
                            <input type="radio" value="<?php echo $heroes1; ?>" name="character"
                                   id="<?php echo $heroes1; ?>"/><?php echo $heroes1; ?></label>
                            <?php
                        }
                        echo '</div><br>';

                        echo ' <div class="form-actions" align="center"><input class="btn btn-primary" align="center" type="submit" value="Submit" name="ref" /></div>';
                    }

                    ?>

                </form>
            </div><!-- Main -->
        </div><!-- Cointainer -->
        <hr>
        <?php include('browser.php');
        $ua = getBrowser();
        $ip = $_SERVER['REMOTE_ADDR'];
        ?>
        <div class="row-fluid" align="center">
            <div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">
                    Your IP:&nbsp;&nbsp; <i>  <?php echo getRealIpAddr(); ?> </i></p></div>
            <div class="span4" style="border-right:1px solid #d9d9d9"><p style="margin:0; padding:0; text-align:center">
                    Your Browser:<i>&nbsp;&nbsp;<?php echo $ua['name'] . " " . $ua['version']; ?></i></p></div>
            <div class="span4"><p style="margin:0; padding:0 ;text-align:center">Visitor Counter : <i>
                        &nbsp;&nbsp;<?php echo $_country; ?></i></p></div>

        </div><!-- details -->
    </div> <!-- /container fluid-->
<?php include 'footer.php'; ?>