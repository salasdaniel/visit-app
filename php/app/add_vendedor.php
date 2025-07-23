<?php

    session_start();
    require '../config/conexion.php';

    $nombre = trim(strtoupper($_POST['nombre'])) ;
    $apellido = trim(strtoupper($_POST['apellido']));
    $ci = trim($_POST['ci']);
    $rol = trim($_POST['rol']);

   
    $sql = "SELECT * FROM personas WHERE ci = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ci);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $_SESSION['msj'] = "El documento ingresado, ya se encuentra registrado en la base de datos.";
        $_SESSION['msj_code'] = 0 ;
        header("Location: ../views/admin/vendedores.php");

    } elseif ($result->num_rows <= 0) {
        
        $stmt->close();
        $sql = "INSERT INTO personas VALUES (NULL,?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $nombre,$apellido,$ci,$rol);
       

        if ( $stmt->execute()){
            $_SESSION['msj'] = "Se ha registrado una nueva persona en base de datos.";
            $_SESSION['msj_code'] = 1 ;
            header("Location: ../views/admin/vendedores.php");
            ;
        }else{
            $_SESSION['msj'] = "¡Error al comunicarse con la Base de Datos!";
            $_SESSION['msj_code'] = 2;
        }
    }

    $stmt->close();
    $conn->close();

?>
