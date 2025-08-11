<!-- Footer -->
<div>
<footer class="bg-light py-3">
		<div class="container text-center">
			<small class="text-muted">© <?php echo date('Y'); ?> daniel@noko.com.py</small>
		</div>
</footer>
<!-- <footer class="main-footer ptb pt20 dn">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul id="subFooterLinks">
                    <li>Get in touch <strong>daniel@noko.com.py</strong></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div id="copy">© 2023 Noko</div>
            </div>
        </div>
    </div>
</footer> -->
<!-- Footer End -->
</div>
<!-- Page End -->

<!-- Back to top button -->
<div id="toTop"><i class="fa fa-chevron-up"></i></div>

<?php
// Include configuration if not already included
if (!defined('BASE_URL')) {
    require_once(dirname(__DIR__) . '/config/connection.php');
}

// For Docker environment, use root path
$base_path = $_SERVER['HTTP_HOST'] === 'localhost:8080' ? '/' : BASE_URL;
?>

<!-- Vendor Javascript Files -->
<script src="<?php echo $base_path; ?>vendor/easing/js/easing.min.js"></script>
<script src="<?php echo $base_path; ?>vendor/parsley/js/parsley.min.js"></script>
<script src="<?php echo $base_path; ?>vendor/nice-select/js/jquery.nice-select.min.js"></script>
<script src="<?php echo $base_path; ?>vendor/mmenu/js/mmenu.min.js"></script>
<script src="<?php echo $base_path; ?>vendor/filepond/js/filepond-plugin-file-validate-size.js"></script>
<script src="<?php echo $base_path; ?>vendor/filepond/js/filepond-plugin-file-validate-type.js"></script>
<script src="<?php echo $base_path; ?>vendor/filepond/js/filepond.min.js"></script>
<script src="<?php echo $base_path; ?>vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $base_path; ?>js/scripts.js"></script>

</body>

</html>