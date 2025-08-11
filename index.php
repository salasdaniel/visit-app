<?php
session_start();
require './php/partials/head.php';

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

<style>
/* Remove modal backdrop */
.modal-backdrop {
    display: none !important;
}

/* Ensure modal is visible without backdrop */
.modal.show {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>

<!-- Main -->
<main class="vh-100">
	<div class="contact py-5" style="min-height: 85vh; display: flex; align-items: center;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<!-- Card: Login Form -->
					<div class="card">
						<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
							<strong>Welcome to Visit App</strong>
							<button type="button" class="btn btn-outline-light btn-sm" data-toggle="modal" data-target="#howToTestModal">
								<i class="fa fa-question-circle mr-1"></i>How to test it?
							</button>
						</div>
						<div class="card-body">
							<p class="mb-4">To log in, please enter your ID number.</p>
							<form method="POST" id="contactForm" name="contactForm" action="php/app/login.php">
								<div class="form-group d-flex align-items-end" style="gap: 10px;">
									<div class="flex-grow-1">
										<label for="document">Document Number</label>
										<input id="document" name="document" type="number" class="form-control" required>
									</div>
									<button type="submit" name="submit" class="btn btn-primary"
										style="height: 35px;">
										Submit <i class="fa fa-paper-plane ml-2"></i>
									</button>
								</div>
							</form>
							
							<!-- Link to README -->
							<div class="text-center mt-3">
								<small class="text-muted">
									<i class="fa fa-download mr-1"></i>
									For more info <a href="README.md" download class="text-primary">download README.md</a>
								</small>
							</div>
						</div>
					</div>
					<!-- End Card -->
				</div>
			</div>
		</div>
	</div>
	
	<!-- How to Test Modal -->
	<div class="modal fade" id="howToTestModal" tabindex="-1" role="dialog" aria-labelledby="howToTestModalLabel" aria-hidden="true" data-backdrop="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header bg-dark text-white">
					<h5 class="modal-title text-white" id="howToTestModalLabel">
						<i class="fa fa-question-circle mr-2"></i>How to Test the Application
					</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<!-- Administrative Role -->
							<div class="card mb-4">
								<div class="card-header bg-primary text-white">
									<h6 class="mb-0 text-white"><i class="fa fa-user-shield mr-2"></i>Administrative Role</h6>
								</div>
								<div class="card-body">
									<p class="mb-2"><strong>Login</strong> with <span class="badge badge-info">12345678</span></p>
									<ul class="mb-0">
										<li><strong>Add/view/edit records:</strong> Select the section you want to manage: users, clients, products. In each section you can create, edit, deactivate and bulk load.</li>
										<li><strong>Bulk data:</strong> In products and clients view, download the Bulk Example fill it with required data and upload it.</li>
										<li><strong>Reports:</strong> In all sections you'll find tables with database records.</li>
										<li class="text-muted"><small>Feel free to explore the application and test its features. :)</small></li>
									</ul>
								</div>
							</div>
							
							<!-- Advisor Role -->
							<div class="card mb-4">
								<div class="card-header bg-primary text-white">
									<h6 class="mb-0 text-white"><i class="fa fa-user mr-2"></i>Advisor Role</h6>
								</div>
								<div class="card-body">
									<p class="mb-2"><strong>Login</strong> with <span class="badge badge-info">87654321</span> <small class="text-muted">(optimized for mobile)</small></p>
									<ul class="mb-0">
										<li><strong>Mark entry/exit:</strong> <a href="img/qr.jpeg" download class="text-primary">Download QR code</a> and scan it</li>
										<li><strong>Form:</strong> Complete the visit form, photographic records are required.</li>
										<li><strong>WhatsApp message:</strong> For this environment Ultramsg is inactive for security reasons.</li>
									</ul>
								</div>
							</div>
							
							<!-- Additional Info -->
							<div class="alert alert-info">
								<i class="fa fa-info-circle mr-2"></i>
								<strong>Need more details?</strong> 
								<a href="README.md" download class="text-primary">Download README.md</a> for complete documentation.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times mr-1"></i>Close
					</button>
				</div>
			</div>
		</div>
	</div>
	
	<?php require './php/partials/footer.php'; ?>
</main>

<!-- Main End -->
