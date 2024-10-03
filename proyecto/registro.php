<?php
// Conexión a la base de datos
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'raicesbolivianas';

$conexion = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['email'];
$contraseña = $_POST['password'];
$confirmarContraseña = $_POST['confirm_password'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

// Verificar que las contraseñas coincidan
if ($contraseña !== $confirmarContraseña) {
    die("Error: Las contraseñas no coinciden.");
}

// Encriptar la contraseña
$contraseñaEncriptada = password_hash($contraseña, PASSWORD_BCRYPT);

// Insertar los datos en la base de datos
$sql = "INSERT INTO Usuario (Nombre, Apellido, Correo, Contraseña, Teléfono, Dirección) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssss", $nombre, $apellido, $correo, $contraseñaEncriptada, $telefono, $direccion);

if ($stmt->execute()) {
    echo "Registro completado exitosamente";
} else {
    echo "Error en la ejecución: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
