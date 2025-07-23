
<?php
	
	require '../../config/user_validation.php';
	require '../../partials/head.php';
	require '../../partials/subheader.php';
	require '../../config/conexion.php';


	if (isset($_SESSION['upload_error'])) {
	

		switch ($_SESSION['upload_error']) {
			case 1:
				echo "<script>
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: 'Error al cargas los archivos...',
								})
						</script>";
				break;
			case 0:
				echo "<script>
								Swal.fire({
								icon: 'success',
								title: '¡Éxito!',
								text: 'Los datos se han enviado correctamente a la base de datos',
								showConfirmButton: false,
								timer: 1500
								})

								setTimeout(function(){
									window.location.href = 'logout.php';			
								}, 2000)

						</script>";
				break;
		}

		unset($_SESSION['upload_error']);
	}

	$sql = "SELECT *
			FROM productos ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();


	?>

		<!-- Main -->
		<main style="display: flex; justify-content: center">
			<!-- Contact  -->
			<!-- Form -->
			<div class="cent">
					<form method="POST" class = ' cent pb20' id="contactForm" name="contactForm" action="../../app/add_formulario.php" class="cent" enctype="multipart/form-data">
						
						
						</div>
						<div class="col-lg-8 m0" style = "margin-bottom: 100px; margin-top: 50px;">
							<!-- Personal Details -->
							<div class="row box first">
								<div class="box-header">
									<h3><strong>1</strong>Check-in</h3>
									<p>Adjuntar foto para continuar</p>
								</div>
								
								<div class="col-12">
									<div class="input-group mb-3">
										<div class="custom-file ">
											<input type="file" class="custom-file-input" id="img1" style = "cursor: pointer" name="img1" accept=".jpg, .jpeg, .png " required>
											<label class="custom-file-label imginput" for="img1">Antes - piscina</label>
										</div>
									</div>
								</div>
							</div>

							<div class="row box first" id="seccion2" style="display: none;">

								<div class="box-header">
									<h3><strong>2</strong>Datos de la visita</h3>
									<p></p>
								</div>

								<div class="col-12">
									<div class="form-group cent">
										
									
										<select  class="nice-select" name="pregunta_1" style="width: 100%;" required>
											<option disabled selected value=''>¿Dejó cargando agua?</option>
											<option value="si">Sí</option>
											<option value="no">No</option>
										</select>
									</div>
								</div>
								
								<div class="col-12">
									<div class="form-group cent">
									
										<select  class="nice-select" name="pregunta_2" style="width: 100%;" required>
											<option disabled selected value=''>¿Dejó filtrando la piscina?</option>
											<option value="si">Sí</option>
											<option value="no">No</option>
										</select>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group cent">
										<select  class="nice-select" name="pregunta_3" style="width: 100%;" required>
											<option disabled selected value=''>¿Hizo puesta de químicos?</option>
											<option value="si">Sí</option>
											<option value="no">No</option>
										</select>
									</div>
								</div>
							
							</div>
							<!-- Personal Details End -->
							<!-- Subject -->
							<div class="row box" id="seccion3" style="display: none;">
								<div class="box-header">
									<h3><strong>3</strong>Registros fotográficos</h3>
									<p>Solo formatos jpg, png, pdf, max. 1Mb.</p>
								</div>
								<div class ="cent" style="width: 100%; padding: 7px">
									
									<div class="input-group mb-3">
											
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile02" style = "cursor: pointer" name="img2" accept=".jpg, .jpeg, .png " required>
												<label class="custom-file-label imginput" for="inputGroupFile01">Despues - piscina</label>
											</div>

									</div>
									<div class="input-group mb-3">
											
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile03" style = "cursor: pointer" name="img3" accept=".jpg, .jpeg, .png " required>
												<label class="custom-file-label imginput" for="inputGroupFile01">Testeador de niveles químicos</label>
											</div>
									</div>
									<div class="input-group mb-3">
											
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile04" style = "cursor: pointer" name="img4" accept=".jpg, .jpeg, .png " required>
												<label class="custom-file-label imginput" for="inputGroupFile01">Sala de máquinas</label>
											</div>
									</div>

								 <!-- NUEVOS CAMPOS EN EL FORMULARIO -->
								 
								 
								</div>
								
								
							</div>
							<div class="row box" id="seccion4" style="display: none;">

							   <div class="box-header">
								   <h3><strong>4</strong>Necesidades del Cliente</h3>
								   <p></p>
							   </div>

							   <div class="col-12">
								   <div class="form-group cent">
									   <select  class="nice-select" name="pregunta_4" id="productos" style="width: 100%;" required>
										   <option selected disabled value =''>¿Necesita productos?</option>
										   <option value="si">Sí</option>
										   <option value="no">No</option>
									   </select>
								   </div>
							   </div>
							
