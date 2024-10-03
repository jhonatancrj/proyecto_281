<?php
session_start();
session_destroy(); // Cerrar la sesión
header('Location: index.html'); // Redirigir a la página principal
exit();
?>
