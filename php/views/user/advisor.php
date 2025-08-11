<?php

	require dirname(__DIR__, 2) . '/config/user_validation.php';
	require dirname(__DIR__, 2) . '/partials/head.php';
	require dirname(__DIR__, 2) . '/partials/subheader.php';
	require dirname(__DIR__, 2) . '/config/connection.php';
	require dirname(__DIR__, 2) . '/partials/swal.php';

	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$_SESSION['entry_time'] = date("H:i:s");
	$_SESSION['date'] = date("Y-m-d");

	// create cliuents array for JavaScript
	$customers_array = array();
	$query = "SELECT id, first_name, last_name FROM customers WHERE is_active = true ORDER BY first_name ASC";
	$result = pg_query($conn, $query);
	
	if ($result) {
		while ($user_info = pg_fetch_assoc($result)) {
			$id = $user_info['id'];
			$first_name= $user_info['first_name'];
			$last_name = $user_info['last_name'];
			$full_name = ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $first_name)))) . " " . ucfirst(strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $last_name))));
			
			$customers_array[] = array(
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
		<?php require dirname(__DIR__, 2) . '/partials/footer.php'; ?>
	</main>
	<!-- Main End -->



	<script>
		// JS customers array
		const customers = <?php echo json_encode($customers_array); ?>;
		
		// Toggle card content
		document.addEventListener('DOMContentLoaded', function() {
			

			// search
			const searchInput = document.getElementById('search_client');
			const searchResults = document.getElementById('search_results');
			const hiddenInput = document.getElementById('client_id');
			const submitBtn = document.getElementById('submit_btn');

			searchInput.addEventListener('input', function() {
				const query = this.value.toLowerCase().trim();
				
				// clean up results 
				if (query.length < 3) {
					searchResults.style.display = 'none';
					searchResults.innerHTML = '';
					hiddenInput.value = '';
					submitBtn.disabled = true;
					return;
				}

				// filter customers that match the search
				const matches = customers.filter(customer => 
					customer.search_text.includes(query)
				);

				// show results
				if (matches.length > 0) {
					searchResults.innerHTML = '';
					matches.forEach(customer => {
						const item = document.createElement('button');
						item.type = 'button';
						item.className = 'list-group-item list-group-item-action';
						item.textContent = customer.full_name;
						item.addEventListener('click', function() {
							searchInput.value = customer.full_name;
							hiddenInput.value = customer.id;
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

			// hide results when clicking outside
			document.addEventListener('click', function(event) {
				if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
					searchResults.style.display = 'none';
				}
			});
		});
	</script>
