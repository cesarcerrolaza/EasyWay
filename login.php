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
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuario WHERE email = '$email' AND contrasena = '$contrasena'";
    $result = mysqli_query($conn, $query);
    
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['ID'] = $row['id'];
        header("Location: index.php");
    }
    else {
        echo "Usuario o contraseña incorrectos";
    }
}

?>

<h1 align="center">Registro</h1>

<form  method='post' action='login.php'>
    <input type = 'email' name = 'email' placeholder = 'Email' required><br>
    <input type = 'contrasena' name = 'contrasena' placeholder = 'Contraseña' required><br>
    <input type = 'submit' value = 'Iniciar sesión'>
</form>

<form  method='get' action='register.php'>
    <input type = 'submit' value = 'Registrarse'>
</form>