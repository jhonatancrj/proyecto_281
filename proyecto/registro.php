<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'raicesbolivianas');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Procesar el formulario de alta de usuarios
if (isset($_POST['alta_usuario'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Encriptar la contraseña
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO Usuario (Nombre, Apellido, Correo, Contraseña, Teléfono, Dirección) 
            VALUES ('$nombre', '$apellido', '$correo', '$contraseña', '$telefono', '$direccion')";

    if ($conexion->query($sql) === TRUE) {
        // Redireccionar usando JavaScript después de un breve retraso
        echo "<script>
                setTimeout(function() {
                    window.location.href = '{$_SERVER['PHP_SELF']}';
                }, 1000);
              </script>";
        exit();
    } else {
        echo "Error al agregar el usuario: " . $conexion->error;
        exit(); // Asegúrate de salir después de imprimir el error
    }
}

// Procesar el formulario de baja de usuarios
if (isset($_POST['baja_usuario'])) {
    $id = $_POST['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM Usuario WHERE ID_Usuario=$id";
    if ($conexion->query($sql) === TRUE) {
        // Redireccionar usando JavaScript después de un breve retraso
        echo "<script>
                setTimeout(function() {
                    window.location.href = '{$_SERVER['PHP_SELF']}';
                }, 1000);
              </script>";
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $conexion->error;
        exit(); // Asegúrate de salir después de imprimir el error
    }
}

// Procesar el formulario de edición de usuarios
if (isset($_POST['edit_usuario'])) {
    $edit_id = $_POST['edit_id'];
    $edit_nombre = $_POST['edit_nombre'];
    $edit_apellido = $_POST['edit_apellido'];
    $edit_correo = $_POST['edit_correo'];
    $edit_telefono = $_POST['edit_telefono'];
    $edit_direccion = $_POST['edit_direccion'];

    // Actualizar los datos del usuario en la base de datos
    $sql = "UPDATE Usuario SET Nombre='$edit_nombre', Apellido='$edit_apellido', Correo='$edit_correo', Teléfono='$edit_telefono', Dirección='$edit_direccion' 
            WHERE ID_Usuario=$edit_id";

    if ($conexion->query($sql) === TRUE) {
        // Redireccionar usando JavaScript después de un breve retraso
        echo "<script>
                setTimeout(function() {
                    window.location.href = '{$_SERVER['PHP_SELF']}';
                }, 1000);
              </script>";
        exit();
    } else {
        echo "Error al modificar el usuario: " . $conexion->error;
        exit(); // Asegúrate de salir después de imprimir el error
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos para botones */
        .btn-agregar, .btn-editar, .btn-eliminar {
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }
        .btn-agregar { background-color: #4CAF50; }
        .btn-editar { background-color: #f1c40f; }
        .btn-eliminar { background-color: #e74c3c; }

        .btn-agregar:hover { background-color: #45a049; }
        .btn-editar:hover { background-color: #d4ac0d; }
        .btn-eliminar:hover { background-color: #c0392b; }

        /* Otros estilos */
        .modal { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Obtener todos los usuarios de la base de datos
        $sql = "SELECT ID_Usuario, Nombre, Apellido, Correo, Teléfono, Dirección FROM Usuario";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th></tr>";
            // Mostrar los datos de cada usuario en la tabla
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['ID_Usuario'] . "</td>";
                echo "<td>" . $fila['Nombre'] . "</td>";
                echo "<td>" . $fila['Apellido'] . "</td>";
                echo "<td>" . $fila['Correo'] . "</td>";
                echo "<td>" . $fila['Teléfono'] . "</td>";
                echo "<td>" . $fila['Dirección'] . "</td>";
                // Botón para eliminar usuario
                echo "<td>
                        <form method='post' action='{$_SERVER['PHP_SELF']}'>
                            <input type='hidden' name='id' value='" . $fila['ID_Usuario'] . "'>
                            <input type='submit' name='baja_usuario' value='Eliminar' class='btn-eliminar'>
                        </form>
                      </td>";
                // Botón para editar usuario
                echo "<td>
                        <button class='btn-editar' onclick='openEditModal(" . $fila['ID_Usuario'] . ", \"" . $fila['Nombre'] . "\", \"" . $fila['Apellido'] . "\", \"" . $fila['Correo'] . "\", \"" . $fila['Teléfono'] . "\", \"" . $fila['Dirección'] . "\")'>Editar</button>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron usuarios en la base de datos.";
        }
        ?>

        <button id="btn-add-usuario" class='btn-agregar'>Agregar Usuario</button>

        <!-- Modal para agregar usuario -->
        <div id="add-usuario-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre"><br><br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido"><br><br>
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo"><br><br>
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña"><br><br>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono"><br><br>
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion"><br><br>
                    <input type="submit" name="alta_usuario" value="Agregar">
                </form>
            </div>
        </div>

        <!-- Modal para editar usuario -->
        <div id="edit-usuario-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="edit-usuario-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <label for="edit_nombre">Nombre:</label>
                    <input type="text" id="edit_nombre" name="edit_nombre"><br><br>
                    <label for="edit_apellido">Apellido:</label>
                    <input type="text" id="edit_apellido" name="edit_apellido"><br><br>
                    <label for="edit_correo">Correo:</label>
                    <input type="email" id="edit_correo" name="edit_correo"><br><br>
                    <label for="edit_telefono">Teléfono:</label>
                    <input type="text" id="edit_telefono" name="edit_telefono"><br><br>
                    <label for="edit_direccion">Dirección:</label>
                    <input type="text" id="edit_direccion" name="edit_direccion"><br><br>
                    <input type="submit" name="edit_usuario" value="Guardar cambios">
                </form>
            </div>
        </div>

    </div>

    <script>
        // Obtener el modal de agregar usuario
        var addModal = document.getElementById("add-usuario-modal");

        // Obtener el botón para abrir el modal de agregar usuario
        var addBtn = document.getElementById("btn-add-usuario");

        // Obtener el botón para cerrar el modal de agregar usuario
        var addSpan = document.getElementById("add-usuario-modal").getElementsByClassName("close")[0];

        // Cuando se haga clic en el botón, abrir el modal de agregar usuario
        addBtn.onclick = function() {
            addModal.style.display = "block";
        }

        // Cuando se haga clic en <span> (x), cerrar el modal de agregar usuario
        addSpan.onclick = function() {
            addModal.style.display = "none";
        }

        // Cuando se haga clic en cualquier lugar fuera del modal, cerrar el modal de agregar usuario
        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = "none";
            }
        }

        // Función para abrir el modal de editar usuario y prellenar los campos
        function openEditModal(id, nombre, apellido, correo, telefono, direccion) {
            var editModal = document.getElementById("edit-usuario-modal");
            var editForm = document.getElementById("edit-usuario-form");

            // Poner los valores del usuario en los campos del formulario de edición
            editForm.elements["edit_id"].value = id;
            editForm.elements["edit_nombre"].value = nombre;
            editForm.elements["edit_apellido"].value = apellido;
            editForm.elements["edit_correo"].value = correo;
            editForm.elements["edit_telefono"].value = telefono;
            editForm.elements["edit_direccion"].value = direccion;

            // Mostrar el modal de editar usuario
            editModal.style.display = "block";
        }

        // Obtener el botón para cerrar el modal de editar usuario
        var editSpan = document.getElementById("edit-usuario-modal").getElementsByClassName("close")[0];

        // Cuando se haga clic en <span> (x), cerrar el modal de editar usuario
        editSpan.onclick = function() {
            var editModal = document.getElementById("edit-usuario-modal");
            editModal.style.display = "none";
        }
    </script>
</body>
</html>
