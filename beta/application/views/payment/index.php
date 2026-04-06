
<main>
    <!--  Main Container  -->
    <div class="section red  darken-3" id="index-banner" >

        <div class="row ">
            <div class="col s12 m12  white-text">
                <h3 class="header ">Payment Getway</h3>
                <h5 class="header "> Now you can donate to the game using paypal and payuMoney. </h5>
            </div>
        </div>

    </div>
    <div class="section   z-depth-2" style="margin-left: 1%;margin-right: 1%;margin-bottom: 2%;">
        <div class="row " style="">

            <div class="col s12 m3">
                <h3>Get in touch</h3>
                <div class="divider"></div>
                <div>
                    <p>
                    <div class="row">
                        <div class="s2"><i class="mdi-communication-call small left"></i></div>
                        <div class="s10">
                            <b>Call</b><br>
                            9555511333
                        </div>
                    </div>
                    <div class="row">
                        <div class="s2"><i class="mdi-communication-email small left"></i></div>
                        <div class="s10">
                            <b>Email</b><br>
                            <a class="mail_thrw ng-binding" ng-href="mailto:support@a3ultimate.com" href="mailto:support@a3ultimate.com">support@a3ultimate.com</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="s2"><i class="mdi-communication-location-on small left"></i></div>
                        <div class="s10">
                            <b>Address</b><br>
                            Gurgaon
                        </div>
                    </div>
                    </p>


                </div>
            </div>
            <div class="col s12 m9">You can now make payments for our services. 

                For Quotations, Please contact us using email or just give us a call on 09555511333.

                We Provide Different Services such as Website Development, Software Development, 
                Android App development, A3 Ultimate Premium Coins, Sms gateway integration etc.
                <div><?php if(isset($errors)){ echo $errors; } ?></div>
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s3"><a class="active" href="#test2">Indian</a></li>
                            <li class="tab col s3"><a  href="#test1">Non-Indian</a></li>
                        </ul>
                    </div>
                    <div id="test1" class="col s12">
                        <br>
                        <div class="row">
                            <form class="col s12" action="<?= $checkout_url ?>" method='post' name='frmPayPal1'>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <i class="mdi-action-shopping-cart prefix"></i>
                                        <input id="premium-coins" type="text" class="validate" value="404.44">
                                        <label for="premium-coins">Premium Coins</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <span id="required-amout"></span>
                                        <input type='hidden' name='business' value='<?php echo $paypal_id; ?>'> <!-- found on top -->
                                        <input type='hidden' name='cmd' value="_xclick">
                                        <input type='hidden' name='image_url' value='/images/1.png'> <!-- logo of your website -->
                                        <input type="hidden" name="rm" value="2" /> <!--1-get 0-get 2-POST -->
                                        <input type='hidden' class="name" name='item_name' value='A3 Ultimate Premium Coins'>

                                        <input type='hidden' name='item_number' value='<?php echo $transaction_id ?>'>
                                        <input type='hidden' name='no_shipping' value='1'>
                                        <input type='hidden' name='no_note' value='1'>
                                        <input type='hidden' name='handling' value='0'>
                                        <input type="hidden" name="currency_code" value="USD">
                                        <input type="hidden" name="lc" value="US">
                                        <input type="hidden" name="cbt" value="Return to the website">
                                        <input type="hidden" name="bn" value="PP-BuyNowBF">
                                        <input type='hidden' name='cancel_return' value='/beta/payment?cancle=1&status=payment_cancled'>
                                        <input type='hidden' name='return' value='/testpaypal/success.php?paypal_success'>
                                        <input type="hidden" name="notify_url" value="https://www.a3ultimate.com/testpaypal/ipn.php" /> 

                                        <input id="amount_paypal" type='hidden'  name='amount' value=''> 
                                        <input type="hidden" name="custom" value='<?php echo $this->session->userdata('username'); ?>'><!-- custom field -->
                                        
                                    </div>
                                </div>
                                <div class="section">
                                    <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0"  type="submit" name="submit" alt="PayPal – The safer, easier way to pay online." disabled="" id="submit">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="test2" class="col s12">
                        <br>
                        <div class="row">
                            <form class="col s12" action="/Payu/" method='post' name='frmPayu'>
                                <div class="row">
                                    
                                    <div class="input-field col s6">
                                        <span id="required-amout"></span>
                                        <input type='hidden' name='productinfo' value='<?php echo $this->session->userdata('username'); ?>'> <!-- found on top -->
                                        </div>
                                </div>
                                <div class="section">
                                    <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0"  type="submit" name="submit1" alt="PayUMoney Payments." id="submit1">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
