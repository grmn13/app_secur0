<?php
session_start();

require_once 'archivo_supersecreto_que_deberia_ser_encriptado_y_que_nadie_deberia_de_ver_pero_que_esta_aqui_en_texto_plano_porque_no_se_que_hacer_con_el_xd.php';
// Si no hay sesión, devolvemos al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Pagina_login.html");
    exit();
}
// Conexión a la base de datos

$host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Notas - Dashboard</title>
    <link rel="stylesheet" href="Pagina_princip.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">NoteApp</div>
        <div class="user-info">
            Bienvenido, <span id="username-display"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
    </header>

    <main class="container">
        <section class="actions">
            <button class="btn-new-note" onclick="openModal()">+ Nueva Nota</button>
        </section>

        <section class="notes-grid" id="notes-container">
            <?php
            // CONSULTA PREPARADA para traer solo las notas de este usuario
            $stmt = $conn->prepare("SELECT titulo, contenido, fecha_creacion FROM notas WHERE usuario_id = ? ORDER BY fecha_creacion DESC");
            $stmt->bind_param("i", $_SESSION['usuario_id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($nota = $result->fetch_assoc()) {
                    echo '<div class="note-card">';
                    echo '<h3>' . htmlspecialchars($nota['titulo']) . '</h3>';
                    echo '<p>' . nl2br(htmlspecialchars($nota['contenido'])) . '</p>';
                    echo '<span class="date">' . $nota['fecha_creacion'] . '</span>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tienes notas aún. ¡Crea la primera!</p>';
            }
            $stmt->close();
            ?>
        </section>
    </main>

    <div id="noteModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Crear Nueva Nota</h2>
            <form action="guardar_nota.php" method="POST">
                <input type="text" name="titulo" placeholder="Título de la nota" required>
                <textarea name="contenido" placeholder="Escribe tu nota aquí..." rows="10" required></textarea>
                <button type="submit" class="btn-save">Guardar Nota</button>
            </form>
        </div>
    </div>

    <script src="Pagina_princip.js"></script>
</body>
</html>
