<div id="footer">
<div id="footer-end">
<?php
if($logged_in == 1) {
?>
<ul>
<li><a href="about.php">About</a></li>
<li><a href="privacy.php">Privacy</a></li>
<li><a href="help.php">Help</a></li>
</ul>
<?php
}
?>
<span class="copyright">&copy; <?php echo date('Y') ?> Spheres</span>

</div>
</div>
</div>
<script type="text/javascript" src="includes/colortip-1.0-jquery.js"></script>
<script type="text/javascript" src="includes/tooltipinit.js"></script>
</body>
</html>
<?php
mysql_close($connection) or die();
?>