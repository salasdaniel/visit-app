<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../config/conexion.php';

$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));
$client = pg_fetch_assoc($result);

$client_id = $client['id'];
$first_name = $client['nombre'];
$last_name = $client['apellido'];
$document = $client['ruc'];
$phone = $client['telefono'];
$address = $client['direccion'];
$visit_day = $client['dia_visita'];
$visit_time = $client['horario_visita'];
$observation = $client['observacion'];
pg_free_result($result);
pg_close($conn);
?>


<!-- Main -->
<main >
	<div class="contact container">
		<div class="card mb-5">
			<div class="card-header bg-dark text-white">
				<strong>Edit Client Data</strong>
			</div>
			<div class="card-body">
				<form method="POST" id="contactForm" name="contactForm" action="../../app/edit_client.php">
					<input type="hidden" name="id" value="<?php echo $client_id; ?>">
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="username">First Name</label>
							<input type="text" id="username" name="nombre" class="form-control" placeholder="John..." required pattern="^[a-zA-Z\s.]+$" value="<?php echo $first_name; ?>">
						</div>
						<div class="form-group col-md-3">
							<label for="apellido">Last Name</label>
							<input type="text" id="apellido" name="apellido" class="form-control" placeholder="Smith..." required value="<?php echo $last_name; ?>">
						</div>
						<div class="form-group col-md-3">
							<label for="ruc">ID or Passport</label>
							<input type="text" id="ruc" name="ruc" class="form-control" placeholder="202-555-0173" required value="<?php echo $document; ?>">
						</div>
						<div class="form-group col-md-3">
							<label for="phone">Contact Number</label>
							<input type="text" id="phone" name="numero" class="form-control" placeholder="+1 202-555-0173" required value="<?php echo $phone; ?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="direccion">Address</label>
							<input type="text" id="direccion" name="direccion" class="form-control" placeholder="742 Evergreen Terrace, Springfield, IL 62704" required value="<?php echo $address; ?>">
						</div>
						<div class="form-group col-md-4">
							<label for="subjectList">Visit Day</label>
							<select id="subjectList" name="dia" class="form-control" required>
								<option disabled>Select the day</option>
								<option value="monday" <?php if ($visit_day == 'lunes') echo 'selected'; ?>>Monday</option>
								<option value="tuesday" <?php if ($visit_day == 'martes') echo 'selected'; ?>>Tuesday</option>
								<option value="wednesday" <?php if ($visit_day == 'miercoles') echo 'selected'; ?>>Wednesday</option>
								<option value="thursday" <?php if ($visit_day == 'jueves') echo 'selected'; ?>>Thursday</option>
								<option value="friday" <?php if ($visit_day == 'viernes') echo 'selected'; ?>>Friday</option>
								<option value="saturday" <?php if ($visit_day == 'sabado') echo 'selected'; ?>>Saturday</option>
								<option value="sunday" <?php if ($visit_day == 'domingo') echo 'selected'; ?>>Sunday</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="hora">Visit Time</label>
							<input type="time" id="hora" name="hora" class="form-control" required value="<?php echo $visit_time; ?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="observation">Observations</label>
							<input type="text" id="observation" name="observacion" class="form-control" placeholder="Visit on Sunday..." required value="<?php echo $observation; ?>">
						</div>
					</div>
					<div class="d-flex justify-content-end align-items-end w-100">
						<button type="submit" name="submit" class="btn btn-primary" style="height: 35px;">
							Save Changes <i class="fa fa-paper-plane ml-2"></i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>
<?php require '../../partials/footer.php'; ?>