// Mostrar el modal de registro
document.getElementById("registroBtn").addEventListener("click", function() {
    document.getElementById("registroModal").style.display = "block";
});

// Cerrar el modal
document.querySelector(".close").addEventListener("click", function() {
    document.getElementById("registroModal").style.display = "none";
});

// Validar que las contraseñas coincidan
function validarFormulario() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
        alert("Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
        return false; // No enviar el formulario si las contraseñas no coinciden
    }
    return true; // Si coinciden, enviar el formulario
}



// Función para iniciar sesión
function iniciarSesion() {
    var username = document.getElementById("username").value;
    localStorage.setItem("usuario", username); // Guardar el nombre del usuario en localStorage
    alert("Sesión iniciada como: " + username);
    window.location.href = "index.html"; // Redirigir a la página principal
}

// Mostrar el nombre del usuario si está logueado
window.onload = function() {
    var usuario = localStorage.getItem("usuario");
    var userGreeting = document.getElementById("userGreeting");

    if (usuario) {
        // Si el usuario ha iniciado sesión, mostrar su nombre
        userGreeting.innerHTML = `Bienvenido, ${usuario}`;
        userGreeting.style.color = "#5D4037"; // Color del texto del nombre del usuario
        userGreeting.style.marginLeft = "20px"; // Margen para separar del resto
        userGreeting.style.fontSize = "18px"; // Tamaño de la fuente

        // Ocultar el botón de "Iniciar Sesión" y "Registro"
        document.querySelector('a[href="login.html"]').style.display = 'none'; // Ocultar botón de "Iniciar Sesión"
        document.querySelector('a[href="registro.html"]').style.display = 'none'; // Ocultar botón de "Registro"
    }
}
// Función para cerrar sesión
function cerrarSesion() {
    localStorage.removeItem("usuario"); // Eliminar el usuario de localStorage
    window.location.reload(); // Recargar la página para actualizar la interfaz
}
