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







// endpoints/login.php


require_once '../conexion.php';



// Para responder a preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


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
