<?php

// ================= REDIRECCIÓN INICIAL =================
// Este archivo es el punto de entrada de la aplicación. Su única
// responsabilidad es redirigir al usuario a la pantalla de login.
// Esto evita la exposición de lógica adicional desde la raíz del proyecto.

// Cuando el usuario entra al proyecto, automáticamente lo envía al login
header("Location: views/login_view.php");

// Detiene la ejecución del script para evitar que siga cargando código innecesario
exit();