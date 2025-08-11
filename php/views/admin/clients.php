<?php

require dirname(__DIR__, 2) . '/config/admin_validation.php';
require dirname(__DIR__, 2) . '/partials/head.php';
require dirname(__DIR__, 2) . '/partials/subheader.php';
require dirname(__DIR__, 2) . '/partials/swal.php';
require dirname(__DIR__, 2) . '/config/connection.php';

// SweetAlert 

if (isset($_SESSION['msg']) && isset($_SESSION['msg_code'])) {
	echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
	if ($_SESSION['msg_code'] == 1) {
		echo '<script>
		Swal.fire({
			icon: "success",
			title: "Success",
			text: "' . addslashes($_SESSION['msg']) . '"
		});
		</script>';
	} else if ($_SESSION['msg_code'] == 2) {
		echo '<script>
		Swal.fire({
			icon: "warning",
			title: "Duplicate documents found",
			html: "' . addslashes($_SESSION['msg']) . '"
		});
		</script>';
	}
	unset($_SESSION['msg']);
	unset($_SESSION['msg_code']);
}


$sql = "SELECT * FROM customers ORDER BY id DESC";
$result = pg_query($conn, $sql);

$clients = [];
if ($result) {
	while ($user_info = pg_fetch_assoc($result)) {
		$clients[] = [
			'id' => $user_info['id'],
			'first_name' => ucfirst(strtolower($user_info['first_name'])),
			'last_name' => ucfirst(strtolower($user_info['last_name'])),
			'ruc' => $user_info['tax_id'],
			'phone' => $user_info['phone'],
			'address' => $user_info['address'],
			'plan' => $user_info['subscription_plan'],
			'observation' => $user_info['notes'],
			'active' => ($user_info['is_active'] === 't') ? 'Yes' : 'No'

		];
	}
}


