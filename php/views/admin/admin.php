<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';


$_SESSION['id'];
$_SESSION['nombre'];
$_SESSION['apellido'];
$_SESSION['ci'];
$_SESSION['rol'];

$nombre_completo = ucfirst(strtolower($_SESSION['nombre'])) . " " . ucfirst(strtolower($_SESSION['apellido']));

?>

<!-- Main -->
<main>
	<!-- Contact  -->
	<div class="contact">
		<div class="container">
			<!-- Form -->
			<div class="row cent">
				<div style="margin: 50px 0px; text-align: center" class="ptb20">
					<h1 style="color:#53c4da">¡Bienvenido <?php echo $nombre_completo ?>! </h1>
				</div>
				<div class="col-lg-8 flex " id="mainContent">

					<div class="col-lg-8" id="sidebar">
						<!-- Contact Info Container -->
						<div id="contactInfoContainer" class="theiaStickySidebar">
							<a href="vendedores.php" target="_parent">
								<div class="contact-box pointer">
									<i class="icon icon-map-marker"></i>
									<h2>Vendedores</h2>
									<p>Agregar, eliminar o ver vendores</p>
								</div>
							</a>
							<a href="clientes.php">
								<div class="contact-box pointer">
									<i class="icon icon-envelope"></i>
									<h2>Clientes</h2>
									<p>Agregar, eliminar o ver clientes</p>
								</div>
							</a>
							<a href="vw_visitas.php">
								<div class="contact-box pointer">
									<i class="icon icon-phone-call2"></i>
									<h2>Visitas</h2>
									<p>Ver visitas</p>
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