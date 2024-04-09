<?php

session_start(); // Inicia la sesión


// Conectar con la base de datos
$servername = "localhost";
$username = "pw";
$password = "pw";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$bd = mysqli_select_db($conn, 'easyway');
if(!$bd) {
    echo"Error al seleccionar la base de datos.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $query = "INSERT INTO usuario (nombre, email, contrasena) VALUES ('$nombre', '$email', '$contrasena')";
    $result = mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn)) {
        $_SESSION['ID'] = mysqli_insert_id($conn);
        header("Location: index.php");
    }
    else {
        echo "Usuario o contraseña incorrectos";
    }
}

?>

<h1 align="center">Inicio de Sesión</h1>

<form  method='post' action='register.php'>
    <input type = 'text' name = 'nombre' placeholder = 'Nombre' required><br>
    <input type = 'email' name = 'email' placeholder = 'Email' required><br>
    <input type = 'contrasena' name = 'contrasena' placeholder = 'Contraseña' required><br>
    <input type = 'submit' value = 'Registrate'>
</form>

