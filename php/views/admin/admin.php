<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';



$_SESSION['user_id'];
$_SESSION['first_name'];
$_SESSION['last_name'];
$_SESSION['document'];
$_SESSION['role'];

$full_name = ucfirst(strtolower($_SESSION['first_name'])) . " " . ucfirst(strtolower($_SESSION['last_name']));

?>

<!-- Main -->
<main>
	<!-- Contact  -->
	<div class="contact">
		<div class="container">
			<!-- Form -->
			<div class="row cent">
				<div style="margin: 50px 0px; text-align: center" class="ptb20">
					<h1 style="color:#53c4da">Welcome <?php echo $full_name ?>! </h1>
				</div>
				<div class="col-lg-8 flex " id="mainContent">

					<div class="col-lg-8" id="sidebar">
						<!-- Contact Info Container -->
						<div id="contactInfoContainer" class="theiaStickySidebar">
							<a href="users.php" target="_parent">
								<div class="contact-box pointer">
									<i class="icon icon-map-marker"></i>
									<h2>Users</h2>
									<p>Add, remove or view users</p>
								</div>
							</a>
							<a href="clientes.php">
								<div class="contact-box pointer">
									<i class="icon icon-envelope"></i>
									<h2>Clients</h2>
									<p>Add, remove or view clients</p>
								</div>
							</a>
							<a href="vw_visitas.php">
								<div class="contact-box pointer">
									<i class="icon icon-phone-call2"></i>
									<h2>Visits</h2>
									<p>View visits</p>
								</div>
							</a>
						</div>
						<!-- Contact Info Container End -->
					</div>
				</div>

				<!-- Form End -->
			</div>
		</div>
		<!-- Contact End -->
</main>
<!-- Main End -->

<?php require '../../partials/footer.php'; ?>