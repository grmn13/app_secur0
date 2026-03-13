<?php
session_start();

require_once 'archivo_supersecreto_que_deberia_ser_encriptado_y_que_nadie_deberia_de_ver_pero_que_esta_aqui_en_texto_plano_porque_no_se_que_hacer_con_el_xd.php';

$host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;


if (!isset($_SESSION['usuario_id'])) {
    die("Acceso no autorizado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli($host, $db_user, $db_pass, $db_name);

    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $usuario_id = $_SESSION['usuario_id']; // El ID del usuario logueado

    $sql = "INSERT INTO notas (usuario_id, titulo, contenido) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // "iss" = Integer, String, String
        $stmt->bind_param("iss", $usuario_id, $titulo, $contenido);
        
        if ($stmt->execute()) {
            header("Location: Pagina_princip.php"); // Volver al dashboard
        } else {
            echo "Error al guardar la nota: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>
