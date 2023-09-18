<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Macronutrientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Calculadora de Macronutrientes</h1>
        <form action="calculadora.php" method="POST">
            <label for="peso">Peso (kg):</label>
            <input type="number" name="peso" id="peso" required>

            <label for="altura">Altura (cm):</label>
            <input type="number" name="altura" id="altura" required>

            <label for="edad">Edad (años):</label>
            <input type="number" name="edad" id="edad" required>

            <label for="genero">Género:</label>
            <select name="genero" id="genero" required>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
            </select>

            <label for="nivel_actividad">Nivel de actividad:</label>
            <select name="nivel_actividad" id="nivel_actividad" required>
                <option value="sedentario">Sedentario</option>
                <option value="ligero">Ligero</option>
                <option value="moderado">Moderado</option>
                <option value="intenso">Intenso</option>
                <option value="muy_intenso">Muy intenso</option>
            </select>

            <input type="submit" value="Calcular macronutrientes">
        </form>

        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $peso = $_POST['peso'];
                $altura = $_POST['altura'];
                $edad = $_POST['edad'];
                $genero = $_POST['genero'];
                $nivel_actividad = $_POST['nivel_actividad'];
            
                // Calcular Tasa metabólica basal (TMB) usando la ecuación de Mifflin-St Jeor
                if ($genero == 'masculino') {
                    $tmb = (10 * $peso) + (6.25 * $altura) - (5 * $edad) + 5;
                } else {
                    $tmb = (10 * $peso) + (6.25 * $altura) - (5 * $edad) - 161;
                }
            
                // Calcular las calorías diarias necesarias según el nivel de actividad
                $multiplicador_actividad = [
                    'sedentario' => 1.2,
                    'ligero' => 1.375,
                    'moderado' => 1.55,
                    'intenso' => 1.725,
                    'muy_intenso' => 1.9,
                ];
            
                $calorias = $tmb * $multiplicador_actividad[$nivel_actividad];
            
                // Calcular macronutrientes
                $proteinas = $peso * 2.2; // 2.2 g de proteínas por kg de peso
                $grasas = ($calorias * 0.25) / 9; // 25% de calorías provienen de grasas
                $carbohidratos = ($calorias - (($proteinas * 4) + ($grasas * 9))) / 4;
            
                echo "<div class='resultados'>";
                echo "<h3>Resultados:</h3>";
                echo "<div class='resultado'><span>Calorías:</span><span>" . round($calorias) . " kcal</span></div>";
                echo "<div class='resultado'><span>Proteínas:</span><span>" . round($proteinas) . " g</span></div>";
                echo "<div class='resultado'><span>Grasas:</span><span>" . round($grasas) . " g</span></div>";
                echo "<div class='resultado'><span>Carbohidratos:</span><span>" . round($carbohidratos) . " g</span></div>";
                echo "</div>";

            }
            
        ?>

        <a href="index.php" class="back-button">Volver a la página principal</a>
    </div>
</body>
</html>
