<?php
// Ativa a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define o cabeçalho para responder em formato JSON
header('Content-Type: application/json');

// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';

// --- Autenticação do usuário usando o token de sessão ---
$headers = getallheaders();
$token = $headers['Authorization'] ?? '';
if (!$token) {
    http_response_code(401); // 401 Unauthorized
    echo json_encode(['success' => false, 'message' => 'Token não informado.']);
    exit;
}

// Decodifica o token para obter o ID do usuário
$token = str_replace('Bearer ', '', $token);
$partes = explode(':', base64_decode($token));
$usuario_id = $partes[0] ?? '';

// Busca e valida se o usuário existe no banco de dados
$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE id = ?');
$stmt->execute([$usuario_id]);
if (!$stmt->fetch()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuário não autorizado.']);
    exit;
}

// --- Recebe e valida os dados da publicação ---
$data = json_decode(file_get_contents('php://input'), true);
$titulo = trim($data['titulo'] ?? '');
$tipo = trim($data['tipo'] ?? '');
$descricao = trim($data['descricao'] ?? '');

if (!$titulo || !$tipo || !$descricao) {
    http_response_code(400); // 400 Bad Request
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos.']);
    exit;
}

// --- Insere a nova publicação no banco de dados ---
try {
    $stmt = $pdo->prepare('INSERT INTO publicacoes (usuario_id, titulo, tipo, descricao) VALUES (?, ?, ?, ?)');
    if ($stmt->execute([$usuario_id, $titulo, $tipo, $descricao])) {
        echo json_encode(['success' => true, 'message' => 'Conteúdo publicado com sucesso!']);
    } else {
        http_response_code(500); // 500 Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Erro ao publicar conteúdo.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar com o banco de dados.']);
}