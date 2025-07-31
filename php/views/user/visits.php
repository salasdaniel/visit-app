<?php

require '../../config/user_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../config/connection.php';


if (isset($_SESSION['upload_error'])) {

	switch ($_SESSION['upload_error']) {
		case 1:
			echo "<script>
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Error uploading files...',
					})
				 </script>";
			break;
		case 0:
			echo "<script>
					Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: 'Data has been sent successfully to the database',
					showConfirmButton: false,
					timer: 1500
					})

					setTimeout(function(){
						window.location.href = 'logout.php';
					}, 2000);
				</script>";
			break;
	}

	unset($_SESSION['upload_error']);
}

// PostgreSQL query to get all products
$query = "SELECT * FROM products ORDER BY name ASC";
$result = pg_query($conn, $query);

if (!$result) {
	die('Database error: ' . pg_last_error($conn));
}


?>

<!-- Main -->
<main>
	<div class="contact container" style="padding-bottom:0; flex: 1;">
		<!-- Check-in Card -->
		<div class="card mb-0">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong><i class="fa fa-camera mr-2"></i>1. Check-in</strong>

			</div>
			<div class="card-body collapse show" id="checkinCardBody">
				<p class="text-muted mb-3">Attach photo to continue</p>
				<form method="POST" id="contactForm" name="contactForm" action="../../app/add_visit.php" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="img1">Before - Pool Photo</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="img1" name="img1" accept=".jpg, .jpeg, .png" required>
								<label class="custom-file-label " for="img1" style = "overflow: hidden;">Choose file...</label>
							</div>
							<small class="form-text text-muted">Only jpg, jpeg, png formats allowed. Max 1MB.</small>
						</div>
					</div>
			</div>
		</div>

		<!-- Visit Data Card -->
		<div class="card mb-0" id="section2" style="display: none;">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong><i class="fa fa-clipboard-list mr-2"></i>2. Visit Data</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#visitDataCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse show" id="visitDataCardBody">
				<div class="form-row">
					<div class="form-group col-12 col-md-4">
						<label for="question_1">Did you leave water filling?</label>
						<select class="form-control" name="question_1" required>
							<option disabled selected value=''>Select an option...</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</div>
					<div class="form-group col-12 col-md-4">
						<label for="question_2">Did you leave the pool filtering?</label>
						<select class="form-control" name="question_2" required>
							<option disabled selected value=''>Select an option...</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</div>
					<div class="form-group col-12 col-md-4">
						<label for="question_3">Did you add chemicals?</label>
						<select class="form-control" name="question_3" required>
							<option disabled selected value=''>Select an option...</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<!-- Photographic Records Card -->
		<div class="card mb-0" id="section3" style="display: none;">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong><i class="fa fa-images mr-2"></i>3. Photographic Records</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#photoCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse show" id="photoCardBody">
				<p class="text-muted mb-3">Only jpg, png, pdf formats, max. 1Mb.</p>
				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="inputGroupFile02">After - Pool</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="inputGroupFile02" name="img2" accept=".jpg, .jpeg, .png" required>
							<label class="custom-file-label " for="inputGroupFile02" style = "overflow: hidden;">Choose file...</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="inputGroupFile03">Chemical Level Tester</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="inputGroupFile03" name="img3" accept=".jpg, .jpeg, .png" required>
							<label class="custom-file-label " for="inputGroupFile03" style = "overflow: hidden;">Choose file...</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="inputGroupFile04">Machine Room</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="inputGroupFile04" name="img4" accept=".jpg, .jpeg, .png" required>
							<label class="custom-file-label" for="inputGroupFile04" style = "overflow: hidden;">Choose file...</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Client Needs Card -->
		<div class="card mb-0" id="section4" style="display: none;">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong><i class="fa fa-shopping-cart mr-2"></i>4. Client Needs</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#clientNeedsCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse show" id="clientNeedsCardBody">
				<div class="form-row">
					<div class="form-group col-md-12">
						<label for="product">The customer needs products?</label>
						<select class="form-control" name="question_4" id="products" required>
							<option selected disabled value=''>Select an option...</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						</select>
					</div>
				</div>


				<div class="" style="display:none" id="listcontainer">
					<input type="hidden" name="quantity" id="quantity" value="0">

					<div class="mb-3 p-2 bg-light rounded">
						<small class="text-muted">
							<i class="fa fa-info-circle mr-1"></i>
							<span id="selected-count">0 products selected</span> | 
							<span class="text-success">Only selected products will be sent</span>
						</small>
					</div>

					<?php
					while ($products = pg_fetch_assoc($result)) {
						$id = $products['id'];
						$name = $products['name'];
					?>
						<div class="flex-row align-items-center py-2 border-bottom">
							<div style="display: flex; justify-content: space-between; align-items: center;">
								<span class="product-name"><?php echo htmlspecialchars($name) ?></span>
								<input type="hidden" name="product<?php echo $id ?>" value="<?php echo htmlspecialchars($name) ?>">
								<!-- <small class="text-muted qty-display">0 qty</small> -->

								<!-- </div>
							<div class="col-md-3"> -->
								<div class="input-group input-group-sm" style="max-width: 80px; max-height: 31px">
									<div class="input-group-prepend">
										<button class="btn btn-primary btn-decrease" type="button" data-product="<?php echo $id ?>">
											<i class="fa fa-minus"></i>
										</button>
									</div>
									<input type="number" class="form-control text-center product-quantity" style="font-size: 12px;"
										value="0" min="0" max="999"
										name="quantity<?php echo $id ?>"
										data-product="<?php echo $id ?>">
									<div class="input-group-append">
										<button class="btn btn-primary btn-increase" type="button" data-product="<?php echo $id ?>">
											<i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
							</div>

						</div>
					<?php } ?>
				</div>


				<div style="display:none; margin-top: 30px" id="textarea">
					<div class="form-group">
						<label for="observations"><i class="fa fa-comment mr-2"></i>Does the client need other services or products?</label>
						<textarea name="observations" id="observations" cols="30" rows="4" class="form-control" placeholder="Example: Hoses, pipes, nets, vacuum cleaner.."></textarea>
					</div>
				</div>

			</div>

			<!-- Submit Card -->
			<div class="card mb-0" id="btn" style="display: none;">
				<div class="card-header bg-primary text-white">
					<strong><i class="fa fa-paper-plane mr-2"></i>Submit Visit Report</strong>
				</div>
				<div class="card-body text-center">
					<p class="text-muted mb-3">Review all information and submit your visit report</p>
					<button type="submit" name="submit" class="btn btn-primary btn-lg">
						<i class="fa fa-paper-plane mr-2"></i>Submit
					</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php require '../../partials/footer.php'; ?>
