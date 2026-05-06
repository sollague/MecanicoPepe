<?php
session_start(); // Inicia la sesión para poder guardar datos del usuario

// ================= VALIDACIÓN DE LOGIN =================

// Verifica si el usuario y contraseña enviados por el formulario son correctos
if ($_POST['usuario'] == "admin" && $_POST['password'] == "1234") {

    // Si son correctos, se guarda el usuario en sesión
    $_SESSION['usuario'] = "admin";

    // Redirige al dashboard (pantalla principal del sistema)
    header("Location: ../views/dashboard_view.php");
    exit();

} else {

    // Si los datos son incorrectos, muestra un mensaje de error
    echo "Credenciales incorrectas";
}