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

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$name = trim($data["name"] ?? "");
$phone = trim($data["phone"] ?? "");
$bkash_number = trim($data["bkash_number"] ?? "");
$trx_id = trim($data["trx_id"] ?? "");
$amount = floatval($data["amount"] ?? 0);

$campaign_id = !empty($data["campaign_id"])
    ? intval($data["campaign_id"])
    : null;

$cause_id = !empty($data["cause_id"])
    ? intval($data["cause_id"])
    : null;

$note = trim($data["note"] ?? "");


/*
 * Validate required information
 */

if (
    $name === "" ||
    $phone === "" ||
    $bkash_number === "" ||
    $trx_id === "" ||
    $amount <= 0
) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required donation information."
    ]);

    exit;
}


try {

    $stmt = $pdo->prepare("
        INSERT INTO donations
        (
            name,
            phone,
            bkash_number,
            trx_id,
            amount,
            campaign_id,
            cause_id,
            note,
            status
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $name,
        $phone,
        $bkash_number,
        $trx_id,
        $amount,
        $campaign_id,
        $cause_id,
        $note
    ]);


    $donationId = $pdo->lastInsertId();


    echo json_encode([

        "success" => true,

        "message" =>
            "Your donation details have been submitted and will be verified by an admin shortly.",

        "donation_id" => $donationId

    ]);


} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" => "Could not submit donation."

    ]);

}