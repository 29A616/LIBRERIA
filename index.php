<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web SPA - Proyecto Final</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-primary text-white p-3 text-center">
        <h1>Liberty Library</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="signin.php">Registro</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 container">
        <section class="destacados mb-5">
            <h2 class="text-center mb-3">Libros Destacados</h2>
            <div class="d-flex justify-content-between">
                <?php
                $conexion = new mysqli('localhost', 'root', '', 'libreria', 3306);

                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }

                $query_destacados = "SELECT ID, titulo, autor FROM libros ORDER BY titulo ASC LIMIT 3";
                $result_destacados = $conexion->query($query_destacados);

                if ($result_destacados->num_rows > 0) {
                    while ($row = $result_destacados->fetch_assoc()) {
                        echo "
                        <div class='card' style='width: 30%;'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['titulo']}</h5>
                                <p class='card-text'>Autor: {$row['autor']}</p>
                                <form method='POST' action='index_handler.php'>
                                    <input type='hidden' name='libro_id' value='{$row['ID']}'>
                                    <button type='submit' class='btn btn-primary w-100'>Agregar al Carrito</button>
                                </form>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p class='text-center'>No hay libros destacados disponibles.</p>";
                }
                ?>
            </div>
        </section>

        <section class="lista-completa">
            <h2 class="text-center mb-3">Lista de libros</h2>
            <ul class="list-group">
                <?php
                $query_libros = "SELECT ID, titulo, autor FROM libros ORDER BY titulo ASC";
                $result_libros = $conexion->query($query_libros);

                if ($result_libros->num_rows > 0) {
                    while ($row = $result_libros->fetch_assoc()) {
                        echo "
                        <li class='list-group-item d-flex justify-content-between align-items-center'>
                            <div>
                                <strong>{$row['titulo']}</strong> - Autor: {$row['autor']}
                            </div>
                            <form method='POST' action='index_handler.php'>
                                <input type='hidden' name='libro_id' value='{$row['ID']}'>
                                <button type='submit' class='btn btn-primary'>Agregar al Carrito</button>
                            </form>
                        </li>";
                    }
                } else {
                    echo "<li class='list-group-item'>No hay libros disponibles.</li>";
                }

                $conexion->close();
                ?>
            </ul>
        </section>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        Liberty Library All Rights Reserved &reg;
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
