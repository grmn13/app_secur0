<?php
session_start();
 
require_once 'archivo_supersecreto_que_deberia_ser_encriptado_y_que_nadie_deberia_de_ver_pero_que_esta_aqui_en_texto_plano_porque_no_se_que_hacer_con_el_xd.php';

$host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;

// Crear conexión
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
 
// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $salt = "quemecambiendepracticasporfavor";
    $user_input = $_POST['usuario'];
    $pass_input = $_POST['password'] . $salt;
 
    // 2. Query preparada mejorada
    // IMPORTANTE: Seleccionamos también el 'id' para poder usarlo en la sesión
    $sql = "SELECT id, username, password_hash FROM usuarios WHERE username = ?";
    // Preparar la sentencia
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("s", $user_input);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // 4. Verificar el hash de la contraseña
            if (password_verify($pass_input, $row['password_hash'])) {
                // --- CAMBIO CLAVE AQUÍ ---
                // Guardamos el ID del usuario en la sesión para que 'Pagina_princip.php' lo reconozca
                $_SESSION['usuario_id'] = $row['id']; 
                $_SESSION['username'] = $row['username'];
                // Redirigir al dashboard (asegúrate de que el nombre coincide: Pagina_princip.php)
                header("Location: Pagina_princip.php");
                exit();
            } else {
                sleep(3);
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "El usuario no existe.";
        }
 
        // Cerrar la sentencia
        $stmt->close();
    }
}
 
// Cerrar conexión
$conn->close();
?>
