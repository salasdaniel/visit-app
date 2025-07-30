<?php

	require '../../config/user_validation.php';
	require '../../partials/head.php';
	require '../../partials/subheader.php';
	require '../../config/connection.php';
	require '../../partials/swal.php';

	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$_SESSION['entry_time'] = date("H:i:s");
	$_SESSION['date'] = date("Y-m-d");

	// Crear array de clientes para JavaScript
	$clientes_array = array();
	$query = "SELECT id, nombre, apellido FROM clientes WHERE activo = true ORDER BY nombre ASC";
	$result = pg_query($conn, $query);
	
	if ($result) {
		while ($info_usuario = pg_fetch_assoc($result)) {
			$id = $info_usuario['id'];
			$first_name= $info_usuario['nombre'];
			$last_name = $info_usuario['apellido'];
			$full_name = ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $first_name)))) . " " . ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $last_name))));
			
			$clientes_array[] = array(
				'id' => $id,
				'full_name' => $full_name,
				'search_text' => strtolower($full_name)
			);
		}
	}
	pg_close($conn);

	?>

	<!-- Main -->
	<main>
		<div class="contact container" style="padding-bottom:0; flex: 1;">
			<!-- Search Client Card -->
			<div class="card mb-0">
				<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
					<strong>Search Clients</strong>
					
				</div>
				<div class="card-body collapse show" id="searchClientCardBody">
					<form method="POST" id="contactForm" name="contactForm" action="../../app/check_client.php">
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="search_client">Search and select a client</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" id="search_client" placeholder="Type at least 3 letters to search..." autocomplete="off">
									<div class="input-group-append">
										<button type="submit" name="submit" class="btn btn-primary" id="submit_btn" >
											<i class="fa fa-paper-plane mr-2"></i>Submit
										</button>
									</div>
								</div>
								<input type="hidden" name="client_id" id="client_id" required>
								<div id="search_results" class="list-group" style="display: none; max-height: 200px; overflow-y: auto; position: absolute; z-index: 1000; width: calc(100% - 30px); top: 66px"></div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<!-- Add Client Section -->
			
		</div>
		<?php require '../../partials/footer.php'; ?>
	</main>
	<!-- Main End -->

	


	<script>
		// Array de clientes desde PHP
		const clientes = <?php echo json_encode($clientes_array); ?>;
		
		// Toggle card content
		document.addEventListener('DOMContentLoaded', function() {
			

			// Funcionalidad de búsqueda de clientes
			const searchInput = document.getElementById('search_client');
			const searchResults = document.getElementById('search_results');
			const hiddenInput = document.getElementById('client_id');
			const submitBtn = document.getElementById('submit_btn');

			searchInput.addEventListener('input', function() {
				const query = this.value.toLowerCase().trim();
				
				// Limpiar resultados si hay menos de 3 caracteres
				if (query.length < 3) {
					searchResults.style.display = 'none';
					searchResults.innerHTML = '';
					hiddenInput.value = '';
					submitBtn.disabled = true;
					return;
				}

				// Filtrar clientes que coincidan con la búsqueda
				const matches = clientes.filter(cliente => 
					cliente.search_text.includes(query)
				);

				// Mostrar resultados
				if (matches.length > 0) {
					searchResults.innerHTML = '';
					matches.forEach(cliente => {
						const item = document.createElement('button');
						item.type = 'button';
						item.className = 'list-group-item list-group-item-action';
						item.textContent = cliente.full_name;
						item.addEventListener('click', function() {
							searchInput.value = cliente.full_name;
							hiddenInput.value = cliente.id;
							searchResults.style.display = 'none';
							submitBtn.disabled = false;
						});
						searchResults.appendChild(item);
					});
					searchResults.style.display = 'block';
				} else {
					searchResults.innerHTML = '<div class="list-group-item text-muted">No clients found</div>';
					searchResults.style.display = 'block';
					hiddenInput.value = '';
					submitBtn.disabled = true;
				}
			});

			// Ocultar resultados al hacer clic fuera
			document.addEventListener('click', function(event) {
				if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
					searchResults.style.display = 'none';
				}
			});
		});
	</script>
