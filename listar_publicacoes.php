<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once 'db.php';


$tipo = $_GET['tipo'] ?? null;

$sql = '
    SELECT 
        p.id, 
        p.titulo, 
        p.tipo, 
        p.descricao, 
        p.data_criacao,
        u.nome AS autor_nome
    FROM publicacoes p
    JOIN usuarios u ON p.usuario_id = u.id
';

if ($tipo) {
    $sql .= ' WHERE p.tipo = :tipo';
}

$sql .= ' ORDER BY p.data_criacao DESC';

$stmt = $pdo->prepare($sql);


if ($tipo) {
    $stmt->bindValue(':tipo', $tipo);
}


$stmt->execute();

$publicacoes = [];
while ($row = $stmt->fetch()) {
    $publicacoes[] = $row;
}

echo json_encode(['success' => true, 'publicacoes' => $publicacoes]);