</main>

<script>
	$(document).ready(function() {
		// Toggle card content functionality (from clients.php)


		// Products selection functionality
		$("#products").change(function(e) {
			console.log(this.value)
			if (this.value == 'true') {
				console.log(this.value)
				$("#listcontainer").slideDown(500)
				$("#textarea").slideDown(500)
			} else {
				$("#listcontainer").slideUp(500)
				$("#textarea").slideUp(500)
			}
		})

		// Custom file input styling with filename display
		var customFileInputs = document.querySelectorAll(".custom-file-input");
		customFileInputs.forEach(function(input) {
			input.addEventListener("change", function() {
				if (this.files.length > 0) {
					console.log('file selected');
					var customFileLabel = this.nextElementSibling;
					customFileLabel.style.backgroundColor = "#c3e6cb";
					customFileLabel.textContent = this.files[0].name;
				} else {
					var customFileLabel = this.nextElementSibling;
					customFileLabel.style.backgroundColor = "";
					customFileLabel.textContent = "Choose file...";
				}
			});
		});

		// Progressive form reveal on first image upload
		$('#img1').change(function(input) {
			$('#section2').slideDown(500)
			$('#section3').slideDown(500)
			$('#section4').slideDown(500)
			$('#btn').slideDown(500)
		})

		// Quantity increment/decrement buttons (improved functionality)
		$(document).on('click', '.btn-increase, .btn-decrease', function(event) {
			event.preventDefault();

			const productId = $(this).data('product');
			const $input = $(`.product-quantity[data-product="${productId}"]`);
			const $qtyDisplay = $(this).closest('.row').find('.qty-display');

			let currentValue = parseInt($input.val()) || 0;

			if ($(this).hasClass('btn-increase')) {
				currentValue++;
			} else if ($(this).hasClass('btn-decrease') && currentValue > 0) {
				currentValue--;
			}

			// Update input value
			$input.val(currentValue);

			// Update quantity display
			$qtyDisplay.text(currentValue + ' qty');

			// Visual feedback for selected products
			const $row = $(this).closest('.row');
			if (currentValue > 0) {
				$row.addClass('table-active').removeClass('border-bottom').addClass('border-primary');
				$input.removeClass('border-secondary').addClass('border-primary');
			} else {
				$row.removeClass('table-active border-primary').addClass('border-bottom');
				$input.removeClass('border-primary').addClass('border-secondary');
			}

			// Update selected products counter
			updateSelectedProductsCounter();
		});

		// Allow manual input in quantity fields
		$(document).on('input', '.product-quantity', function() {
			const $input = $(this);
			const $qtyDisplay = $input.closest('.row').find('.qty-display');
			const value = parseInt($input.val()) || 0;

			// Ensure value is within bounds
			if (value < 0) $input.val(0);
			if (value > 999) $input.val(999);

			const finalValue = parseInt($input.val()) || 0;
			$qtyDisplay.text(finalValue + ' qty');

			// Visual feedback
			const $row = $input.closest('.row');
			if (finalValue > 0) {
				$row.addClass('table-active').removeClass('border-bottom').addClass('border-primary');
				$input.removeClass('border-secondary').addClass('border-primary');
			} else {
				$row.removeClass('table-active border-primary').addClass('border-bottom');
				$input.removeClass('border-primary').addClass('border-secondary');
			}

			// Update selected products counter
			updateSelectedProductsCounter();
		});

		// Function to update selected products counter
		function updateSelectedProductsCounter() {
			const selectedCount = $('.product-quantity').filter(function() {
				return parseInt($(this).val()) > 0;
			}).length;
			
			const text = selectedCount === 1 ? '1 product selected' : `${selectedCount} products selected`;
			$('#selected-count').text(text);
			
			// Update visual indicator
			if (selectedCount > 0) {
				$('#selected-count').removeClass('text-muted').addClass('text-primary');
			} else {
				$('#selected-count').removeClass('text-primary').addClass('text-muted');
			}
		}

		// Optimize form submission - send all products but only log selected ones
		$('#contactForm').on('submit', function(e) {
			console.log('Form submission starting...');
			
			// Get all product quantity inputs
			const productInputs = $('.product-quantity');
			let selectedProducts = [];
			
			productInputs.each(function() {
				const quantity = parseInt($(this).val()) || 0;
				const productId = $(this).data('product');
				
				if (quantity > 0) {
					selectedProducts.push({
						id: productId,
						quantity: quantity,
						name: $(`input[name="product${productId}"]`).val()
					});
				}
				// Don't remove any inputs - let server handle filtering
			});
			
			console.log('Selected products for submission:', selectedProducts);
			console.log(`Total products: ${productInputs.length}, Selected: ${selectedProducts.length}`);
			
			// Continue with normal form submission
			return true;
		});
	});
</script>
<!-- Main End -->
<?php
// Close PostgreSQL connection
pg_close($conn);

?>