<?php
session_start();
include 'conexion.php';

if (isset($_SESSION["id"]) && isset($_SESSION["nombre_usuario"]) && isset($_SESSION["tipo_usuario"])) {
    echo "Sesión iniciada. ID de usuario: " . $_SESSION["id"] . ", nombre de usuario: " . $_SESSION["nombre_usuario"] . ", tipo de usuario: " . $_SESSION["tipo_usuario"] . "<br>";
} else {
    echo "Sesión no iniciada.<br>";
}

if (isset($_SESSION['mensaje'])) {
    echo $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}



$sql = "SELECT * FROM grupos_musculares";
$resultado = $conn->query($sql);

// $conn->close();

$sql_ejercicios = "SELECT id, titulo FROM articulos";
$resultado_ejercicios = $conn->query($sql_ejercicios);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutinas de Entrenamiento</title>
    <link rel="stylesheet" href="styles.css">

    <script>
        function eliminarArticulo(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este artículo?')) {
                window.location.href = 'eliminar_articulo.php?id=' + id;
            }
        }
        function eliminarRutina(id) { 
            if (confirm('¿Estás seguro de que deseas eliminar esta rutina?')) {
                window.location.href = 'eliminar_rutina.php?id=' + id;
            }
        }

    </script>

    

</head>
<body>
    <div class="container">
        <h1>Rutinas de Entrenamiento</h1>
        
        <form action="rutinas.php" method="POST">
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

            <input type="submit" value="Mostrar rutina">
        </form>

        
    <h2>Crear rutina personalizada</h2>
    <form action="rutinas.php" method="POST">
        <input type="hidden" name="accion" value="crear_rutina">
        <label for="nombre_rutina">Nombre de la rutina:</label>
        <input type="text" name="nombre_rutina" id="nombre_rutina" required>
        
        <label for="ejercicios">Ejercicios:</label>
        <select name="ejercicios[]" id="ejercicios" multiple required>
            <?php
                if ($resultado_ejercicios->num_rows > 0) {
                    while ($row = $resultado_ejercicios->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['titulo'] . '</option>';
                    }
                } else {
                    echo "<option value=''>No se encontraron ejercicios</option>";
                }
            ?>

        </select>

        <input type="submit" value="Crear rutina">
    </form>
    
    


        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'conexion.php';

            if (isset($_POST['accion']) && $_POST['accion'] == 'crear_rutina') {
                // Procesar la creación de la rutina personalizada
                $nombre_rutina = $_POST['nombre_rutina'];
                $ejercicios = $_POST['ejercicios'];
            
                // Guardar la rutina en la base de datos (aquí debes crear una tabla para almacenar las rutinas personalizadas)
                $usuarios_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

                if ($usuarios_id === null) {
                    echo "Debes iniciar sesión para crear una rutina personalizada.";
                    exit;
                }
                $sql_insert = "INSERT INTO rutinas_personalizadas (usuarios_id, nombre) VALUES (?, ?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bind_param("is", $usuarios_id, $nombre_rutina);
                $stmt->execute();

                $rutina_id = $conn->insert_id;

                foreach ($ejercicios as $ejercicio_id) {
                    $sql_insert_ejercicio = "INSERT INTO rutinas_ejercicios (rutinas_personalizadas_id, articulos_id) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql_insert_ejercicio);
                    $stmt->bind_param("id", $rutina_id, $ejercicio_id);
                    $stmt->execute();
                }


                $sql_rutina = "SELECT * FROM rutinas_personalizadas WHERE id = $rutina_id";
                $resultado_rutina = $conn->query($sql_rutina);
                $rutina_personalizada = $resultado_rutina->fetch_assoc();


            
                // Mostrar un mensaje de éxito
                echo "<p>Rutina personalizada creada con éxito.</p>";

                // echo "<h3>Rutina personalizada:</h3>";
                // echo "<p>ID: " . ($rutina_personalizada['id'] ?? 'N/A') . "</p>";
                // echo "<p>Nombre: " . ($rutina_personalizada['nombre'] ?? 'N/A') . "</p>";

                $sql_ejercicios_rutina = "SELECT articulos.titulo FROM rutinas_ejercicios JOIN articulos ON rutinas_ejercicios.articulos_id = articulos.id WHERE rutinas_ejercicios.rutinas_personalizadas_id = $rutina_id";
                $resultado_ejercicios_rutina = $conn->query($sql_ejercicios_rutina);
                // echo "<p>Ejercicios:</p>";
                echo "<ul>";
                while ($row = $resultado_ejercicios_rutina->fetch_assoc()) {
                    echo "<li>" . $row['titulo'] . "</li>";
                }
                echo "</ul>";


            } else {
                
            }
            
            $grupo_muscular_id = isset($_POST['grupo_muscular']) ? $_POST['grupo_muscular'] : null;
            if ($grupo_muscular_id !== null) {
                $sql = "SELECT articulos.id, articulos.titulo, articulos.contenido FROM articulos WHERE articulos.grupo_muscular_id = $grupo_muscular_id";
                $resultado = $conn->query($sql);
            }
            

            if ($resultado->num_rows > 0) {
                // echo "<table>";
                // echo "<tr><th>ID</th><th>Título</th><th>Contenido</th></tr>";
                while ($row = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["titulo"] . "</td>";
                    echo "<td>" . $row["contenido"] . "</td>";
                    echo "<td><button onclick='eliminarArticulo(" . $row["id"] . ")'>Eliminar</button></td>";
                    echo "</tr>";
                }
                // echo "</table>";
            } else {
                echo "No hay ejercicios disponibles.";
            }
            if (isset($_SESSION["id"])) {
                $usuario_id = $_SESSION["id"];
                $sql_rutinas_usuario = "SELECT * FROM rutinas_personalizadas WHERE usuarios_id = $usuario_id";
                $resultado_rutinas_usuario = $conn->query($sql_rutinas_usuario);

                if ($resultado_rutinas_usuario->num_rows > 0) {
                    echo "<h3>Tus rutinas personalizadas:</h3>";
                    while ($rutina = $resultado_rutinas_usuario->fetch_assoc()) {
                        echo "<h4>" . $rutina['nombre'] . "</h4>";

                        $rutina_id = $rutina['id'];
                        $sql_ejercicios_rutina = "SELECT articulos.titulo FROM rutinas_ejercicios JOIN articulos ON rutinas_ejercicios.articulos_id = articulos.id WHERE rutinas_ejercicios.rutinas_personalizadas_id = $rutina_id";
                        $resultado_ejercicios_rutina = $conn->query($sql_ejercicios_rutina);

                        echo "<ul>";
                        while ($row = $resultado_ejercicios_rutina->fetch_assoc()) {
                            echo "<li>" . $row['titulo'] . "</li>";
                        }
                        echo "</ul>";
                    }
                    if (isset($rutina_personalizada['id'])) {
                        echo "<button onclick='eliminarRutina(" . $rutina_personalizada['id'] . ")'>Eliminar</button>";
                    } else {
                        echo "No se pudo obtener el ID de la rutina personalizada.";
                    }
                    
                } else {
                    echo "<p>No tienes rutinas personalizadas.</p>";
                }
            }

            $conn->close();
        }
        ?>

        <a href="index.php" class="back-button">Volver a la página principal</a>
    </div>
</body>
</html>