<!-- 							   
							   <div class="col-12" style="display:none" id="listcontainer">
								   <div class="form-group cent">
										<label>Lista de productos</label>
										<select class="nice-select" name="productos[]" id="list" multiple style="width: 100%; height: 30vh; padding-top: 10px; margin: 0">
										
										<?php 
										// while ($productos = $result->fetch_assoc()){
										// 	$id = $productos['id'];
										// 	$nombre = $productos['nombre'];

										// 	echo "<option value='$nombre'>$nombre</option>";
										// };
										
										// $stmt->close();
    									// $conn->close();

										?>
										</select>
									</div>
								</div> -->

								<!-- <div class="col-12" style="display:none" id="listcontainer">
										<div class="form-group cent">
											<label>Lista de productos</label>
											<select class="nice-select" name="productos[]" id="list" multiple style="width: 100%; height: 30vh; padding-top: 10px; margin: 0">
											
											</select>
										</div>
									</div> -->

											
							   
							   <div class="col-12 " style="display:none" id="listcontainer">

								<input type="text" name = 'cant_productos' value="<?php echo $result->num_rows;?>" hidden>		
							   <?php 
								while ($productos = $result->fetch_assoc()){
									$id = $productos['id'];
									$nombre = $productos['nombre'];

								?>
								
								<div class="form-group d-flex" style='margin:0; background-color:none'>
									<input type="text" value="<?php echo $nombre ?>" readonly class="form-control"  style='background-color:white; border:none; border-bottom: 1px #ddd solid;' name="producto<?php echo $id?>">
									<input type="number" readonly value ='0' placeholder="Cant." class="form-control" tabindex="<?php echo $id?>"
									style='border:none; text-align: center; width:15%; padding: 0; background-color:white; border-bottom: 1px #ddd solid;' name = "cantidad<?php echo $id?>" >
									<button class="btn btn-primary" style="margin: 5px;background-color: #53c4da; border: none" tabindex="<?php echo $id?>">-</button>
									<button class="btn btn-primary" style="margin: 5px;background-color: #53c4da;border: none" tabindex="<?php echo $id?>">+</button>
								</div>

								<?php } ?>

								</div>


							   <div class="col-12" style="display:none; margin-top: 30px" id="textarea">
								   <div class="form-group cent">
										<label>¿El cliente necesita otros servicios o productos?</label>

										<textarea name="observaciones" id="observaciones" cols="30" rows="10"style="width: 100%; height: 20vh" class="nice-select" 
										placeholder="Ejemplo: Mangueras, tubos, mallas, aspiradora.."></textarea>
									</div>
								</div>

							</div>	
							<!-- Terms End -->
							<!-- Submit-->
							<div class="row box" id="btn" style="display: none;">
								<div class="col-12">
									<div class="form-group">
										<button type="submit" name="submit" class="btn-form-func">
											<span class="btn-form-func-content">Enviar</span>
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
	</div>
				
	<!-- Contact End -->
	</main>

	<script>
            
      $(document).ready(function() {

        // $("#list option").mousedown(function(e) {
          
        //   e.preventDefault();
        //   $(this).prop("selected", !$(this).prop("selected"));
        //       return false;
        // });
		

		
		$('#list').on('change', function() {
			const selectedOptions = Array.from(this.selectedOptions);
			
			selectedOptions.forEach(function(option) {
				const productId = option.value; // ID del producto
				const cantidad = prompt(`Ingrese la cantidad para ${option.textContent}`, 1);
				
				// Actualiza el texto de la opción seleccionada con la cantidad
				$(option).text(`${option.textContent} (Cant: ${cantidad})`);
				
				// Actualiza el valor (value) de la opción con el ID del producto
				$(option).val(`${productId}- Cant: ${cantidad}`);
				
				// Puedes hacer algo con el ID del producto y la cantidad aquí, como enviarlos a un servidor o mostrarlos en la página.
				console.log(`Producto ID: ${productId}, Cantidad: ${cantidad}`);

				
			});
		});
		

		$("#productos").change(function(e){

			console.log(this.value)

			if(this.value == 'si'){

				console.log(this.value)
				$("#listcontainer").slideDown(500)
				$("#textarea").slideDown(500)
			}else{
				$("#listcontainer").slideUp(500)
				$("#textarea").slideUp(500)
			}
		})

		var customFileInputs = document.querySelectorAll(".custom-file-input");

		customFileInputs.forEach(function(input) {
				input.addEventListener("change", function() {
					if (this.files.length > 0) {
						console.log('entra');
						var customFileLabel = this.nextElementSibling; // Encuentra el elemento .custom-file-label adyacente
						customFileLabel.style.backgroundColor = "#c3e6cb";
					} else {
						// Restaurar el fondo a su valor original si es necesario
						var customFileLabel = this.nextElementSibling;
						customFileLabel.style.backgroundColor = "";
					}
				});
			});

		});

		$('#img1').change(function(input){
			$('#seccion2').slideDown(500)
			$('#seccion3').slideDown(500)
			$('#seccion4').slideDown(500)
			$('#btn').slideDown(500)
		})

		$(".btn-primary").on("click", function(event) {
			event.preventDefault(); // Prevenir el envío del formulario

			var $input = $(this).siblings('input[type="number"]');
			var value = parseInt($input.val());

			if ($(this).text() === "+") {
				value++;
			} else if ($(this).text() === "-" && value > 0) {
				value--;
			}

			$input.val(value);
		});

   
    </script>
	<!-- Main End -->
	<?php require '../../partials/footer.php'; ?>