<?php
// 1. Inicia o reanuda la sesión actual. 
// Es obligatorio llamarlo para poder acceder a los datos de la sesión que queremos destruir.
session_start();

// 2. Elimina absolutamente toda la información almacenada en $_SESSION (como el ID del usuario o nombre).
// Libera la memoria del servidor asociada a esa sesión específica.
session_destroy();

// 3. Envía un encabezado HTTP al navegador para forzar el redireccionamiento.
// En este caso, manda al usuario de vuelta a la pantalla de login.
header("Location: ../views/login_view.php");