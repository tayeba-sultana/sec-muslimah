 <?php

session_start();

require_once "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("
        SELECT *
        FROM admins
        WHERE username = ?
        LIMIT 1
    ");

    $stmt->execute([$username]);

    $admin = $stmt->fetch();

    if (
        $admin &&
        password_verify($password, $admin["password"])
    ) {

        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_name"] = $admin["name"];

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SEC Muslimah — Admin Login</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:wght@400;600&family=Playfair+Display:wght@400;600;700;900&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --deep: #1e0a38;
            --mid: #4a1880;
            --soft: #8b4fbe;
            --lav: #d4b8f0;
            --pink: #f0a8cc;
            --rose: #e87ab0;
            --gold: #c8922a;
            --gl: #e8b84b;
            --cream: #fdf6ff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            min-height: 100vh;

            font-family: "Cormorant Garamond", serif;

            background:
                linear-gradient(
                    160deg,
                    #1e0a38 0%,
                    #3d1470 42%,
                    #6b2fa0 72%,
                    #c060a0 100%
                );

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px;

            position: relative;

            overflow: hidden;
        }


        /* Decorative glowing circles */

        body::before {

            content: "";

            position: absolute;

            width: 500px;

            height: 500px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(232,184,75,.16),
                    transparent 70%
                );

            top: -180px;

            left: -180px;

            filter: blur(20px);
        }


        body::after {

            content: "";

            position: absolute;

            width: 450px;

            height: 450px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(240,168,204,.18),
                    transparent 70%
                );

            bottom: -170px;

            right: -150px;

            filter: blur(20px);
        }


        .stars {

            position: absolute;

            inset: 0;

            pointer-events: none;

            overflow: hidden;
        }


        .star {

            position: absolute;

            color: var(--gl);

            opacity: .5;

            animation: twinkle 3s infinite alternate;
        }


        .star:nth-child(1) {
            top: 15%;
            left: 12%;
            font-size: 18px;
        }

        .star:nth-child(2) {
            top: 25%;
            right: 15%;
            font-size: 13px;
            animation-delay: .7s;
        }

        .star:nth-child(3) {
            bottom: 20%;
            left: 18%;
            font-size: 12px;
            animation-delay: 1.2s;
        }

        .star:nth-child(4) {
            bottom: 15%;
            right: 20%;
            font-size: 20px;
            animation-delay: 1.8s;
        }


        @keyframes twinkle {

            from {
                opacity: .2;
                transform: scale(.7);
            }

            to {
                opacity: .8;
                transform: scale(1.2);
            }

        }


        .login-wrapper {

            width: 100%;

            max-width: 440px;

            position: relative;

            z-index: 2;
        }


        .login-card {

            background: rgba(255,255,255,.96);

            border-radius: 28px;

            padding: 45px 42px;

            box-shadow:
                0 30px 80px rgba(20,5,40,.35);

            border:
                1px solid rgba(255,255,255,.6);

            position: relative;

            overflow: hidden;
        }


        .login-card::before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            height: 6px;

            background:
                linear-gradient(
                    to right,
                    var(--rose),
                    var(--gold)
                );
        }


        .logo {

            width: 76px;

            height: 76px;

            border-radius: 50%;

            margin: 0 auto 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 34px;

            background:
                linear-gradient(
                    135deg,
                    var(--deep),
                    var(--mid)
                );

            border: 2px solid var(--gold);

            box-shadow:
                0 10px 25px rgba(74,24,128,.25);
        }


        .brand {

            text-align: center;

            font-family: "Playfair Display", serif;

            font-size: 1.55rem;

            font-weight: 700;

            color: var(--deep);

            margin-bottom: 5px;
        }


        .brand span {

            color: var(--gold);
        }


        .subtitle {

            text-align: center;

            color: var(--soft);

            font-family: "Playfair Display", serif;

            font-style: italic;

            font-size: 1.05rem;

            margin-bottom: 30px;
        }


        .arabic {

            text-align: center;

            color: var(--gold);

            font-family: "Amiri", serif;

            font-size: 1.7rem;

            margin-bottom: 6px;
        }


        .title {

            text-align: center;

            font-family: "Playfair Display", serif;

            color: var(--deep);

            font-size: 2rem;

            margin-bottom: 7px;
        }


        .description {

            text-align: center;

            color: #80658f;

            font-size: 1rem;

            margin-bottom: 28px;
        }


        .error {

            background: #fff0f4;

            border:

                1px solid #edb4c9;

            color: #9d3159;

            border-radius: 12px;

            padding: 12px 15px;

            margin-bottom: 20px;

            text-align: center;

            font-size: .95rem;
        }


        .field {

            margin-bottom: 20px;
        }


        .field label {

            display: block;

            margin-bottom: 7px;

            color: var(--deep);

            font-weight: 700;

            font-size: .95rem;

            letter-spacing: .04em;
        }


        .input-wrap {

            position: relative;
        }


        .input-icon {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            font-size: 1.1rem;
        }


        .input {

            width: 100%;

            padding: 13px 15px 13px 45px;

            border-radius: 12px;

            border: 1px solid #dbcbe7;

            background: #fcf9ff;

            color: var(--deep);

            font-family: "Cormorant Garamond", serif;

            font-size: 1.05rem;

            outline: none;

            transition:
                border .25s,
                box-shadow .25s;
        }


        .input:focus {

            border-color: var(--soft);

            box-shadow:
                0 0 0 4px rgba(139,79,190,.12);

            background: white;
        }


        .login-btn {

            width: 100%;

            border: none;

            border-radius: 50px;

            padding: 14px 20px;

            margin-top: 5px;

            background:
                linear-gradient(
                    135deg,
                    var(--gold),
                    #b87820
                );

            color: white;

            font-family: "Playfair Display", serif;

            font-size: 1.05rem;

            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 8px 24px rgba(200,146,42,.3);

            transition:
                transform .25s,
                box-shadow .25s;
        }


        .login-btn:hover {

            transform: translateY(-2px);

            box-shadow:
                0 13px 30px rgba(200,146,42,.42);
        }


        .back {

            display: block;

            text-align: center;

            margin-top: 23px;

            color: var(--soft);

            text-decoration: none;

            font-size: .95rem;
        }


        .back:hover {

            color: var(--deep);
        }


        .footer {

            text-align: center;

            color: rgba(255,255,255,.65);

            margin-top: 20px;

            font-size: .85rem;
        }


        @media (max-width: 500px) {

            body {
                padding: 18px;
            }

            .login-card {
                padding: 38px 25px;
            }

            .title {
                font-size: 1.7rem;
            }

        }

    </style>

