<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "<p class='text-center text-danger'>Debes iniciar sesión para agregar libros al carrito.</p>";
    header("refresh:3;url=login.php");
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'libreria', 3306);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el ID del libro y el usuario
$usuario_id = $_SESSION['usuario_id'];
$libro_id = $_POST['libro_id'];

// Verificar si el libro ya está en el carrito
$query_verificar = "SELECT * FROM carrito WHERE usuario_id = $usuario_id AND libro_id = $libro_id";
$result = $conexion->query($query_verificar);

if ($result->num_rows > 0) {
    // Incrementar la cantidad si ya está en el carrito
    $query_actualizar = "UPDATE carrito SET cantidad = cantidad + 1 WHERE usuario_id = $usuario_id AND libro_id = $libro_id";
    $conexion->query($query_actualizar);
} else {
    // Agregar el libro al carrito si no está
    $query_insertar = "INSERT INTO carrito (usuario_id, libro_id, cantidad, monto_total) 
                       VALUES ($usuario_id, $libro_id, 1, (SELECT precio FROM libros WHERE ID = $libro_id))";
    $conexion->query($query_insertar);
}

// Redirigir al catálogo después de agregar
header("Location: index.php");
exit;

$conexion->close();
?>