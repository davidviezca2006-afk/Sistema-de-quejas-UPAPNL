<?php
$host = "127.0.0.1:3307";
$user = "root";
$pass = "";
$db = "bd_quejas_upap";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rol = $_POST['rol'];
    $correo = $_POST['correo'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    // Validar correo institucional
    if (!preg_match("/@upapnl\.edu\.mx$/", $correo)) {
        echo "Correo no válido";
        exit;
    }

    // INSERT SEGURO (ANTI SQL INJECTION)
    $stmt = $conn->prepare("INSERT INTO quejas (rol, correo, tipo, descripcion) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $rol, $correo, $tipo, $descripcion);

    if ($stmt->execute()) {
        echo "<h2>Queja registrada correctamente ✅</h2>";
        echo "<a href='index.html'>Volver</a>";
    } else {
        echo "Error al guardar: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>