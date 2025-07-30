<!-- Sub Header -->
<style>
/* Offcanvas Sidebar Styles - Using Bootstrap classes */
.offcanvas-sidebar {
    position: fixed;
    top: 0;
    left: -100%;
    width: 280px;
    height: 100vh;
    background: #343a40;
    z-index: 1045;
    transition: left 0.3s ease-in-out;
    overflow-y: auto;
}

.offcanvas-sidebar.show {
    left: 0;
}

.offcanvas-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.15s linear;
}

.offcanvas-backdrop.show {
    opacity: 1;
    visibility: visible;
}

.offcanvas-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #495057;
}

.offcanvas-title {
    margin-bottom: 0;
    line-height: 1.5;
    color: white;
    font-size: 24px;
    font-weight: 600;
}

.btn-close-sidebar {
    padding: 0.25rem;
    background: transparent;
    border: 0;
    border-radius: 0.25rem;
    opacity: 0.5;
    color: white;
    font-size: 1.5rem;
    line-height: 1;
    cursor: pointer;
}

.btn-close-sidebar:hover {
    opacity: 0.75;
}

.offcanvas-body {
    flex-grow: 1;
    padding: 1rem;
    overflow-y: auto;
}

/* Sidebar nav adjustments */
.sidebar-nav {
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}

.sidebar-nav .nav-link {
    display: block;
    padding: 0.75rem 1rem;
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    border-radius: 0.25rem;
    margin-bottom: 0.25rem;
    transition: all 0.15s ease-in-out;
}

.sidebar-nav .nav-link:hover,
.sidebar-nav .nav-link.active {
    color: white;
    background-color: rgba(255, 255, 255, 0.1);
}
</style>

<?php

if ($_SESSION['role'] == 1) {

?>

    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" style="padding: 0px 50px">
        <!-- Mobile sidebar toggle button -->
        <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <a class="navbar-brand" href="#" style="font-size: 24px; font-weight: 600">VISIT APP</a>

        <!-- Desktop Navigation - Bootstrap collapse -->
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../admin/admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/users.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/clients.php">Clients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/visits.php">Visits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/products.php">Products</a>
                </li>
            </ul>

            <a href="../../app/logout.php"><button type="button" class="btn btn-light">Logout</button></a>
        </div>
    </nav>

    <!-- Offcanvas Sidebar for Mobile -->
    <div class="offcanvas-backdrop" id="sidebarBackdrop"></div>
    <div class="offcanvas-sidebar" id="offcanvasSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">VISIT APP</h5>
            <button type="button" class="btn-close-sidebar" id="closeSidebar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../admin/admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/users.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/clients.php">Clients</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/visits.php">Visits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/products.php">Products</a>
                </li>
            </ul>
            
            <div class="mt-auto pt-3">
                <a href="../../app/logout.php" class="btn btn-light w-100">Logout</a>
            </div>
        </div>
    </div>

    <!-- Alternative navigation for relative paths -->
    <div class="d-none" id="alternativeNav">
        <ul class="navbar-nav sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php">Users</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="clients.php">Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="visits.php">Visits</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php">Products</a>
            </li>
        </ul>
    </div>

    

<?php } else { ?>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" style="padding: 0px 50px">

        <a class="navbar-brand" href="#" style="font-size: 24px; font-weight: 600 ">VISIT APP</a>
    </nav>
<?php } ?>
<!-- Sub Header End -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const offcanvasSidebar = document.getElementById('offcanvasSidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const closeSidebar = document.getElementById('closeSidebar');

        function showSidebar() {
            offcanvasSidebar.classList.add('show');
            sidebarBackdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function hideSidebar() {
            offcanvasSidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Toggle sidebar
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            showSidebar();
        });

        // Close sidebar
        closeSidebar.addEventListener('click', hideSidebar);
        sidebarBackdrop.addEventListener('click', hideSidebar);

        // Close on window resize if desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                hideSidebar();
            }
        });

        // Update sidebar navigation based on current path
        function updateSidebarNavigation() {
            const currentPath = window.location.pathname;
            const altNav = document.getElementById('alternativeNav');
            const sidebarNav = document.querySelector('.offcanvas-body .sidebar-nav');
            
            // Check if we need to use alternative navigation (relative paths)
            if (currentPath.includes('/admin/') && !currentPath.includes('../admin/')) {
                // We're in the admin directory, use relative paths
                const altLinks = altNav.querySelectorAll('a');
                const sidebarLinks = sidebarNav.querySelectorAll('a');
                
                altLinks.forEach((altLink, index) => {
                    if (sidebarLinks[index]) {
                        sidebarLinks[index].href = altLink.href;
                    }
                });
            }

            // Mark active link
            const sidebarLinks = sidebarNav.querySelectorAll('.nav-link');
            sidebarLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath && currentPath.includes(linkPath.split('/').pop())) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }

        updateSidebarNavigation();
    });
    </script>