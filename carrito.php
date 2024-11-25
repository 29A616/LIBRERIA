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
    <title>Carrito de Compras</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link active" href="carrito.php">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="signin.php">Registro</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container flex-grow-1 mt-4">
        <h2 class="text-center">Carrito de Compras</h2>

        <?php
        
        if (!isset($_SESSION['usuario'])) {
            echo "<p class='text-center text-danger'>Debe iniciar sesión para usar el carrito.</p>";
            echo "<p class='text-center'><a href='login.php' class='btn btn-primary'>Iniciar Sesión</a></p>";
        } else {
            $conexion = new mysqli('localhost', 'root', '', 'libreria', 3306);

            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }

            $usuario_id = $_SESSION['usuario_id'];
            $query_carrito = "SELECT libros.titulo, libros.autor, carrito.cantidad, 
                              (libros.precio * carrito.cantidad) AS total
                              FROM carrito
                              INNER JOIN libros ON carrito.libro_id = libros.ID
                              WHERE carrito.usuario_id = $usuario_id";

            $result_carrito = $conexion->query($query_carrito);

            if ($result_carrito->num_rows > 0) {
                $monto_total = 0;

                echo "<table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($row = $result_carrito->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['titulo']}</td>
                            <td>{$row['autor']}</td>
                            <td>{$row['cantidad']}</td>
                            <td>\${$row['total']}</td>
                          </tr>";
                    $monto_total += $row['total'];
                }

                echo "</tbody>
                      </table>";
                echo "<p class='text-end'><strong>Monto Total: \${$monto_total}</strong></p>";
                
                echo "<div class='text-center'>
                        <form method='POST' action='carrito_handler.php'>
                            <button type='submit' name='pagar' class='btn btn-success'>Pagar</button>
                            <button type='submit' name='vaciar' class='btn btn-danger'>Vaciar Carrito</button>
                        </form>
                      </div>";
            } else {
                echo "<p class='text-center'>Tu carrito está vacío.</p>";
            }

            $conexion->close();
        }
        ?>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        Liberty Library All Rights Reserved &reg;
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
