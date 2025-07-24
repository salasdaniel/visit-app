<?php

require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../partials/swal.php';
require '../../config/conexion.php';

?>
<!-- Main -->
<main class="py-5">
	<div class="container">
		<!-- Form Card -->
		<div class="card mb-5">
			<div class="card-header bg-dark text-white">
				<strong>Add a New Client</strong>
			</div>
			<div class="card-body">
				<form method="POST" id="contactForm" name="contactForm" action="../../app/add_cliente.php">
					<!-- Personal Information -->
					<div class="mb-4">
						<h5><strong>1.</strong> Personal Information</h5>
						<div class="form-group">
							<input id="username" class="form-control" name="nombre" placeholder="First Name..." type="text" required pattern="^[a-zA-Z\s.]+$">
							<input id="apellido" class="form-control" name="apellido" placeholder="Last Name..." type="text" required>
						</div>
						<div class="form-group">
							<input id="ruc" class="form-control" name="ruc" placeholder="ID or RUC..." type="text" required>
							<input id="phone" class="form-control" name="numero" placeholder="Contact Number. e.g. 991444333" type="number" required>
						</div>
					</div>

					<!-- Visit Data -->
					<div class="mb-4">
						<h5><strong>2.</strong> Visit Details</h5>
						<div class="form-group">
							<input id="direccion" class="form-control" name="direccion" placeholder="Address..." type="text" required>
						</div>
						<div class="form-group">
							<select id="subjectList" class="form-control" name="plan" required>
								<option disabled selected>Select a Plan</option>
								<?php
								$sql = "SELECT * FROM planes";
								$result = pg_query($conn, $sql);
								while ($planes = pg_fetch_assoc($result)) {
									$idplan =  $planes['id'];
									$nombre_plan =  $planes['nombre'];
									echo "<option value='$idplan'>$nombre_plan</option>";
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<input id="hora" class="form-control" name="observacion" placeholder="Observations..." required>
						</div>
					</div>

					<!-- Submit -->
					<div class="form-group text-right">
						<button type="submit" name="submit" class="btn btn-primary">
							Register <i class="fa fa-paper-plane ml-2"></i>
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Bulk Upload Section -->
		<div class="card mb-5">
			<div class="card-header bg-dark text-white">
				<strong>Bulk Upload Clients</strong>
			</div>
			<div class="card-body">
				<form action="../../../app/procesar_excel.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="inputGroupFile02">Attach .xls file</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="inputGroupFile02" name="archivo_excel" required>
							<label class="custom-file-label" for="inputGroupFile02">Choose file</label>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-success mr-2">
							Process <i class="fa fa-paper-plane ml-2"></i>
						</button>
						<a href='../../../docs/plantilla_clientes.xlsx' class="btn btn-secondary">
							Download Template
						</a>
					</div>
					<div class="card-body">
						<strong>Instructions</strong>
						<ul>
							<li>1. Columns must follow the same order as the template.</li>
							<li>2. Phone numbers must be numeric, without dashes, spaces, or other characters.</li>
							<li>3. Plans must be specified as numbers: 1 for Gold, 2 for Silver, 3 for Bronze.</li>
							<li class="text-danger">You must follow the instructions exactly to load records into the database.</li>
						</ul>
					</div>
				</form>
			</div>
		</div>


		<!-- Clients List -->
		<?php if ($_SESSION['role'] == 1): ?>
			<div class="card">
				<div class="card-header bg-dark text-white">
					<strong>Clients List</strong>
				</div>
				<div class="card-body">
					<p class="mb-2 small">
						Page <?php echo $pagina ?> – Total records: <?php echo $total_registros ?>
					</p>
					<div class="table-responsive">
						<table class="table table-striped table-bordered text-center">
							<thead>
								<tr>
									<th>ID</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>RUC</th>
									<th>Phone</th>
									<th>Address</th>
									<th>Plan</th>
									<th>Observation</th>
									<th colspan="2">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($info_usuario = pg_fetch_assoc($result)): ?>
									<tr>
										<td><?php echo $info_usuario['id']; ?></td>
										<td><?php echo ucfirst(strtolower($info_usuario['nombre'])); ?></td>
										<td><?php echo ucfirst(strtolower($info_usuario['apellido'])); ?></td>
										<td><?php echo $info_usuario['ruc']; ?></td>
										<td><?php echo $info_usuario['telefono']; ?></td>
										<td><?php echo $info_usuario['direccion']; ?></td>
										<td><?php echo $info_usuario['plan']; ?></td>
										<td><?php echo $info_usuario['observacion']; ?></td>
										<td>
											<button type="button" class="btn btn-danger btn-sm" value="<?php echo $info_usuario['id']; ?>">-</button>
										</td>
										<td>
											<button type="button" class="btn btn-info btn-sm" value="<?php echo $info_usuario['id']; ?>">Edit</button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>

					<!-- Pagination -->
					<nav class="mt-4">
						<ul class="pagination justify-content-center">
							<li class="page-item">
								<a class="page-link" href="?num=<?php echo ($pagina > 1) ? $pagina - 1 : 1; ?>">Previous</a>
							</li>
							<li class="page-item">
								<a class="page-link" href="?num=<?php echo ($pagina < $paginas) ? $pagina + 1 : $pagina; ?>">Next</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		<?php endif; ?>
	</div>
</main>


<script>
	btns = document.getElementsByClassName('btn-danger');

	document.getElementById('inputGroupFile02').addEventListener('change', function() {
		var fileInput = this;
		var fileName = fileInput.value;

		if (/\.(xlsx)$/i.test(fileName)) {
			// La extensión del archivo es .xlsx, está permitida
		} else {
			// La extensión del archivo no es .xlsx, mostrar un mensaje de error
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Solo se permiten archivos con extensión .xlsx.',

			})
			fileInput.value = ''; // Limpiar el input de archivo
		}
	});


	for (var i = 0; i < btns.length; i++) {
		btns[i].addEventListener('click', function() {
			id = this.value;
			console.log(id);
			event.preventDefault();
			Swal.fire({
				title: '¿Deseas eliminar el registro?',
				text: "Al eliminar el registro de la base de datos, no se podrá recuperar la información.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sí'
			}).then((result) => {
				if (result.isConfirmed) {

					window.location.href = '../../app/delete_clientes.php?id=' + id;


				}
			})


		})
	}

	btnsP = document.getElementsByClassName('btn-primary');

	for (var i = 0; i < btns.length; i++) {
		btnsP[i].addEventListener('click', function() {
			id = this.value;
			console.log(id);
			event.preventDefault();
			Swal.fire({
				title: '¿Deseas editar el registro?',
				text: "Te redireccionaremos a una nueva página para editar la información",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sí'
			}).then((result) => {
				if (result.isConfirmed) {

					window.location.href = '../../views/admin/editar_clientes.php?id=' + id;


				}
			})


		})
	}
</script>
<!-- Main End -->
<?php require '../../partials/footer.php'; ?>