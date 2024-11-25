<?php
session_start();
$conexion = new mysqli('localhost', 'root', '', 'libreria');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $query = "SELECT * FROM USUARIOS WHERE email = '$email'";
    $result = $conexion->query($query);

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['contraseña'])) {
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['usuario_id'] = $usuario['ID']; // ID del usuario para usar en otras operaciones
            header("Location: index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El correo electrónico no está registrado.";
    }
}

$conexion->close();
?>
