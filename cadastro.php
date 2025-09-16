<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// cadastro.php
header('Content-Type: application/json');
require_once 'db.php';

// Recebe dados do POST
$data = json_decode(file_get_contents('php://input'), true);
$nome = trim($data['nome'] ?? '');
$email = trim($data['email'] ?? '');
$senha = $data['senha'] ?? '';

// Validação básica
if (!$nome || !$email || !$senha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'E-mail inválido.']);
    exit;
}

// Verifica se o e-mail já existe
$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado.']);
    exit;
}

// Salva usuário
$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)');
if ($stmt->execute([$nome, $email, $hash])) {
    echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário.']);
}
?>
