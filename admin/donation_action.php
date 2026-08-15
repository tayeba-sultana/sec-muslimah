<?php

require_once "auth.php";
require_once "../config/database.php";


$id = intval(
    $_GET["id"] ?? 0
);

$action =
    $_GET["action"] ?? "";


if ($id <= 0) {

    die("Invalid donation ID.");

}


switch ($action) {


    /*
     * Verify donation
     */

    case "verify":

        $stmt = $pdo->prepare("
            UPDATE donations

            SET status = 'verified'

            WHERE id = ?
        ");

        $stmt->execute([$id]);

        break;


    /*
     * Reject donation
     */

    case "reject":

        $stmt = $pdo->prepare("
            UPDATE donations

            SET status = 'rejected'

            WHERE id = ?
        ");

        $stmt->execute([$id]);

        break;


    /*
     * Delete donation
     */

    case "delete":

        $stmt = $pdo->prepare("
            DELETE FROM donations

            WHERE id = ?
        ");

        $stmt->execute([$id]);

        break;


    default:

        die("Invalid action.");

}


header(
    "Location: donations.php"
);

exit;