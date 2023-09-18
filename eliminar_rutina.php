<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION["id"])) {
    echo "Debes iniciar sesión para eliminar una rutina personalizada.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $rutina_id = $_GET['id'];
    $usuario_id = $_SESSION["id"];

    $sql_delete = "DELETE FROM rutinas_personalizadas WHERE id = ? AND usuarios_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("ii", $rutina_id, $usuario_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['mensaje'] = "Rutina borrada exitosamente.";
    } else {
        $_SESSION['mensaje'] = "No se pudo eliminar la rutina.";
    }
    

    $conn->close();

    // Redireccionar de vuelta a la página rutinas.php
    header("Location: rutinas.php");
    exit;
} else {
    // Redireccionar de vuelta a la página rutinas.php en caso de que no se proporcione el ID de la rutina
    header("Location: rutinas.php");
    exit;
}
?>
