<?php

require './php/partials/head.php';
session_start();

if (isset($_SESSION['error'])) {

	echo "<script>
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'The entered document is not found in the database...',
			})
		</script>";

	session_destroy();
}

if (isset($_SESSION['role'])) {
	if ($_SESSION['role'] == 2) {
		header("Location: php/views/user/qr.php");
	} elseif ($_SESSION['role'] == 2) {
		header("Location: php/views/admin/admin.php");
	}
}
?>
<!-- Main -->
<main>
	<div class="contact py-5" style="min-height: 85vh; display: flex; align-items: center;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<!-- Card: Login Form -->
					<div class="card">
						<div class="card-header bg-dark text-white">
							<strong>Welcome to Visit App</strong>
						</div>
						<div class="card-body">
							<p class="mb-4">To log in, please enter your ID number.</p>
							<form method="POST" id="contactForm" name="contactForm" action="php/app/login.php">
								<div class="form-group d-flex align-items-end" style="gap: 10px;">
									<div class="flex-grow-1">
										<label for="ci">Document Number</label>
										<input id="ci" name="ci" type="number" class="form-control" required>
									</div>
									<button type="submit" name="submit" class="btn btn-primary"
										style="height: 35px;">
										Submit <i class="fa fa-paper-plane ml-2"></i>
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- End Card -->
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Main End -->

<?php require './php/partials/footer.php'; ?>