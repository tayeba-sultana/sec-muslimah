<?php

require_once "auth.php";
require_once "../config/database.php";


$id = intval($_GET["id"] ?? 0);


if ($id <= 0) {
    die("Invalid event ID.");
}


/*
 * Get the event
 */

$stmt = $pdo->prepare("
    SELECT *
    FROM events
    WHERE id = ?
");

$stmt->execute([$id]);

$event = $stmt->fetch();


if (!$event) {
    die("Event not found.");
}

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Edit Event
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        .form-box {
            max-width: 650px;
            border: 1px solid #ddd;
            padding: 25px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 9px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

    </style>

</head>

<body>


<h1>
    Edit Event
</h1>


<p>

<a href="events.php">
    ← Back to Events
</a>

</p>


<div class="form-box">


<form
    method="POST"
    action="event_action.php"
>


    <input
        type="hidden"
        name="action"
        value="edit"
    >


    <input
        type="hidden"
        name="id"
        value="<?= $event["id"] ?>"
    >


    <label>
        Event Title
    </label>

    <input
        type="text"
        name="title"
        value="<?= htmlspecialchars(
            $event["title"]
        ) ?>"
        required
    >


    <label>
        Description
    </label>

    <textarea
        name="description"
        rows="5"
    ><?= htmlspecialchars(
        $event["description"]
    ) ?></textarea>


    <label>
        Event Date
    </label>

    <input
        type="date"
        name="event_date"
        value="<?= htmlspecialchars(
            $event["event_date"]
        ) ?>"
        required
    >


    <label>
        Event Time
    </label>

    <input
        type="time"
        name="event_time"
        value="<?= htmlspecialchars(
            $event["event_time"]
        ) ?>"
        required
    >


    <label>
        Location
    </label>

    <input
        type="text"
        name="location"
        value="<?= htmlspecialchars(
            $event["location"]
        ) ?>"
        required
    >


    <label>
        Number of Seats
    </label>

    <input
        type="number"
        name="seats"
        min="0"
        value="<?= htmlspecialchars(
            $event["seats"]
        ) ?>"
    >


    <label>
    Status
</label>

<select name="status">

    <option
        value="active"
        <?= $event["status"] === "active"
            ? "selected"
            : "" ?>
    >
        Active
    </option>

    <option
        value="closed"
        <?= $event["status"] === "closed"
            ? "selected"
            : "" ?>
    >
        Closed
    </option>

    <option
        value="cancelled"
        <?= $event["status"] === "cancelled"
            ? "selected"
            : "" ?>
    >
        Cancelled
    </option>

</select>


    <button type="submit">
        Save Changes
    </button>


</form>


</div>


</body>

</html>