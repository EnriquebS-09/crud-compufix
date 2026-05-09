<?php
session_start();
include '../conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: ../login.php");
    exit();
}

/* =========================
   CAMBIAR ESTADO
========================= */

if(isset($_GET['estado']) && isset($_GET['id'])){

    $estado = $_GET['estado'];
    $id = $_GET['id'];

    $update = "UPDATE citas
    SET estado='$estado'
    WHERE id_cita='$id'";

    $conexion->query($update);

    header("Location: citas.php");
    exit();
}

/* =========================
   ELIMINAR CITA
========================= */

if(isset($_GET['eliminar'])){

    $id = $_GET['eliminar'];

    $delete = "DELETE FROM citas
    WHERE id_cita='$id'";

    $conexion->query($delete);

    header("Location: citas.php");
    exit();
}

/* =========================
   CONSULTA PRINCIPAL
========================= */

$sql = "SELECT citas.*,

usuarios.nombre AS usuario,

servicios.nombre AS servicio

FROM citas

INNER JOIN usuarios
ON citas.id_usuario = usuarios.id_usuario

INNER JOIN servicios
ON citas.id_servicio = servicios.id_servicio

ORDER BY citas.fecha DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        Panel Admin - CompuFix
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        .table{
            color: white;
        }

        .table thead{
            background: #111827;
        }

        .badge-p{
            background: orange;
            padding: 8px;
            border-radius: 8px;
        }

        .badge-e{
            background: #0d6efd;
            padding: 8px;
            border-radius: 8px;
        }

        .badge-f{
            background: green;
            padding: 8px;
            border-radius: 8px;
        }

        .navbar{
            background: #111827 !important;
        }

        .btn{
            margin: 2px;
        }

        h2{
            font-weight: bold;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark px-4">

    <span class="navbar-brand fs-4">
        <i class="bi bi-shield-lock"></i>
        Panel Administrador
    </span>

    <div>

        <a href="../dashboard.php"
        class="btn btn-primary btn-sm">

            <i class="bi bi-grid"></i>
            Dashboard

        </a>

        <a href="../logout.php"
        class="btn btn-danger btn-sm">

            <i class="bi bi-box-arrow-right"></i>
            Cerrar sesión

        </a>

    </div>

</nav>

<!-- CONTENIDO -->

<div class="container py-5">

    <div class="card p-4 shadow">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>
                Gestión de Mantenimientos
            </h2>

            <span class="badge bg-primary fs-6">

                Total:
                <?php echo $resultado->num_rows; ?>

            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle">

                <thead>

                    <tr>

                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Equipo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($fila = $resultado->fetch_assoc()): ?>

                    <tr>

                        <!-- CLIENTE -->

                        <td>
                            <?php echo $fila['usuario']; ?>
                        </td>

                        <!-- SERVICIO -->

                        <td>
                            <?php echo $fila['servicio']; ?>
                        </td>

                        <!-- EQUIPO -->

                        <td>
                            <?php echo $fila['equipo']; ?>
                        </td>

                        <!-- FECHA -->

                        <td>
                            <?php echo $fila['fecha']; ?>
                        </td>

                        <!-- HORA -->

                        <td>
                            <?php echo $fila['hora']; ?>
                        </td>

                        <!-- ESTADO -->

                        <td>

                            <?php

                            if($fila['estado'] == "Pendiente"){

                                echo "
                                <span class='badge-p'>
                                    Pendiente
                                </span>";

                            }

                            elseif($fila['estado'] == "En proceso"){

                                echo "
                                <span class='badge-e'>
                                    En proceso
                                </span>";

                            }

                            else{

                                echo "
                                <span class='badge-f'>
                                    Finalizado
                                </span>";

                            }

                            ?>

                        </td>

                        <!-- ACCIONES -->

                        <td>

                            <!-- PENDIENTE -->

                            <a href="?id=<?php echo $fila['id_cita']; ?>&estado=Pendiente"
                            class="btn btn-warning btn-sm">

                                Pendiente

                            </a>

                            <!-- PROCESO -->

                            <a href="?id=<?php echo $fila['id_cita']; ?>&estado=En proceso"
                            class="btn btn-primary btn-sm">

                                Proceso

                            </a>

                            <!-- FINALIZAR -->

                            <a href="?id=<?php echo $fila['id_cita']; ?>&estado=Finalizado"
                            class="btn btn-success btn-sm">

                                Finalizar

                            </a>

                            <!-- ELIMINAR -->

                            <a href="?eliminar=<?php echo $fila['id_cita']; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar esta cita?')">

                                Eliminar

                            </a>

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