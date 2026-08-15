<?php

require_once "auth.php";
require_once "../config/database.php";


/*
 * Get all donations
 */

$stmt = $pdo->query("
    SELECT
        donations.*,
        campaigns.title AS campaign_title,
        causes.title AS cause_title
    FROM donations

    LEFT JOIN campaigns
        ON donations.campaign_id = campaigns.id

    LEFT JOIN causes
        ON donations.cause_id = causes.id

    ORDER BY donations.created_at DESC
");

$donations = $stmt->fetchAll();

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Donation Management
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            padding: 30px;
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

        .pending {
            color: orange;
            font-weight: bold;
        }

        .verified {
            color: green;
            font-weight: bold;
        }

        .rejected {
            color: red;
            font-weight: bold;
        }

        .action {
            margin-right: 5px;
        }

    </style>

</head>

<body>


<h1>
    Donation Management
</h1>


<p>

<a href="dashboard.php">
    ← Back to Dashboard
</a>

</p>


<table>

    <thead>

        <tr>

            <th>ID</th>

            <th>Donor</th>

            <th>Phone</th>

            <th>bKash Number</th>

            <th>Transaction ID</th>

            <th>Amount</th>

            <th>Purpose</th>

            <th>Status</th>

            <th>Action</th>

        </tr>

    </thead>


    <tbody>


    <?php if (count($donations) === 0): ?>

        <tr>

            <td colspan="9">

                No donations found.

            </td>

        </tr>


    <?php else: ?>


        <?php foreach ($donations as $donation): ?>

            <tr>

                <td>
                    <?= $donation["id"] ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $donation["name"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $donation["phone"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $donation["bkash_number"]
                    ) ?>
                </td>


                <td>
                    <?= htmlspecialchars(
                        $donation["trx_id"]
                    ) ?>
                </td>


                <td>
                    ৳<?= number_format(
                        $donation["amount"],
                        2
                    ) ?>
                </td>


                <td>

                    <?php

                    if ($donation["campaign_title"]) {

                        echo "Campaign: " .
                            htmlspecialchars(
                                $donation["campaign_title"]
                            );

                    } elseif ($donation["cause_title"]) {

                        echo "Cause: " .
                            htmlspecialchars(
                                $donation["cause_title"]
                            );

                    } else {

                        echo "General";

                    }

                    ?>

                </td>


                <td>

                    <span class="<?= htmlspecialchars(
                        $donation["status"]
                    ) ?>">

                        <?= htmlspecialchars(
                            ucfirst(
                                $donation["status"]
                            )
                        ) ?>

                    </span>

                </td>


                <td>


                    <?php if (
                        $donation["status"] === "pending"
                    ): ?>

                        <a
                            class="action"
                            href="donation_action.php?id=<?= $donation["id"] ?>&action=verify"
                        >
                            Verify
                        </a>

                        |

                        <a
                            class="action"
                            href="donation_action.php?id=<?= $donation["id"] ?>&action=reject"
                        >
                            Reject
                        </a>

                        |

                    <?php endif; ?>


                    <a
                        class="action"
                        href="donation_action.php?id=<?= $donation["id"] ?>&action=delete"
                        onclick="return confirm('Are you sure you want to delete this donation?')"
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