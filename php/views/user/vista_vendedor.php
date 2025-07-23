<?php

	require '../../config/user_validation.php';
	require '../../partials/head.php';
	require '../../partials/subheader.php';
	require '../../config/conexion.php';
	require '../../partials/swal.php';

	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$_SESSION['hora_entrada'] = date("H:i:s");
	$_SESSION['fecha'] = date("Y-m-d");

	?>

		<!-- Main -->
		<main style="height: 90vh" class="cent vh70">
			<!-- Contact  -->
			<!-- Form -->
			<div class="row cent">
				<form method="POST" id="contactForm" name="contactForm" action="../../app/add_registro_cliente.php" class="cent">
					<div style="margin: 50px 0px 50px 0px">
						<h1 style="color:#53c4da">Buscar clientes </h1>
					</div>

					<!-- Personal Details -->
					<div class="row box first vw100" style="width: 800px;">
						<div class="col-md-12 col-sm-12 vw100" style="width: 1000px; height: 40px">
							<div class="form-group" style="display: flex;" id="modal">
								<select class="form-control js-example-basic-single" name="id_cliente" required>
									<option disabled selected value=""></option>
									<?php

									$sql = "SELECT id, nombre, apellido
												FROM clientes ORDER BY nombre ASC";
									$stmt = $conn->prepare($sql);
									$stmt->bind_param("ii", $inicio, $por_pagina);
									$stmt->execute();
									$result = $stmt->get_result();

									while ($info_usuario = $result->fetch_assoc()) {
										$id = $info_usuario['id'];
										$nombre = $info_usuario['nombre'];
										$apellido = $info_usuario['apellido'];
										$nombre_completo = ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombre)))) . " " . ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $apellido))));
										echo "<option value='$id'>$nombre_completo</option>";
									}
									$stmt->close();
									$conn->close();
									?>

								</select>

								<button type="submit" name="submit" class="btn-form-func" style="width: 10%; border:none; margin-left: 2%;">
									<span class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
								</button>
							</div>
						</div>
					</div>

					<!-- Terms End -->
					<!-- Submit-->
					<!-- Submit -->
				</form>
			</div>
			<!-- Form End -->
			<div style="margin: 50px 0px 50px 0px; flex-direction:row; width: 100%; display:none" class="cent">
				<h1 style="color:#53c4da">Agregar clientes </h1>
				<a href="clientes.php" style="width: 5%; border:none; margin-left: 2%; "><button class="btn-form-func">
						<span class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
								<style>
									svg {
										fill: #ffffff
									}
								</style>
								<path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
							</svg>
						</span>
					</button>
				</a>

			</div>
			<!-- Contact End -->
		</main>
		<!-- Main End -->

	


		<script>
			
			$(document).ready(function() {
				$('.js-example-basic-single').select2({
					placeholder: 'Select an option'
				});
			});
	
		</script>

<?php require '../../partials/footer.php'; ?>