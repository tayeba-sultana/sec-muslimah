<?php

header("Content-Type: application/json");

require_once "../config/database.php";


/*
 * GET
 * Return all events
 */

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    try {

        $stmt = $pdo->query("
            SELECT
                id,
                title,
                description,
                event_date,
                event_time,
                location,
                seats,
                status,
                created_at
            FROM events
            ORDER BY event_date ASC, event_time ASC
        ");

        $events = $stmt->fetchAll();

        echo json_encode([
            "success" => true,
            "events" => $events
        ]);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "success" => false,
            "message" => "Could not load events."
        ]);
    }

    exit;
}


/*
 * POST
 * Add a new event
 */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );


    $title = trim(
        $data["title"] ?? ""
    );

    $description = trim(
        $data["description"] ?? ""
    );

    $event_date =
        trim($data["event_date"] ?? "");

    $event_time =
        trim($data["event_time"] ?? "");

    $location =
        trim($data["location"] ?? "");

    $seats =
        intval($data["seats"] ?? 0);


    /*
     * Validate
     */

    if (
        $title === "" ||
        $event_date === "" ||
        $event_time === "" ||
        $location === ""
    ) {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" =>
                "Please fill in all required fields."
        ]);

        exit;
    }


    try {

        $stmt = $pdo->prepare("
            INSERT INTO events
            (
                title,
                description,
                event_date,
                event_time,
                location,
                seats,
                status
            )
            VALUES (?, ?, ?, ?, ?, ?, 'active')
        ");

        $stmt->execute([
            $title,
            $description,
            $event_date,
            $event_time,
            $location,
            $seats
        ]);


        echo json_encode([

            "success" => true,

            "message" =>
                "Event created successfully.",

            "event_id" =>
                $pdo->lastInsertId()

        ]);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([

            "success" => false,

            "message" =>
                "Could not create event."

        ]);
    }

    exit;
}


/*
 * Unsupported method
 */

http_response_code(405);

echo json_encode([

    "success" => false,

    "message" =>
        "Method not allowed."

]);