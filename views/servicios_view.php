<?php
// ================= LISTA DE SERVICIOS =================
// Simulación de base de datos usando un array

$servicios = [
    ["id" => 1, "nombre" => "Cambio de aceite", "precio" => 25, "desc" => "Lubricación del motor"],
    ["id" => 2, "nombre" => "Revisión general", "precio" => 40, "desc" => "Chequeo completo"],
    ["id" => 3, "nombre" => "Alineación y balanceo", "precio" => 30, "desc" => "Mejora estabilidad"],
    ["id" => 4, "nombre" => "Cambio de frenos", "precio" => 60, "desc" => "Sistema de seguridad"]
];

// ================= LISTA DE MECÁNICOS =================
// Simulación de perfiles de mecánicos con experiencia y rating

$mecanicos = [
    ["nombre" => "Juan", "exp" => "5 años", "rating" => "4.5"],
    ["nombre" => "Carlos", "exp" => "8 años", "rating" => "4.8"],
    ["nombre" => "Pedro", "exp" => "3 años", "rating" => "4.2"]
];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Servicios</title>

    <!-- Estilos globales del sistema -->
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <div class="container">

        <!-- Título del módulo -->
        <h2>Solicitar Servicio</h2>

        <!-- ================= FORMULARIO PRINCIPAL ================= -->
        <!-- Envía datos al controlador para procesar factura -->
        <form method="POST" action="../controllers/ServicioController.php">

            <!-- ================= DATOS DEL CLIENTE ================= -->
            <h3>Datos del cliente</h3>

            <input type="text" name="cliente" placeholder="Nombre completo" required>
            <input type="text" name="cedula" placeholder="Cédula" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="vehiculo" placeholder="Vehículo" required>

            <!-- ================= SELECCIÓN DE MECÁNICO ================= -->
            <h3>Selecciona un mecánico</h3>

            <!-- Recorre lista de mecánicos -->
            <?php foreach ($mecanicos as $index => $m): ?>
                <div class="box">

                    <!-- Radio button: solo permite elegir uno -->
                    <input type="radio" name="mecanico" value="<?= $index ?>" required>

                    <strong><?= $m['nombre'] ?></strong><br>

                    Experiencia: <?= $m['exp'] ?><br>

                    Calificación: ⭐ <?= $m['rating'] ?>

                </div>
            <?php endforeach; ?>

            <!-- ================= SERVICIOS ================= -->
            <h3>Servicios</h3>

            <!-- Recorre lista de servicios disponibles -->
            <?php foreach ($servicios as $s): ?>
                <div class="box">

                    <!-- Checkbox: permite seleccionar varios -->
                    <input type="checkbox" name="servicios[]" value="<?= $s['id'] ?>">

                    <strong><?= $s['nombre'] ?></strong> - $<?= $s['precio'] ?><br>

                    <small><?= $s['desc'] ?></small>

                </div>
            <?php endforeach; ?>

            <!-- Botón final -->
            <button type="submit">Generar factura</button>

        </form>

    </div>
</body>

</html>