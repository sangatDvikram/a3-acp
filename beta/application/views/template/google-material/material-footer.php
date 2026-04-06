<footer class="mdl-mega-footer">
    <div class="mdl-mega-footer--middle-section">

        <div class="mdl-mega-footer--drop-down-section">
            <input class="mdl-mega-footer--heading-checkbox" type="checkbox" checked>
            <h1 class="mdl-mega-footer--heading">Features</h1>
            <ul class="mdl-mega-footer--link-list">
                <li><a href="#">About</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Partners</a></li>
                <li><a href="#">Updates</a></li>
            </ul>
        </div>

        <div class="mdl-mega-footer--drop-down-section">
            <input class="mdl-mega-footer--heading-checkbox" type="checkbox" checked>
            <h1 class="mdl-mega-footer--heading">Details</h1>
            <ul class="mdl-mega-footer--link-list">
                <li><a href="#">Specs</a></li>
                <li><a href="#">Tools</a></li>
                <li><a href="#">Resources</a></li>
            </ul>
        </div>

        <div class="mdl-mega-footer--drop-down-section">
            <input class="mdl-mega-footer--heading-checkbox" type="checkbox" checked>
            <h1 class="mdl-mega-footer--heading">Technology</h1>
            <ul class="mdl-mega-footer--link-list">
                <li><a href="#">How it works</a></li>
                <li><a href="#">Patterns</a></li>
                <li><a href="#">Usage</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Contracts</a></li>
            </ul>
        </div>

        <div class="mdl-mega-footer--drop-down-section">
            <input class="mdl-mega-footer--heading-checkbox" type="checkbox" checked>
            <h1 class="mdl-mega-footer--heading">FAQ</h1>
            <ul class="mdl-mega-footer--link-list">
                <li><a href="#">Questions</a></li>
                <li><a href="#">Answers</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
        </div>

    </div>

    <div class="mdl-mega-footer--bottom-section">
        <div class="mdl-logo">Title</div>
        <ul class="mdl-mega-footer--link-list">
            <li><a href="#">Help</a></li>
            <li><a href="#">Privacy & Terms</a></li>
        </ul>
    </div>

</footer>
</main>
</div>

<!--  Scripts-->
<script src="<?php echo base_url(); ?>assects/js/jquery-2.1.1.min.js"></script>
<script src="https://storage.googleapis.com/code.getmdl.io/1.0.1/material.min.js"></script>

<?php
if (isset($append_manual_sctript_to_footer)) {
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