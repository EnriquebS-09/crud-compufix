<?php
session_start();
include 'conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

$mensaje = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id_usuario = $_SESSION['id_usuario'];

    $id_servicio = $_POST['servicio'];
    $equipo = $_POST['equipo'];
    $problema = $_POST['problema'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $sql = "INSERT INTO citas
    (id_usuario, id_servicio, equipo, problema, fecha, hora)

    VALUES

    ('$id_usuario','$id_servicio','$equipo','$problema','$fecha','$hora')";

    if($conexion->query($sql)){
        $mensaje = "Cita agendada correctamente";
    }else{
        $mensaje = "Error al agendar";
    }
}

$servicios = $conexion->query("SELECT * FROM servicios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar - CompuFix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #0f172a;
            color: white;
        }

        .card{
            background: #1e293b;
            border: none;
            border-radius: 15px;
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


        .form-control,
        .form-select{
            background: #334155;
            border: none;
            color: white;
        }

        .form-control:focus,
        .form-select:focus{
            background: #334155;
            color: white;
            box-shadow: none;
        }

        .btn-custom{
            background: #2563eb;
            border: none;
            color: white;
        }

        .btn-custom:hover{
            background: #1d4ed8;
        }
        .placeholder{
            color:white;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-dark bg-dark px-4">

    <a href="dashboard.php" class="navbar-brand">
        CompuFix
    </a>

    <a href="logout.php" class="btn btn-danger btn-sm">
        Cerrar sesión
    </a>

</nav>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card p-4 shadow">

                <h2 class="mb-4 text-center">
                    Agendar Mantenimiento
                </h2>

                <?php if($mensaje != ""): ?>

                    <div class="alert alert-info">
                        <?php echo $mensaje; ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label>Servicio</label>

                        <select name="servicio" class="form-select" required>

                            <option value="">Seleccione</option>

                            <?php while($servicio = $servicios->fetch_assoc()): ?>

                                <option value="<?php echo $servicio['id_servicio']; ?>">

                                    <?php echo $servicio['nombre']; ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Equipo</label>

                        <input type="text"
                        name="equipo"
                        class="form-control"
                        placeholder="Ejemplo: Laptop HP"
                        required>

                    </div>

                    <div class="mb-3">

                        <label>Problema</label>

                        <textarea
                        name="problema"
                        class="form-control"
                        rows="4"
                        required></textarea>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Fecha</label>

                            <input type="date"
                            name="fecha"
                            class="form-control"
                            required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Hora</label>

                            <input type="time"
                            name="hora"
                            class="form-control"
                            required>

                        </div>

                    </div>

                    <button type="submit"
                    class="btn btn-custom w-100">

                        Agendar

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>