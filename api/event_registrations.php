<?php

header("Content-Type: application/json");

require_once "../config/database.php";


/*
 * Only POST requests are allowed
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Only POST requests are allowed."
    ]);

    exit;
}


/*
 * Read JSON sent by JavaScript
 */

$data = json_decode(
    file_get_contents("php://input"),
    true
);


/*
 * Get submitted values
 */

$event_id = intval(
    $data["event_id"] ?? 0
);

$name = trim(
    $data["name"] ?? ""
);

$student_id = trim(
    $data["student_id"] ?? ""
);

$department = trim(
    $data["department"] ?? ""
);

$batch = trim(
    $data["batch"] ?? ""
);


/*
 * Validate required fields
 */

if (
    $event_id <= 0 ||
    $name === "" ||
    $student_id === "" ||
    $department === "" ||
    $batch === ""
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


    /*
     * Find event
     */

    $stmt = $pdo->prepare("
        SELECT
            id,
            title,
            seats,
            status
        FROM events
        WHERE id = ?
        LIMIT 1
    ");


    $stmt->execute([
        $event_id
    ]);


    $event = $stmt->fetch();



    /*
     * Event doesn't exist
     */

    if (!$event) {

        http_response_code(404);

        echo json_encode([
            "success" => false,
            "message" =>
                "Event not found."
        ]);

        exit;

    }



    /*
     * Only active events accept
     * registration
     */

    if ($event["status"] !== "active") {

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" =>
                "Registration for this event is closed."
        ]);

        exit;

    }



    /*
     * Prevent duplicate registration
     */

    $stmt = $pdo->prepare("
        SELECT id
        FROM event_registrations
        WHERE event_id = ?
        AND student_id = ?
        LIMIT 1
    ");


    $stmt->execute([

        $event_id,
        $student_id

    ]);


    if ($stmt->fetch()) {

        http_response_code(409);

        echo json_encode([
            "success" => false,
            "message" =>
                "You are already registered for this event."
        ]);

        exit;

    }



    /*
     * Check event capacity
     */

    if (
        intval($event["seats"]) > 0
    ) {


        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM event_registrations
            WHERE event_id = ?
        ");


        $stmt->execute([
            $event_id
        ]);


        $registered =
            intval(
                $stmt->fetchColumn()
            );



        /*
         * Event is full
         */

        if (
            $registered >=
            intval($event["seats"])
        ) {

            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" =>
                    "Sorry, this event is already full."
            ]);

            exit;

        }

    }



    /*
     * Insert registration
     */

    $stmt = $pdo->prepare("
        INSERT INTO event_registrations
        (
            event_id,
            name,
            student_id,
            department,
            batch
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");


    $stmt->execute([

        $event_id,
        $name,
        $student_id,
        $department,
        $batch

    ]);



    /*
     * Return success
     */

    echo json_encode([

        "success" => true,

        "message" =>
            "You have successfully registered for this event.",

        "registration_id" =>
            $pdo->lastInsertId()

    ]);


} catch (PDOException $e) {


    /*
     * Server/database error
     */

    http_response_code(500);


    echo json_encode([

        "success" => false,

        "message" =>
            "Could not complete registration."

    ]);

}

?>