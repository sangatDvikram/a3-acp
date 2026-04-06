<?php
require_once "inc/config.php";
require_once "inc/secondary_functions.php";
if (logged_in())
{
    header("Location: http://$_SERVER[SERVER_NAME]/ACP/");
}

ini_set("display_errors", 0);
//page_protect();

$err = array();
$msg = array();


if (isset($_POST['register']))
{
    foreach ($_POST as $key => $value)
    {
        $data[$key] = antisql($value);
    }


        $data['username'] = trim($data['username']);
        $data['password'] = trim($data['password']);


        if (empty($data['fullname']) || strlen($data['fullname']) < 4 || !preg_match("/[A-Za-z\s]/", $data['fullname']))
        {
            $err[] = "ERROR : Invalid name. Please enter atleast 3 or more characters for your name";
        }

        if (empty($data['username']) || strlen($data['username']) < 6 || strlen($data['username']) > 9)
        {
            $err[] = "ERROR : Make sure the username is having characters between 6-9.";
        }
        if (!preg_match("/[A-Za-z0-9]/", $data['username']))
        {
            $err[] = "ERROR : Make sure the username is Alphanumeric only do not add any Special characters .";
        }
        if (empty($data['password']) || strlen($data['password']) > 9 || strlen($data['password']) < 6)
        {
            $err[] = "ERROR : Make sure the password is having characters between 6-9 only.";
        }

        if (!isEmail($data['email']))
        {
            $err[] = "ERROR : Invalid email address.";
        }

        if (!checkPwd($data['password'], $data['rpassword']))
        {
            $err[] = "ERROR : Invalid Password or mismatch. Enter 6 chars or more";
        }

        $user_ip = $_SERVER['REMOTE_ADDR'];

        $host = $_SERVER['HTTP_HOST'];

        $host_upper = strtoupper($host);

        $actcode = md5(GenKey());

        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        $usr_email = $data['email'];

        $username = $data['username'];

        $rs_duplicate = odbc_exec($con, "SELECT c_id FROM account WHERE c_id='$username'");
        if (odbc_fetch_row($rs_duplicate) > 0)
        {
            $err[] = "ERROR : The username already exists. Please try again with different username and email.";
        }

        if (empty($err))
        {
            $hashed_trnxpass = password_hash($data['trnxpass'], PASSWORD_BCRYPT);
            $hashed_answer   = password_hash($data['answer'],   PASSWORD_BCRYPT);
            $sql_insert1 = odbc_exec($con, "INSERT INTO AccountInfo(account,word,contact,name,trnxpass,question,answer) VALUES('$username','$data[referrer]','$data[tel]','$data[fullname]','$hashed_trnxpass','$data[question]','$hashed_answer')");
            $sql_insert2 = "INSERT INTO account (c_id, regip, msg, actcode, verified, pcoins, c_sheadera, c_sheaderb, c_sheaderc, c_headera, c_headerb, c_headerc, d_cdate, d_udate, c_status, m_body, acc_status, salary, last_salary, gold) VALUES ('$username', '$_SERVER[REMOTE_ADDR]', 'Welcome to A3Ultimate. The support Admin will use this section to send important personalised messages to a player. Thanks for Joining us. Hope you will enjoy!', '$actcode', '0', '0.00', 'reserve', 'reserve', 'reserve', '$data[password]', '$usr_email', 'reserve', CONVERT(DATETIME, '$date', 102), CONVERT(DATETIME, '$date', 102), 'A', 'reserve', 'Normal', CONVERT(DATETIME, '$date', 102), CONVERT(DATETIME, '$date', 102), '0.00')";
            $query1 = odbc_exec($con, $sql_insert2);
            if (!$query1)
            {
                $err[] = "ERROR : There was an error registering your account. Please try again later.";
            } else
            {
                $log = "Hello " . $data['fullname'] . ",<br><br>Your Account has been registered.<br>
             Please keep this email safe for future reference<br><br><br>
             <br>Username - $username
             <br>Secret Question - $data[question]
             <br>Secret Answer - $data[answer]
             <br>Your Full Name - $data[fullname]
             <br>You were reffered by - $data[referrer]
             <br><a href='http://$_SERVER[SERVER_NAME]/verifyemail.php?acc=$username&code=$actcode'>Click here</a> to activate your account.
             <br>If you face problem in accessing above link, copy paste this URL into your browser: <br>http://$_SERVER[SERVER_NAME]/verifyemail.php?acc=$username&code=$actcode
             <br><br>
             For any queries, you can contact us on ".getenv('SUPPORT_PHONE')." or raise a support ticket by visiting http://support.a3ultimate.com
             <br>- Admin Ultimate";
                log_action($username, "N.A", $log, $con);
                $subject = "Welcome to A3 Ultimate.";
                email_action($username, $subject, $log, $con);
                $mailparts = explode("@", $usr_email);

                $output = truncate($mailparts[0]);
                $output .= "@" . $mailparts[1];
                $msg[] = "Account Successfully Registered. Please note that your email ID is $output and it will be required to verify your account in future.<br>If you don't have access to the email account, re-register with a valid email address.";
            }
        }
}

