<?php
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios(nombre, email, password)
            VALUES('$nombre', '$email', '$password')";

    if ($conexion->query($sql)) {
        $mensaje = "Usuario registrado correctamente";
    } else {
        $mensaje = "Error al registrar";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - CompuFix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
    background: #0f172a;
    color: white;
}

.card {
    background: #1e293b;
    border-radius: 15px;
    border: none;
    color: white; /* Aseguramos que el texto dentro de la tarjeta sea blanco */
}

/* Aseguramos que cualquier título dentro de .card sea blanco */
.card h1,
.card h2,
.card h3,
.card h4,
.card h5,
.card h6,
.card p,
.card span,
.card label {
    color: white;
}

.form-control {
    background: #334155;
    border: none;
    color: white;
}

.form-control:focus {
    background: #334155;
    color: white;
    box-shadow: none;
}

/* Ajuste para placeholder también */
.form-control::placeholder {
    color: #94a3b8; /* gris claro */
    opacity: 1;
}

.btn-primary {
    background: #2563eb;
    border: none;
    color: white; /* texto del botón blanco */
}

.btn-primary:hover {
    background: #1d4ed8;
}

/* Si hubiera enlaces como "Crear cuenta" */
a {
    color: #60a5fa; /* azul claro visible sobre fondo oscuro */
}
    </style>
</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card p-4 shadow">

                <h2 class="text-center mb-4">Crear Cuenta</h2>

                <?php if($mensaje != ""): ?>
                    <div class="alert alert-info">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Registrarse
                    </button>

                </form>

                <div class="text-center mt-3">
                    <a href="login.php" class="text-info">
                        ¿Ya tienes cuenta?
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>