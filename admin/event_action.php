<?php

require_once "auth.php";
require_once "../config/database.php";


/*
 * Support both POST and GET
 */

$action =
    $_POST["action"]
    ?? $_GET["action"]
    ?? "";


$id =
    intval(
        $_POST["id"]
        ?? $_GET["id"]
        ?? 0
    );


/*
 * ADD
 */

if ($action === "add") {

    $title =
        trim($_POST["title"] ?? "");

    $description =
        trim($_POST["description"] ?? "");

    $event_date =
        trim($_POST["event_date"] ?? "");

    $event_time =
        trim($_POST["event_time"] ?? "");

    $location =
        trim($_POST["location"] ?? "");

    $seats =
        intval($_POST["seats"] ?? 0);


    if (
        $title === "" ||
        $event_date === "" ||
        $event_time === "" ||
        $location === ""
    ) {

        die(
            "Please fill in all required fields."
        );
    }


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


    header(
        "Location: events.php"
    );

    exit;
}

/*
 * EDIT
 */

if ($action === "edit") {

    if ($id <= 0) {

        die("Invalid event ID.");

    }


    $title =
        trim($_POST["title"] ?? "");

    $description =
        trim($_POST["description"] ?? "");

    $event_date =
        trim($_POST["event_date"] ?? "");

    $event_time =
        trim($_POST["event_time"] ?? "");

    $location =
        trim($_POST["location"] ?? "");

    $seats =
        intval($_POST["seats"] ?? 0);

    $status =
        $_POST["status"] ?? "active";


    /*
     * Validate
     */

    if (
        $title === "" ||
        $event_date === "" ||
        $event_time === "" ||
        $location === ""
    ) {

        die(
            "Please fill in all required fields."
        );

    }


    /*
     * Only allow valid statuses
     */

    if (
    $status !== "active" &&
    $status !== "closed" &&
    $status !== "cancelled"
) {

    $status = "active";

}


    /*
     * Update event
     */

    $stmt = $pdo->prepare("
        UPDATE events

        SET
            title = ?,
            description = ?,
            event_date = ?,
            event_time = ?,
            location = ?,
            seats = ?,
            status = ?

        WHERE id = ?
    ");


    $stmt->execute([

        $title,

        $description,

        $event_date,

        $event_time,

        $location,

        $seats,

        $status,

        $id

    ]);


    header(
        "Location: events.php"
    );

    exit;
}

/*
 * DELETE
 */

if ($action === "delete") {

    if ($id <= 0) {

        die("Invalid event ID.");

    }


    $stmt = $pdo->prepare("
        DELETE FROM events
        WHERE id = ?
    ");

    $stmt->execute([$id]);


    header(
        "Location: events.php"
    );

    exit;
}


/*
 * TOGGLE STATUS
 */

if ($action === "toggle") {

    if ($id <= 0) {

        die("Invalid event ID.");

    }


    $stmt = $pdo->prepare("
        SELECT status
        FROM events
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    $event = $stmt->fetch();


    if (!$event) {

        die("Event not found.");

    }


    /*
     * Change between active and closed
     *
     * active → closed
     * closed → active
     *
     * cancelled stays cancelled
     */

    if ($event["status"] === "active") {

        $newStatus = "closed";

    } elseif ($event["status"] === "closed") {

        $newStatus = "active";

    } else {

        /*
         * If the event is cancelled,
         * don't automatically reactivate it.
         */

        $newStatus = "cancelled";

    }


    $stmt = $pdo->prepare("
        UPDATE events
        SET status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $newStatus,
        $id
    ]);


    header(
        "Location: events.php"
    );

    exit;
}


/*
 * Unknown action
 */

die("Invalid action.");