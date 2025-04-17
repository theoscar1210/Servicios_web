<?php
// endpoints/register.php
header('Content-Type: application/json');

require_once '../db/conexion.php';

// Obtener datos del POST
$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'] ?? '';
$password = $data['password'] ?? '';

if ($usuario && $password) {
    // Verificar si ya existe
    $query = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $query->execute([$usuario]);

    if ($query->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'mensaje' => 'El usuario ya existe.']);
    } else {
        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        $insert->execute([$usuario, $hashedPassword]);

        echo json_encode(['status' => 'success', 'mensaje' => 'Usuario registrado exitosamente.']);
    }
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Usuario y contraseña son obligatorios.']);
}
