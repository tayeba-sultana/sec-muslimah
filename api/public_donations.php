<?php

header("Content-Type: application/json");

require_once "../config/database.php";

try {

    /* =========================
       CAMPAIGNS
    ========================= */

    $stmt = $pdo->query("
        SELECT
            c.id,
            c.title,
            c.description,
            c.goal_amount,
            COALESCE(
                SUM(
                    CASE
                        WHEN d.status = 'verified'
                        THEN d.amount
                        ELSE 0
                    END
                ),
                0
            ) AS raised_amount
        FROM campaigns c
        LEFT JOIN donations d
            ON d.campaign_id = c.id
        WHERE c.status = 'active'
        GROUP BY
            c.id,
            c.title,
            c.description,
            c.goal_amount
        ORDER BY c.id DESC
    ");

    $campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /* =========================
       DONATION CAUSES
    ========================= */

    $stmt = $pdo->query("
        SELECT
            c.id,
            c.title,
            c.description,
            c.goal_amount,
            COALESCE(
                SUM(
                    CASE
                        WHEN d.status = 'verified'
                        THEN d.amount
                        ELSE 0
                    END
                ),
                0
            ) AS raised_amount
        FROM causes c
        LEFT JOIN donations d
            ON d.cause_id = c.id
        WHERE c.status = 'active'
        GROUP BY
            c.id,
            c.title,
            c.description,
            c.goal_amount
        ORDER BY c.id DESC
    ");

    $causes = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /* =========================
       CLOTHES DRIVES
    ========================= */

    $stmt = $pdo->query("
        SELECT
            id,
            title,
            description,
            dropoff_location,
            deadline
        FROM clothes_drives
        WHERE status = 'active'
        ORDER BY id DESC
    ");

    $clothes = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /* =========================
       GENERAL DONATIONS
    ========================= */

    $stmt = $pdo->query("
        SELECT COALESCE(SUM(amount), 0)
        FROM donations
        WHERE status = 'verified'
          AND campaign_id IS NULL
          AND cause_id IS NULL
    ");

    $generalRaised = $stmt->fetchColumn();


    /* =========================
       CAMPAIGN DONATIONS
    ========================= */

    $stmt = $pdo->query("
        SELECT COALESCE(SUM(amount), 0)
        FROM donations
        WHERE status = 'verified'
          AND campaign_id IS NOT NULL
    ");

    $campaignRaised = $stmt->fetchColumn();


    echo json_encode([
        "success" => true,
        "campaigns" => $campaigns,
        "causes" => $causes,
        "clothes" => $clothes,
        "general_raised" => (float)$generalRaised,
        "campaign_raised" => (float)$campaignRaised
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}