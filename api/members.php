<?php

header("Content-Type: application/json");

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Only POST requests are allowed."
    ]);

    exit;
}

/*
 * Get JSON data sent by the frontend
 */
$data = json_decode(
    file_get_contents("php://input"),
    true
);

/*
 * Read the submitted values
 */
$name = trim($data["name"] ?? "");
$student_id = trim($data["student_id"] ?? "");
$department = trim($data["department"] ?? "");
$batch = trim($data["batch"] ?? "");
$reason = trim($data["reason"] ?? "");

/*
 * Basic validation
 */
if ($name === "" || $student_id === "") {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Full Name and Student ID are required."
    ]);

    exit;
}

/*
 * Generate a member ID.
 *
 * We use the database ID after inserting,
 * so there is no risk of duplicate IDs.
 */
try {

    /*
     * Insert the member
     */
    $stmt = $pdo->prepare("
        INSERT INTO members
        (
            name,
            student_id,
            department,
            batch,
            reason,
            status
        )
        VALUES (?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $name,
        $student_id,
        $department,
        $batch,
        $reason
    ]);

    /*
     * Get the new database ID
     */
    $memberId = $pdo->lastInsertId();

    /*
     * Create the public Member ID
     *
     * Example:
     * SMC-0001
     * SMC-0002
     */
    $memberCode = "SMC-" . str_pad(
        $memberId,
        4,
        "0",
        STR_PAD_LEFT
    );

    echo json_encode([
        "success" => true,
        "message" => "Your membership request has been submitted.",
        "member_id" => $memberCode,
        "name" => $name
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not submit membership request."
    ]);
}