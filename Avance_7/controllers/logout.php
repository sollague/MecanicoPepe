<?php

// Este controlador destruye la sesión actual y redirige al usuario
// de regreso al formulario de login.
require_once __DIR__ . '/../models/SessionManager.php';
require_once __DIR__ . '/../models/Response.php';

SessionManager::logout();
Response::redirect('../views/login_view.php');