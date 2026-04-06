<!--  Footer Begings here  -->
<?php if (!isset($plain_footer)) { ?>
    <footer class="page-footer grey darken-3">

        <div class="row">
            <div class="col l3 s12">
                <h5 class="white-text">About A3 Ultimate</h5>
                <p class="grey-text text-lighten-4">We are a team of players working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


            </div>
            <div class="col l3 s12">

                <div class="section col s6">
                    <h5 class="white-text">Site Map</h5> 
                    <ul>
                        <li><a class="orange-text" href="#!">Home</a></li>
                        <li><a class="orange-text" href="#!">Downloads</a></li>
                        <li><a class="orange-text" href="#!" title="Board of heroes">BOH</a></li>
                        <li><a class="orange-text" href="#!">Contact Us</a></li>
                    </ul>
                </div>
                <div class="section col s6">
                    <h5 class="white-text">Specials</h5> 
                    <ul>
                        <li><a class="blue-text" href="#!">ACP</a></li>
                        <li><a class="blue-text" href="<?php echo site_url('guides') ?>">Guides</a></li>
                        <li><a class="blue-text" href="#!">Eshop</a></li>
                        <li><a class="blue-text" href="#!">Auction</a></li>
                        <li><a class="blue-text" href="<?php echo site_url('payment') ?>">Payments</a></li>
                    </ul>
                </div>

            </div>
            <div class="col l3 s12">

                <div class="section col s6">
                    <h5 class="white-text">Legal</h5>
                    <ul>
                        <li><a class="light-green-text" href="#!">Privacy Policy</a></li>
                        <li><a class="light-green-text" href="#!">Refund Policy</a></li>
                        <li><a class="light-green-text" href="#!">Terms of Service</a></li>

                    </ul>
                </div>
                <div class="section col s6">
                    <h5 class="white-text">Social</h5>
                    <ul>
                        <li><a class="purple-text" href="<?php echo site_url('staff') ?>">Staff</a></li>
                        <li><a class="purple-text" href="#!">Forum</a></li>
                        <li><a class="purple-text" href="#!">Facebook</a></li>
                        <li><a class="purple-text" href="#!">TS3</a></li>
                    </ul>
                </div>
            </div>
            <div class="col l3 s12 white-text visitor-counter">
                <h5 class="white-text">Site Statistic</h5>
                <span id="visitor-counter">  </span>

            </div>

        </div>

        <div class="footer-copyright">
            <div class="container">
                © 2011-2015 A3 Ultimate. All Rights Reserved
                <span class="grey-text text-lighten-4 right" style="font-size: 12px">Page rendered in <em>{elapsed_time}</em> seconds</span>
            </div>
        </div>
    </footer>

<?php } ?>


<!--  Scripts-->
<script src="<?php echo base_url(); ?>assects/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
	//$("#loader").fadeOut("slow");
})
</script>
<script src="<?php echo base_url(); ?>assects/js/materialize.js"></script>

<script src="<?php echo base_url(); ?>assects/js/init.js"></script>

<?php 
if(isset($append_manual_sctript_to_footer))
    {
    echo "<script>$append_manual_sctript_to_footer</script>\n";
    }

if (isset($js)) {
    foreach ($js as $js_link) {
        echo ""
        . "<script src='" . base_url() . "assects/js/$js_link'></script>\n";
    }
}
?>



</body>
</html>
