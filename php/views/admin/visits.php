<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../config/conexion.php';

$perPage = 10;
$page = !empty($_REQUEST['num']) ? (int)$_REQUEST['num'] : 1;
$start = ($page > 1) ? ($page - 1) * $perPage : 0;

$sqlTotal = "SELECT COUNT(*) FROM vw_visitas";
$resultTotal = pg_query($conn, $sqlTotal);
// $totalRows = ($resultTotal && pg_num_rows($resultTotal) > 0) ? (int)pg_fetch_result($resultTotal, 0, 0) : 0;
// $pages = ($totalRows > 0) ? ceil($totalRows / $perPage) : 1;

$sql = "SELECT * FROM vw_visitas ORDER BY id DESC";
$result = pg_query($conn, $sql);

$visits = [];
if ($result) {
	while ($row = pg_fetch_assoc($result)) {
		$visits[] = [
			'id' => $row['id'],
			'client_name' => ucfirst(strtolower($row['cliente_nombre'] ?? '')) . ' ' . ucfirst(strtolower($row['cliente_apellido'] ?? '')),
			'advisor_name' => ucfirst(strtolower($row['persona_nombre'] ?? '')) . ' ' . ucfirst(strtolower($row['persona_apellido'] ?? '')),
			'date' => $row['fecha'],
			'entry_time' => $row['hora_ingreso'],
			'exit_time' => $row['hora_salida'],
			'duration' => $row['tiempo_visita'],
			'water' => ($row['agua'] === 'true' ) ? 'Yes' : 'No',
			'filter' => ($row['filtro'] === 'true' ) ? 'Yes' : 'No',
			'chemicals' => ($row['quimicos'] === 'true' ) ? 'Yes' : 'No',
			'needs' => ($row['necesita_productos'] === 'true' ) ? 'Yes' : 'No',
			'products' => ($row['productos'] === null || $row['productos'] === '') ? 'No Needs' : $row['productos'],
			'observations' => ($row['observaciones'] === null || $row['observaciones'] === '') ? 'No Obs.' : $row['observaciones'],
			'img_1' => $row['img_1'],
			'img_2' => $row['img_2'],
			'img_3' => $row['img_3']
		];
	}
}
?>
<!-- Main -->
<main>
	<div class="contact container" style="padding-bottom:0; flex: 1;">
		<div class="card mb-0">
			<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
				<strong>Visits List</strong>
			</div>
			<div class="card-body">
				<div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
					<label for="recordsPerPage" class="mb-0 mr-2">Show</label>
					<select id="recordsPerPage" class="form-control mr-3" style="width: 90px;">
						<option value="10">10</option>
						<option value="20">20</option>
						<option value="50">50</option>
					</select>
					<input type="text" id="tableSearch" class="form-control" placeholder="Search..." style="max-width: 250px;">
					<label for="dateStart" class="mb-0 ml-3">From</label>
					<input type="date" id="dateStart" class="form-control ml-2" style="width: 170px;">
					<label for="dateEnd" class="mb-0 ml-2">To</label>
					<input type="date" id="dateEnd" class="form-control ml-2" style="width: 170px;">
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover text-center" id="visitsTable">
						<thead class="thead-light">
							<tr>
								<th onclick="sortTable(0)">ID <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(1)">Client Name <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(2)">Advisor Name <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(3)">Date <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(4)">Entry Time <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(5)">Exit Time <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(6)">Duration <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(7)">Water <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(8)">Filter <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(9)">Chemicals <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(10)">Needs <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(11)">Products <i class="fa fa-sort"></i></th>
								<th onclick="sortTable(12)">Observations <i class="fa fa-sort"></i></th>
								<th>Photos</th>
							</tr>
						</thead>
						<tbody id="visitsTableBody">
							<!-- JS render -->
						</tbody>
					</table>
				</div>
				<nav aria-label="Page navigation example" class="mt-3">
					<ul class="pagination justify-content-center">
						<!-- JS render -->
					</ul>
				</nav>
			</div>
		</div>
		<!-- Modal para mostrar imágenes -->
		<div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<!-- <div class="modal-header">
						<h5 class="modal-title">Visit Images</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div> -->
					<div class="modal-body p-0 bg-dark">
						<div id="visitCarousel" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators" id="carouselIndicators">
							</ol>
							<div class="carousel-inner" id="carouselInner">
							</div>
							<a class="carousel-control-prev" href="#visitCarousel" role="button" data-slide="prev" style="background: rgba(0,0,0,0.5); width: 8%; border-radius: 0 10px 10px 0;">
								<span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0 0 3px rgba(255,255,255,0.8));"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#visitCarousel" role="button" data-slide="next" style="background: rgba(0,0,0,0.5); width: 8%; border-radius: 10px 0 0 10px;">
								<span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0 0 3px rgba(255,255,255,0.8));"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require '../../partials/footer.php'; ?>
</main>

