<?php
session_start();
include 'conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT citas.*, servicios.nombre AS servicio

FROM citas

INNER JOIN servicios
ON citas.id_servicio = servicios.id_servicio

WHERE citas.id_usuario = '$id_usuario'

ORDER BY citas.fecha DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas - CompuFix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background: #0f172a;
            color: white;
        }

        .table{
            color: white;
        }

        .card{
            background: #1e293b;
            border: none;
            border-radius: 15px;
        }

        .badge-pendiente{
            background: orange;
        }

        .badge-proceso{
            background: #0d6efd;
        }

        .badge-finalizado{
            background: green;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-dark bg-dark px-4">

    <a href="dashboard.php" class="navbar-brand">
        CompuFix
    </a>

    <div>

        <a href="agendar.php" class="btn btn-primary btn-sm">
            Nueva cita
        </a>

        <a href="logout.php" class="btn btn-danger btn-sm">
            Cerrar sesión
        </a>

    </div>

</nav>

<div class="container py-5">

    <div class="card p-4 shadow">

        <h2 class="mb-4">
            Mis Mantenimientos
        </h2>

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle">

                <thead>

                    <tr>
                        <th>Servicio</th>
                        <th>Equipo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>

                </thead>

                <tbody>

                    <?php while($fila = $resultado->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $fila['servicio']; ?>
                        </td>

                        <td>
                            <?php echo $fila['equipo']; ?>
                        </td>

                        <td>
                            <?php echo $fila['fecha']; ?>
                        </td>

                        <td>
                            <?php echo $fila['hora']; ?>
                        </td>

                        <td>

                            <?php
                            
                            if($fila['estado'] == "Pendiente"){
                                echo "<span class='badge badge-pendiente'>Pendiente</span>";
                            }

                            elseif($fila['estado'] == "En proceso"){
                                echo "<span class='badge badge-proceso'>En proceso</span>";
                            }

                            else{
                                echo "<span class='badge badge-finalizado'>Finalizado</span>";
                            }

                            ?>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>