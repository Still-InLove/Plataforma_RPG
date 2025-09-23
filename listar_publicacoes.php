<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once 'db.php';

$stmt = $pdo->query('
    SELECT 
        p.id, 
        p.titulo, 
        p.tipo, 
        p.descricao, 
        p.data_criacao,
        u.nome AS autor_nome
    FROM publicacoes p
    JOIN usuarios u ON p.usuario_id = u.id
    ORDER BY p.data_criacao DESC
');

$publicacoes = [];
while ($row = $stmt->fetch()) {
    $publicacoes[] = $row;
}

echo json_encode(['success' => true, 'publicacoes' => $publicacoes]);
?>