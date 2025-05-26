<?php
session_start();
$billingInfo = $_SESSION['billingInfo'] ?? [];
$clientNote = $_SESSION['client_note'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Porosia u bë me sukses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f0f2f5;
        }
        .success-box {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            color: #2ecc71;
        }
        .info, .note {
            margin-top: 20px;
        }
        .note {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #28a745;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="success-box">
    <h2>Faleminderit për porosinë!</h2>
    <div class="info">
        <?php if (!empty($billingInfo)): ?>
            <ul>
                <?php foreach ($billingInfo as $key => $value): ?>
                    <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php if (!empty($clientNote)): ?>
        <div class="note">
            <strong>Shënimi juaj:</strong> <?= nl2br(htmlspecialchars($clientNote)) ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
