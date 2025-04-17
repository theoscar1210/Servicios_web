<?php
// endpoints/login.php
header('Content-Type: application/json');

require_once '../db/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$usuario = $data['usuario'] ?? '';
$password = $data['password'] ?? '';

if ($usuario && $password) {
    $stmt = $conn->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar contraseña
        if (password_verify($password, $row['password'])) {
            echo json_encode(['status' => 'success', 'mensaje' => 'Autenticación satisfactoria.']);
        } else {
            echo json_encode(['status' => 'error', 'mensaje' => 'Contraseña incorrecta.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'Usuario no encontrado.']);
    }
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Usuario y contraseña son requeridos.']);
}
