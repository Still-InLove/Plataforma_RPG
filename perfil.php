<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once 'db.php';

// Simulação de autenticação via token simples
$headers = getallheaders();
$token = $headers['Authorization'] ?? '';
if (!$token) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token não informado.']);
    exit;
}

// Decodifica token (exemplo simples)
$token = str_replace('Bearer ', '', $token);
$partes = explode(':', base64_decode($token));
$user_id = $partes[0] ?? '';
$email = $partes[1] ?? '';

// Busca usuário
$stmt = $pdo->prepare('SELECT id, nome, email FROM usuarios WHERE id = ? AND email = ?');
$stmt->execute([$user_id, $email]);
$usuario = $stmt->fetch();
if (!$usuario) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    exit;
}

// Busca publicações do usuário (exemplo: tabela publicacoes)
$pubs = [];
$stmt = $pdo->prepare('SELECT id, titulo, tipo, descricao FROM publicacoes WHERE usuario_id = ?');
$stmt->execute([$user_id]);
while ($row = $stmt->fetch()) {
    $pubs[] = $row;
}

// Retorna dados do perfil
$response = [
    'success' => true,
    'usuario' => $usuario,
    'publicacoes' => $pubs
];
echo json_encode($response);
?>
