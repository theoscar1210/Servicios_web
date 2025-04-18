<?php

// HABILITAR CORS PARA EL FRONTEND
header("Access-Control-Allow-Origin: *"); // Puedes reemplazar * por http://127.0.0.1:5500 si prefieres
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// RESPUESTA ANTES DE ENVIAR EL FETCH, PARA OPCIONES
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



// endpoints/register.php
header('Content-Type: application/json');

require_once '../conexion.php';

// Habilita CORS



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
