<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once 'db.php';

// Recebe dados do POST
$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$senha = $data['senha'] ?? '';

if (!$email || !$senha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'E-mail inválido.']);
    exit;
}

// Busca usuário
$stmt = $pdo->prepare('SELECT id, nome, email, senha FROM usuarios WHERE email = ?');
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos.']);
    exit;
}

// Simples token de sessão (apenas para exemplo)
$token = base64_encode($usuario['id'] . ':' . $usuario['email'] . ':' . time());

// Retorna dados do usuário e token
echo json_encode([
    'success' => true,
    'token' => $token,
    'usuario' => [
        'id' => $usuario['id'],
        'nome' => $usuario['nome'],
        'email' => $usuario['email']
    ]
]);
?>