<script>
	const visitsData = <?php echo json_encode($visits); ?>;
	let visitsPerPage = 10;
	let currentPage = 1;
	let filteredVisits = visitsData;
	let sortDirection = {};

	function applyFilters() {
		const searchValue = document.getElementById('tableSearch').value.toLowerCase();
		const dateStart = document.getElementById('dateStart').value;
		const dateEnd = document.getElementById('dateEnd').value;
		let result = visitsData.filter(visit => {
			let matchesSearch = Object.values(visit).join(' ').toLowerCase().includes(searchValue);
			let matchesDate = true;
			if (dateStart) {
				matchesDate = visit.date >= dateStart;
			}
			if (dateEnd) {
				matchesDate = matchesDate && visit.date <= dateEnd;
			}
			return matchesSearch && matchesDate;
		});
		// If there is a sorted column, apply the sort order
		if (typeof applyFilters.sortedCol !== 'undefined') {
			const n = applyFilters.sortedCol;
			const keys = ['id', 'client_name', 'advisor_name', 'date', 'entry_time', 'exit_time', 'duration', 'water', 'filter', 'chemicals', 'needs', 'products', 'observations'];
			const key = keys[n];
			let dir = sortDirection[n] || "asc";
			result.sort((a, b) => {
				let x = a[key];
				let y = b[key];
				if (key === 'date') {
					x = new Date(x);
					y = new Date(y);
				} else if (!isNaN(x) && !isNaN(y)) {
					x = Number(x);
					y = Number(y);
				}
				if (x < y) return dir === "asc" ? -1 : 1;
				if (x > y) return dir === "asc" ? 1 : -1;
				return 0;
			});
		}
		filteredVisits = result;
	}

	function renderTable(page = 1) {
		applyFilters();
		const start = (page - 1) * visitsPerPage;
		const end = start + visitsPerPage;
		const visitsToShow = filteredVisits.slice(start, end);
		const tbody = document.getElementById('visitsTableBody');
		tbody.innerHTML = '';
		visitsToShow.forEach(visit => {
			const row = document.createElement('tr');
			row.innerHTML = `
			<th scope="row" class="text-center">${visit.id}</th>
			<td class="text-center">${visit.client_name}</td>
			<td class="text-center">${visit.advisor_name}</td>
			<td class="text-center">${visit.date}</td>
			<td class="text-center">${visit.entry_time}</td>
			<td class="text-center">${visit.exit_time}</td>
			<td class="text-center">${visit.duration}</td>
			<td class="text-center">${visit.water}</td>
			<td class="text-center">${visit.filter}</td>
			<td class="text-center">${visit.chemicals}</td>
			<td class="text-center">${visit.needs}</td>
			<td class="text-center">${visit.products}</td>
			<td class="text-center">${visit.observations}</td>
			<td class="text-center">
				<button type="button" class="btn btn-primary view" data-id="${visit.id}">View</button>
			</td>
		`;
			tbody.appendChild(row);
		});
		renderPagination();
		attachViewEvents();
	}

	function renderPagination() {
		const totalPages = Math.ceil(filteredVisits.length / visitsPerPage);
		const pagination = document.querySelector('.pagination');
		pagination.innerHTML = '';
		pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a></li>`;
		for (let i = 1; i <= totalPages; i++) {
			pagination.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
		}
		pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a></li>`;
	}

	function changePage(page) {
		const totalPages = Math.ceil(filteredVisits.length / visitsPerPage);
		if (page < 1 || page > totalPages) return;
		currentPage = page;
		renderTable(currentPage);
	}

	document.getElementById('tableSearch').addEventListener('keyup', function() {
		currentPage = 1;
		renderTable(currentPage);
	});

	document.getElementById('recordsPerPage').addEventListener('change', function() {
		visitsPerPage = parseInt(this.value);
		currentPage = 1;
		renderTable(currentPage);
	});

	document.getElementById('dateStart').addEventListener('change', function() {
		currentPage = 1;
		renderTable(currentPage);
	});
	document.getElementById('dateEnd').addEventListener('change', function() {
		currentPage = 1;
		renderTable(currentPage);
	});

	function sortTable(n) {
		let dir = sortDirection[n] === "asc" ? "desc" : "asc";
		sortDirection[n] = dir;
		applyFilters.sortedCol = n;
		renderTable(currentPage);
	}

	function attachViewEvents() {
		const btns = document.getElementsByClassName('view');
		for (let i = 0; i < btns.length; i++) {
			btns[i].addEventListener('click', function(event) {
				const id = this.getAttribute('data-id');
				event.preventDefault();

				
				const visit = visitsData.find(v => v.id == id);
				if (!visit) return;

				// get the valid images
				const images = [visit.img_1, visit.img_2, visit.img_3].filter(img => img && img !== '' && img !== null);

				if (images.length === 0) {
					alert('No images available for this visit.');
					return;
				}

				// clean carrousel 
				const carouselInner = document.getElementById('carouselInner');
				const carouselIndicators = document.getElementById('carouselIndicators');
				carouselInner.innerHTML = '';
				carouselIndicators.innerHTML = '';

				
				images.forEach((img, index) => {
					
					const slideDiv = document.createElement('div');
					slideDiv.className = `carousel-item ${index === 0 ? 'active' : ''}`;
					slideDiv.innerHTML = `
					<img src="../../images/${img}" class="d-block w-100" alt="Visit Image ${index + 1}" 
						 style="max-height: 500px; object-fit: contain; background: #f8f9fa;"
						 onerror="this.onerror=null; this.src='../../images/image-not-found.jpg';">
				`;
					carouselInner.appendChild(slideDiv);

					
					const indicatorLi = document.createElement('li');
					indicatorLi.setAttribute('data-target', '#visitCarousel');
					indicatorLi.setAttribute('data-slide-to', index);
					if (index === 0) indicatorLi.className = 'active';
					carouselIndicators.appendChild(indicatorLi);
				});

			
				$('#imageModal').modal('show');

				
				removeModalBackdrop();

				$('#visitCarousel').carousel('dispose');
				$('#visitCarousel').carousel({
					interval: false,
					wrap: true
				});
			});
		}
	}


	function removeModalBackdrop() {
		setTimeout(() => {
			const backdrop = document.querySelector('.modal-backdrop.fade.show');
			if (backdrop) {
				backdrop.remove();
			}
		}, 100);
	}

	document.addEventListener('DOMContentLoaded', function() {
		renderTable(currentPage);
	});
</script>
<!-- Main -->