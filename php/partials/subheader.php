<!-- Sub Header -->
<?php

if ($_SESSION['role'] == 1) {

?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark" style="padding: 0px 50px">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" style="font-size: 24px; font-weight: 600 ">VISIT APP</a>

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
        </ul>

        <a href="../../app/logout.php"><button type="button" class="btn btn-light">Logout</button></a>
    </div>
</nav>


    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Home</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="users.php">Users</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="clients.php">Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="visits.php">Visits</a>
            </li>
        </ul>

        <a href="logout.php"><button type="button" class="btn btn-light">Logout</button></a>
    </div>

<?php } ?>
<!-- Sub Header End -->