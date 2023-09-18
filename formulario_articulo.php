<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "biblioteca_ejercicios", 3307);

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Consultar la tabla de grupos musculares
$resultado = $conexion->query("SELECT * FROM grupos_musculares");

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Tus etiquetas head aquí -->
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<form action="agregar_articulo.php" method="POST">

  <!-- Tus otros elementos de formulario aquí -->
  <label for="titulo">Título:</label>
  <input type="text" name="titulo" id="titulo" required>
  
  <label for="contenido">Descripción:</label>
  <textarea name="contenido" id="contenido" rows="10" cols="30" required></textarea>

  
  <!-- Insertar el desplegable en la posición deseada -->
  <label for="grupo_muscular">Grupo muscular:</label>
  <select name="grupo_muscular" id="grupo_muscular">
  <?php
  if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
      echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
    }
  } else {
    echo "<option value=''>No se encontraron grupos musculares</option>";
  }
  ?>
  </select>

  <input type="submit" value="Guardar">
</form>

</body>
</html>
