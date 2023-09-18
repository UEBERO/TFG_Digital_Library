<?php
include 'conexion.php';

$sql = "SELECT articulos.id, articulos.titulo, articulos.contenido, grupos_musculares.nombre as grupo_muscular 
        FROM articulos 
        JOIN grupos_musculares ON articulos.grupo_muscular_id = grupos_musculares.id";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Título</th><th>Contenido</th><th>Grupo muscular</th><th>Acciones</th></tr>";

    
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["titulo"] . "</td>";
        echo "<td>" . $row["contenido"] . "</td>";
        echo "<td>" . $row["grupo_muscular"] . "</td>";
        echo "<td><button onclick='eliminarArticulo(" . $row["id"] . ")'>Eliminar</button></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "No se encontraron artículos";
}

$conn->close();
?>
