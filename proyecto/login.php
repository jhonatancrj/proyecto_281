<?php
session_start(); // Iniciar la sesión

// Conectar a la base de datos
$conn = new mysqli('localhost', 'usuario', 'contraseña', 'nombre_bd');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario existe, ahora verificamos la contraseña
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['usuario'] = $email; // Guardar el email en la sesión
            header('Location: index.html'); // Redirigir a la página principal
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No existe una cuenta asociada a este correo.";
    }
}

$conn->close();
?>
