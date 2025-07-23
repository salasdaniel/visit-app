<?php

require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../config/conexion.php';
require '../../partials/swal.php';

?>

<!-- Main -->
<main>
	<!-- Contact  -->
	<div class="contact" style="padding-bottom: 100px">
		<div class="container cent">
			<div style="margin: 100px  0px 50px 0px">
				<h1 style="color:#53c4da">Listado de Usuarios</h1>
			</div>
			<!-- lista de empleados -->
			<div class="col-lg-8 row box first " id="mainContent">

				<?php

				// Paginacio
				$por_pagina = 10;

				if (!empty($_REQUEST['num'])) {

					$pagina = $_REQUEST['num'];
				} else {
					$_REQUEST['num'] = 1;
					$pagina = $_REQUEST['num'];
				}

				if ($pagina > 1) {
					$inicio = ($pagina - 1) * $por_pagina;
				} else {
					$inicio = 0;
				}
				$sql = "SELECT * FROM personas";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
				$total_registros = $result->num_rows;


				$sql = "SELECT personas.id, personas.nombre, personas.apellido, personas.ci, roles.rol
											FROM personas
											INNER JOIN roles ON personas.rol = roles.id ORDER BY id DESC LIMIT ?, ? ";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ii", $inicio, $por_pagina);
				$stmt->execute();
				$result = $stmt->get_result();

				$paginas = ceil($total_registros / $por_pagina);


				?>

				<table class="table">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Nombre</th>
							<th scope="col">Apellido</th>
							<th scope="col">N° Documento</th>
							<th scope="col">Rol</th>
							<th scope="col">Accion</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($info_usuario = $result->fetch_assoc()) {
							$id = $info_usuario['id'];
							$nombre = $info_usuario['nombre'];
							$apellido = $info_usuario['apellido'];
							$ci = $info_usuario['ci'];
							$rol = $info_usuario['rol'];
						?>

							<tr>
								<th scope="row"><?php echo $id; ?></th>
								<td><?php echo ucfirst(strtolower($nombre)); ?></td>
								<td><?php echo ucfirst(strtolower($apellido)); ?></td>
								<td><?php echo $ci; ?></td>
								<td><?php echo ucfirst(strtolower($rol)); ?></td>
								<td><a href=''><button type="button" class="btn btn-danger" value="<?php echo $id; ?>" style="font-size: 12px"> <strong>-</strong> </button></a></td>


							</tr>

						<?php
						}
						?>
						<script>
							btns = document.getElementsByClassName('btn-danger');

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

											window.location.href = '../../app/delete_empleados.php?id=' + id;


										}
									})


								})
							}
						</script>
					</tbody>
				</table>
			</div>
			<nav aria-label="Page navigation example" style="padding-top: 20px">
				<ul class="pagination justify-content-center">
					<li class="page-item">
						<a class="page-link" href="?num=<?php echo ($paginas >= $pagina) ? $pagina - 1 : $pagina; ?>" tabindex="-1">Previous</a>
					</li>

					<?php

					for ($i = 1; $i <= $paginas; $i++) {
						echo "<li class='page-item'><a class='page-link' href='?num=$i'>$i</a></li>";
					}

					?>
					<li class="page-item">
						<a class="page-link" href="?num=<?php echo ($pagina < $paginas) ? $pagina + 1 : $pagina; ?>">Next</a>
					</li>
				</ul>
			</nav>

		</div>
		<!-- Form -->
		<div class="row cent">
			<form method="POST" id="contactForm" name="contactForm" action="../../app/add_vendedor.php" class="cent">
				<div style="margin: 50px 0px">
					<h1 style="color:#53c4da">¡Agrega un nuevo empleado! </h1>
				</div>
				<div class="col-lg-8" id="mainContent">
					<!-- Personal Details -->
					<div class="row box first">
						<div class="box-header">
							<h3><strong>1</strong>Información Personal</h3>
							<p></p>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="username" class="form-control" name="nombre" placeholder="Nombre..." type="text" data-parsley-pattern="^[a-zA-Z\s.]+$" required />
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="email" class="form-control" name="apellido" placeholder="Apellido..." type="text" required />
							</div>
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<input id="phone" class="form-control" name="ci" placeholder="Número de cédula" type="number" required />
							</div>
						</div>
					</div>
					<!-- Personal Details End -->
					<!-- Subject -->
					<div class="row box">
						<div class="box-header">
							<h3><strong>2</strong>Rol</h3>
							<p></p>
						</div>
						<div class="col-12">
							<div class="form-group">
								<select id="subjectList" class="nice-select" name="rol" style="width: 100%;">
									<option value="1">Administrador</option>
									<option value="2">Asesor</option>
								</select>
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

		<!-- Form End -->
	</div>
	</div>
	<!-- Contact End -->
</main>

<!-- Main End -->

<?php require '../../partials/footer.php'; ?>