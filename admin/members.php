<!-- <?php

require_once "auth.php";
require_once "../config/database.php";

$stmt = $pdo->query("
    SELECT *
    FROM members
    ORDER BY created_at DESC
");

$members = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Members</title>

<style>

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #ccc;
    padding:10px;
}

th{
    background:#f3f3f3;
}

a{
    text-decoration:none;
}

</style>

</head>
<body>

<h1>Member Management</h1>

<p>

<a href="dashboard.php">
← Back to Dashboard
</a>

</p>

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Student ID</th>
<th>Department</th>
<th>Batch</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php foreach($members as $member): ?>

<tr>

<td>
<?= $member["id"] ?>
</td>

<td>
<?= htmlspecialchars($member["name"]) ?>
</td>

<td>
<?= htmlspecialchars($member["student_id"]) ?>
</td>

<td>
<?= htmlspecialchars($member["department"]) ?>
</td>

<td>
<?= htmlspecialchars($member["batch"]) ?>
</td>

<td>
<?= htmlspecialchars($member["status"]) ?>
</td>

<td>

<a href="member_action.php?id=<?= $member["id"] ?>&action=approve">
Approve
</a>

|

<a href="member_action.php?id=<?= $member["id"] ?>&action=reject">
Reject
</a>

|

<a
href="member_action.php?id=<?= $member["id"] ?>&action=delete"
onclick="return confirm('Delete member?')"
>
Delete
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html> -->



<?php

require_once "auth.php";
require_once "../config/database.php";

$stmt = $pdo->query("
    SELECT *
    FROM members
    ORDER BY created_at DESC
");

$members = $stmt->fetchAll();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SEC Muslimah — Member Management</title>

<link
href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Cormorant+Garamond:wght@400;600&display=swap"
rel="stylesheet"
>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;

    background: #f8f4fb;

    color: #352342;

    font-family: "Cormorant Garamond", serif;
}


/* TOP BAR */

.topbar {

    background: linear-gradient(
        135deg,
        #3d2455,
        #6b4385
    );

    color: white;

    padding: 18px 30px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 4px 18px rgba(60, 30, 80, .18);
}

.brand {

    display: flex;

    align-items: center;

    gap: 10px;
}

.brand-icon {

    font-size: 1.5rem;
}

.brand-name {

    font-family: "Playfair Display", serif;

    font-size: 1.4rem;

    font-weight: 700;
}

.brand-name span {

    color: #e7c982;
}

.logout {

    color: white;

    text-decoration: none;

    border: 1px solid rgba(255,255,255,.5);

    padding: 7px 16px;

    border-radius: 20px;
}

.logout:hover {

    background: rgba(255,255,255,.12);
}


/* CONTAINER */

.container {

    max-width: 1250px;

    margin: 0 auto;

    padding: 40px 22px;
}


/* HEADER */

.page-header {

    margin-bottom: 25px;
}

.page-header h1 {

    font-family: "Playfair Display", serif;

    margin: 0 0 8px;

    font-size: 2.2rem;
}

.page-header p {

    margin: 0;

    color: #86699a;

    font-size: 1.1rem;
}

.back {

    display: inline-block;

    margin-top: 18px;

    color: #5a3870;

    text-decoration: none;

    font-weight: 600;
}

.back:hover {

    color: #8a5aa5;
}


/* TABLE CARD */

.table-card {

    background: white;

    border-radius: 18px;

    padding: 22px;

    box-shadow:
        0 5px 20px rgba(60,30,80,.08);

    border: 1px solid #eee4f4;

    overflow-x: auto;
}


/* TABLE */

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 900px;
}

th {

    background: #f3edf7;

    color: #4b2d63;

    font-family: "Playfair Display", serif;

    font-weight: 700;

    text-align: left;

    padding: 14px 12px;

    border-bottom: 2px solid #e4d6eb;
}

