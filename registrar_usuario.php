<?php
require_once 'archivo_supersecreto_que_deberia_ser_encriptado_y_que_nadie_deberia_de_ver_pero_que_esta_aqui_en_texto_plano_porque_no_se_que_hacer_con_el_xd.php';

$host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (strlen($_POST['new_password']) < 8) {
        die("Error: La contraseña debe tener al menos 8 caracteres.");
    }

    // 2. Validar complejidad con Expresión Regular
    // Requiere: Mayúscula (?=.*[A-Z]), Minúscula (?=.*[a-z]), Número (?=.*[0-9]) 
    // y Símbolo (?=.*[\W_])
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/';

    if (!preg_match($pattern, $_POST['new_password'])) {
        die("Error: La contraseña debe incluir mayúsculas, minúsculas, números y al menos un símbolo.");
    }
    // Recogemos los datos del formulario de registro
    // Nota: Asegúrate que en el HTML los inputs tengan name="new_user" y name="new_password"
    // le voy a poner un salt para que no se sea vulnerable a un ataque con rainbow table jejeA
    $salt = "quemecambiendepracticasporfavor";
    $user = $_POST['new_user'];
    $pass = $_POST['new_password'] . $salt;

    // 2. HASHEAR la contraseña antes de guardarla
    // PASSWORD_DEFAULT utiliza actualmente bcrypt, el estándar de la industria.
    $password_safe = password_hash($pass, PASSWORD_DEFAULT);

    // 3. Query preparada para insertar según tu estructura SQL
    // No insertamos 'id' ni 'fecha_registro' porque son automáticos
    $sql = "INSERT INTO usuarios (username, password_hash) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // "ss" indica que enviamos dos parámetros de tipo String
        $stmt->bind_param("ss", $user, $password_safe);

        try{
            $stmt->execute();
            // Éxito: Redirigir al login con un mensaje de éxito
            header("Location: Pagina_login.html?reg=success");
            exit();
        } catch (mysqli_sql_exception $e) {
            // Error común: El nombre de usuario ya existe (UNIQUE constraint)
            if ($e->getCode() === 1062) {
                echo "Error: El usuario ya existe.";
            } else {
                echo "Error al registrar: " . $conn->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>
