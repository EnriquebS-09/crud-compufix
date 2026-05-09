<?php
session_start();
include 'conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

$totalCitas = $conexion->query("
SELECT COUNT(*) AS total
FROM citas
WHERE id_usuario='$id_usuario'
")->fetch_assoc();

$pendientes = $conexion->query("
SELECT COUNT(*) AS total
FROM citas
WHERE estado='Pendiente'
AND id_usuario='$id_usuario'
")->fetch_assoc();

$proceso = $conexion->query("
SELECT COUNT(*) AS total
FROM citas
WHERE estado='En proceso'
AND id_usuario='$id_usuario'
")->fetch_assoc();

$finalizados = $conexion->query("
SELECT COUNT(*) AS total
FROM citas
WHERE estado='Finalizado'
AND id_usuario='$id_usuario'
")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard - CompuFix</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
body {
    background: #0f172a;
    color: white;
}

/* ---------- BARRA LATERAL ---------- */
.sidebar {
    width: 250px;
    height: 100vh;
    background: #111827;
    position: fixed;
    padding-top: 30px;
    color: white; /* Por si acaso algún texto directo */
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 15px 25px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #1e293b;
}

/* ---------- CONTENIDO PRINCIPAL ---------- */
.main {
    margin-left: 250px;
    padding: 30px;
    color: white; /* Asegura todo el texto dentro de .main */
}

/* ---------- TARJETAS ---------- */
.card {
    background: #1e293b;
    border: none;
    border-radius: 15px;
    color: white; /* Texto dentro de la tarjeta */
}

/* Aseguramos títulos, párrafos, labels, etc. dentro de .card */
.card h1, .card h2, .card h3, .card h4, .card h5, .card h6,
.card p, .card span, .card label, .card a {
    color: white;
}

/* ---------- NÚMEROS GRANDES ---------- */
.number {
    font-size: 35px;
    font-weight: bold;
    color: white; /* ¡Clave para que se vea! */
}

/* ---------- FORMULARIOS ---------- */
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

.form-control::placeholder {
    color: #94a3b8;
    opacity: 1;
}

/* ---------- BOTONES ---------- */
.btn-primary {
    background: #2563eb;
    border: none;
    color: white;
}

.btn-primary:hover {
    background: #1d4ed8;
}

/* ---------- ENLACES GENERALES ---------- */
a {
    color: #60a5fa; /* azul claro, o puedes usar white si lo prefieres */
}

</style>

</head>

<body>

<div class="sidebar">

    <h3 class="text-center mb-4">
        CompuFix
    </h3>

    <a href="dashboard.php">
        <i class="bi bi-grid"></i>
        Dashboard
    </a>

    <a href="agendar.php">
        <i class="bi bi-calendar-plus"></i>
        Agendar
    </a>

    <a href="mis_citas.php">
        <i class="bi bi-tools"></i>
        Mis mantenimientos
    </a>

    <?php if($_SESSION['rol'] == 'admin'): ?>

    <a href="admin/citas.php">
        <i class="bi bi-shield-lock"></i>
        Panel Admin
    </a>

    <?php endif; ?>

    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i>
        Cerrar sesión
    </a>

</div>

<div class="main">

    <h2 class="mb-4">
        Bienvenido,
        <?php echo $_SESSION['nombre']; ?>
    </h2>

    <div class="row g-4">

        <div class="col-md-3">

            <div class="card p-4 shadow">

                <h5>Total citas</h5>

                <div class="number">
                    <?php echo $totalCitas['total']; ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card p-4 shadow">

                <h5>Pendientes</h5>

                <div class="number text-warning">
                    <?php echo $pendientes['total']; ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card p-4 shadow">

                <h5>En proceso</h5>

                <div class="number text-primary">
                    <?php echo $proceso['total']; ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card p-4 shadow">

                <h5>Finalizados</h5>

                <div class="number text-success">
                    <?php echo $finalizados['total']; ?>
                </div>

            </div>

        </div>

    </div>

    <div class="row mt-5 g-4">

        <div class="col-md-6">

            <div class="card p-4 shadow">

                <h4>
                    Agendar mantenimiento
                </h4>

                <p>
                    Programa soporte técnico rápidamente.
                </p>

                <a href="agendar.php"
                class="btn btn-primary">

                    Agendar

                </a>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card p-4 shadow">

                <h4>
                    Ver mantenimientos
                </h4>

                <p>
                    Consulta el estado de tus equipos.
                </p>

                <a href="mis_citas.php"
                class="btn btn-success">

                    Ver citas

                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>