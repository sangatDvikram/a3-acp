<!DOCTYPE html>
<html lang="en" style="font-family: 'Roboto', sans-serif; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; box-sizing: border-box; line-height: 1.5; font-weight: normal; color: rgba(0, 0, 0, 0.87); font-size: 15px;">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <title>Payment Successfull</title>
        <link rel="icon" href="/beta/assects/images/favicon/favicon.ico" sizes="32x32">
    </head>
    <body style="background-color: #9e9e9e !important; box-sizing: inherit; margin: 0;" bgcolor="#9e9e9e !important">
        <div style="position: absolute; right: 2%; left: 2%; background-color: #FFFFFF !important; box-sizing: inherit; padding: 0 5px 5px;">
            <div style="box-sizing: inherit; padding-top: 1rem; padding-bottom: 1rem;">
                <div style="box-sizing: inherit;">
                    <a target="_blank" href="" style="box-sizing: inherit; color: #039be5; text-decoration: none; -webkit-tap-highlight-color: transparent; background-color: transparent;"><img src="/beta/assects/images/email/logo.png" width="150px" style="box-sizing: inherit; border: 0;"></a>



                </div>
                <div style="background-color: #F44336 !important; box-sizing: inherit; display: flex; -webkit-flex-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; -webkit-justify-content: center; justify-content: center; margin-left: auto; margin-right: auto; margin-bottom: 20px;">
                    <div style="color: #FFFFFF !important; box-sizing: border-box; float: left; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; width: 75%; margin-left: 0; padding: 0 0.75rem;">

                        <span style="font-family: Calibri; font-size: 2em; box-sizing: inherit;"> You have successfully bought <b style="font-weight: bold; box-sizing: inherit;"><?=$buyed_coins;?> Premium Coins</b> using paypal.</span>


                    </div>
                    <div style="color: #FFFFFF !important; box-sizing: border-box; float: left; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; width: 25%; margin-left: 0; padding: 0 0.75rem;">
                        <p style="box-sizing: inherit; line-height: 2rem;">

                            <img src="/beta/assects/images/email/paypal.png" width="100px" style="box-sizing: inherit; max-width: 100%; height: auto; border: 0;"></p>

                    </div>
                </div>
                <div style="box-sizing: inherit; padding-top: 1rem; padding-bottom: 1rem;">
                    <p style="box-sizing: inherit; line-height: 2rem;">
                        Dear <?=$first_name;?> <?=$last_name;?>,<br style="box-sizing: inherit;"><span style="color: #2196F3 !important; box-sizing: inherit;"><b style="font-weight: bold; box-sizing: inherit;">Please note your transaction details:</b></span>
                    </p>
                    <table style="border-collapse: collapse; border-spacing: 0; box-sizing: inherit; width: 100%; display: table; border: none;">
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">Transaction Type</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle"><?=$payment_type;?></td>

                        </tr>
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">Transaction ID</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle"><?=$txn_id;?></td>

                        </tr>
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">Transaction Date</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle"><?=$payment_date;?></td>

                        </tr>
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">Transaction Amount</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">$<?=$mc_gross;?></td>

                        </tr
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">Transaction Premium Coins</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle"><?=$buyed_coins;?></td>

                        </tr>
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">New Premium Coins Balance</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle"><?=$total_coins;?></td>

                        </tr>
                        <tr style="box-sizing: inherit; border-bottom-width: 1px; border-bottom-color: #d0d0d0; border-bottom-style: solid;">
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle">Transaction Status</td>
                            <td style="box-sizing: inherit; display: table-cell; text-align: left; vertical-align: middle; border-radius: 2px; padding: 15px 5px; border: none;" align="left" valign="middle"><?=$payment_status;?></td>

                        </tr>
                    </table>
                    <br style="box-sizing: inherit;"><span style="color: #2196F3 !important; box-sizing: inherit;"><b style="font-weight: bold; box-sizing: inherit;">Instructions:</b></span>
                    <ol style="box-sizing: inherit;">
                        <li style="box-sizing: inherit;">Do remember to reconnect before using eShop. </li>
                        <li style="box-sizing: inherit;">If you have any questions about the payment please let us know at <a ng-href="mailto:support@a3ultimate.com" href="mailto:support@a3ultimate.com" style="box-sizing: inherit; color: #039be5; text-decoration: none; -webkit-tap-highlight-color: transparent; background-color: transparent;">support@a3ultimate.com</a> </li>
                        <li style="box-sizing: inherit;">Click here to read our <a href="/RefundPolicy/">Refund Policy</a>. </li>
                        <li style="box-sizing: inherit;">Never share your A3Ultimate ID password with others. </li>
                    </ol>

                    Regards,<br style="box-sizing: inherit;"><b style="font-weight: bold; box-sizing: inherit;">Team Ultimate.</b>




                </div>





            </div>
            <div style="font-family: Calibri; background-color: #f5f5f5 !important; box-sizing: inherit; padding-top: 1rem; padding-bottom: 1rem;"> 
                <p style="box-sizing: inherit; line-height: 2rem;">
                    Notes : This is an automated email. Please don't reply to this email. If you want to contact us, mail us at <a ng-href="mailto:support@a3ultimate.com" href="mailto:support@a3ultimate.com" style="box-sizing: inherit; color: #039be5; text-decoration: none; -webkit-tap-highlight-color: transparent; background-color: transparent;">support@a3ultimate.com</a>
                   <br style="box-sizing: inherit;">
                   © 2011-2015 <a href="/">A3 Ultimate</a>. All Rights Reserved 
                </p>
            </div>
        </div>




        <script src="/beta/assects/js/jquery-2.1.1.min.js" style="box-sizing: inherit;"></script><script src="/beta/assects/js/materialize.js" style="box-sizing: inherit;"></script><script src="/beta/assects/js/init.js" style="box-sizing: inherit;"></script>
    </body>
</html>