?>
<!-- Main -->
<main>
	<div class="contact container" style="padding-bottom:0; flex: 1;">
		<!-- Form Card -->
		<div class="card mb-0">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong>Add a New Client</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#addClientCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse show" id="addClientCardBody">
				<form method="POST" id="contactForm" name="contactForm" action="../../app/add_client.php">
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="username">First Name</label>
							<input type="text" id="username" name="first_name" class="form-control" placeholder="John... " required pattern="^[a-zA-Z\s.]+$">
						</div>
						<div class="form-group col-md-3">
							<label for="apellido">Last Name</label>
							<input type="text" id="apellido" name="last_name" class="form-control" placeholder="Smith..." required>
						</div>
						<div class="form-group col-md-3">
							<label for="ruc">ID or Passport</label>
							<input type="text" id="ruc" name="tax_id" class="form-control" placeholder="202-555-0173 " required>
						</div>
						<div class="form-group col-md-3">
							<label for="phone">Contact Number</label>
							<input type="text" id="phone" name="phone" class="form-control" placeholder="+1 202-555-0173" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="direccion">Address</label>
							<input type="text" id="direccion" name="address" class="form-control" placeholder="742 Evergreen Terrace  Springfield, IL 62704  United States... " required>
						</div>
						<div class="form-group col-md-4">
							<label for="subjectList">Plan</label>
							<select id="subjectList" name="subscription_plan" class="form-control" required>
								<option disabled selected>Select a Plan</option>
								<?php
								$sql_plan = "SELECT * FROM plans";
								$result_plan = pg_query($conn, $sql_plan);
								while ($plan = pg_fetch_assoc($result_plan)) {
									$idplan =  $plan['id'];
									$plan_name =  $plan['name'];
									echo "<option value='$idplan'>$plan_name</option>";
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-4 ">
							<label for="hora" class="">Observations</label>
							<input type="text" id="hora" name="notes" class="form-control" placeholder="Visit on sunday..." required>

						</div>
						<div class="d-flex justify-content-end align-items-end w-100">
							<button type="submit" name="submit" class="btn btn-primary" style="height: 35px;">
								Register <i class="fa fa-paper-plane ml-2"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- Bulk Upload Section -->
		<div class="card mb-0">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong>Bulk Upload Clients</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#bulkUploadCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse" id="bulkUploadCardBody">
				<form action="../../app/bulk.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="inputGroupFile02">Attach .xls file</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="inputGroupFile02" name="excel_file" required>
							<label class="custom-file-label" for="inputGroupFile02">Choose file</label>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-primary mr-2">
							Process <i class="fa fa-paper-plane ml-2"></i>
						</button>
						<?php
						// Dynamic path for template download
						$template_path = ($_SERVER['HTTP_HOST'] === 'localhost:8080') ? '/docs/clients_template.xlsx' : BASE_URL . 'docs/clients_template.xlsx';
						?>
						<a href='<?php echo $template_path; ?>' class="btn btn-secondary">
							Download Template
						</a>
					</div>
					<div class="card-body">
						<strong>Instructions</strong>
						<ul>
							<li>1. Columns must follow the same order as the template.</li>
							<li>2. Plans must be specified as numbers: 1 for Gold, 2 for Silver, 3 for Bronze.</li>
							<li class="text-danger">You must follow the instructions exactly to load records into the database.</li>
						</ul>
					</div>
				</form>
			</div>
		</div>


		<!-- Clients List -->
		<?php if ($_SESSION['role'] == 1): ?>
			<div class="card mb-0">
				<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
					<strong>Clients List</strong>
					<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#clientsListCardBody"><i class="fa fa-chevron-down"></i></button>
				</div>
				<div class="card-body collapse show" id="clientsListCardBody">
					<div class="d-flex align-items-center gap-2 mb-3">
						<label for="recordsPerPage" class="mb-0 mr-2">Show</label>
						<select id="recordsPerPage" class="form-control mr-3" style="width: 90px;">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
						</select>
						<input type="text" id="tableSearch" class="form-control" placeholder="Search..." style="max-width: 250px;">
						<select id="activeFilter" class="form-control ml-2" style="width: 120px;">
							<option value="yes" selected>Active</option>
							<option value="no">Inactive</option>
							<option value="all">All</option>
						</select>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered table-hover text-center" id="clientsTable">
							<thead class="thead-light">
								<tr>
									<th class="text-center" onclick="sortTable(0)">ID <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(1)">First Name <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(2)">Last Name <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(3)">RUC <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(4)">Phone <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(5)">Address <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(6)">Plan <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(7)">Observation <i class="fa fa-sort"></i></th>
									<th class="text-center" onclick="sortTable(7)">Active <i class="fa fa-sort"></i></th>
									<th class="text-center">Delete</th>
									<th class="text-center">Edit</th>
								</tr>
							</thead>
							<tbody id="clientsTableBody">
								<!-- JS render -->
							</tbody>
						</table>
					</div>
					<nav aria-label="Page navigation example" class="mt-3">
						<ul class="pagination justify-content-center">
							<!-- JS render -->
						</ul>
					</nav>

					<script>

					</script>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php require '../../partials/footer.php'; ?>
</main>


<script>
	// Toggle card content
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelectorAll('.toggle-card').forEach(function(btn) {
			btn.addEventListener('click', function() {
				var target = document.querySelector(this.getAttribute('data-target'));
				if (target.classList.contains('show')) {
					target.classList.remove('show');
					this.innerHTML = '<i class="fa fa-chevron-right"></i>';
				} else {
					target.classList.add('show');
					this.innerHTML = '<i class="fa fa-chevron-down"></i>';
				}
			});
		});
	});
	btns = document.getElementsByClassName('btn-danger');
	btnsP = document.getElementsByClassName('btn-primary');



	const clientsData = <?php echo json_encode($clients); ?>;
	let clientsPerPage = 10;
	let currentPage = 1;
	let filteredClients = [];
	let sortDirection = {};

	function applyFilters() {
		const searchValue = document.getElementById('tableSearch').value.toLowerCase();
		const activeValue = document.getElementById('activeFilter').value;
		filteredClients = clientsData.filter(client => {
			if (activeValue === 'yes' && client.active !== 'Yes') return false;
			if (activeValue === 'no' && client.active !== 'No') return false;
			if (activeValue === 'all') {
				// no filter
			}
			if (searchValue && !Object.values(client).join(' ').toLowerCase().includes(searchValue)) return false;
			return true;
		});
	}

	function renderTable(page = 1) {
		const start = (page - 1) * clientsPerPage;
		const end = start + clientsPerPage;
		const clientsToShow = filteredClients.slice(start, end);
		const tbody = document.getElementById('clientsTableBody');
		tbody.innerHTML = '';
		clientsToShow.forEach(client => {
			const row = document.createElement('tr');
			row.innerHTML = `
			<th scope="row" class="text-center">${client.id}</th>
			<td class="text-center">${client.first_name}</td>
			<td class="text-center">${client.last_name}</td>
			<td class="text-center">${client.ruc}</td>
			<td class="text-center">${client.phone}</td>
			<td class="text-center">${client.address}</td>
			<td class="text-center">${client.plan}</td>
			<td class="text-center">${client.observation}</td>
			<td class="text-center">${client.active}</td>
			<td class="text-center">
				<button type="button" class="btn btn-danger btn-sm" value="${client.id}" style="font-size: 12px"><strong>-</strong></button>
			</td>
<td class="text-center">
	<button type="button" class="btn btn-primary btn-edit btn-sm" value="${client.id}" style="font-size: 12px">Edit</button>
</td>
		`;
			tbody.appendChild(row);
		});
		renderPagination();
		attachDeleteEvents();
		attachEditEvents();
	}

	function renderPagination() {
		const totalPages = Math.ceil(filteredClients.length / clientsPerPage);
		const pagination = document.querySelector('.pagination');
		pagination.innerHTML = '';
		pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a></li>`;
		for (let i = 1; i <= totalPages; i++) {
			pagination.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
		}
		pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a></li>`;
	}

	function changePage(page) {
		const totalPages = Math.ceil(filteredClients.length / clientsPerPage);
		if (page < 1 || page > totalPages) return;
		currentPage = page;
		renderTable(currentPage);
	}

	document.getElementById('tableSearch').addEventListener('keyup', function() {
		applyFilters();
		currentPage = 1;
		renderTable(currentPage);
	});

	document.getElementById('activeFilter').addEventListener('change', function() {
		applyFilters();
		currentPage = 1;
		renderTable(currentPage);
	});

	document.getElementById('recordsPerPage').addEventListener('change', function() {
		clientsPerPage = parseInt(this.value);
		currentPage = 1;
		renderTable(currentPage);
	});

	function sortTable(n) {
		const keys = ['id', 'first_name', 'last_name', 'ruc', 'phone', 'address', 'plan', 'observation'];
		const key = keys[n];
		let dir = sortDirection[n] === "asc" ? "desc" : "asc";
		sortDirection[n] = dir;
		filteredClients.sort((a, b) => {
			let x = a[key];
			let y = b[key];
			if (!isNaN(x) && !isNaN(y)) {
				x = Number(x);
				y = Number(y);
			}
			if (x < y) return dir === "asc" ? -1 : 1;
			if (x > y) return dir === "asc" ? 1 : -1;
			return 0;
		});
		renderTable(currentPage);
	}

	function attachDeleteEvents() {
		const btns = document.getElementsByClassName('btn-danger');
		for (let i = 0; i < btns.length; i++) {
			btns[i].addEventListener('click', function(event) {
				const id = this.value;
				event.preventDefault();
				Swal.fire({
					title: 'Do you want to inactivate this record?',
					text: "Once inactivated, the changes cannot be recovered.",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = '../../app/delete_clients.php?id=' + id;
					}
				})
			});
		}
	}

	function attachEditEvents() {
		const btns = document.getElementsByClassName('btn-edit');
		for (let i = 0; i < btns.length; i++) {
			btns[i].addEventListener('click', function(event) {
				const id = this.value;
				event.preventDefault();
				Swal.fire({
					title: 'Do you want to edit this record?',
					text: "You will be redirected to a new page to edit the information.",
					icon: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = '../../views/admin/edit_clients.php?id=' + id;
					}
				});
			});
		}
	}

	// initalize filters and render table
	document.addEventListener('DOMContentLoaded', function() {
		applyFilters();
		renderTable(currentPage);
	});

	document.getElementById('inputGroupFile02').addEventListener('change', function() {
		var fileInput = this;
		var fileName = fileInput.value;

		if (/\.(xlsx)$/i.test(fileName)) {
			
		} else {
			
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Solo se permiten archivos con extensión .xlsx.',

			})
			fileInput.value = ''; 
		}
	});


	// ...existing code...
</script>
<!-- Main End -->