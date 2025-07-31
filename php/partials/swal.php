<?php
if (isset($_SESSION['msg'])) {
	$respuesta = $_SESSION['msg'];

	switch ($_SESSION['msg_code']) {
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
								title: '¡Success!',
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
					title: 'Record deleted successfully',
					showConfirmButton: false,
					timer: 1500
				})
			</script>";
}

unset($_SESSION['deleted']);
unset($_SESSION['msg']);
unset($_SESSION['msg_code']);

?>