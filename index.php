<?php

// ================= REDIRECCIÓN INICIAL =================

// Cuando el usuario entra al proyecto, automáticamente lo envía al login
header("Location: views/login_view.php");

// Detiene la ejecución del script para evitar que siga cargando código innecesario
exit();