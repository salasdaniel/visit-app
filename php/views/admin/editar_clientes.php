<?php

require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../config/conexion.php';

$id = $_GET['id'];

$sql = "SELECT * FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$info_usuario = $result->fetch_assoc();
$id = $info_usuario['id'];
$nombre = $info_usuario['nombre'];
$apellido = $info_usuario['apellido'];
$ruc = $info_usuario['ruc'];
$numero = $info_usuario['telefono'];
$direccion = $info_usuario['direccion'];
$dia = $info_usuario['dia_visita'];
$hora = $info_usuario['horario_visita'];
$observacion = $info_usuario['observacion'];

$stmt->close();
$conn->close()


?>

<!-- Main -->
<main>
	<!-- Contact  -->
	<div class="contact" style="padding-bottom: 100px">


		<!-- Form -->
		<div class="row cent">
			<form method="POST" id="contactForm" name="contactForm" action="../../app/add_editar.php" class="cent">
				<div style="margin: 100px 0px 50px 0px">
					<h1 style="color:#53c4da">Editar datos</h1>
				</div>
				<div class="col-lg-8" id="mainContent">
					<!-- Personal Details -->
					<div class="row box first">

						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input type="text" hidden name="id" value="<?php echo $id; ?>">
								<input id="username" class="form-control" name="nombre" placeholder="Nombre..." type="text" data-parsley-pattern="^[a-zA-Z\s.]+$" required value="<?php echo $nombre; ?>" />
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="apellido" class="form-control" name="apellido" placeholder="Apellido..." type="text" required value="<?php echo $apellido; ?> " />
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="ruc" class="form-control" name="ruc" placeholder="CI o RUC" type="text" required value="<?php echo $ruc; ?>" />
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="phone" class="form-control" name="numero" placeholder="Número de de contacto. Ej: 991444333" type="number" required value="<?php echo $numero; ?>" />
							</div>
						</div>
					</div>
					<!-- Personal Details End -->
					<!-- Subject -->
					<div class="row box">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="direccion" class="form-control" name="direccion" placeholder="Dirección..." type="text" required value="<?php echo $direccion; ?>" />
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<select id="subjectList" class="nice-select" name="dia" style="width: 100%;" required>
									<option disabled selected>Seleccione el día</option>
									<option value="lunes">Lunes</option>
									<option value="martes">Martes</option>
									<option value="miercoles">Miercoles</option>
									<option value="jueves">Jueves</option>
									<option value="viernes">Viernes</option>
									<option value="sabado">Sábado</option>
									<option value="domingo">Domingo</option>
								</select>
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<label for="hora">Hora</label><br>
							<div class="form-group">
								<input id="hora" class="form-control" name="hora" placeholder="Dirección..." type="time" required value="<?php echo $hora; ?>" />
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="hora" class="form-control" name="observacion" placeholder="Observaciones..." type="textarea" required value="<?php echo $observacion; ?>" />
							</div>
						</div>

					</div>
					<!-- Terms End -->
					<!-- Submit-->
					<div class="row box">
						<div class="col-12">
							<div class="form-group">
								<button type="submit" name="submit" class="btn-form-func">
									<span class="btn-form-func-content">Submit</span>
									<span class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
								</button>
							</div>
						</div>
					</div>
					<!-- Submit -->
			</form>
		</div>
	</div>
	<!-- Contact End -->
</main>
<!-- Main End -->

<!-- Footer -->
<?php require '../../partials/footer.php'; ?>