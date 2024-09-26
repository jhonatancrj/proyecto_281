// Seleccionar los elementos
const modal = document.getElementById('registroModal');
const btn = document.getElementById('registroBtn');
const closeBtn = document.querySelector('.close');

// Mostrar el modal al hacer clic en el botón de registro
btn.onclick = function() {
    modal.style.display = 'flex';
}

// Cerrar el modal al hacer clic en la "x"
closeBtn.onclick = function() {
    modal.style.display = 'none';
}

// Cerrar el modal al hacer clic fuera del contenido
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
