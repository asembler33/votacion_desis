<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";  // Dirección del servidor de la base de datos
$username = "root";         // Nombre de usuario de la base de datos
$password = "";             // Contraseña de la base de datos
$dbname = "votacion_desis"; // Nombre de la base de datos

// Crear una nueva instancia de la clase mysqli para la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión a la base de datos fue exitosa
if ($conn->connect_error) {
    // Si hay un error en la conexión, mostrar un mensaje de error y terminar la ejecución del script
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}


$conn->close();
?>