?>


    <!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="utf-8">
    <title>A3 Ultimate - Register a new account.</title>
    <?php include 'header.php' ?>
    <div class="container-fluid">
        <div class="page-header">
            <h1>Register New Account:</h1>
        </div>
        <?php
        if (!empty($err))
        {
            echo "<div class=\"alert alert-error\" align=\"Center\">";
            foreach ($err as $e)
            {
                echo "$e <br>";
            }
            echo "</div>";
        }
        if (!empty($msg))
        {
            echo "<div class=\"alert alert-success\" align=\"Center\"><h4>" . $msg[0] . "</h4></div>";

        }

        ?>
        <div id="row">

            <form class="form-horizontal" action=" " method="POST">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Username</label>
                    <div class="controls">
                        <input type="text" id="username" name="username" class="k-textbox" style="color:#000;"
                               placeholder="Username" <?php if (isset($data['username']))
                        {
                            echo 'value="' . $data['username'] . '"';
                        } ?> required validationMessage="Please enter a Username"/><span class="help-inline">Use Only Alphanumeric characters. Special characters are not allowed.</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputPassword">Password</label>
                    <div class="controls">
                        <input id="password" name="password" type="password" class="k-textbox" style="color:#000;"
                               placeholder="Password" required validationMessage="Please enter a Password"/>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Confirm Password</label>
                    <div class="controls">
                        <input id="rpassword" name="rpassword" type="password" class="k-textbox" style="color:#000;"
                               placeholder="Repeat Password" required validationMessage="Please Repeat Password"/>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Transaction Password</label>
                    <div class="controls">
                        <input id="trnxpass" name="trnxpass" type="password" class="k-textbox" style="color:#000;"
                               placeholder="Transaction Password Password" required validationMessage="input Transaction Password"/>


                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputQuestion">Secret Question</label>
                    <div class="controls">
                        <input type="text" id="question" name="question" class="k-textbox" style="color:#000;"
                               placeholder="Input Secret Question" <?php if (isset($data['question']))
                        {
                            echo 'value="' . $data['question'] . '"';
                        } ?> required validationMessage="Please enter a Question"/><span class="help-inline">Use Only Alphanumeric characters. Special characters are not allowed.</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputAnswer">Secret Answer</label>
                    <div class="controls">
                        <input type="text" id="answer" name="answer" class="k-textbox" style="color:#000;"
                               placeholder="Input Secret Answer" <?php if (isset($data['answer']))
                        {
                            echo 'value="' . $data['answer'] . '"';
                        } ?> required validationMessage="Please enter an Answer"/><span class="help-inline">Use Only Alphanumeric characters. Special characters are not allowed.</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="inputEmail">Your Full Name</label>
                    <div class="controls">
                        <input type="text" id="fullname" name="fullname" class="k-textbox" style="color:#000;"
                               placeholder="Full name" <?php if (isset($data['fullname']))
                        {
                            echo 'value="' . $data['fullname'] . '"';
                        } ?> required validationMessage="Please enter Full Name"/>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls"><?php if (isset($_GET['mail']))
                        { ?>
                            <input type="email" readonly="readonly" id="email" name="email" class="k-textbox"
                                   style="color:#000;"
                                   placeholder="e.g. myname@example.net" <?php echo 'value="' . base64_decode($_GET['mail']) . '"'; ?>
                                   required data-email-msg="Email format is not valid" /><?php } else
                        { ?><input type="email" id="email" name="email" class="k-textbox" style="color:#000;"
                                   placeholder="e.g. myname@example.net" <?php if (isset($data['email']))
                        {
                            echo 'value="' . $data['email'] . '"';
                        } ?> required data-email-msg="Email format is not valid" /><?php } ?><span class="help-inline">Email can't be changed once registered.. (Please input carefully.)</span>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Phone Number</label>
                    <div class="controls">
                        <input type="tel" id="tel" name="tel" class="k-textbox" style="color:#000;" pattern="\d{10}"
                               placeholder="Ten digit phone number" <?php if (isset($data['tel']))
                        {
                            echo 'value="' . $data['tel'] . '"';
                        } ?> required validationMessage="Please enter a ten digit phone number"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Referrer</label>
                    <div class="controls"><?php if (isset($_GET['char']))
                        { ?>
                            <input type="text" readonly="readonly" id="referrer" name="referrer" class="k-textbox"
                                   style="color:#000;" placeholder="Enter referrer character name."
                                   required <?php echo 'value="' . $_GET['char'] . '"'; ?>
                                   validationMessage="Please enter a character's name who referred you." /><?php } else
                        { ?><input type="text" id="referrer" name="referrer" class="k-textbox" style="color:#000;"
                                   placeholder="Enter referrer character name."
                                   required <?php if (isset($data['referrer']))
                        {
                            echo 'value="' . $data['referrer'] . '"';
                        } ?> validationMessage="Please enter a character's name who referred you." /><?php } ?><span
                            class="help-inline"><-This character will get 1000 coins when you reach RB 10. (you too can earn by referring others)</span>

                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="g-recaptcha" data-sitekey="6Lex6msrAAAAAP6MrkV5JsXAv4AZg-EEUTAJA1nv"></div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" name="Accept" required validationMessage="Acceptance is required!"/>
                            I accept the <a href="/TermOfServices/">Terms of Service</a>,<a
                                href="/RefundPolicy/">Refund Policy</a> and <a
                                href="/PrivacyPolicy/">Privacy Policy</a>.
                        </label>
                        <button type="submit" name="register" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>

        </div>

    </div> <!-- /container -->
<?php include 'footer.php' ?>