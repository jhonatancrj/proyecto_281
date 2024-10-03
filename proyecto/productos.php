<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'raicesbolivianas';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los productos
$sql = "SELECT * FROM producto"; // Asegúrate de que la tabla se llame 'producto'
$result = $conn->query($sql);

$productos = [];
if ($result) { // Verifica si la consulta fue exitosa
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    } else {
        echo "No hay productos disponibles.";
    }
} else {
    echo "Error en la consulta: " . $conn->error; // Muestra error de consulta
}

$conn->close();
?>
