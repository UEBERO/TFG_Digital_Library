<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre_usuario"])) {
        $nombre_usuario = $_POST["nombre_usuario"];
    } else {
        echo "Error: nombre_usuario no está definido.";
    }
    
    if (isset($_POST["contrasena"])) {
        $contrasena = $_POST["contrasena"];
    } else {
        echo "Error: contrasena no está definido.";
    }
    
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    } else {
        echo "Error: email no está definido.";
    }
    
    if (isset($_POST["codigo_admin"]) && $_POST["codigo_admin"] === "SoyAdmin") {
        $tipo_usuario = "administrador";
    } else {
        $tipo_usuario = "usuario";
    }
    
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, email, tipo_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre_usuario, $contrasena_hash, $email, $tipo_usuario);
    
    if ($stmt->execute()) {
        $id_usuario = $stmt->insert_id; 

        if (isset($_POST["codigo_admin"]) && $_POST["codigo_admin"] == "SoyAdmin") {
            $sql = "UPDATE usuarios SET tipo_usuario = 'administrador' WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
        }
    
        header("Location: login.php");
        exit;
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
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="TextoRegistro">Registro</h1>
        <form action="registro.php" method="post">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required>
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" required>
            <label for="codigo_admin">Código de administrador (opcional):</label>
            <input type="text" name="codigo_admin" id="codigo_admin">
            <input type="submit" value="Registrarse">
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
    </div>
</body>
</html>
