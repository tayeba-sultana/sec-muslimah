<?php

header("Content-Type: application/json");

require_once "../config/database.php";

try {

    $stmt = $pdo->query("
        SELECT
            id,
            type,
            title,
            arabic,
            content,
            source,
            author
        FROM resources
        WHERE status = 'published'
        ORDER BY id DESC
    ");

    $resources = $stmt->fetchAll();

    echo json_encode([
        "success" => true,
        "resources" => $resources
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not load resources."
    ]);
}