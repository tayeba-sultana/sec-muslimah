<?php

require_once "auth.php";
require_once "../config/database.php";


/*
 * Get all events
 */

$stmt = $pdo->query("
    SELECT *
    FROM events
    ORDER BY event_date ASC, event_time ASC
");

$events = $stmt->fetchAll();

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Event Management
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .form-box {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 30px;
            max-width: 600px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 18px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f3f3f3;
        }

        .active {
    color: green;
    font-weight: bold;
}

.closed {
    color: orange;
    font-weight: bold;
}

.cancelled {
    color: red;
    font-weight: bold;
}
    </style>

</head>

<body>


<h1>
    Event Management
</h1>


<p>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

</p>


<!-- =========================
     ADD EVENT
========================= -->

<div class="form-box">

    <h2>
        Add New Event
    </h2>


    <form
        method="POST"
        action="event_action.php"
    >

        <input
            type="hidden"
            name="action"
            value="add"
        >


        <label>
            Event Title
        </label>

        <input
            type="text"
            name="title"
            required
        >


        <label>
            Description
        </label>

        <textarea
            name="description"
            rows="4"
        ></textarea>


        <label>
            Event Date
        </label>

        <input
            type="date"
            name="event_date"
            required
        >


        <label>
            Event Time
        </label>

        <input
            type="time"
            name="event_time"
            required
        >


        <label>
            Location
        </label>

        <input
            type="text"
            name="location"
            required
        >


        <label>
            Number of Seats
        </label>

        <input
            type="number"
            name="seats"
            min="0"
            value="0"
        >


        <button type="submit">
            Add Event
        </button>

    </form>

</div>


<!-- =========================
     EVENT LIST
========================= -->

<h2>
    Existing Events
</h2>


<table>

    <thead>

        <tr>

            <th>ID</th>

            <th>Title</th>

            <th>Date</th>

            <th>Time</th>

            <th>Location</th>

            <th>Seats</th>

            <th>Status</th>

            <th>Action</th>

        </tr>

    </thead>


    <tbody>


    <?php if (count($events) === 0): ?>

        <tr>

            <td colspan="8">

                No events found.

            </td>

        </tr>


    <?php else: ?>


        <?php foreach ($events as $event): ?>

            <tr>

                <td>
                    <?= $event["id"] ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $event["title"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $event["event_date"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $event["event_time"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $event["location"]
                    ) ?>
                </td>


                <td>
                    <?= $event["seats"] ?>
                </td>


                <td>

                    <strong>

                        <?= htmlspecialchars(
                            ucfirst(
                                $event["status"]
                            )
                        ) ?>

                    </strong>

                </td>


                <td>

                    <a
                        href="event_edit.php?id=<?= $event["id"] ?>"
                    >
                        Edit
                    </a>

                    |

                    <?php if ($event["status"] === "active"): ?>

    <a
        href="event_action.php?action=toggle&id=<?= $event["id"] ?>"
    >
        Close Event
    </a>

<?php elseif ($event["status"] === "closed"): ?>

    <a
        href="event_action.php?action=toggle&id=<?= $event["id"] ?>"
    >
        Reopen Event
    </a>

<?php else: ?>

    <span>
        Cancelled
    </span>

<?php endif; ?>

                    |

                    <a
                        href="event_action.php?action=delete&id=<?= $event["id"] ?>"
                        onclick="return confirm('Delete this event?')"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>


    <?php endif; ?>


    </tbody>

</table>


</body>

</html>