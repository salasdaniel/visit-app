<?php
if (isset($_SESSION['msj'])) {
	$respuesta = $_SESSION['msj'];

	switch ($_SESSION['msj_code']) {
		case 0:
			echo "<script>
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: '$respuesta',
								})

								console.log('entra en 0');		
								console.log('$respuesta');

						</script>";
			break;
		case 1:
			echo "<script>
								Swal.fire({
								icon: 'success',
								title: '¡Éxito!',
								text: '$respuesta',
								showConfirmButton: false,
								timer: 1500
								})
								console.log('entra en 1');
								console.log('$respuesta');		
						</script>";
			break;
		case 2:
			echo "<script>
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: '$respuesta',
								})

								console.log('entra en 2');		
								console.log('$respuesta');		
							</script>";
			break;
	}
}

if (isset($_SESSION['deleted'])) {

	echo "<script>
		 
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'Registro eliminado con éxito',
					showConfirmButton: false,
					timer: 1500
				})
			</script>";
}

unset($_SESSION['deleted']);
unset($_SESSION['msj']);
unset($_SESSION['msj_code']);

?>