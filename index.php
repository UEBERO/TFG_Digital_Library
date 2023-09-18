<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mi sitio web de artículos</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<nav>
    <div id="menu-box">
        <div id="menu-bar"></div>
        <div id="menu-bar"></div>
        <div id="menu-bar"></div>
    </div>
    <label class="logo">FitVise</label>
    <ul>
        <li><a class="active" href="index.php">Galeria</a></li>
        <li><a href="rutinas.php">Rutinas</a></li>
        <li><a href="calculadora.php">Calculadora</a></li>
        <li><a id="join-btn" href="login.php">Unete</a></li>
        <li><a id='join-btn' href="registro.php">Registrarse</a></li>
    </ul>
</nav>
<h1>Galeria</h1>
<a href="formulario_articulo.php">Agregar artículo</a>
<?php if (isset($_SESSION["nombre_usuario"])): ?>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre_usuario"]); ?></p>
<?php endif; ?>

<hr>
<?php include 'mostrar_articulos.php'; ?>
<script>
    function eliminarArticulo(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este artículo?')) {
            fetch('eliminar_articulo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}`,
            })
                .then((response) => response.text())
                .then((message) => {
                    alert(message);
                    location.reload();
                });
        }
    }
</script>

</body>
</html>
