<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION["tipo_usuario"]) || $_SESSION["tipo_usuario"] == "invitado") {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $grupo_muscular_id = $_POST['grupo_muscular'];
    $sql = "INSERT INTO articulos (titulo, contenido, grupo_muscular_id) VALUES ('$titulo', '$contenido', $grupo_muscular_id)";

    if ($conn->query($sql) === TRUE) {
        echo "<link rel='stylesheet' href='styles.css' />";
        echo "<div class='container'>";
        echo "<h1>Artículo agregado exitosamente</h1>";
        echo "<a class='back-button' href='index.php'>Volver a la página principal</a>";
        echo "</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: index.php");
    exit;
}
?>
