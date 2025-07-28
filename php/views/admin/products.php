<?php
require '../../config/admin_validation.php';
require '../../partials/head.php';
require '../../partials/subheader.php';
require '../../partials/swal.php';
require '../../config/conexion.php';

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
			icon: "error",
			title: "Error",
			html: "' . addslashes($_SESSION['msg']) . '"
		});
		</script>';
    }
    unset($_SESSION['msg']);
    unset($_SESSION['msg_code']);
}


// Get products data
$products = [];
$sql = "SELECT p.id, p.nombre, p.costo, p.venta, p.activo, p.id_usuario_creacion, CONCAT(u.nombre, ' ', u.apellido) as usuario_creador
        FROM productos p 
        LEFT JOIN personas u ON p.id_usuario_creacion = u.id 
        ORDER BY p.id";
$result = pg_query($conn, $sql);

if ($result) {
    while ($product_info = pg_fetch_assoc($result)) {
        $products[] = [
            'id' => $product_info['id'],
            'name' => $product_info['nombre'],
            'cost' => $product_info['costo'],
            'sale_price' => $product_info['venta'],
            'created_by_id' => $product_info['id_usuario_creacion'],
            'created_by' => $product_info['usuario_creador'] ? $product_info['usuario_creador'] : 'Unknown',
            'active' => ($product_info['activo'] === 't') ? 'Yes' : 'No'
        ];
    }
}

