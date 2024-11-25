<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="carrito.php">Carrito</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signin.php">Registro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container flex-grow-1 mt-4">
        <h2 class="text-center">Inicio de Sesión</h2>
        <form id="loginForm" action="login_handler.php" method="POST" class="mx-auto mt-3" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
        <p class="text-center mt-3">¿No estás registrado? <a href="register.php">Regístrate aquí</a></p>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        Liberty Library All Rights Reserved &reg;
    </footer>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

            if (!passwordRegex.test(password)) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 8 caracteres, incluyendo un número y una letra.');
            }
        });
    </script>
</body>
</html>
