<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'libreria', 3306);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificación si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $passwordConfirm = mysqli_real_escape_string($conexion, $_POST['passwordConfirm']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);

    // Validación de contraseñas coincidentes
    if ($password !== $passwordConfirm) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Validar que el email no exista ya
    $query = "SELECT * FROM USUARIOS WHERE email = '$email'";
    $result = $conexion->query($query);
    
    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
        exit;
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $query = "INSERT INTO USUARIOS (nombre, email, contraseña, dirección, teléfono) 
              VALUES ('$nombre', '$email', '$hashed_password', '$direccion', '$telefono')";

    if ($conexion->query($query)) {
        echo "Registro exitoso. Ahora puedes iniciar sesión. Espera mientras eres redirigido automáticamente";
        header("refresh:3;url=login.php");
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
        header("refresh:3;url=signin.php");
    }
}

$conexion->close();
?>
