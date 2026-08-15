<!-- <?php

require_once "auth.php";
require_once "../config/database.php";

$members = $pdo
    ->query("SELECT COUNT(*) FROM members")
    ->fetchColumn();

$pendingMembers = $pdo
    ->query("
        SELECT COUNT(*)
        FROM members
        WHERE status = 'pending'
    ")
    ->fetchColumn();

$donations = $pdo
    ->query("
        SELECT COALESCE(SUM(amount), 0)
        FROM donations
        WHERE status = 'verified'
    ")
    ->fetchColumn();

$events = $pdo
    ->query("
        SELECT COUNT(*)
        FROM events
        WHERE status = 'active'
    ")
    ->fetchColumn();

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Admin Dashboard
    </title>

</head>

<body>

    <h1>
        SEC Muslimah Admin Dashboard
    </h1>

    <p>
        Welcome,
        <?= htmlspecialchars($_SESSION["admin_name"]) ?>
    </p>

    <hr>

    <h2>
        Statistics
    </h2>

    <p>
        Total Members:
        <?= $members ?>
    </p>

    <p>
        Pending Members:
        <?= $pendingMembers ?>
    </p>

    <p>
        Verified Donations:
        ৳<?= number_format($donations, 2) ?>
    </p>

    <p>
        Active Events:
        <?= $events ?>
    </p>

    <hr>

    <h2>
        Management
    </h2>

    <p>
        <a href="members.php">
            Manage Members
        </a>
    </p>

    <p>
        <a href="donations.php">
            Manage Donations
        </a>
    </p>

    <p>
        <a href="events.php">
            Manage Events
        </a>
    </p>

    <p>
        <a href="logout.php">
            Logout
        </a>
    </p>

</body>

</html> -->


<?php

require_once "auth.php";
require_once "../config/database.php";

$members = $pdo
    ->query("SELECT COUNT(*) FROM members")
    ->fetchColumn();

$pendingMembers = $pdo
    ->query("
        SELECT COUNT(*)
        FROM members
        WHERE status = 'pending'
    ")
    ->fetchColumn();

$donations = $pdo
    ->query("
        SELECT COALESCE(SUM(amount), 0)
        FROM donations
        WHERE status = 'verified'
    ")
    ->fetchColumn();

$events = $pdo
    ->query("
        SELECT COUNT(*)
        FROM events
        WHERE status = 'active'
    ")
    ->fetchColumn();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SEC Muslimah — Admin Dashboard</title>

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

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 22px;
}

.welcome {
    margin-bottom: 30px;
}

.welcome h1 {
    font-family: "Playfair Display", serif;
    margin: 0 0 8px;
    font-size: 2.2rem;
}

.welcome p {
    margin: 0;
    color: #86699a;
    font-size: 1.1rem;
}

.stats {
    display: grid;
    grid-template-columns:
        repeat(4, 1fr);

    gap: 20px;

    margin-bottom: 35px;
}

.card {
    background: white;

    border-radius: 16px;

    padding: 25px;

    box-shadow:
        0 5px 20px rgba(60,30,80,.08);

    border: 1px solid #eee4f4;
}

.card-icon {
    font-size: 1.7rem;
    margin-bottom: 10px;
}

.card-number {
    font-family: "Playfair Display", serif;
    font-size: 2rem;
    font-weight: 700;
    color: #4b2d63;
}

.card-label {
    color: #9477a5;
    margin-top: 5px;
    font-size: 1rem;
}

.management {
    background: white;

    border-radius: 18px;

    padding: 28px;

    box-shadow:
        0 5px 20px rgba(60,30,80,.08);
}

.management h2 {
    font-family: "Playfair Display", serif;
    margin-top: 0;
}

.links {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 15px;
}

.link-card {
    text-decoration: none;

    color: #4b2d63;

    border: 1px solid #eadff0;

    border-radius: 12px;

    padding: 18px;

    transition: .2s;
}

.link-card:hover {
    transform: translateY(-2px);

    background: #faf7fc;

    border-color: #cdb5da;
}

.link-icon {
    font-size: 1.5rem;
}

.link-title {
    font-weight: 600;

    margin-top: 8px;

    font-size: 1.1rem;
}

@media (max-width: 800px) {

    .stats {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .links {
        grid-template-columns:
            1fr;
    }

}

@media (max-width: 500px) {

    .topbar {
        padding: 15px;
    }

    .brand-name {
        font-size: 1.1rem;
    }

    .container {
        padding: 25px 15px;
    }

    .stats {
        grid-template-columns:
            1fr;
    }

    .welcome h1 {
        font-size: 1.8rem;
    }

}

</style>

</head>

<body>

<header class="topbar">

    <div class="brand">

        <span class="brand-icon">🌙</span>

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

    <section class="welcome">

        <h1>
            Admin Dashboard
        </h1>

        <p>
            Welcome,
            <?= htmlspecialchars($_SESSION["admin_name"]) ?>
            🌸
        </p>

    </section>


    <section class="stats">

        <div class="card">

            <div class="card-icon">
                👥
            </div>

            <div class="card-number">
                <?= $members ?>
            </div>

            <div class="card-label">
                Total Members
            </div>

        </div>


        <div class="card">

            <div class="card-icon">
                ⏳
            </div>

            <div class="card-number">
                <?= $pendingMembers ?>
            </div>

            <div class="card-label">
                Pending Members
            </div>

        </div>


        <div class="card">

            <div class="card-icon">
                💗
            </div>

            <div class="card-number">
                ৳<?= number_format($donations, 2) ?>
            </div>

            <div class="card-label">
                Verified Donations
            </div>

        </div>


        <div class="card">

            <div class="card-icon">
                📅
            </div>

            <div class="card-number">
                <?= $events ?>
            </div>

            <div class="card-label">
                Active Events
            </div>

        </div>

    </section>


    <section class="management">

        <h2>
            Management
        </h2>

        <div class="links">

            <a
                class="link-card"
                href="members.php"
            >
                <div class="link-icon">
                    👥
                </div>

                <div class="link-title">
                    Manage Members
                </div>
            </a>


            <a
                class="link-card"
                href="donations.php"
            >
                <div class="link-icon">
                    💰
                </div>

                <div class="link-title">
                    Manage Donations
                </div>
            </a>


            <a
                class="link-card"
                href="events.php"
            >
                <div class="link-icon">
                    📅
                </div>

                <div class="link-title">
                    Manage Events
                </div>
            </a>

        </div>

    </section>

</main>

</body>

</html>