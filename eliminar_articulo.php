<?php

//Restringir el acceso a usuarios que no tengan permiso
session_start();

if (!isset($_SESSION["tipo_usuario"]) || $_SESSION["tipo_usuario"] != "administrador") {
    echo "No tienes permiso para eliminar artículos";
    exit;
}

// El resto del código para eliminar el artículo

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    include 'conexion.php';

    $id = $_POST["id"];

    $sql = "DELETE FROM articulos WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Artículo eliminado exitosamente";
    } else {
        echo "Error al eliminar el artículo: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: index.php");
    exit;
}
?>
