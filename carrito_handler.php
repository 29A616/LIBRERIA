<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli('localhost', 'root', '', 'libreria', 3306);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$usuario_id = $_SESSION['usuario_id']; // ID del usuario autenticado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pagar'])) {
        // Lógica para pagar (podría incluir generación de factura)
        echo "Gracias por tu compra. Tu carrito ha sido vaciado.";
    } elseif (isset($_POST['vaciar'])) {
        echo "Tu carrito ha sido vaciado.";
    }

    // Vaciar el carrito
    $query_vaciar = "DELETE FROM carrito WHERE usuario_id = $usuario_id";
    if ($conexion->query($query_vaciar)) {
        header("Location: carrito.php");
        exit;
    } else {
        echo "Error al vaciar el carrito: " . $conexion->error;
    }
}

$conexion->close();
?>
