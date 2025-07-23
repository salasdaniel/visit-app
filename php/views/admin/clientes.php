<?php

require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../partials/swal.php';
require '../../config/conexion.php';

?>
<!-- Main -->
<main>
	<!-- Contact  -->
	<!-- Form -->
	<div class="row cent">
		<form method="POST" id="contactForm" name="contactForm" action="../../app/add_cliente.php" class="cent">
			<div class="stittle">
				<h1 style="color:#53c4da">¡Agrega un nuevo cliente! </h1>
			</div>
			<div class="col-lg-8" style="width: 70%; max-width: 95vw;">
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
							<input id="apellido" class="form-control" name="apellido" placeholder="Apellido..." type="text" required />
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<input id="ruc" class="form-control" name="ruc" placeholder="CI o RUC" type="text" required />
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<input id="phone" class="form-control" name="numero" placeholder="Número de de contacto. Ej: 991444333" type="number" required />
						</div>
					</div>
				</div>
				<!-- Personal Details End -->
				<!-- Subject -->
				<div class="row box">
					<div class="box-header">
						<h3><strong>2</strong>Datos de visita</h3>
						<p></p>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<input id="direccion" class="form-control" name="direccion" placeholder="Dirección..." type="text" required />
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<select id="subjectList" class="nice-select" name="plan" style="width: 100%;">
								<option disabled selected>Seleccione Plan</option>

							<?php 
							$sql = "SELECT * FROM planes ";
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							$result = $stmt->get_result();

							while($planes = $result->fetch_assoc()){
								$idplan =  $planes['id'];
								$nombre_plan =  $planes['nombre'];

								echo "<option value='$idplan'>$nombre_plan</option>";
							}
							
							?>
					
							</select>
						</div>
					</div>
					<!-- <div class="col-md-12 col-sm-12">
						<label for="hora">Hora</label><br>
						<div class="form-group">
							<input id="hora" class="form-control" name="hora" placeholder="Dirección..." type="time" required />
						</div>
					</div> -->
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<input id="hora" class="form-control" name="observacion" placeholder="Observaciones..." type="textarea" required />
						</div>
					</div>
				</div>
				<!-- Terms End -->
				<!-- Submit-->
				<div class="row box">
					<div class="col-12">
						<div class="form-group">
							<button type="submit" name="submit" class="btn-form-func">
								<span class="btn-form-func-content">Registrar</span>
								<span class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
							</button>
						</div>
					</div>
				</div>
				<!-- Submit -->
		</form>
	</div>
	<div class="row d-flex" style="margin: 50px 0px; flex-direction:column; align-items: center; max-width:90vw">
	
	<h4>Carga masiva de clientes</h4>
		<form action=".../../../../app/procesar_excel.php" method="post" enctype="multipart/form-data">
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="inputGroupFile02" style = "cursor: pointer" name="archivo_excel" required>
				<label class="custom-file-label imginput" for="inputGroupFile01">Adjuntar archivo .xls </label>
				<button type="submit" name="submit" class="btn-cesar" style="width: auto; padding: 10px; margin: 10px; left: 33%;">
					<span class="btn-form-func-content">Procesar</span>
					<span class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
				</button>
				<a href='../../../docs/plantilla_clientes.xlsx' class="btn-cesar" style="width: auto; padding: 10px; margin: 10px; left: 33%;">
					<span class="btn-form-func-content">Descargar Plantilla</span>	
				</a>
			</div>
		</form>
		
	</div>
	<div class="row cent" style="max-width: 90vw;">
		<h6>OBSERVACIONES</h6>
		<ul >
			<li>1. Las columnas deben ser en el mismo orden que en la plantilla.</li>
			<li>2. El numero de telefono debe ser numerico, sin guiones, espacios y otros caracteres.</li>
			<li>3. Los planes deben colocarse en un numero 1 para Oro, 2 para Plata, 3 para Bronce</li>
			<li style="color:red">Debe seguir las indicaciones al pie de la letra para ingresar los registros a la BD </li>
			</ul>
	</div>

	<!-- Form End -->

	<?php

	if ($_SESSION['rol'] == 1) {

	?>

		<div class="contact" style="padding-bottom: 50px">
			<div class="container cent">
				<div class="ptittle">
					<h1 style="color:#53c4da">Listado de clientes</h1>
				</div>


				<div class="col-lg-12 row box first " id="mainContent" style="overflow: auto; max-width: 95vw">

					<?php

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
					$sql = "SELECT * FROM vw_clientes ";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$result = $stmt->get_result();
					$total_registros = $result->num_rows;


					$sql = "SELECT *
											FROM vw_clientes ORDER BY id DESC
											LIMIT ?, ? ";
					$stmt = $conn->prepare($sql);
					$stmt->bind_param("ii", $inicio, $por_pagina);
					$stmt->execute();
					$result = $stmt->get_result();

					$paginas = ceil($total_registros / $por_pagina);


					?>
					<span style="font-size: 10px;"><?php echo $pagina ?>.- Registros totales <?php echo $total_registros ?> </span>
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Nombre</th>
								<th scope="col">Apellido</th>
								<th scope="col">Ruc</th>
								<th scope="col">Teléfono</th>
								<th scope="col">Dirección</th>
								<th scope="col">Plan</th>
								<th scope="col">Observación</th>
								<th scope="col"></th>
								<th scope="col"></th>

							</tr>
						</thead>
						<tbody>
							<?php
							while ($info_usuario = $result->fetch_assoc()) {
								$id = $info_usuario['id'];
								$nombre = $info_usuario['nombre'];
								$apellido = $info_usuario['apellido'];
								$ruc = $info_usuario['ruc'];
								$numero = $info_usuario['telefono'];
								$direccion = $info_usuario['direccion'];
								$plan = $info_usuario['plan'];
								$observacion = $info_usuario['observacion'];
							?>

								<tr>
									<th scope="row"><?php echo $id; ?></th>
									<td><?php echo ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombre)))); ?></td>
									<td><?php echo ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $apellido)))); ?></td>
									<td><?php echo $ruc; ?></td>
									<td><?php echo $numero; ?></td>
									<td><?php echo preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $direccion)); ?></td>
									<td><?php echo $plan; ?></td>
								 
									<td><?php echo preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $observacion)); ?></td>
									<td>
										<button type="button" class="btn btn-danger" style="border: none" value="<?php echo $id; ?>" style="font-size: 12px"> <strong>-</strong> </button>
									</td>
									<td>
										<button type="button" class="btn btn-primary" style="background-color: #53c4da; border: none" value="<?php echo $id; ?>" style="font-size: 12px"> <strong>Edit</strong> </button>
									</td>
								</tr>

							<?php } ?>

						</tbody>
					</table>
				</div>
				<nav aria-label="Page navigation example" style="padding-top: 20px">
					<ul class="pagination justify-content-center">
						<li class="page-item">
							<a class="page-link" href="?num=<?php echo ($paginas >= $pagina) ? $pagina - 1 : $pagina; ?>" tabindex="-1">Previous</a>
						</li>
						<?php

						// for ($i = 1; $i <= $paginas; $i++) {
						// 	echo "<li class='page-item'><a class='page-link' href='?num=$i'>$i</a></li>";
						// }

						?>
						<!-- <li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li> -->
						<li class="page-item">
							<a class="page-link" href="?num=<?php echo ($pagina < $paginas) ? $pagina + 1 : $pagina; ?>">Next</a>
						</li>
					</ul>
				</nav>

			</div>

		</div>
		</div>
	<?php
	}
	?>
	<!-- Contact End -->
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