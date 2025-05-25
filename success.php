<?php
session_start();
if (!isset($_SESSION['billingInfo'])) {
    header("Location: checkout.php");
    exit;
}

$billingInfo = $_SESSION['billingInfo'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Porosia u krye me sukses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f5f5f5;
        }
        h2 {
            color: green;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: white;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h2>Checkout i suksesshëm</h2>
<ul>
    <?php foreach ($billingInfo as $key => $value): ?>
        <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
    <?php endforeach; ?>
</ul>

<?php unset($_SESSION['billingInfo']); ?>

</body>
</html>
