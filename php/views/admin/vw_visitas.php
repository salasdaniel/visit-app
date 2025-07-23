

	<?php
	require '../../config/admin_validation.php';
	require '../../partials/head.php';
	require '../../partials/subheader.php';
	require '../../config/conexion.php';

	?>


		<!-- Sub Header End -->

		<!-- Main -->
		<main>

			<div class="contact" >
				<div class="container cent">
					<div style="margin: 25px 0px">
						<h1 style="color:#53c4da">Registro de visitas</h1>
					</div>
					
					
					<div class="col-lg-12 row box first " id="mainContent"  style="overflow: auto;">

						<?php
	
						$por_pagina = 10;
						
						if(!empty($_REQUEST['num'])){
							
							$pagina = $_REQUEST['num'];
							
							
						}else{
							$_REQUEST['num'] = 1;
							$pagina = $_REQUEST['num'];
							
						}
						
						if($pagina>1){
							$inicio = ($pagina - 1) * $por_pagina;
							
						}else{
							$inicio = 0;
							
						}
							$sql = "SELECT * FROM vw_visitas ORDER BY id DESC";
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							$result = $stmt->get_result();
							$total_registros = $result->num_rows;

							$sql = "SELECT * FROM vw_visitas ORDER BY id DESC LIMIT ?, ? ";
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("ii", $inicio, $por_pagina);
							$stmt->execute();
							$result = $stmt->get_result();

							$paginas = ceil($total_registros/$por_pagina);


						?>
						<span class ="tableHeader"><?php echo $pagina?>.- Registros totales <?php echo $total_registros?> 
						<button class="btn-primary" id = 'csv'>Descargar Pag CSV</button> 
						<button class="btn-primary" id = 'allcsv' >Descargar Todo CSV</button> 
						</span> 
						
						<table class="table">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Nombre Cliente</th>
									<th scope="col">Nombre Asesor</th>
									<th scope="col">Fecha</th>
									<th scope="col">Hora de Ingreso</th>
									<th scope="col">Hora de Salida</th>
									<th scope="col">Duracion</th>
									<th scope="col">Agua</th>
									<th scope="col">Filtro</th>
									<th scope="col">Quimicos</th>
									<th scope="col">Necesidades</th>
									<th scope="col">Productos</th>
									<th scope="col">Observaciones</th>
									<th scope="col">Fotos</th>

									
								</tr>
							</thead>

							<tbody>
								<?php
								while ($visitas = $result->fetch_assoc()) {
									$id = $visitas['id'];
									$nombre_cliente = ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $visitas['cliente_nombre'])))).' '.ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $visitas['cliente_apellido']))));
									$nombre_persona = ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $visitas['persona_nombre'])))).' '.ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $visitas['persona_apellido']))));
									$fecha = $visitas['fecha'];
									$hora_ingreso = $visitas['hora_ingreso'];
									$hora_salida = $visitas['hora_salida'];
									$tiempo_visita = $visitas['tiempo_visita'];
									$agua = $visitas['agua'];
									$filtro = $visitas['filtro'];
									$quimicos = $visitas['quimicos'];
									$necesidades = $visitas['necesita_productos'];
									$productos = $visitas['productos'];
									$observaciones = $visitas['observaciones'];
                                    $img1 = $visitas['img_1'];
                                    $img2 = $visitas['img_2'];
                                    $img3 = $visitas['img_3'];
								?>

									<tr>
										<th scope="row"><?php echo $id ?></th>
										<td><?php echo $nombre_cliente ?></td>
										<td><?php echo $nombre_persona ?></td>
										<td><?php echo $fecha; ?></td>
										<td><?php echo $hora_ingreso; ?></td>
										<td><?php echo $hora_salida; ?></td>
										<td><?php echo $tiempo_visita ?></td>
										<td><?php echo $agua ?></td>
										<td><?php echo $filtro; ?></td>
										<td><?php echo $quimicos ?></td>
										<td><?php echo $necesidades ?></td>
										<td><?php echo $productos ?></td>
										<td><?php echo $observaciones ?></td>
										<td>
                                        <button type="button" id = "view" class="btn btn-primary view" style="background-color: #53c4da; border: none" data-id = "<?php echo $id; ?>" style ="font-size: 12px"> <strong>Ver</strong> </button>
                                        </td>
										
									</tr>

								<?php
								}
								
								?>


                            </tbody>
                        </table>
                    </div>
                    <div class = 'img_view' style="display: none">
                        <button type="button" id= "closeview" class="btn btn-danger" style="border: none"value = "" style ="font-size: 12px"> <strong>X</strong></button>
						<div id="slider-container" class="">	
					
						</div>
                        <div class='next'>></div>
                        <div class='prev'><</div>
                    </div>

             
						<nav aria-label="Page navigation example" style="padding-top: 20px">
							<ul class="pagination justify-content-center">
								<li class="page-item">
								<a class="page-link" href="?num=<?php echo ($paginas >= $pagina) ? $pagina-1 : $pagina; ?>" tabindex="-1">Previous</a>
								</li>
								<!-- <?php 
									// for ($i = 1; $i <= $paginas; $i++) {
									// 	echo "<li class='page-item'><a class='page-link' href='?num=$i'>$i</a></li>";
									// }
								?> -->
								<li class="page-item">
								<a class="page-link" href="?num=<?php echo ($pagina < $paginas) ? $pagina+1 : $pagina; ?>">Next</a>
								</li>
							</ul>
							
						</nav>

				</div>
				
			</div>
	</div>
				<?php
					
				?>
	<!-- Contact End -->
	</main>
	<!-- Main End -->



	<script>

		let btnClose = document.getElementById('closeview');
		let imagenContainer = document.getElementsByClassName('img_view')[0]
		let nav = document.getElementsByClassName('navbar')[0];

		btnClose.addEventListener('click', function() {
			imagenContainer.style.display = 'none';
			nav.style.display = 'flex';
		});

		$(document).ready(function() {
			$('.view').on('click', function() {
				console.log('click')
				imagenContainer.style.display = 'flex';
				nav.style.display = 'none';
				
				const id = $(this).data('id');

				$.ajax({
					url: '../../app/obtener_imagenes.php',
					
					type: 'GET',
					data: { id: id },
					dataType: 'json',
					success: function(data) {

						modal = `
										<img src="../../../${data[0]}" class="imgSlider" alt="" style='max-width: 80vw; max-height: 80vh;'>
										<img src="../../../${data[1]}" class="imgSlider" alt="" style='max-width: 80vw; max-height: 80vh; display:none'>
										<img src="../../../${data[2]}" class="imgSlider" alt="" style='max-width: 80vw; max-height: 80vh; display:none'>
										<img src="../../../${data[3]}" class="imgSlider" alt="" style='max-width: 80vw; max-height: 80vh; display:none'>
									`
						$('#slider-container').html(modal);
					},
					error: function(error) {
						console.error('Error al cargar imágenes:', error);
					}
				});
			});

			$("#csv").click(function() {
				// Obtener la tabla HTML
				var table = $(".table")[0];

				// Crear un array para almacenar los datos
				var data = [];

				// Recorrer las filas de la tabla
				$(table).find("tr").each(function() {
					var rowData = [];

					// Recorrer las celdas de la fila actual
					$(this).find("td, th").each(function() {
						// Verificar si la celda contiene un botón
						if ($(this).find("button").length === 0) {
							// Obtener el contenido de la celda
							var cellContent = $(this).text();

							// Si la celda contiene comas, enciérrela entre comillas dobles
							if (cellContent.indexOf(",") !== -1) {
								cellContent = '"' + cellContent + '"';
							}

							// Agregar el contenido de la celda al array
							rowData.push(cellContent);
						}
					});

					// Agregar la fila al array de datos
					data.push(rowData.join(","));
				});

				// Crear un archivo CSV
				var csvContent = "data:text/csv;charset=utf-8," + data.join("\n");

				// Crear un enlace de descarga
				var encodedUri = encodeURI(csvContent);
				var link = document.createElement("a");
				link.setAttribute("href", encodedUri);
				link.setAttribute("download", "tabla.csv");

				// Simular un clic en el enlace para iniciar la descarga
				link.click();
			});


			$("#allcsv").click(function() {
			// Realizar una solicitud AJAX al servidor para obtener el archivo CSV
			$.ajax({
				url: "../../app/exportar_csv.php", // Ruta a tu script PHP que genera el CSV completo
				type: "GET",
				success: function(data) {
				// 'data' debe contener el contenido del archivo CSV generado en el servidor
				var csvContent = "data:text/csv;charset=utf-8," + encodeURIComponent(data);

				// Crear un enlace temporal para descargar el archivo CSV
				var link = document.createElement("a");
				link.setAttribute("href", csvContent);
				link.setAttribute("download", "tabla_completa.csv");
				document.body.appendChild(link);

				// Simular un clic en el enlace para iniciar la descarga
				link.click();

				// Eliminar el enlace temporal
				document.body.removeChild(link);
				},
				error: function(error) {
				console.error("Error al descargar el archivo CSV:", error);
				}
			});
			});

		});



		// Obtener todas las imágenes en el slider
		const sliderImages = document.getElementsByClassName('imgSlider');
		let currentImageIndex = 0;

		document.querySelector('.next').addEventListener('click', () => {
			console.log(sliderImages[currentImageIndex])
			sliderImages[currentImageIndex].style.display = 'none';
			currentImageIndex = (currentImageIndex + 1) % sliderImages.length;
			sliderImages[currentImageIndex].style.display = 'block';
		});

		document.querySelector('.prev').addEventListener('click', () => {
			sliderImages[currentImageIndex].style.display = 'none';
			currentImageIndex = (currentImageIndex - 1 + sliderImages.length) % sliderImages.length;
			sliderImages[currentImageIndex].style.display = 'block';
		});


	</script>

<?php require '../../partials/footer.php'; ?>