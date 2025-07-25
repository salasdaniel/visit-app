<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';



$_SESSION['user_id'];
$_SESSION['first_name'];
$_SESSION['last_name'];
$_SESSION['document'];
$_SESSION['role'];

$full_name = ucfirst(strtolower($_SESSION['first_name'])) . " " . ucfirst(strtolower($_SESSION['last_name']));

?>

<!-- Main -->
<main class="d-flex flex-column" style="min-height: 92vh;">
	<div class="contact py-5 flex-grow-1">
		<div class="container">

			<div class="row justify-content-center mb-4">
				<div class="col-lg-10 py-5" >
					<h2 class="display-4 text-left ">
						Welcome <?php echo $full_name ?>!
					</h2>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="card">
						<div class="card-header bg-dark text-white">
							<strong>Dashboard</strong>
						</div>
						<div class="card-body">

							<div class="row text-center">
								<div class="col-md-4 mb-4">
									<a href="users.php" target="_parent" class="text-decoration-none text-dark">
										<div class="border rounded p-4 h-100 bg-light transition-hover">
											<i class="icon icon-map-marker fa-2x mb-2 d-block"></i>
											<h5 class="font-weight-bold">Users</h5>
											<p class="mb-0">Add, remove or view users</p>
										</div>
									</a>
								</div>
								<div class="col-md-4 mb-4">
									<a href="clients.php" class="text-decoration-none text-dark">
										<div class="border rounded p-4 h-100 bg-light transition-hover">
											<i class="icon icon-envelope fa-2x mb-2 d-block"></i>
											<h5 class="font-weight-bold">Clients</h5>
											<p class="mb-0">Add, remove or view clients</p>
										</div>
									</a>
								</div>
								<div class="col-md-4 mb-4">
									<a href="visits.php" class="text-decoration-none text-dark">
										<div class="border rounded p-4 h-100 bg-light transition-hover">
											<i class="icon icon-phone-call2 fa-2x mb-2 d-block"></i>
											<h5 class="font-weight-bold">Visits</h5>
											<p class="mb-0">View visits</p>
										</div>
									</a>
								</div>
							</div>

						</div> <!-- /.card-body -->
					</div> <!-- /.card -->
				</div> <!-- /.col -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</div> <!-- /.contact -->

	
</main>

<!-- Estilo de efecto hover -->
<style>
	.transition-hover {
		transition: box-shadow 0.3s ease-in-out;
	}
	.transition-hover:hover {
		box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
	}
</style>


<!-- Main End -->

<?php require '../../partials/footer.php'; ?>