</head>


<body>


<div class="stars">

    <span class="star">✦</span>
    <span class="star">✧</span>
    <span class="star">✦</span>
    <span class="star">✧</span>

</div>


<div class="login-wrapper">


    <div class="login-card">


        <div class="logo">
            🌙
        </div>


        <div class="brand">
            SEC <span>Muslimah</span>
        </div>


        <div class="subtitle">
            Sisters Empowerment Community
        </div>


        <div class="arabic">
            ﷽
        </div>


        <h1 class="title">
            Admin Login
        </h1>


        <p class="description">
            Sign in to manage your SEC Muslimah community.
        </p>


        <?php if ($error): ?>

            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="field">

                <label for="username">
                    Username
                </label>

                <div class="input-wrap">

                    <span class="input-icon">
                        👤
                    </span>

                    <input
                        class="input"
                        id="username"
                        type="text"
                        name="username"
                        placeholder="Enter your username"
                        autocomplete="username"
                        required
                    >

                </div>

            </div>


            <div class="field">

                <label for="password">
                    Password
                </label>

                <div class="input-wrap">

                    <span class="input-icon">
                        🔒
                    </span>

                    <input
                        class="input"
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                </div>

            </div>


            <button
                class="login-btn"
                type="submit"
            >
                🔐 &nbsp; Sign In to Admin Panel
            </button>


        </form>


        <a
            class="back"
            href="../index.html"
        >
            ← Back to SEC Muslimah Website
        </a>


    </div>


    <div class="footer">
        SEC Muslimah Community • Admin Area
    </div>


</div>


</body>

</html>