?>
<!-- Main -->
<main class="">
    <div class="contact container" style="padding-bottom:0;">
        <!-- Form Card -->
        <div class="card mb-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <strong>Add a New Product</strong>
                <button class="btn btn-sm btn-light toggle-card" type="button" data-target="#addProductCardBody"><i class="fa fa-chevron-down"></i></button>
            </div>
            <div class="card-body collapse show" id="addProductCardBody">
                <form method="POST" id="productForm" name="productForm" action="../../app/add_product.php">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="product_name">Product Name</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Product name..." required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cost">Cost Price</label>
                            <input type="number" id="cost" name="cost" class="form-control" placeholder="0.00" step="0.01" min="0" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sale_price">Sale Price</label>
                            <input type="number" id="sale_price" name="sale_price" class="form-control" placeholder="0.00" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="form-row">
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
                <strong>Bulk Upload Products</strong>
                <button class="btn btn-sm btn-light toggle-card" type="button" data-target="#bulkUploadCardBody"><i class="fa fa-chevron-down"></i></button>
            </div>
            <div class="card-body collapse" id="bulkUploadCardBody">
                <form action="../../app/bulk_products.php" method="post" enctype="multipart/form-data">
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
                        <a href='../../../docs/product_template.xlsx' class="btn btn-secondary">
                            Download Template
                        </a>
                    </div>
                    <div class="card-body">
                        <strong>Instructions</strong>
                        <ul>
                            <li>1. Columns must follow the same order as the template.</li>
                            <li>2. Price fields must be numeric values (use decimal point for cents).</li>
                            <li class="text-danger">You must follow the instructions exactly to load records into the database.</li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products List -->
        <?php if ($_SESSION['role'] == 1): ?>
            <div class="card mb-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <strong>Products List</strong>
                    <button class="btn btn-sm btn-light toggle-card" type="button" data-target="#productsListCardBody"><i class="fa fa-chevron-down"></i></button>
                </div>
                <div class="card-body collapse show" id="productsListCardBody">
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
                        <table class="table table-bordered table-hover text-center" id="productsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" onclick="sortTable(0)">ID <i class="fa fa-sort"></i></th>
                                    <th class="text-center" onclick="sortTable(1)">Product Name <i class="fa fa-sort"></i></th>
                                    <th class="text-center" onclick="sortTable(2)">Cost Price <i class="fa fa-sort"></i></th>
                                    <th class="text-center" onclick="sortTable(3)">Sale Price <i class="fa fa-sort"></i></th>
                                    <th class="text-center" onclick="sortTable(4)">Profit Margin <i class="fa fa-sort"></i></th>
                                    <th class="text-center" onclick="sortTable(5)">Created By <i class="fa fa-sort"></i></th>
                                    <th class="text-center" onclick="sortTable(6)">Active <i class="fa fa-sort"></i></th>
                                    <th class="text-center">Delete</th>
                                    <th class="text-center">Edit</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
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

    // Products data from PHP
    const productsData = <?php echo json_encode($products); ?>;
    let productsPerPage = 10;
    let currentPage = 1;
    let filteredProducts = [];
    let sortDirection = {};

    function applyFilters() {
        const searchValue = document.getElementById('tableSearch').value.toLowerCase();
        const activeValue = document.getElementById('activeFilter').value;
        filteredProducts = productsData.filter(product => {
            if (activeValue === 'yes' && product.active !== 'Yes') return false;
            if (activeValue === 'no' && product.active !== 'No') return false;
            if (activeValue === 'all') {
                // no filter
            }
            if (searchValue && !Object.values(product).join(' ').toLowerCase().includes(searchValue)) return false;
            return true;
        });
    }

    function calculateProfitMargin(cost, sale) {
        if (cost == 0) return 'N/A';
        const margin = ((sale - cost) / cost) * 100;
        return margin.toFixed(2) + '%';
    }

    function renderTable(page = 1) {
        const start = (page - 1) * productsPerPage;
        const end = start + productsPerPage;
        const productsToShow = filteredProducts.slice(start, end);
        const tbody = document.getElementById('productsTableBody');
        tbody.innerHTML = '';
        productsToShow.forEach(product => {
            const profitMargin = calculateProfitMargin(parseFloat(product.cost), parseFloat(product.sale_price));
            const row = document.createElement('tr');
            row.innerHTML = `
            <th scope="row" class="text-center">${product.id}</th>
            <td class="text-center">${product.name}</td>
            <td class="text-center">$${parseFloat(product.cost).toFixed(2)}</td>
            <td class="text-center">$${parseFloat(product.sale_price).toFixed(2)}</td>
            <td class="text-center">${profitMargin}</td>
            <td class="text-center">${product.created_by}</td>
            <td class="text-center">${product.active}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" value="${product.id}" style="font-size: 12px"><strong>-</strong></button>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-primary btn-edit btn-sm" value="${product.id}" style="font-size: 12px">Edit</button>
            </td>
        `;
            tbody.appendChild(row);
        });
        renderPagination();
        attachDeleteEvents();
        attachEditEvents();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = '';
        pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a></li>`;
        for (let i = 1; i <= totalPages; i++) {
            pagination.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
        }
        pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a></li>`;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
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
        productsPerPage = parseInt(this.value);
        currentPage = 1;
        renderTable(currentPage);
    });

    function sortTable(n) {
        const keys = ['id', 'name', 'cost', 'sale_price', 'profit_margin', 'created_by', 'active'];
        const key = keys[n];
        let dir = sortDirection[n] === "asc" ? "desc" : "asc";
        sortDirection[n] = dir;

        filteredProducts.sort((a, b) => {
            let x, y;

            if (key === 'profit_margin') {
                x = calculateProfitMargin(parseFloat(a.cost), parseFloat(a.sale_price));
                y = calculateProfitMargin(parseFloat(b.cost), parseFloat(b.sale_price));
                // Handle N/A values
                if (x === 'N/A') x = -999;
                if (y === 'N/A') y = -999;
                if (x !== -999) x = parseFloat(x);
                if (y !== -999) y = parseFloat(y);
            } else {
                x = a[key];
                y = b[key];
                if (!isNaN(x) && !isNaN(y)) {
                    x = Number(x);
                    y = Number(y);
                }
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
                    title: 'Do you want to inactive this product?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../../app/delete_product.php?id=' + id;
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
                    title: 'Do you want to edit this product?',
                    text: "You will be redirected to a new page to edit the information.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../../views/admin/edit_product.php?id=' + id;
                    }
                });
            });
        }
    }

    // Initialize table
    document.addEventListener('DOMContentLoaded', function() {
        applyFilters();
        renderTable(currentPage);
    });

    document.getElementById('inputGroupFile02').addEventListener('change', function() {
        var fileInput = this;
        var fileName = fileInput.value;

        if (/\.(xlsx)$/i.test(fileName)) {
            // File extension is .xlsx, allowed
        } else {
            // File extension is not .xlsx, show error message
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Only .xlsx files are allowed.',
            })
            fileInput.value = ''; // Clear the file input
        }
    });
</script>
<!-- Main End -->