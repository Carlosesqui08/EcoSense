<?php
// Conexión a la base de datos
$servername = "sql306.infinityfree.com";
$username = "if0_38994223";
$password = "SGMDEZDyAv8Lsj2";
$dbname = "if0_38994223_ecosense_io";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para registrar un nuevo usuario
function registrarUsuario($usuario, $correo, $contrasena) {
    global $conn;
    // Escapar los datos para prevenir inyección SQL
    $usuario = $conn->real_escape_string($usuario);
    $correo = $conn->real_escape_string($correo);
    // Hash de la contraseña para seguridad
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (usuario, correo, contrasena) VALUES ('$usuario', '$correo', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Función para iniciar sesión
function iniciarSesion($usuario, $contrasena) {
    global $conn;
    // Escapar los datos para prevenir inyección SQL
    $usuario = $conn->real_escape_string($usuario);
    
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['contrasena'])) {
            // Inicio de sesión exitoso - podrías iniciar una sesión aquí
            // session_start();
            // $_SESSION['usuario_id'] = $row['id'];
            // $_SESSION['usuario_nombre'] = $row['usuario'];
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Función para almacenar datos del sensor
function guardarDatosSensor($temperatura, $humedad, $ppm, $luz, $foco) {
    global $conn;
    // Convertir y escapar datos para seguridad
    $temperatura = floatval($temperatura);
    $humedad = floatval($humedad);
    $ppm = floatval($ppm);
    $luz = floatval($luz);
    $foco = $conn->real_escape_string($foco);
    
    $sql = "INSERT INTO datos_sensores (temperatura, humedad, ppm, luz, foco) 
            VALUES ($temperatura, $humedad, $ppm, $luz, '$foco')";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// No cerrar la conexión aquí, ya que este archivo será incluido en otros
// y necesitaremos la conexión activa
// $conn->close();
?>