td {

    padding: 13px 12px;

    border-bottom: 1px solid #eee5f2;

    vertical-align: middle;
}

tr:hover td {

    background: #fcf9fd;
}


/* STATUS */

.status {

    display: inline-block;

    padding: 5px 12px;

    border-radius: 20px;

    font-size: .9rem;

    font-weight: 600;

    text-transform: capitalize;
}

.status-pending {

    background: #fff4d6;

    color: #8a6714;
}

.status-approved {

    background: #e5f5e9;

    color: #28713b;
}

.status-rejected {

    background: #fbe5e7;

    color: #9b3038;
}


/* ACTIONS */

.actions {

    display: flex;

    gap: 7px;

    flex-wrap: wrap;
}

.action {

    display: inline-block;

    text-decoration: none;

    padding: 6px 11px;

    border-radius: 8px;

    font-family: inherit;

    font-size: .95rem;

    font-weight: 600;

    transition: .2s;
}

.approve {

    background: #e5f5e9;

    color: #28713b;
}

.approve:hover {

    background: #d4edd9;
}

.reject {

    background: #fbe5e7;

    color: #9b3038;
}

.reject:hover {

    background: #f4d3d6;
}

.delete {

    background: #f1e7f5;

    color: #6b4385;
}

.delete:hover {

    background: #e6d8ec;
}


/* EMPTY */

.empty {

    text-align: center;

    padding: 40px;

    color: #9477a5;

    font-size: 1.1rem;
}


/* MOBILE */

@media (max-width: 700px) {

    .topbar {

        padding: 15px;
    }

    .brand-name {

        font-size: 1.1rem;
    }

    .container {

        padding: 25px 15px;
    }

    .page-header h1 {

        font-size: 1.8rem;
    }

}

</style>

</head>

<body>


<header class="topbar">

    <div class="brand">

        <span class="brand-icon">
            🌙
        </span>

        <div class="brand-name">
            SEC <span>Muslimah</span>
        </div>

    </div>

    <a
        class="logout"
        href="logout.php"
    >
        Logout
    </a>

</header>


<main class="container">


    <section class="page-header">

        <h1>
            Member Management
        </h1>

        <p>
            Review and manage membership requests.
        </p>

        <a
            class="back"
            href="dashboard.php"
        >
            ← Back to Dashboard
        </a>

    </section>


    <section class="table-card">


        <?php if (empty($members)): ?>

            <div class="empty">

                No members have submitted a membership request yet.

            </div>

        <?php else: ?>


            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Name</th>

                        <th>Student ID</th>

                        <th>Department</th>

                        <th>Batch</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>


                <?php foreach ($members as $member): ?>


                    <tr>


                        <td>
                            <?= (int)$member["id"] ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($member["name"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($member["student_id"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($member["department"]) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($member["batch"]) ?>
                        </td>


                        <td>

                            <?php

                            $status =
                                strtolower(
                                    $member["status"] ?? "pending"
                                );

                            ?>


                            <span
                                class="status status-<?= htmlspecialchars($status) ?>"
                            >

                                <?= htmlspecialchars($status) ?>

                            </span>

                        </td>


                        <td>


                            <div class="actions">


                                <a
                                    class="action approve"
                                    href="member_action.php?id=<?= (int)$member["id"] ?>&action=approve"
                                >
                                    ✓ Approve
                                </a>


                                <a
                                    class="action reject"
                                    href="member_action.php?id=<?= (int)$member["id"] ?>&action=reject"
                                >
                                    ✕ Reject
                                </a>


                                <a
                                    class="action delete"
                                    href="member_action.php?id=<?= (int)$member["id"] ?>&action=delete"
                                    onclick="return confirm('Delete this member permanently?')"
                                >
                                    🗑 Delete
                                </a>


                            </div>


                        </td>


                    </tr>


                <?php endforeach; ?>


                </tbody>

            </table>


        <?php endif; ?>


    </section>


</main>

</body>

</html>