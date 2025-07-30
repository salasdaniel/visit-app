<?php

require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../config/connection.php'; // Cambia a tu archivo de conexión PostgreSQL
require '../../partials/swal.php';

?>

<!-- Main -->
<!-- Contact  -->
<?php

// Pagination
$per_page = 10;

$page = !empty($_REQUEST['num']) ? (int)$_REQUEST['num'] : 1;
$start = ($page > 1) ? ($page - 1) * $per_page : 0;

// Total records
// Get paginated users
$sql = "SELECT u.id, u.first_name, u.last_name, u.document_number, roles.role_name, u.is_active
						FROM users u
						INNER JOIN roles ON u.role = roles.id
						ORDER BY u.id DESC";
$result = pg_query($conn, $sql);

$users = [];
while ($user_info = pg_fetch_assoc($result)) {
	$users[] = [
		'id' => $user_info['id'],
		'name' => ucfirst(strtolower($user_info['first_name'])),
		'lastname' => ucfirst(strtolower($user_info['last_name'])),
		'document' => $user_info['document_number'],
		'role' => ucfirst(strtolower($user_info['role_name'])),
		'active' => ($user_info['is_active'] === 't') ? 'Yes' : 'No'
	];
}

?>
<main>
	<div class="contact container" style="padding-bottom:0; flex: 1;">

		<!-- Card: Form -->
		<div class="card">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong>Add a New User</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#addUserCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse show" id="addUserCardBody">
				<form method="POST" id="contactForm" name="contactForm" action="../../app/add_user.php">
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="username">Name</label>
							<input type="text" id="username" name="first_name" class="form-control" placeholder="Name..." required pattern="^[a-zA-Z\s.]+$">
						</div>
						<div class="form-group col-md-4">
							<label for="lastname">Last Name</label>
							<input type="text" id="lastname" name="last_name" class="form-control" placeholder="Last name..." required>
						</div>
						<div class="form-group col-md-4">
							<label for="document">Document Number</label>
							<input type="number" id="document" name="document_number" class="form-control" placeholder="Document number..." required>
						</div>
					</div>

					<div class="form-group d-flex align-items-end" style="gap: 10px;">
						<div class="flex-grow-1">
							<label for="subjectList">Role</label>
							<select id="subjectList" name="role" class="form-control" style="height: 38px;">
								<option value="1">Admin</option>
								<option value="2">Advisor</option>
							</select>
						</div>
						<button type="submit" name="submit" class="btn btn-primary " style="height: 38px;">
							Submit <i class="fa fa-paper-plane ml-2"></i>
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Card: filters, table, pagination -->
		<div class="card mb-5">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong>Users List</strong>
				<button class="btn btn-sm btn-light toggle-card" type="button" data-target="#usersListCardBody"><i class="fa fa-chevron-down"></i></button>
			</div>
			<div class="card-body collapse show" id="usersListCardBody">
				<div class="d-flex align-items-center gap-2 mb-3">
					<label for="recordsPerPage" class="mb-0 mr-2">Show</label>
					<select id="recordsPerPage" class="form-control mr-3" style="width: 90px;">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="50">50</option>
					</select>
					<input type="text" id="tableSearch" class="form-control" placeholder="Search..." style="max-width: 250px;">
					<select id="activeFilter" class="form-control ml-2" style="width: 120px;">
						<option value="All">All</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>

				<div class="table-responsive">
					<table class="table table-bordered table-hover text-center" id="userTable">
						<thead class="thead-light">
							<tr>
								<th onclick="sortTable(0)">ID <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(1)">Name <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(2)">Last Name <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(3)">Document No. <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(4)">Role <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(5)">Active <i class="fa fa-sort"></i></th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="userTableBody">
							<!-- Rows go here -->
						</tbody>
					</table>
				</div>

				<nav aria-label="Page navigation" class="mt-4">
					<ul class="pagination justify-content-center">
						<li class="page-item">
							<a class="page-link" href="?num=<?php echo ($page > 1) ? $page - 1 : 1; ?>">Previous</a>
						</li>
						<?php for ($i = 1; $i <= $pages; $i++): ?>
							<li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
								<a class="page-link" href="?num=<?php echo $i; ?>"><?php echo $i; ?></a>
							</li>
						<?php endfor; ?>
						<li class="page-item">
							<a class="page-link" href="?num=<?php echo ($page < $pages) ? $page + 1 : $page; ?>">Next</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>



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
	const usersData = <?php echo json_encode($users); ?>;
	let usersPerPage = 10;
	let currentPage = 1;
	let filteredUsers = usersData.filter(user => user.active === 'Yes'); // Mostrar todos inicialmente
	let sortDirection = {};

	function renderTable(page = 1) {
		const start = (page - 1) * usersPerPage;
		const end = start + usersPerPage;
		const usersToShow = filteredUsers.slice(start, end);

		const tbody = document.getElementById('userTableBody');
		tbody.innerHTML = '';

		usersToShow.forEach(user => {
			const row = document.createElement('tr');
			row.innerHTML = `
				<th scope="row" class="text-center">${user.id}</th>
				<td class="text-center">${user.name}</td>
				<td class="text-center">${user.lastname}</td>
				<td class="text-center">${user.document}</td>
				<td class="text-center">${user.role}</td>
				<td class="text-center">${user.active}</td>
				<td class="text-center">
					<a href=''><button type="button" class="btn btn-danger" value="${user.id}" style="font-size: 12px"><strong>-</strong></button></a>
				</td>
			`;
			tbody.appendChild(row);
		});

		renderPagination();
		attachDeleteEvents();
	}

	document.getElementById('recordsPerPage').addEventListener('change', function() {
		usersPerPage = parseInt(this.value);
		currentPage = 1;
		renderTable(currentPage);
	});

	document.getElementById('activeFilter').addEventListener('change', function() {
		applyFilters();
	});

	document.getElementById('tableSearch').addEventListener('keyup', function() {
		applyFilters();
	});

	function applyFilters() {
		const filter = document.getElementById('tableSearch').value.toLowerCase();
		const activeValue = document.getElementById('activeFilter').value;
		
		filteredUsers = usersData.filter(user => {
			const matchesSearch = Object.values(user).join(' ').toLowerCase().includes(filter);
			const matchesActive = (activeValue === 'All') || (user.active === activeValue);
			return matchesSearch && matchesActive;
		});
		currentPage = 1;
		renderTable(currentPage);
	}

	function renderPagination() {
		const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
		const pagination = document.querySelector('.pagination');
		pagination.innerHTML = '';

		// Previous
		pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a></li>`;

		// Page numbers
		for (let i = 1; i <= totalPages; i++) {
			pagination.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
		}

		// Next
		pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a></li>`;
	}

	function changePage(page) {
		const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
		if (page < 1 || page > totalPages) return;
		currentPage = page;
		renderTable(currentPage);
	}


	// Sorting
	function sortTable(n) {
		const keys = ['id', 'name', 'lastname', 'document', 'role', 'active'];
		const key = keys[n];
		let dir = sortDirection[n] === "asc" ? "desc" : "asc";
		sortDirection[n] = dir;

		filteredUsers.sort((a, b) => {
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
						window.location.href = '../../app/delete_users.php?id=' + id;
					}
				})
			})
		}
	}
	renderTable(currentPage);
</script>
<!-- Main End -->