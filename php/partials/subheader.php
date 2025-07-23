<!-- Sub Header -->
<?php

if ($_SESSION['rol'] == 1) {

?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="padding: 10px 50px; background-color: #53c4da">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#" style="font-size: 24px; font-weight: 600 ">PROPOOL</a>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="../admin/admin.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/vendedores.php">Asesores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/clientes.php">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../admin/vw_visitas.php"> Visitas</a>
            </li>
        </ul>

        <a href="../../app/logout.php"><button type="button" class="btn btn-light">Logout</button></a>
    </div>
</nav>


    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Inicio </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="vendedores.php">Vendedores </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="clientes.php">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vw_visitas.php">Visitas</a>
            </li>
        </ul>

        <a href="logout.php"><button type="button" class="btn btn-light">Logout</button></a>
    </div>

<?php } ?>
<!-- Sub Header End -->