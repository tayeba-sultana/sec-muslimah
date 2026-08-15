<?php

header("Content-Type: application/json");

require_once "../config/database.php";

try {

    $stmt = $pdo->query("
        SELECT
            id,
            title,
            content,
            type,
            icon,
            notice_date
        FROM notices
        WHERE status = 'published'
        ORDER BY
            notice_date DESC,
            id DESC
    ");

    $notices = $stmt->fetchAll();

    echo json_encode([
        "success" => true,
        "notices" => $notices
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not load notices."
    ]);
}