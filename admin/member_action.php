<?php

require_once "auth.php";
require_once "../config/database.php";

$id = intval($_GET["id"] ?? 0);
$action = $_GET["action"] ?? "";

if($id <= 0){

    die("Invalid ID");
}

switch($action){

    case "approve":

        $stmt = $pdo->prepare("
            UPDATE members
            SET status='approved'
            WHERE id=?
        ");

        $stmt->execute([$id]);

        break;


    case "reject":

        $stmt = $pdo->prepare("
            UPDATE members
            SET status='rejected'
            WHERE id=?
        ");

        $stmt->execute([$id]);

        break;


    case "delete":

        $stmt = $pdo->prepare("
            DELETE FROM members
            WHERE id=?
        ");

        $stmt->execute([$id]);

        break;
}

header("Location: members.php");
exit;