<?php

require './php/partials/head.php';
session_start();

if (isset($_SESSION['error'])) {

	echo "<script>
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'El documento ingresado, no se encuentra en base de datos...',
			})
		</script>";
	
	session_destroy();
}

if (isset($_SESSION['rol'])){
	if($_SESSION['rol'] == 2){
		header("Location: php/views/user/qr.php");
	}elseif($_SESSION['rol'] == 2){
		header("Location: php/views/admin/admin.php");
	}
}
?>
		<!-- Main -->
		<main>
			<!-- Contact  -->
			<div class="contact vh70" style="height: 85vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
				<div class="container">
					<!-- Form -->
					<form method="POST" id="contactForm" name="contactForm" action="php\app\login.php">
						<div class="row" style="display: flex; justify-content: center">
							<div class="col-lg-8" id="mainContent">
								<!-- aviso  -->
								
								<!-- Personal Details -->
								<div class="row box first">
									<div class="box-header">
										<h3 style="margin: 0px">Inicio Sesión</h3>
										<p>Para iniciar sesión ingrese su número de cédula.<br></p>
									</div>
								
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<input id="ci" class="form-control" name="ci" type="number" required/>
										</div>
									</div>
								</div>
								
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
							</div>
						
						</div>
					</form>
					<!-- Form End -->
				</div>
			</div>
			<!-- Contact End -->
		</main>
		<!-- Main End -->

<?php require './php/partials/footer.php'; ?>

