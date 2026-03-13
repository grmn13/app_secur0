// Referencias a elementos
const modal = document.getElementById("noteModal");
const noteForm = document.getElementById("noteForm");
const notesContainer = document.getElementById("notes-container");

// Función para abrir el modal
function openModal() {
    modal.style.display = "block";
}

// Función para cerrar el modal
function closeModal() {
    modal.style.display = "none";
    noteForm.reset(); // Limpia los campos al cerrar
}

// Cerrar si se hace click fuera de la caja blanca
window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}

// Lógica para "Guardar" la nota (Simulación)
noteForm.onsubmit = function(e) {
    e.preventDefault();

    const title = document.getElementById("noteTitle").value;
    const text = document.getElementById("noteText").value;

    // Crear la estructura de la nueva tarjeta
    const newNote = document.createElement("div");
    newNote.classList.add("note-card");
    newNote.innerHTML = `
        <h3>${title}</h3>
        <p>${text}</p>
        <span class="date">Recién creada</span>
    `;

    // Añadirla al principio de la lista
    notesContainer.prepend(newNote);

    // Cerrar el pop-up
    closeModal();
}

// Cargar nombre de usuario (opcional, si vienes de login)
window.onload = function() {
    const user = localStorage.getItem("username") || "Usuario Invitado";
    document.getElementById("username-display").innerText = user;
}