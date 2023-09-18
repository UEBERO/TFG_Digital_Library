<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST["nombre_usuario"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT id, contrasena, tipo_usuario FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $contrasena_hash, $tipo_usuario);
            $stmt->fetch();

            if (password_verify($contrasena, $contrasena_hash)) {
                $_SESSION["id"] = $id;
                $_SESSION["nombre_usuario"] = $nombre_usuario;
                $_SESSION["tipo_usuario"] = $tipo_usuario;
                header("Location: index.php");
                exit;
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "No se encontró ninguna cuenta con ese nombre de usuario";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar sesión</h1>
        <form action="login.php" method="post">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" required>
            <input type="submit" value="Iniciar sesión">
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php">Registrarse</a></p>
    </div>
</body>
</html>
